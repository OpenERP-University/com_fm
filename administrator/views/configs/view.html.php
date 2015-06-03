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
class FmViewConfigs extends JViewLegacy {

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

        FmHelper::addSubmenu('configs');

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

        JToolBarHelper::title(JText::_('COM_FM_TITLE_CONFIGS'), 'configs.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/config';
        if (file_exists($formPath)) {

//            if ($canDo->get('core.create')) {
//                JToolBarHelper::addNew('config.add', 'JTOOLBAR_NEW');
//            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('config.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('configs.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('configs.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
//                JToolBarHelper::deleteList('', 'configs.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('configs.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('configs.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'configs.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('configs.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_fm');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_fm&view=configs');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.social_insurance_employee' => JText::_('COM_FM_CONFIGS_SOCIAL_INSURANCE_EMPLOYEE'),
		'a.social_insurance_support' => JText::_('COM_FM_CONFIGS_SOCIAL_INSURANCE_SUPPORT'),
		'a.medical_insurance_employee' => JText::_('COM_FM_CONFIGS_MEDICAL_INSURANCE_EMPLOYEE'),
		'a.medical_insurance_support' => JText::_('COM_FM_CONFIGS_MEDICAL_INSURANCE_SUPPORT'),
		'a.unemployment_insurance_employee' => JText::_('COM_FM_CONFIGS_UNEMPLOYMENT_INSURANCE_EMPLOYEE'),
		'a.unemployment_insurance_support' => JText::_('COM_FM_CONFIGS_UNEMPLOYMENT_INSURANCE_SUPPORT'),
		'a.union_employee' => JText::_('COM_FM_CONFIGS_UNION_EMPLOYEE'),
		'a.union_support' => JText::_('COM_FM_CONFIGS_UNION_SUPPORT'),
		);
	}

}
