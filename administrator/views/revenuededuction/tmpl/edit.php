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
    js(document).ready(function () {

        js('input:hidden.employee_guid').each(function () {
            var name = js(this).attr('name');
            if (name.indexOf('employee_guidhidden')) {
                js('#jform_employee_guid option[value="' + js(this).val() + '"]').attr('selected', true);
            }
        });
        js("#jform_employee_guid").trigger("liszt:updated");
        js('#jform_pay_electricity').keyup(function () {
            js('#jform_pay_electricity').val(checkvalue(js('#jform_pay_electricity').val()));
        });
        js('#jform_water_charges').keyup(function () {
            js('#jform_water_charges').val(checkvalue(js('#jform_water_charges').val()));
        });
        js('#jform_rent').keyup(function () {
            js('#jform_rent').val(checkvalue(js('#jform_rent').val()));
        });
        js('#jform_detain').keyup(function () {
            js('#jform_detain').val(checkvalue(js('#jform_detain').val()));
            var gt_detain_stype = js('#jform_detain_type').val();
            var gt_detain = parseInt(js('#jform_detain').val());
            if (gt_detain_stype == 1 && gt_detain >= 30) {
                js('#notify-text').html("<span>Số ngày nhập quá lớn!</span>");
            }
            else
            {
                js('#notify-text').html("<span></span>");
            }
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

    Joomla.submitbutton = function (task)
    {
        if (task == 'revenuededuction.cancel') {
            Joomla.submitform(task, document.getElementById('revenuededuction-form'));
        }
        else {

            if (task != 'revenuededuction.cancel' && document.formvalidator.isValid(document.id('revenuededuction-form'))) {

                Joomla.submitform(task, document.getElementById('revenuededuction-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_fm&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="revenuededuction-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FM_TITLE_REVENUEDEDUCTION', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
                    <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
                    <input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
                    <input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
                    <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

                    <?php if (empty($this->item->created_by)) { ?>
                        <input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

                    <?php } else {
                        ?>
                        <input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

                    <?php } ?>				<input type="hidden" name="jform[guid]" value="<?php echo $this->item->guid; ?>" />
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('employee_guid'); ?></div>
                        <div class="controls"><?php echo $this->item->employeeName; ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('pay_electricity'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('pay_electricity'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('water_charges'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('water_charges'); ?></div>
                    </div>
                    <?php echo $this->form->getControlGroup('house_type'); ?>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('rent'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('rent'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('detain_type'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('detain_type'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('detain'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('detain'); ?></div>
                    </div>
                    <div  class="controls" style="color: red" id="notify-text"> </div>

                    <input type="hidden" name="jform[time_update]" value="<?php echo $this->item->time_update; ?>" />


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php if (JFactory::getUser()->authorise('core.admin', 'fm')) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
            <?php echo $this->form->getInput('rules'); ?>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>
