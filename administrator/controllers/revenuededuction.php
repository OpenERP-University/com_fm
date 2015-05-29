<?php
/**
 * @version     1.0.0
 * @package     com_fm
 * @copyright   Bản quyền (C) 2015. Các quyền đều được bảo vệ.
 * @license     bản quyền mã nguồn mở GNU phiên bản 2
 * @author      NghiaDinhTrong <dinhtrongnghia92@gmail.com> - https://www.facebook.com/G55.RaFiKi
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Revenuededuction controller class.
 */
class FmControllerRevenuededuction extends JControllerForm
{

    function __construct() {
        $this->view_list = 'revenuedeductions';
        parent::__construct();
    }

}