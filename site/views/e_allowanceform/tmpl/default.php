<?php
/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      Nghia <dinhtrongnghia92@gmail.com> - http://www.facebook.com/G55.RaFiKi
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_fm', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_fm/assets/js/form.js');


?>
</style>
<script type="text/javascript">
    if (jQuery === 'undefined') {
        document.addEventListener("DOMContentLoaded", function(event) { 
            jQuery('#form-e_allowance').submit(function(event) {
                
            });

            
			jQuery('input:hidden.employee_guid').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('employee_guidhidden')){
					jQuery('#jform_employee_guid option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_employee_guid").trigger("liszt:updated");
        });
    } else {
        jQuery(document).ready(function() {
            jQuery('#form-e_allowance').submit(function(event) {
                
            });

            
			jQuery('input:hidden.employee_guid').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('employee_guidhidden')){
					jQuery('#jform_employee_guid option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_employee_guid").trigger("liszt:updated");
        });
    }
</script>

<div class="e_allowance-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-e_allowance" action="<?php echo JRoute::_('index.php?option=com_fm&task=e_allowance.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<input type="hidden" name="jform[guid]" value="<?php echo $this->item->guid; ?>" />

	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('employee_guid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('employee_guid'); ?></div>
	</div>
	<?php foreach((array)$this->item->employee_guid as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="employee_guid" name="jform[employee_guidhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('fe_allowances'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('fe_allowances'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('option_allowance'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('option_allowance'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('earn_salary'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('earn_salary'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('option_study'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('option_study'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('option_break'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('option_break'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('allowance_other'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('allowance_other'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('info_allowance'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('info_allowance'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('info_payroll'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('info_payroll'); ?></div>
	</div>				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','fm')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','fm')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-e_allowance").appendChild(input);
                    });
                </script>
             <?php endif; ?>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=e_allowanceform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_fm" />
        <input type="hidden" name="task" value="e_allowanceform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
