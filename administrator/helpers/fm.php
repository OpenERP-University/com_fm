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

/**
 * Fm helper.
 */
class FmHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
		
		//hệ số
        		JHtmlSidebar::addEntry(
			JText::_('COM_FM_TITLE_CONFIGS'),
			'index.php?option=com_fm&view=configs',
			$vName == 'configs'
		);
		
		//giảm trừ
				JHtmlSidebar::addEntry(
			JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'),
			'index.php?option=com_fm&view=revenuedeductions',
			$vName == 'revenuedeductions'
		);
		//phụ cấp
				JHtmlSidebar::addEntry(
			JText::_('COM_FM_TITLE_E_ALLOWANCES'),
			'index.php?option=com_fm&view=e_allowances',
			$vName == 'e_allowances'
		);
                                
               

		JHtmlSidebar::addEntry(
			JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'),
			'index.php?option=com_fm&view=employeepayrolls',
			$vName == 'employeepayrolls'
		);
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_fm';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
