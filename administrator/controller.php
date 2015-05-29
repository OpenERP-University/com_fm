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

    public function Payroll() {
        $date_payroll = JComponentHelper::getParams('com_fm')->get('date_payroll');
        if ($date_payroll) {

            $now = getdate();
            $date_now = $now["mday"];
            $month = $now["mon"];
            $payroll_model = $this->getModel("employeepayroll");
            $item = $payroll_model->Connect();
            if ($date_payroll == 25) {
                $payroll = $payroll_model->Math($item['CB'], $item['heso']);
                $info_payroll = $payroll_model->mathSalary($item['CB']);
            }
        }
    }

    public function view_salary() {
        JFactory::getDocument()->setMimeEncoding('application/json');

        $input = JFactory::getApplication()->input;

        $month = $input->get("month");
        $year = $input->get("year");
        $salary_model = $this->getModel("salaryhistory");
//cái lịch sử lương ở đây
        $salary = $salary_model->getPayroll($month, $year);

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
        $h = 0;
        $k = 0;
        
        // $n= count($salarydecode['TienLuong_CB']);
        foreach ($salarydecode as $value) {
            foreach ($value->employee_guid as $data) {
                $fullname[$i] = $salary_model->getEmployeeName($data);
                $year_salary[$i] = $year[$k];
                $month_salary[$i] = $month[$k];
                $i++;
            }
            $k++;

            foreach ($value->DonVi as $data) {
                $department[$j] = $data;
                $j++;
            }

            foreach ($value->TienLuong_CB as $data) {
                $salary_employee[$h] = $data;
                $h++;
            }

        }
       
        $data = array(
            "month" => $month_salary,
            "years" => $year_salary,
            "salary" => $salary_employee,
            "fullname" => $fullname,
            "department" => $department   
        );

        echo json_encode($data);
        
        JFactory::getApplication()->close();
    }

    public function dataPayroll() {
        $payroll_model = $this->getModel("employeepayroll");
        $item = $payroll_model->Connect();
        $result = $payroll_model->Math($item['CB'], $item['heso']);

        return json_encode($result);
    }

    public function saveSalary() {
        $date_salary = JComponentHelper::getParams('com_fm')->get('date_salary');
        $date_payroll = JComponentHelper::getParams('com_fm')->get('date_payroll');
        if ($date_salary) {

            $now = getdate();
            $date_now = $now["mday"];
            $month = $now["mon"];
            $year = $now["year"];
            $infosalary_model = $this->getModel('salaryhistory');
            $infosalary = $infosalary_model->getSalary($month, $year);
            // $payroll_model = $this->getModel("employeepayroll");
            $salary = $this->dataPayroll();
            if ($infosalary == NULL) {
                if ($date_salary == 26 && $date_salary > $date_payroll) {
                    $infosalary_model->insertInfoPayroll($month, $year, $salary);
                }
                if ($date_salary == 26 && $date_salary < $date_payroll) {
                    $month = $month - 1;
                    $infosalary_model->insertInfoPayroll($month, $year, $salary);
                }
            }
        }
    }

    public function exportExcel() {
        require_once JPATH_COMPONENT . '/helpers/excel.php';
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
        $h = 0;
        $k = 0;
        $n=0;$m=0; $a=0;$b=0;$c=0;$d=0;$e=0;$f=0;$g=0;$l=0;$a1=0;$b1=0;$c1=0;$d1=0;$e1=0;$f1=0;$h1=0;$g1=0;
        // $n= count($salarydecode['TienLuong_CB']);
        foreach ($salarydecode as $value) {
            foreach ($value->employee_guid as $data) {
                $fullname[$i] = $salary_model->getEmployeeName($data);
                $year_salary[$i] = $year[$k];
                $month_salary[$i] = $month[$k];
                $i++;
            }
            $k++;

            foreach ($value->DonVi as $data) {
                $department[$j] = $data;
                $j++;
            }

            foreach ($value->TienLuong_CB as $data) {
                $salary_employee[$h] = $data;
                $h++;
            }

            foreach ($value->HSPC_CV as $data) {
                $HSPC_CV[$n] = $data;
                $n++;
            }
            foreach ($value->HSPV_VK as $data) {
                $HSPV_VK[$m] = $data;
                $m++;
            }
            foreach ($value->HSPC_Nghe as $data) {
                $HSPC_Nghe[$a] = $data;
                $a++;
            }
            foreach ($value->HSML as $data) {
                $HSML[$b] = $data;
                $b++;
            }
         
            foreach ($value->HSPCTN as $data) {
                $HSPCTN[$g1] = $data;
                $g1++;
            }
            foreach ($value->TongHeSo as $data) {
                $TongHeSo[$c] = $data;
                $c++;
            }
            foreach ($value->TienLuong_PC as $data) {
                $TienLuong_PC[$d] = $data;
                $d++;
            }
            foreach ($value->BHXH as $data) {
                $BHXH[$e] = $data;
                $e++;
            }
            foreach ($value->BHYT as $data) {
                $BHYT[$f] = $data;
                $f++;
            }
            foreach ($value->BHTN as $data) {
                $BHTN[$g] = $data;
                $g++;
            }
            foreach ($value->TienNha as $data) {
                $TienNha[$l] = $data;
                $l++;
            }
            foreach ($value->TienDien as $data) {
                $TienDien[$a1] = $data;
                $a1++;
            }
            foreach ($value->TienNuoc as $data) {
                $TienNuoc[$b1] = $data;
                $b1++;
            }
            foreach ($value->TamGiu as $data) {
                $TamGiu[$c1] = $data;
                $c1++;
            }
            foreach ($value->TienGiamTru as $data) {
                $TienGiamTru[$d1] = $data;
                $d1++;
            }
            foreach ($value->LuongPC as $data) {
                $LuongPC[$e1] = $data;
                $e1++;
            }
            foreach ($value->TNTT as $data) {
                $TNTT[$f1] = $data;
                $f1++;
            }
            foreach ($value->PC36 as $data) {
                $PC36[$h1] = $data;
                $h1++;
            }
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
            "HSPCTN"=>$HSPCTN,
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
        
        FmHelperExcel::ExportExcel($param, $data);
    }

}
