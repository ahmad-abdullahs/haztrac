<?php

require_once "include/Expressions/Actions/AbstractAction.php";
require_once "custom/Synolia/SynoFieldMask/Helpers/FieldMaskHandler.php";

class SetSynoFieldMaskAction extends AbstractAction
{
    protected $mask = "";

    public function SetSynoFieldMaskAction($params)
    {
        $this->params = $params;
        $this->targetField = $params['target'];
        $this->targetLabel = $params['label'];
        $this->mask = $params['value'];
    }

    /**
     * Returns the javascript class equavalent to this php class
     *
     * @return string javascript.
     */
    public static function getJavascriptClass()
    {
        global $app_strings;

        return "
SUGAR.forms.SetSynoFieldMaskAction = function(variable, mask, label) {
    if(typeof(variable.target) != 'undefined'){
        mask = variable.value;
        label = variable.label;
        variable = variable.target;
    }

    this.variable = variable;
    this.maskOptions = mask;
    this.label    = label;
    this._el_lbl  = document.getElementById(this.label);
    this.msg = '".$app_strings['ERR_INVALID_PATTERN']."';

    // Manage required fields for bwc ctx
    this.requireFields = {};
}

/**
 * Triggers this dependency to be re-evaluated again.
 */
SUGAR.util.extend(SUGAR.forms.SetSynoFieldMaskAction, SUGAR.forms.AbstractAction, {

    /**
     * Triggers the masks dependencies.
     */
    exec: function(context) {
        if (typeof(context) == 'undefined')
            context = this.context;

        if (context.view) {
            //We may get triggered before the view has rendered with the full field list.
            //If that occurs wait for the next render to apply.
            if (_.isEmpty(context.view.fields)) {
                context.view.once('render', function(){this.exec(context);}, this);
                return;
            }

            var self = this,
                field = context.view.getField(this.variable, context.model),
                isComposedField = false;

            // find in composed fields
            if(!field && _.contains(context.view.getFieldNames(context.model), this.variable)){
                var fieldDef = this.findField(context, this.variable);
                if(fieldDef){
                    field = context.view.getField(fieldDef.name, context.model);
                    isComposedField = true;
                }
            }

            if(field && !field.synoInputMask){
                field.synoInputMask = function(){
                    var fieldCtx = this;

                    if(isComposedField){
                        fieldCtx = _.find(this.fields, function(childField){
                            return childField.name == self.variable;
                        });
                    }

                    var applyInputMask = _.debounce(_.bind(function(action){
                        var validationName = self.variable+'_field_mask',
                            validator = {},
                            el = this.$('input[type=text]');

                        if(action == 'edit' && self.maskOptions && el){
                            el.inputmask(self.maskOptions, {
                                clearIncomplete: true,
                                clearMaskOnLostFocus: true
                            })
                                .on('complete.inputmask', function () {
                                    validator[validationName] = true;
                                })
                                .on('incomplete.inputmask', function () {
                                    if(el.val() == ''){
                                        validator[validationName] = true;
                                    } else {
                                        validator[validationName] = false;
                                    }
                                });

                            this.model.set(this.name, el.val());

                            if(el.val() == ''){
                                validator[validationName] = true;
                            } else {
                                validator[validationName] = el.inputmask('isComplete');
                                if(_.isUndefined(validator[validationName])){
                                    validator[validationName] = true;
                                }
                            }

                            context.model.addValidationTask(validationName, _.bind(function(fields, errors, callback){
                                if(!validator[validationName]){
                                    errors[self.variable] = SUGAR.App.error.getErrorString('ERR_INVALID_PATTERN', this.module);
                                }
                                callback(null, fields, errors);
                            }, context.model));
                        }
                    }, fieldCtx, this.action), 10);

                    applyInputMask()
                };
                
                field.on('render', field.synoInputMask);
            }
        } else {
            this.bwcExec(context, this.maskOptions);
        }

    },

    bwcExec : function(context, maskOptions) {
        var el = SUGAR.forms.AssignmentHandler.getElement(this.variable),
            self = this;

        if (this._el_lbl != null && el != null) {
            var fName = el.name;

            // Utilisation de jQuery du parent (sidecar)
            var baseSelector = (parent.$('.bwc iframe').get(0)) ? window.parent.$('.bwc iframe').contents() : $('body');
                elJquery = test = baseSelector.find('input[type=text][id=' + el.id + ']:visible'),
                isValid = false;

            if(maskOptions && elJquery){
                elJquery.inputmask(maskOptions)
                    .on('complete.inputmask', function(){
                        self.manageValidate(context, fName, true);
                    })
                    .on('incomplete.inputmask', function(){
                        self.manageValidate(context, fName, false);
                    });


                if(elJquery.val() == ''){
                    isValid = true;
                } else {
                    isValid = elJquery.inputmask('isComplete');
                    if(typeof(isValid) == 'undefined'){
                        isValid = true;
                    }
                }

               this.manageValidate(context, fName, isValid);
            }
        }
    },

    findField : function(ctx, fieldName){
        // find in composed fields the parent with the targeted children
        return _.find(ctx.view.getFields(), function(parentField){
            return (!parentField.fields) ? false : _.find(parentField.fields, function(fieldDefs){
                return fieldDefs.name == fieldName;
            });
        });
    },

    findInValidate : function(form, field) {
        if (validate && validate[form]){
            for (var i in validate[form]){
                if (typeof(validate[form][i]) == 'object' && validate[form][i][0] == field)
                    return i;
            }
        }
        return -1;
    },
    manageValidate : function(context, fName, isValid){
        var i = this.findInValidate(context.formName, fName);
        var validateField = null;

        if(i > -1 && validate[context.formName][i]){
            validateField = validate[context.formName][i];
        }

        if(!this.requireFields[fName] && validateField && validateField[2]){
            this.requireFields[fName] = validateField[3];
        }

        if (!isValid) {
            if (validateField){
                validateField[1] = 'error';
                validateField[2] = true;
                validateField[3] = this.msg;
            }
            else
                addToValidate(context.formName, fName, 'error', true, this.msg);
        } else {
            if (validateField){
                validateField[1] = 'text';
                validateField[2] = (this.requireFields[fName]) ? true : false;
                validateField[3] = (this.requireFields[fName]) ? this.requireFields[fName] : '';
            }
        }
    }
});";
    }

