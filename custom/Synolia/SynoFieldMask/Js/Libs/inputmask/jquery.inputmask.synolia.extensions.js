(function($) {
    //extra definitions
    $.extend($.inputmask.defaults.definitions, {
        '0': {
            validator: "[-+0-9]",
            cardinality: 1,
        },
        '9': {
            validator: "[0-9]",
            cardinality: 1,
        },
        'a': {
            validator: "[a-zA-Z]",
            cardinality: 1,
        },
        'E': {
            validator: "[A-Z]",
            cardinality: 1,
        },
        'e': {
            validator: "[a-z]",
            cardinality: 1,
        },
        'd': {
            validator: "[a-z0-9]",
            cardinality: 1,
        },
        'D': {
            validator: "[A-Z0-9]",
            cardinality: 1,
        },
        '~': {
            validator: "[+-]",
            cardinality: 1,
        },
        'à': {
            validator: "[a-zA-ZçáàãäéèêëíìïóòõöúùüûñÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ]",
            cardinality: 1,
        },
        'ç': {
            validator: "[a-zA-ZçáàãäéèêëíìïóòõöúùüûñÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ()&]",
            cardinality: 1,
        },
        'É': {
            validator: "[A-ZÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ]",
            cardinality: 1,
        },
        'Ñ': {
            validator: "[A-ZÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ()&]",
            cardinality: 1,
        },
        'é': {
            validator: "[a-zçáàãäéèêëíìïóòõöúùüûñ]",
            cardinality: 1,
        },
        'ñ': {
            validator: "[a-zçáàãäéèêëíìïóòõöúùüûñ()&]",
            cardinality: 1,
        },
    });

    // Les aliases doivent être autorisés dans Synolia/SynoFieldMask/Helpers/DeployerImplementation.php
    $.extend($.inputmask.defaults.aliases, {
        'upper': {
            greedy: false,
            repeat: '*',
            mask: 'u',
            skipOptionalPartCharacter: '',
            definitions: {
                'u': {
                    validator: function(chrs, buffer, pos, strict, opts) {
                        return true;
                    },
                    casing: 'upper'
                }
            }
        },
        'upper_first': {
            greedy: false,
            repeat: '*',
            mask: 'f',
            skipOptionalPartCharacter: '',
            definitions: {
                'f': {
                    validator: function(chrs, maskset, pos, strict, opts) {
                        var tmp = maskset.buffer.join('');
                        tmp = tmp.substring(0, pos) + chrs + tmp.substring(pos);
                        tmp = tmp.toLowerCase();
                        tmp = tmp.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])|-+([a-z\u00E0-\u00FC])/g, function($1) {
                            return $1.toUpperCase();
                        });
                        for (var i = 0, l = tmp.length; i < l; i++) {
                            maskset.buffer[i] = tmp.charAt(i);
                        }
                        return strict === true || {"refreshFromBuffer":true};
                    },
                }
            },
        },
        'lower': {
            greedy: false,
            repeat: '*',
            mask: 'l',
            skipOptionalPartCharacter: '',
            definitions: {
                'l': {
                    validator: function(chrs, buffer, pos, strict, opts) {
                        return true;
                    },
                    casing: 'lower'
                }
            }
        },
    });
})(jQuery);
