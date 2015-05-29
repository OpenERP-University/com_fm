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
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_GUID'); ?></th>
			<td><?php echo $this->item->guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_EMPLOYEE_GUID'); ?></th>
			<td><?php echo $this->item->employee_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_DEPARTMENT_GUID'); ?></th>
			<td><?php echo $this->item->department_guid; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_FM_FORM_LBL_EMPLOYEEPAYROLL_PAYROLL'); ?></th>
			<td><?php echo $this->item->payroll; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=employeepayroll.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_FM_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_fm.employeepayroll.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fm&task=employeepayroll.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_FM_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_FM_ITEM_NOT_LOADED');
endif;
?>
