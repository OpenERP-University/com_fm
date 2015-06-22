<?php
/**
* Open ERP University - HUMG
*
* Copyright (c) 2015 Open ERP University <https://github.com/OpenERP-University> - Hanoi University of Mining and Geology (HUMG)- http://humg.edu.vn 
*
* This component is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This component is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this component; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
*
* 
* @version 1.0.0
* @package com_fm
* @copyright Copyright (c) 2015 Open ERP University - Hanoi University of Mining and Geology (HUMG)- http://humg.edu.vn 
* @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
* @group OpenERP University - Chuyen Trung Tran <chuyentt@gmail.com> 
* @author Leader: Tran Xuan Duc <ductranxuan.29710@gmail.com> 
* @author Dinh Trong Nghia <dinhtrongnghia92@gmail.com> 
* @author Nguyen Dau Hoang <hoangdau17592@gmail.com> 
* @author Nguyen Duc Nhan <nhannd92@gmail.com> 
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
        
	js('input:hidden.employee_guid').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('employee_guidhidden')){
			js('#jform_employee_guid option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_employee_guid").trigger("liszt:updated");
        js('#jform_fe_allowances').keyup(function () {
            js('#jform_fe_allowances').val(checkvalue(js('#jform_fe_allowances').val()));
        });
        js('#jform_earn_salary').keyup(function () {
            js('#jform_earn_salary').val(checkvalue(js('#jform_earn_salary').val()));
        });
        js('#jform_allowance_other').keyup(function () {
            js('#jform_allowance_other').val(checkvalue(js('#jform_allowance_other').val()));
        });
        js('#jform_info_allowance').keyup(function () {
            js('#jform_info_allowance').val(checkvalue(js('#jform_info_allowance').val()));
        });
         js('#jform_info_payroll').keyup(function () {
            js('#jform_info_payroll').val(checkvalue(js('#jform_info_payroll').val()));
        });
        

        function checkvalue(data)
        {
            for (var i = 0; i < data.length; i++) {
                if (!parseInt(data[i])) {
                    if (data[i] !== '0') {
                        data = data.substring(0, i);
                    }
                }

            }
            return data;
        }
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'e_allowance.cancel') {
            Joomla.submitform(task, document.getElementById('e_allowance-form'));
        }
        else {
            
            if (task != 'e_allowance.cancel' && document.formvalidator.isValid(document.id('e_allowance-form'))) {
                
                Joomla.submitform(task, document.getElementById('e_allowance-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_fm&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="e_allowance-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FM_TITLE_E_ALLOWANCE', true)); ?>
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
				<div class="control-label"><?php echo $this->form->getLabel('employee_guid'); ?></div>
				<div class="controls"><?php echo $this->item->employeeName; ?></div>
			</div>
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
			</div>


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
