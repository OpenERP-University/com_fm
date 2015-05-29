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

jimport('joomla.application.component.controllerform');

/**
 * Employeepayroll controller class.
 */
class FmControllerEmployeepayroll extends JControllerForm
{

    function __construct() {
        $this->view_list = 'employeepayrolls';
        
        parent::__construct();
    }
    
    public function linksalary()
    {
       
        $this->setRedirect(JRoute::_('index.php?option=com_fm&view=employeepayrolls&layout=listsalary', false));
        
    }

}