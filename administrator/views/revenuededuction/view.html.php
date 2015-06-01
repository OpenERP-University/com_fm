<?php

/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      NghiaDinhTrong <dinhtrongnghia92@gmail.com> - https://www.facebook.com/G55.RaFiKi
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class FmViewRevenuededuction extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');
        $this->item->employeeName = $this->getEmployeeName($this->item->employee_guid);
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
        $canDo = FmHelper::getActions();

        JToolBarHelper::title(JText::_('COM_FM_TITLE_REVENUEDEDUCTION'), 'revenuededuction.png');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create')))) {

            JToolBarHelper::apply('revenuededuction.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('revenuededuction.save', 'JTOOLBAR_SAVE');
        }
        if (!$checkedOut && ($canDo->get('core.create'))) {
            JToolBarHelper::custom('revenuededuction.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        }
        // If an existing item, can save to a copy.
//        if (!$isNew && $canDo->get('core.create')) {
//            JToolBarHelper::custom('revenuededuction.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
//        }
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('revenuededuction.cancel', 'JTOOLBAR_CANCEL');
        } else {
            if ($this->state->params->get('save_history', 0) && $user->authorise('core.edit')) {
                JToolbarHelper::versions('com_fm.revenuededuction', $this->item->id);
            }
            JToolBarHelper::cancel('revenuededuction.cancel', 'JTOOLBAR_CLOSE');
        }
    }

    public function getEmployeeName($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('fullname'))
                    ->from('`#__hrm_employee`')
                    ->where($db->quoteName('guid') . ' = ' . $db->quote($db->escape($employee_guid)));
            $db->setQuery($query);
            $employee_name = $db->loadResult();
            if ($employee_name) {
                return $employee_name;
            }
        } else {
            return FALSE;
        }
    }

}
