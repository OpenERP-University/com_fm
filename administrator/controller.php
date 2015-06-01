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

class FmController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/fm.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'configs');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->saveSalary();
        $this->Payroll();
    }

    /** function payroll -  tính lương
     * Tính lương theo tháng
     */
    public function Payroll() {
        $date_payroll = JComponentHelper::getParams('com_fm')->get('date_payroll');
        $model_date_config = $this->getModel('date_config');
        //    $config = $model_date_config->getDateConfig()[0];
        if ($date_payroll) {
            $this->updatePayroll($date_payroll);
        } else {
            $this->updatePayroll();
        }
    }

    public function updatePayroll($date_payroll = 25) {
        $model_date_config = $this->getModel('date_config');
        if ($model_date_config->checkConfig($date_payroll)) {
            if ($model_date_config->checkDate()) {
                $payroll_model = $this->getModel("employeepayrolls");
                if ($payroll_model->updateSalary()) {
                    $model_date_config->updateCheckoutTime();
                }
            }
        } else if (!$model_date_config->date_config_update($date_payroll)) {
            $this->setError(JText::_('COM_FM_ERROR_NOTIFYCAL'));
        }
    }

    /*     * Chuyển dữ liệu lương về json - hiện lương theo ngày tháng chọn
     * 
     */

    public function view_salary() {
        JFactory::getDocument()->setMimeEncoding('application/json');

        $data = $this->dataEmployeeSalary();

        echo json_encode($data);

        JFactory::getApplication()->close();
    }

    /* Lấy 1 mảng dữ liệu các thuộc tính liên quan đến lương của cán bộ
     * trả về json để lưu vào csdl
     */

    public function dataPayroll() {
        $payroll_model = $this->getModel("employeepayrolls");
        $item = $payroll_model->Connect();
        $result = $payroll_model->Math($item['CB'], $item['heso']);

        return json_encode($result);
    }

    /**
     * Lưu mảng dl liên quan tới lương , theo ngày tháng dc chọn trong option
     */
    public function saveSalary() {

        $date_salary = JComponentHelper::getParams('com_fm')->get('date_salary');
        $model_date_config = $this->getModel('date_config');
        if ($date_salary) {
            $this->insertSalary($date_salary);
        } else
            $this->insertSalary();
    }

    public function insertSalary($date_salary = 26) {
        $model_date_config = $this->getModel('date_config');
        if ($model_date_config->checkConfig($date_salary, 'date_salary')) {

            if ($model_date_config->checkDate('checkout_time_salary')) {
                $infosalary_model = $this->getModel('salaryhistory');
                $salary = $this->dataPayroll();
                if ($infosalary_model->insertInfoPayroll($salary)) {
                    $model_date_config->updateCheckoutTime('checkout_time_salary');
                }
            }
        } else if (!$model_date_config->date_config_update($date_salary,'date_salary','checkout_time_salary')) {
            $this->setError(JText::_('COM_FM_ERROR_NOTIFYCAL'));
        }
    }

    /**
     * Lấy dữ liệu về lương dc lưu thành json ra theo ngày tháng dc chọn
     * Chuyên thành mảng
     * @return type
     */
    public function dataEmployeeSalary() {
        $input = JFactory::getApplication()->input;

        $param['month'] = $input->get("month");
        $param['year'] = $input->get("year");

        $salary_model = $this->getModel("salaryhistory");
//cái lịch sử lương ở đây
        $salary = $salary_model->getPayroll($param['month'], $param['year']);

//gọi đến hàm để lấy các dữ liệu từ cái salary ra
        //$salary = str_replace('},{', ",", $salary);
        $j = 0;
        foreach ($salary as $json) {
            $salarydecode[$j] = json_decode($json['salary']);
            $month[$j] = $json['workmonth'];
            $year[$j] = $json['workyear'];

            $j++;
        }

        $i = 0;
        $j = 0;
        $k = 0;
        $n = 0;
        $m = 0;

        // $n= count($salarydecode['TienLuong_CB']);
        foreach ($salarydecode as $value) {
            foreach ($value->employee_guid as $data) {
                $fullname[$i] = $salary_model->getEmployeeName($data);
                $year_salary[$i] = $year[$k];
                $month_salary[$i] = $month[$k];
                $i++;
            }
            $k++;

            $n = count($value->employee_guid);
            for ($j = 0; $j < $n; $j++) {
                $department[$j + $m] = $value->DonVi[$j];
                $salary_employee[$j + $m] = $value->TienLuong_CB[$j];
                $HSPC_CV[$j + $m] = $value->HSPC_CV[$j];
                $HSPV_VK[$j + $m] = $value->HSPV_VK[$j];
                $HSPC_Nghe [$j + $m] = $value->HSPC_Nghe[$j];
                $HSML[$j + $m] = $value->HSML[$j];
                $HSPCTN[$j + $m] = $value->HSPCTN[$j];
                $TongHeSo[$j + $m] = $value->TongHeSo[$j];
                $TienLuong_PC[$j + $m] = $value->TienLuong_PC[$j];
                $BHXH[$j + $m] = $value->BHXH[$j];
                $BHYT[$j + $m] = $value->BHYT[$j];
                $BHTN[$j + $m] = $value->BHTN[$j];
                $TienNha[$j + $m] = $value->TienNha[$j];
                $TienDien[$j + $m] = $value->TienDien[$j];
                $TienNuoc[$j + $m] = $value->TienNuoc[$j];
                $TamGiu[$j + $m] = $value->TamGiu[$j];
                $TienGiamTru[$j + $m] = $value->TienGiamTru[$j];
                $LuongPC[$j + $m] = $value->LuongPC[$j];
                $TNTT[$j + $m] = $value->TNTT[$j];
                $PC36[$j + $m] = $value->PC36[$j];
                $employee_guid[$j + $m] = $value->employee_guid[$j];
            }
            $m = $m + $n;
        }


        $data = array(
            "month" => $month_salary,
            "years" => $year_salary,
            "salary" => $salary_employee,
            "fullname" => $fullname,
            "department" => $department,
            "HSPC_CV" => $HSPC_CV,
            "HSPC_VK" => $HSPV_VK,
            "HSPC_Nghe" => $HSPC_Nghe,
            "HSML" => $HSML,
            "HSPCTN" => $HSPCTN,
            "TongHeSo" => $TongHeSo,
            "TienLuong_PC" => $TienLuong_PC,
            "BHXH" => $BHXH,
            "BHYT" => $BHYT,
            "BHTN" => $BHTN,
            "TienNha" => $TienNha,
            "TienDien" => $TienDien,
            "TienNuoc" => $TienNuoc,
            "TamGiu" => $TamGiu,
            "TienGiamTru" => $TienGiamTru,
            "LuongPC" => $LuongPC,
            "TNTT" => $TNTT,
            "PC36" => $PC36,
            "employee_guid" => $employee_guid
        );
        return $data;
    }

    /**
     * Export excel chi tiết
     */
    public function exportExcel() {
        require_once JPATH_COMPONENT . '/helpers/excel.php';
        $input = JFactory::getApplication()->input;

        $param['month'] = $input->get("month");
        $param['year'] = $input->get("year");
        $data = $this->dataEmployeeSalary();
        if ($data && $param) {
            FmHelperExcel::ExportExcel($param, $data);
        } else {
            return FALSE;
        }
    }

    /**
     * export excel theo từng cán bộ chọn
     */
    public function exportExcelEmployee() {
        require_once JPATH_COMPONENT . '/helpers/excel.php';
        $input = JFactory::getApplication()->input;

        $param['month'] = $input->get("month");
        $param['year'] = $input->get("year");
        $param['id'] = $input->get("id");
        $id = explode("_", $param['id']);
        $n = count($id) - 1;
        $data = $this->dataEmployeeSalary();

        for ($i = 0; $i < $n; $i++) {
            $month_salary[$i] = $data['month'][$id[$i]];
            $year_salary[$i] = $data['years'][$id[$i]];
            $fullname[$i] = $data['fullname'][$id[$i]];
            $department[$i] = $data['department'][$id[$i]];
            $salary_employee[$i] = $data['salary'][$id[$i]];
            $HSPC_CV[$i] = $data['HSPC_CV'][$id[$i]];
            $HSPV_VK[$i] = $data['HSPC_VK'][$id[$i]];
            $HSPC_Nghe [$i] = $data['HSPC_Nghe'][$id[$i]];
            $HSML[$i] = $data['HSML'][$id[$i]];
            $HSPCTN[$i] = $data['HSPCTN'][$id[$i]];
            $TongHeSo[$i] = $data['TongHeSo'][$id[$i]];
            $TienLuong_PC[$i] = $data['TienLuong_PC'][$id[$i]];
            $BHXH[$i] = $data['BHXH'][$id[$i]];
            $BHYT[$i] = $data['BHYT'][$id[$i]];
            $BHTN[$i] = $data['BHTN'][$id[$i]];
            $TienNha[$i] = $data['TienNha'][$id[$i]];
            $TienDien[$i] = $data['TienDien'][$id[$i]];
            $TienNuoc[$i] = $data['TienNuoc'][$id[$i]];
            $TamGiu[$i] = $data['TamGiu'][$id[$i]];
            $TienGiamTru[$i] = $data['TienGiamTru'][$id[$i]];
            $LuongPC[$i] = $data['LuongPC'][$id[$i]];
            $TNTT[$i] = $data['TNTT'][$id[$i]];
            $PC36[$i] = $data['PC36'][$id[$i]];
        }

        $data = array(
            "month" => $month_salary,
            "years" => $year_salary,
            "salary" => $salary_employee,
            "fullname" => $fullname,
            "department" => $department,
            "HSPC_CV" => $HSPC_CV,
            "HSPC_VK" => $HSPV_VK,
            "HSPC_Nghe" => $HSPC_Nghe,
            "HSML" => $HSML,
            "HSPCTN" => $HSPCTN,
            "TongHeSo" => $TongHeSo,
            "TienLuong_PC" => $TienLuong_PC,
            "BHXH" => $BHXH,
            "BHYT" => $BHYT,
            "BHTN" => $BHTN,
            "TienNha" => $TienNha,
            "TienDien" => $TienDien,
            "TienNuoc" => $TienNuoc,
            "TamGiu" => $TamGiu,
            "TienGiamTru" => $TienGiamTru,
            "LuongPC" => $LuongPC,
            "TNTT" => $TNTT,
            "PC36" => $PC36
        );
        if ($data && $param) {
            FmHelperExcel::tableExcel($param, $data);
        } else {
            return FALSE;
        }
    }

}
