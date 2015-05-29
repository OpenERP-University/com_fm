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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_fm.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_fm' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_GUID'); ?></th>
			<td><?php echo $this->item->guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_SOCIAL_INSURANCE_EMPLOYEE'); ?></th>
			<td><?php echo $this->item->social_insurance_employee; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_SOCIAL_INSURANCE_SUPPORT'); ?></th>
			<td><?php echo $this->item->social_insurance_support; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_MEDICAL_INSURANCE_EMPLOYEE'); ?></th>
			<td><?php echo $this->item->medical_insurance_employee; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_MEDICAL_INSURANCE_SUPPORT'); ?></th>
			<td><?php echo $this->item->medical_insurance_support; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_UNEMPLOYMENT_INSURANCE_EMPLOYEE'); ?></th>
			<td><?php echo $this->item->unemployment_insurance_employee; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_UNEMPLOYMENT_INSURANCE_SUPPORT'); ?></th>
			<td><?php echo $this->item->unemployment_insurance_support; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_UNION_EMPLOYEE'); ?></th>
			<td><?php echo $this->item->union_employee; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_UNION_SUPPORT'); ?></th>
			<td><?php echo $this->item->union_support; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ALLOWANCE_X'); ?></th>
			<td><?php echo $this->item->allowance_x; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ALLOWANCE_Y'); ?></th>
			<td><?php echo $this->item->allowance_y; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ALLOWANCE_Z'); ?></th>
			<td><?php echo $this->item->allowance_z; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_OTHER_ALLOWANCE'); ?></th>
			<td><?php echo $this->item->other_allowance; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_COST_WATER'); ?></th>
			<td><?php echo $this->item->cost_water; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ELECTRICITY_1'); ?></th>
			<td><?php echo $this->item->electricity_1; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ELECTRICITY_2'); ?></th>
			<td><?php echo $this->item->electricity_2; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ELECTRICITY_3'); ?></th>
			<td><?php echo $this->item->electricity_3; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ELECTRICITY_4'); ?></th>
			<td><?php echo $this->item->electricity_4; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ELECTRICITY_5'); ?></th>
			<td><?php echo $this->item->electricity_5; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ELECTRICITY_6'); ?></th>
			<td><?php echo $this->item->electricity_6; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_ALLOWANCE_36'); ?></th>
			<td><?php echo $this->item->allowance_36; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_BASE_PAY'); ?></th>
			<td><?php echo $this->item->base_pay; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_EXTRA_INCOME'); ?></th>
			<td><?php echo $this->item->extra_income; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_CONFIG_TIME_UPDATE'); ?></th>
			<td><?php echo $this->item->time_update; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=config.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_FM_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_fm.config.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=config.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_FM_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_FM_ITEM_NOT_LOADED');
endif;
?>
