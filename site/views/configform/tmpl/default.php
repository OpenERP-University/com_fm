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
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function() {
        jQuery(document).ready(function() {
            jQuery('#form-config').submit(function(event) {
                
            });

            
        });
    });

</script>

<div class="config-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-config" action="<?php echo JRoute::_('index.php?option=com_fm&task=config.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
        
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
		<div class="control-label"><?php echo $this->form->getLabel('social_insurance_employee'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('social_insurance_employee'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('social_insurance_support'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('social_insurance_support'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('medical_insurance_employee'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('medical_insurance_employee'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('medical_insurance_support'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('medical_insurance_support'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('unemployment_insurance_employee'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('unemployment_insurance_employee'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('unemployment_insurance_support'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('unemployment_insurance_support'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('union_employee'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('union_employee'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('union_support'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('union_support'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('allowance_x'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('allowance_x'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('allowance_y'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('allowance_y'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('allowance_z'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('allowance_z'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('other_allowance'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('other_allowance'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('cost_water'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('cost_water'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('electricity_1'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('electricity_1'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('electricity_2'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('electricity_2'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('electricity_3'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('electricity_3'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('electricity_4'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('electricity_4'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('electricity_5'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('electricity_5'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('electricity_6'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('electricity_6'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('allowance_36'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('allowance_36'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('base_pay'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('base_pay'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('extra_income'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('extra_income'); ?></div>
	</div>
	<input type="hidden" name="jform[time_update]" value="<?php echo $this->item->time_update; ?>" />
				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','fm')): ?> style="display:none;" <?php endif; ?> >
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
                       document.getElementById("form-config").appendChild(input);
                    });
                </script>
             <?php endif; ?>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=configform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_fm" />
        <input type="hidden" name="task" value="configform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
