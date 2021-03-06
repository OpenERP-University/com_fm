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
         js('#jform_social_insurance_employee').keyup(function () {
            js('#jform_social_insurance_employee').val(checkvalue(js('#jform_social_insurance_employee').val()));
        });
        js('#jform_social_insurance_support').keyup(function () {
            js('#jform_social_insurance_support').val(checkvalue(js('#jform_social_insurance_support').val()));
        });
        js('#jform_medical_insurance_employee').keyup(function () {
            js('#jform_medical_insurance_employee').val(checkvalue(js('#jform_medical_insurance_employee').val()));
        });
        js('#jform_medical_insurance_support').keyup(function () {
            js('#jform_medical_insurance_support').val(checkvalue(js('#jform_medical_insurance_support').val()));
        });
          js('#jform_unemployment_insurance_employee').keyup(function () {
            js('#jform_unemployment_insurance_employee').val(checkvalue(js('#jform_unemployment_insurance_employee').val()));
        });
        js('#jform_unemployment_insurance_support').keyup(function () {
            js('#jform_unemployment_insurance_support').val(checkvalue(js('#jform_unemployment_insurance_support').val()));
        });
        js('#jform_union_employee').keyup(function () {
            js('#jform_union_employee').val(checkvalue(js('#jform_union_employee').val()));
        });
        js('#jform_union_support').keyup(function () {
            js('#jform_union_support').val(checkvalue(js('#jform_union_support').val()));
        });
          js('#jform_allowance_x').keyup(function () {
            js('#jform_allowance_x').val(checkvalue(js('#jform_allowance_x').val()));
        });
        js('#jform_allowance_y').keyup(function () {
            js('#jform_allowance_y').val(checkvalue(js('#jform_allowance_y').val()));
        });
        js('#jform_allowance_z').keyup(function () {
            js('#jform_allowance_z').val(checkvalue(js('#jform_allowance_z').val()));
        });
        js('#jform_other_allowance').keyup(function () {
            js('#jform_other_allowance').val(checkvalue(js('#jform_other_allowance').val()));
        });
          js('#jform_rent_old').keyup(function () {
            js('#jform_rent_old').val(checkvalue(js('#jform_rent_old').val()));
        });
        js('#jform_rent_new').keyup(function () {
            js('#jform_rent_new').val(checkvalue(js('#jform_rent_new').val()));
        });
        js('#jform_cost_water').keyup(function () {
            js('#jform_cost_water').val(checkvalue(js('#jform_cost_water').val()));
        });
        js('#jform_electricity_1').keyup(function () {
            js('#jform_electricity_1').val(checkvalue(js('#jform_electricity_1').val()));
        });
          js('#jform_electricity_2').keyup(function () {
            js('#jform_electricity_2').val(checkvalue(js('#jform_electricity_2').val()));
        });
        js('#jform_electricity_3').keyup(function () {
            js('#jform_electricity_3').val(checkvalue(js('#jform_electricity_3').val()));
        });
        js('#jform_electricity_4').keyup(function () {
            js('#jform_electricity_4').val(checkvalue(js('#jform_electricity_4').val()));
        });
        js('#jform_electricity_5').keyup(function () {
            js('#jform_electricity_5').val(checkvalue(js('#jform_electricity_5').val()));
        });
          js('#jform_electricity_6').keyup(function () {
            js('#jform_electricity_6').val(checkvalue(js('#jform_electricity_6').val()));
        });
        js('#jform_allowance_36').keyup(function () {
            js('#jform_allowance_36').val(checkvalue(js('#jform_allowance_36').val()));
        });
        js('#jform_base_pay').keyup(function () {
            js('#jform_base_pay').val(checkvalue(js('#jform_base_pay').val()));
        });
        js('#jform_extra_income').keyup(function () {
            js('#jform_extra_income').val(checkvalue(js('#jform_extra_income').val()));
        });
        

        function checkvalue(data)
        {
            var dem = 0;
            for (var i = 0; i < data.length; i++) {
                if (!parseInt(data[i])) {
                     if (data[i] !== '0') {
                        if (dem == 1) {
                            if (data[i] === '.') {
                                data = data.substring(0, i);
                            }
                        }
                        if (data[i] !== '.') {
                            data = data.substring(0, i);
                        } else {
                            dem = 1;
                        }
                    }
                }

            }
            return data;
        }

    });

    Joomla.submitbutton = function (task)
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

                    <?php if (empty($this->item->created_by)) { ?>
                        <input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

                    <?php } else {
                        ?>
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
                    <?php
                    echo $this->form->getControlGroup('rent_old');
                    echo $this->form->getControlGroup('rent_new');
                    ?>
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
