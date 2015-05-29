<?php

/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      Nghia <dinhtrongnghia92@gmail.com> - http://www.facebook.com/G55.RaFiKi
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Fm records.
 */
class FmModelE_allowances extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'guid', 'a.guid',
                'employee_guid', 'a.employee_guid',
                'fe_allowances', 'a.fe_allowances',
                'option_allowance', 'a.option_allowance',
                'earn_salary', 'a.earn_salary',
                'option_study', 'a.option_study',
                'option_break', 'a.option_break',
                'allowance_other', 'a.allowance_other',
                'info_allowance', 'a.info_allowance',
                'info_payroll', 'a.info_payroll',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering employee_guid
		$this->setState('filter.employee_guid', $app->getUserStateFromRequest($this->context.'.filter.employee_guid', 'filter_employee_guid', '', 'string'));

		//Filtering option_allowance
		$this->setState('filter.option_allowance', $app->getUserStateFromRequest($this->context.'.filter.option_allowance', 'filter_option_allowance', '', 'string'));

		//Filtering option_study
		$this->setState('filter.option_study', $app->getUserStateFromRequest($this->context.'.filter.option_study', 'filter_option_study', '', 'string'));

		//Filtering option_break
		$this->setState('filter.option_break', $app->getUserStateFromRequest($this->context.'.filter.option_break', 'filter_option_break', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_fm');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.employee_guid', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__fm_e_allowance` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the foreign key 'employee_guid'
		$query->select('#__hrm_employee_1805192.fullname AS employees_fullname_1805192');
		$query->join('LEFT', '#__hrm_employee AS #__hrm_employee_1805192 ON #__hrm_employee_1805192.guid = a.employee_guid');
        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.employee_guid LIKE '.$search.'  OR  a.fe_allowances LIKE '.$search.'  OR  a.option_allowance LIKE '.$search.'  OR  a.earn_salary LIKE '.$search.'  OR  a.option_study LIKE '.$search.'  OR  a.option_break LIKE '.$search.'  OR  a.allowance_other LIKE '.$search.' )');
            }
        }

        

		//Filtering employee_guid
		$filter_employee_guid = $this->state->get("filter.employee_guid");
		if ($filter_employee_guid) {
			$query->where("a.employee_guid = '".$db->escape($filter_employee_guid)."'");
		}

		//Filtering option_allowance
		$filter_option_allowance = $this->state->get("filter.option_allowance");
		if ($filter_option_allowance) {
			$query->where("a.option_allowance = '".$db->escape($filter_option_allowance)."'");
		}

		//Filtering option_study
		$filter_option_study = $this->state->get("filter.option_study");
		if ($filter_option_study) {
			$query->where("a.option_study = '".$db->escape($filter_option_study)."'");
		}

		//Filtering option_break
		$filter_option_break = $this->state->get("filter.option_break");
		if ($filter_option_break) {
			$query->where("a.option_break = '".$db->escape($filter_option_break)."'");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {

			if (isset($oneItem->employee_guid)) {
				$values = explode(',', $oneItem->employee_guid);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('fullname'))
							->from('`#__hrm_employee`')
							->where($db->quoteName('guid') . ' = '. $db->quote($db->escape($value)))
							->where($db->quoteName('state') . ' >= 0');
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->fullname;
					}
				}

			$oneItem->employee_guid = !empty($textValue) ? implode(', ', $textValue) : $oneItem->employee_guid;

			}
					$oneItem->option_allowance = JText::_('COM_FM_E_ALLOWANCES_OPTION_ALLOWANCE_OPTION_' . strtoupper($oneItem->option_allowance));
					$oneItem->option_study = JText::_('COM_FM_E_ALLOWANCES_OPTION_STUDY_OPTION_' . strtoupper($oneItem->option_study));
					$oneItem->option_break = JText::_('COM_FM_E_ALLOWANCES_OPTION_BREAK_OPTION_' . strtoupper($oneItem->option_break));
		}
        return $items;
    }

}
