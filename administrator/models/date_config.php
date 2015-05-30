<?php

/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      Nghia <dinhtrongnghia92@gmail.com> - http://www.facebook.com/G55.RaFiKi
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Fm model.
 */
class FmModelDate_config extends JModelAdmin {

    public function getForm($data = array(), $loadData = true) {
        
    }

    private $_tbl;

    public function __construct($config = array()) {
        $this->_tbl = '`#__fm_date_config`';
        parent::__construct($config);
    }

    public function getDateConfig() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);
        $query
                ->select('*')
                ->from($this->_tbl);
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if ($result) {
            return $result;
        }
        return 0;
    }

    /**
     * Kiem tra xem truong do co ton tai hay ko
     * 
     * @param type $day
     * @param type $checkField
     * @return type
     */
    public function checkConfig($day = 28, $checkField = 'date_payroll') {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select('count(`id`)')
                ->from($this->_tbl)
                ->where($db->quoteName($db->escape($checkField)) . ' = ' . $db->quote($db->escape($day)));
        $db->setQuery($query);
        
        return $db->loadResult();
    }

    public function checkDate($checkField = 'checkout_time_payroll') {
        if ($checkField) {
            $db = JFactory::getDbo();

            $query = $db->getQuery(true);

            $query
                    ->select('count(`id`)')
                    ->from($this->_tbl)
                    ->where($db->quoteName($db->escape($checkField)) . '<= NOW()');
            $db->setQuery($query);
            
            return $db->loadResult();
        }
        return FALSE;
    }

    public function updateCheckoutTime($checkField = 'checkout_time_payroll') {
        if ($checkField) {
            $db = JFactory::getDbo();

            $db->transactionStart();

            try {
                $query = $db->getQuery(true);

                $query
                        ->update($this->_tbl)
                        ->set($db->quoteName($db->escape($checkField)) . ' = DATE_ADD(' . $checkField . ', INTERVAL 1 MONTH)');
                $db->setQuery($query);
                
                $result = $db->execute();
                
                $db->transactionCommit();
                
                return $result;
            } catch (Exception $exc) {
                $db->transactionRollback();
                return FALSE;
            }
        }
        return FALSE;
    }
    
    
    public function date_config_update($day,$Field1 = 'date_payroll',$Field2 = 'checkout_time_payroll'){
        if($day && $Field1 && $Field2){
            $db = JFactory::getDbo();

            $db->transactionStart();

            try {
                $query = $db->getQuery(true);

                $query
                        ->update($this->_tbl)
                        ->set($db->quoteName($db->escape($Field1)) . " = " .$db->quote($db->escape($day)).",".$db->quoteName($db->escape($Field2))." = DATE_FORMAT(" . $db->quoteName($db->escape($Field2)) . ", '%y-%m-".$day."');");
                $db->setQuery($query);
                
                $result = $db->execute();
                
                $db->transactionCommit();
                
                return $result;
            } catch (Exception $exc) {
                $db->transactionRollback();
                return FALSE;
            }
        }
        return FALSE;
    }
}
