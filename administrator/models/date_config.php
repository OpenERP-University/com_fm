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
    public function changeCheckoutTime($checkField = 'checkout_time_payroll') {
        if ($checkField) {
            $db = JFactory::getDbo();

            $db->transactionStart();

            try {
                $now = getdate();
                $currentDate = $now["mon"];
                $query = $db->getQuery(true);

                $query
                        ->update($this->_tbl)
                        ->set($db->quoteName($db->escape($checkField)) . "= DATE_FORMAT(" . $db->quoteName($db->escape($checkField)) . ", '%y-" . $currentDate . "-%d');" );
                        
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