    /**
     * Returns the javascript code to generate this actions equivalent.
     *
     * @return string javascript.
     */
    public function getJavascriptFire()
    {
        return "new SUGAR.forms.SetSynoFieldMaskAction('{$this->targetField}',".json_encode($this->mask).", '{$this->targetLabel}')";
    }

    /**
     * Applies the Action to the target.
     *
     * @param SugarBean $target
     */
    public function fire(&$target)
    {
        $GLOBALS['log']->info('------------  '.__CLASS__.'::'.__FUNCTION__.' BEGIN ------------');

        if (is_array($this->targetField)) {
            foreach ($this->targetField as $targetField) {
                $this->fireOneTarget($target, $targetField);
            }
        } elseif (is_string($this->targetField)) {
            $this->fireOneTarget($target, $this->targetField);
        }

        $GLOBALS['log']->info('------------  '.__CLASS__.'::'.__FUNCTION__.' END ------------');
    }

    public static function getActionName()
    {
        return "SetSynoFieldMask";
    }

    /**
     * Handle one target field
     *
     * @param $target
     * @param $targetField
     * @return bool
     */
    protected function fireOneTarget($target, $targetField)
    {
        $mask = is_array($this->mask) ? implode("' ", $this->mask) : $this->mask;

        if (
            empty($targetField)
            || $result = FieldMaskHandler::applyMask($target, $targetField, $this->mask) === false
        ) {
            $GLOBALS['log']->fatal(
                'The mask '
                . $mask
                . ' could not be applied to the field '
                . $targetField
                . ' of Bean '
                . $target->module_name
                . ' for record id='
                . $target->id
            );
        }

        return $result;
    }
}
