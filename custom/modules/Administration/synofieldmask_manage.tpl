{*
 **********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by SugarCRM" logo and
 *    (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.; All Rights Reserved.
 *
 * Portions created by SYNOLIA are Copyright (C) 2004-2007 SYNOLIA. You do not
 * have the right to remove SYNOLIA copyrights from the source code or user
 * interface.
 *
 * All Rights Reserved. For more information and to sublicense, resell,rent,
 * lease, redistribute, assign or otherwise transfer Your rights to the Software
 * contact SYNOLIA at contact@synolia.com
 **********************************************************************************
 **********************************************************************************
 * $Header:$
 * The Original Code is:    SYNOFIELDMASK by SYNOLIA
 *                          www.synolia.com - sugar@synolia.com
 * Contributor(s):          ______________________________________.
 * Description :            ______________________________________.
 **********************************************************************************
*}
<div style="clear:both;"></div>
<form method="POST" name="synofieldmask_manage" id="synofieldmask_manage">
{sugar_csrf_form_token}
<input type="hidden" name="module" value="Administration">
<input type="hidden" name="action" value="synofieldmask_manage">
{if $ERRORS neq ''}
<p class="error">
    {$ERRORS}
    <br />&nbsp;
</p>
{/if}
<div style="clear:both;"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
    <tr>
        <td colspan="1">
            <a href="#" onclick="$('#maskConfig').toggle(200);return false;">
                <h4>{sugar_translate module="Administration" label="LBL_MASK_CONFIG"}</h4>
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list view" id="maskConfig">
                <tbody>
                    <tr>
                        <th>{sugar_translate module="Administration" label="LBL_MASK_CONFIG_CAR"}</th>
                        <th>{sugar_translate module="Administration" label="LBL_MASK_CONFIG_CAR_DESC"}</th>
                    </tr>
                    {if $MASKCONFIG|@count gt 0}
                        {foreach from=$MASKCONFIG item=numConf}
                        <tr class="{cycle values='oddListRowS1,evenListRowS1'}">
                            <td>
                                {sugar_translate module="application" label="LBL_MASK_"|cat:$numConf}
                            </td>
                            <td>
                                {sugar_translate module="application" label="LBL_MASK_CONFIG_"|cat:$numConf}<span style="padding-left:20px;font-style:italic;">{sugar_translate module="application" label="LBL_MASK_CONFIG_PATTERN_"|cat:$numConf}</span>
                            </td>
                        </tr>
                        {/foreach}
                    {/if}
                </tbody>
            </table>
            <hr>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list view" id="aliasConfig">
                <tbody>
                    <tr>
                        <th>{sugar_translate module="Administration" label="LBL_ALIAS_CONFIG_CAR"}</th>
                        <th>{sugar_translate module="Administration" label="LBL_ALIAS_CONFIG_CAR_DESC"}</th>
                    </tr>
                    {if $ALIASCONFIG|@count gt 0}
                        {foreach from=$ALIASCONFIG item=numConf}
                        <tr class="{cycle values='oddListRowS1,evenListRowS1'}">
                            <td>
                                {sugar_translate module="application" label="LBL_ALIAS_"|cat:$numConf}
                            </td>
                            <td>
                                {sugar_translate module="application" label="LBL_ALIAS_CONFIG_"|cat:$numConf}
                            </td>
                        </tr>
                        {/foreach}
                    {/if}
                </tbody>
            </table>
        </td>       
    </tr>
</table>

<div style="float:right; margin:20px 0;">
    <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button"  type="submit"  name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >&nbsp;
    <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " >
</div>
<div style="clear:both;"></div>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
    <tr>
        <td colspan="1">
            <h4>{$MOD.LBL_SYNOFIELDMASK_INFOS}</h4>
        </td>
    </tr>
    <tr>
        <td>
            {if $MODULES|@count gt 0}
            {$MOD.LBL_SYNOFIELDMASK_MANAGE_SELECTION_MODULE}
            <select name="modules" id="modules" onchange="choose_module(this.value)">
                <option value='null'>-- {$MOD.LBL_SYNOFIELDMASK_MANAGE_NONE} --</option>
                {html_options options=$MODULES}
            </select>
            {else}
            {$MOD.LBL_SYNOFIELDMASK_MANAGE_NO_MODULE}
            {/if}
        </td>
    </tr>
</table>
{if $MODULES|@count gt 0}    
    {foreach key=module item=relation from=$MODULES_FIELDS name=relationsname }
    <div id="div_{$module}" style="display:none; visibility:hidden;">
    <table>
        <tr>
            <td width="50%" valign="top">
                <table width="100%" class="detail view" cellspacing="0">
                    {foreach item=itemrelation from=$relation name=relationname}
                    <tr>
                        <td width="10%" scope="row">
                            {$itemrelation.vname}
                        </td>
                        <td width="40%" nowrap="nowrap">
                            <input type="text" name="{$module}[{$itemrelation.name}]" size="100" value="{$itemrelation.help}" {$itemrelation.custom_code} />
                        </td>
                    </tr>
                    {/foreach}
                </table>
            </td>
            <td width="50%" rowspan="{$smarty.foreach.relationname.total}">
                <b>{$MOD.LBL_SYNOFIELDMASK_HELP}</b><hr />
                {$MOD.LBL_SYNOFIELDMASK_HELP_TEXT}
            </td>
        </tr>
    </table>
    </div>
    {/foreach}
{/if}
<div style="float:right; margin:20px 0;">
    <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button"  type="submit"  name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >&nbsp;
    <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " >
</div>

</form>

{literal}
<script>
function choose_module(mod){
    {/literal}
    {foreach key=module item=relation from=$MODULES_FIELDS}
        simple_hideId('div_{$module}');
    {/foreach}
    {literal}
    simple_showId('div_'+mod);
}
function simple_showId(baliseId){
    if (document.getElementById && document.getElementById(baliseId) != null){
        document.getElementById(baliseId).style.visibility='visible';
        document.getElementById(baliseId).style.display='block';
        
        var all_input = document.getElementById(baliseId).getElementsByTagName('input');
        for(var i=0;i<all_input.length;i++){
            all_input[i].removeAttribute('disabled');
        }
    }
}

function simple_hideId(baliseId){
    if (document.getElementById && document.getElementById(baliseId) != null){
        document.getElementById(baliseId).style.visibility='hidden';
        document.getElementById(baliseId).style.display='none';
        
        var all_input = document.getElementById(baliseId).getElementsByTagName('input');
        for(var i=0;i<all_input.length;i++){
            all_input[i].disabled = 'disabled';
        }
    }
}
</script>
{/literal}

