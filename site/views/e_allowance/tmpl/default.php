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
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_GUID'); ?></th>
			<td><?php echo $this->item->guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_EMPLOYEE_GUID'); ?></th>
			<td><?php echo $this->item->employee_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_FE_ALLOWANCES'); ?></th>
			<td><?php echo $this->item->fe_allowances; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_OPTION_ALLOWANCE'); ?></th>
			<td><?php echo $this->item->option_allowance; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_EARN_SALARY'); ?></th>
			<td><?php echo $this->item->earn_salary; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_OPTION_STUDY'); ?></th>
			<td><?php echo $this->item->option_study; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_OPTION_BREAK'); ?></th>
			<td><?php echo $this->item->option_break; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_ALLOWANCE_OTHER'); ?></th>
			<td><?php echo $this->item->allowance_other; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_INFO_ALLOWANCE'); ?></th>
			<td><?php echo $this->item->info_allowance; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_E_ALLOWANCE_INFO_PAYROLL'); ?></th>
			<td><?php echo $this->item->info_payroll; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=e_allowance.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_FM_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_fm.e_allowance.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=e_allowance.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_FM_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_FM_ITEM_NOT_LOADED');
endif;
?>
