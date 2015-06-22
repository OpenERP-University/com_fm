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
* @package com_hrm
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
class FmViewE_allowances extends JViewLegacy {

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

        FmHelper::addSubmenu('e_allowances');

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

        JToolBarHelper::title(JText::_('COM_FM_TITLE_E_ALLOWANCES'), 'e_allowances.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/e_allowance';
        if (file_exists($formPath)) {

//            if ($canDo->get('core.create')) {
//                JToolBarHelper::addNew('e_allowance.add', 'JTOOLBAR_NEW');
//            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('e_allowance.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('e_allowances.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('e_allowances.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
//                JToolBarHelper::deleteList('', 'e_allowances.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('e_allowances.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('e_allowances.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'e_allowances.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('e_allowances.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_fm');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_fm&view=e_allowances');

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
        $form = JForm::getInstance('com_fm.e_allowance', 'e_allowance');

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
		//Filter for the field option_allowance
		$select_label = JText::sprintf('COM_FM_FILTER_SELECT_LABEL', 'Phụ cấp nghề');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "X";
		$options[1] = new stdClass();
		$options[1]->value = "2";
		$options[1]->text = "Y";
		$options[2] = new stdClass();
		$options[2]->value = "3";
		$options[2]->text = "Z";
		$options[3] = new stdClass();
		$options[3]->value = "4";
		$options[3]->text = "Khác";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_option_allowance',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.option_allowance'), true)
		);

		//Filter for the field option_study
		$select_label = JText::sprintf('COM_FM_FILTER_SELECT_LABEL', 'Đi học');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "Đi học trong nước";
		$options[1] = new stdClass();
		$options[1]->value = "2";
		$options[1]->text = "Đi học nước ngoài";
		$options[2] = new stdClass();
		$options[2]->value = "3";
		$options[2]->text = "Không";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_option_study',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.option_study'), true)
		);

		//Filter for the field option_break
		$select_label = JText::sprintf('COM_FM_FILTER_SELECT_LABEL', 'Trạng thái');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "Không nghỉ";
		$options[1] = new stdClass();
		$options[1]->value = "2";
		$options[1]->text = "Nghỉ đẻ";
		$options[2] = new stdClass();
		$options[2]->value = "3";
		$options[2]->text = "Nghỉ không lương";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_option_break',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.option_break'), true)
		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.employee_guid' => JText::_('COM_FM_E_ALLOWANCES_EMPLOYEE_GUID'),
		'a.fe_allowances' => JText::_('COM_FM_E_ALLOWANCES_FE_ALLOWANCES'),
		'a.option_allowance' => JText::_('COM_FM_E_ALLOWANCES_OPTION_ALLOWANCE'),
		'a.earn_salary' => JText::_('COM_FM_E_ALLOWANCES_EARN_SALARY'),
		'a.option_study' => JText::_('COM_FM_E_ALLOWANCES_OPTION_STUDY'),
		'a.option_break' => JText::_('COM_FM_E_ALLOWANCES_OPTION_BREAK'),
		'a.allowance_other' => JText::_('COM_FM_E_ALLOWANCES_ALLOWANCE_OTHER'),
		);
	}

}
