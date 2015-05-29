<?php

/**
 * @version     1.0.0
 * @package     com_hrm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      Dinh Trong Nghia <ddinhtrongnghia92@gmail.com > - https://www.facebook.com/G55.RaFiKi
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Hrm model.
 */
class FmModelSalaryhistory extends JModelAdmin {

    public function getForm($data = array(), $loadData = true) {
        
    }

    /*     * Creat GUID
     * 
     * @return type
     */

    public function GUID() {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');
        else
            return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    

    /** get month, year from history_salary
     * 
     * @return type
     */
    public function getSalary($month = NULL, $year = NULL) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select(array($db->quoteName('workmonth'), $db->quoteName('workyear')))
                ->from('`#__fm_history_salary`')
                ->where($db->quoteName('workmonth') . ' = ' . $db->quote($db->escape($month)))
                ->where($db->quoteName('workyear') . ' = ' . $db->quote($db->escape($year)));
        $db->setQuery($query);
        $result = $db->loadAssocList();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    
      /** Insert history payroll
     * 
     * @param type $month
     * @param type $year
     * @param type $salary
     * @return type
     */
    public function insertInfoPayroll($month = NULL, $year = NULL, $salary = NULL) {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "INSERT INTO `#__fm_history_salary`(`guid`,`workmonth`,`workyear`,`salary`) VALUES (" . $db->quote($db->escape($this->GUID())) . "," . $db->quote($db->escape($month)) . "," . $db->quote($db->escape($year)) . "," . $db->quote(($salary)) . ");";
        $db->setQuery($query);
        $result = $db->execute();
        return $result;
    }

    /*     * get payroll form history_salary with month =select, year  =select
     * 
     * @param type $month
     * @param type $year
     * @return boolean
     */

    public function getPayroll($month = NULL, $year = NULL) {
        if ($month || $year) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select(array($db->quoteName('salary'),$db->quoteName('workmonth'), $db->quoteName('workyear')))
                    ->from('`#__fm_history_salary`');
            if ($month) {
                $query->where($db->quoteName('workmonth') . ' = ' . $db->quote($db->escape($month)));
            }
            if ($year) {
                $query->where($db->quoteName('workyear') . ' = ' . $db->quote($db->escape($year)));
            }

            $db->setQuery($query);
            $results = $db->loadAssocList();
            if ($results) {
                return $results;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /** get fullname employee 
     * 
     * @param type $employee_guid
     * @return boolean
     */
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

    /*     * get name department form table department
     * 
     * @param type $department_guid
     * @return boolean
     */

    public function getDepartment($department_guid = NULL) {
        if ($department_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('title'))
                    ->from('`#__hrm_departments`')
                    ->where($db->quoteName('guid') . ' = ' . $db->quote($db->escape($department_guid)));
            $db->setQuery($query);
            $title = $db->loadResult();
            if ($title) {
                return $title;
            }
        } else {
            return FALSE;
        }
    }

}
