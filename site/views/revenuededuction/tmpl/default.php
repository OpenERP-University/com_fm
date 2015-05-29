<?php
/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      NghiaDinhTrong <dinhtrongnghia92@gmail.com> - https://www.facebook.com/G55.RaFiKi
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
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_GUID'); ?></th>
			<td><?php echo $this->item->guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_EMPLOYEE_GUID'); ?></th>
			<td><?php echo $this->item->employee_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_PAY_ELECTRICITY'); ?></th>
			<td><?php echo $this->item->pay_electricity; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_WATER_CHARGES'); ?></th>
			<td><?php echo $this->item->water_charges; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT'); ?></th>
			<td><?php echo $this->item->rent; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_DETAIN_TYPE'); ?></th>
			<td><?php echo $this->item->detain_type; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_DETAIN'); ?></th>
			<td><?php echo $this->item->detain; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_TIME_UPDATE'); ?></th>
			<td><?php echo $this->item->time_update; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=revenuededuction.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_FM_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_fm.revenuededuction.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=revenuededuction.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_FM_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_FM_ITEM_NOT_LOADED');
endif;
?>
