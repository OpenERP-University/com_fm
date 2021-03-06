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
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Fm.
 */
class FmViewRevenuedeductions extends JViewLegacy {

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

        FmHelper::addSubmenu('revenuedeductions');

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

        JToolBarHelper::title(JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'), 'revenuedeductions.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/revenuededuction';
        if (file_exists($formPath)) {

//            if ($canDo->get('core.create')) {
//                JToolBarHelper::addNew('revenuededuction.add', 'JTOOLBAR_NEW');
//            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('revenuededuction.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('revenuedeductions.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('revenuedeductions.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
//                JToolBarHelper::deleteList('', 'revenuedeductions.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('revenuedeductions.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('revenuedeductions.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
//        if (isset($this->items[0]->state)) {
//            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
//                JToolBarHelper::deleteList('', 'revenuedeductions.delete', 'JTOOLBAR_EMPTY_TRASH');
//                JToolBarHelper::divider();
//            } else if ($canDo->get('core.edit.state')) {
//                JToolBarHelper::trash('revenuedeductions.trash', 'JTOOLBAR_TRASH');
//                JToolBarHelper::divider();
//            }
//        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_fm');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_fm&view=revenuedeductions');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);
                                                
        //Filter for the field employee_guid;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_fm.revenuededuction', 'revenuededuction');

        $field = $form->getField('employee_guid');

        $query = $form->getFieldAttribute('filter_employee_guid','query');
        $translate = $form->getFieldAttribute('filter_employee_guid','translate');
        $key = $form->getFieldAttribute('filter_employee_guid','key_field');
        $value = $form->getFieldAttribute('filter_employee_guid','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Tên cán bộ',
            'filter_employee_guid',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.employee_guid')),
            true
        );
    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.employee_guid' => JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'),
		'a.pay_electricity' => JText::_('COM_FM_REVENUEDEDUCTIONS_PAY_ELECTRICITY'),
		'a.water_charges' => JText::_('COM_FM_REVENUEDEDUCTIONS_WATER_CHARGES'),
		'a.rent' => JText::_('COM_FM_REVENUEDEDUCTIONS_RENT'),
		'a.detain_type' => JText::_('COM_FM_REVENUEDEDUCTIONS_DETAIN_TYPE'),
		'a.detain' => JText::_('COM_FM_REVENUEDEDUCTIONS_DETAIN'),
		);
	}

}
