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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_fm/assets/css/fm.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'config.cancel') {
            Joomla.submitform(task, document.getElementById('config-form'));
        }
        else {
            
            if (task != 'config.cancel' && document.formvalidator.isValid(document.id('config-form'))) {
                
                Joomla.submitform(task, document.getElementById('config-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_fm&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="config-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FM_TITLE_CONFIG', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>				<input type="hidden" name="jform[guid]" value="<?php echo $this->item->guid; ?>" />
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


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        <?php if (JFactory::getUser()->authorise('core.admin','fm')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>