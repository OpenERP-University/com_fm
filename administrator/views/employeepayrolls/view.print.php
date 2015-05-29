<?php

/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      Nghia <dinhtrongnghia92@gmail.com> - http://www.facebook.com/G55.RaFiKi
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Fm.
 */
class FmViewEmployeepayrolls extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        FmHelper::addSubmenu('employeepayrolls');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/fm.php';

        $state = $this->get('State');
        $canDo = FmHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'), 'employeepayrolls.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/employeepayroll';
        if (file_exists($formPath)) {

//            if ($canDo->get('core.create')) {
//                JToolBarHelper::addNew('employeepayroll.add', 'JTOOLBAR_NEW');
//            }
//
//            if ($canDo->get('core.edit') && isset($this->items[0])) {
//                JToolBarHelper::editList('employeepayroll.edit', 'JTOOLBAR_EDIT');
//            }
        }
        if ($this->_layout != "listsalary") {
            if (empty($this->item->id)) {
                JToolBarHelper::custom('employeepayroll.linksalary', 'save.png', 'save_f2.png', 'COM_FM_EMPLOYEE_PAYROLL_VIEW', false);
            }

            if ($canDo->get('core.edit.state')) {

                if (isset($this->items[0]->state)) {
                    JToolBarHelper::divider();
                    JToolBarHelper::custom('employeepayrolls.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                    JToolBarHelper::custom('employeepayrolls.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
                } else if (isset($this->items[0])) {
                    //If this component does not use state then show a direct delete button as we can not trash
                    JToolBarHelper::deleteList('', 'employeepayrolls.delete', 'JTOOLBAR_DELETE');
                }

                if (isset($this->items[0]->state)) {
                    JToolBarHelper::divider();
                    JToolBarHelper::archiveList('employeepayrolls.archive', 'JTOOLBAR_ARCHIVE');
                }
                if (isset($this->items[0]->checked_out)) {
                    JToolBarHelper::custom('employeepayrolls.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
                }
            }

            //Show trash and delete for components that uses the state field
            if (isset($this->items[0]->state)) {
                if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                    JToolBarHelper::deleteList('', 'employeepayrolls.delete', 'JTOOLBAR_EMPTY_TRASH');
                    JToolBarHelper::divider();
                } else if ($canDo->get('core.edit.state')) {
                    JToolBarHelper::trash('employeepayrolls.trash', 'JTOOLBAR_TRASH');
                    JToolBarHelper::divider();
                }
            }

            if ($canDo->get('core.admin')) {
                JToolBarHelper::preferences('com_fm');
            }
        }
        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_fm&view=employeepayrolls');

        $this->extra_sidebar = '';

        JHtmlSidebar::addFilter(
                JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_published', JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)
        );

        //Filter for the field employee_guid;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_fm.employeepayroll', 'employeepayroll');

        $field = $form->getField('employee_guid');

        $query = $form->getFieldAttribute('filter_employee_guid', 'query');
        $translate = $form->getFieldAttribute('filter_employee_guid', 'translate');
        $key = $form->getFieldAttribute('filter_employee_guid', 'key_field');
        $value = $form->getFieldAttribute('filter_employee_guid', 'value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items)) {
            foreach ($items as $item) {
                if ($translate == true) {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                } else {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
                '$Employee', 'filter_employee_guid', JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.employee_guid')), true
        );
        //Filter for the field department_guid;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_fm.employeepayroll', 'employeepayroll');

        $field = $form->getField('department_guid');

        $query = $form->getFieldAttribute('filter_department_guid', 'query');
        $translate = $form->getFieldAttribute('filter_department_guid', 'translate');
        $key = $form->getFieldAttribute('filter_department_guid', 'key_field');
        $value = $form->getFieldAttribute('filter_department_guid', 'value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items)) {
            foreach ($items as $item) {
                if ($translate == true) {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                } else {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
                '$Department_guid', 'filter_department_guid', JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.department_guid')), true
        );
    }

    protected function getSortFields() {
        return array(
            'a.id' => JText::_('JGRID_HEADING_ID'),
            'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'a.state' => JText::_('JSTATUS'),
            'a.employee_guid' => JText::_('COM_FM_EMPLOYEEPAYROLLS_EMPLOYEE_GUID'),
            'a.department_guid' => JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'),
            'a.payroll' => JText::_('COM_FM_EMPLOYEEPAYROLLS_PAYROLL'),
        );
    }

}
