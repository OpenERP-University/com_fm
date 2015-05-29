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
