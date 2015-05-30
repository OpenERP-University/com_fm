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
class FmModelEmployeepayroll extends JModelAdmin {

    /**
     * @var		string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_FM';

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param	type	The table type to instantiate
     * @param	string	A prefix for the table class name. Optional.
     * @param	array	Configuration array for model. Optional.
     * @return	JTable	A database object
     * @since	1.6
     */
    public function getTable($type = 'Employeepayroll', $prefix = 'FmTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	JForm	A JForm object on success, false on failure
     * @since	1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_fm.employeepayroll', 'employeepayroll', array('control' => 'jform', 'load_data' => $loadData));


        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return	mixed	The data for the form.
     * @since	1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_fm.edit.employeepayroll.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param	integer	The id of the primary key.
     *
     * @return	mixed	Object on success, false on failure.
     * @since	1.6
     */
    public function getItem($pk = null) {
        if ($item = parent::getItem($pk)) {

            //Do any procesing on fields here if needed
        }

        return $item;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @since	1.6
     */
    protected function prepareTable($table) {
        jimport('joomla.filter.output');

        if (empty($table->id)) {

            // Set ordering to the last item if not set
            if (@$table->ordering === '') {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__fm_employee_payroll');
                $max = $db->loadResult();
                $table->ordering = $max + 1;
            }
        }
    }

    /** Kết nối
     * 
     * @return type
     */
    public function Connect() {

        $db = JFactory::getDbo();
        $db->setQuery('SELECT * FROM #__fm_employee_payroll');
        $result = $db->loadAssocList();

        $db = JFactory::getDbo();
        $db->setQuery('SELECT * FROM #__fm_config');
        $result_config = $db->loadObject();

        $this->item = array(
            "CB" => $result,
            "heso" => $result_config,
        );
        return $this->item;
    }

    /*     * Tinh toan
     * 
     * @param type $Cb
     * @param type $heso
     * @return type
     */

    public function Math($Cb = NUll, $heso = NULL) {
        $i = 0;
        foreach ($Cb as $value) {
            if ($value['employee_guid'] && $heso) {
                $employee_guid[$i] = $value['employee_guid'];
                $Heso_CV[$i] = (float) $this->getAllowances($value['employee_guid']);
                $Heso_ML[$i] = (float) $this->getCoefficient($value['employee_guid']);
                $CanBo[$i] = $this->getEmployee($value['employee_guid']);
                $LoaiCB[$i] = (float) $this->getEmployee_type($value['employee_guid']);
                $GiamTru_CB[$i] = $this->getDetain($value['employee_guid']);
                $PhuCap_TT[$i] = $this->getAllowanceEmployee($value['employee_guid']);
                $DonVi[$i] = $this->getDepartment($value['employee_guid']);
                //$Name[$i] = $this->getEmployeeName($this->items[0]->employee);
                //hệ số thâm niên
                //if($Heso_CV[$i])

                $ThamNien[$i] = (float) $this->TinhThamNien($CanBo[$i][0]['date_of_recruitment']);

                // hệ số hưởng  lương
                $Huong_Luong[$i] = (float) $PhuCap_TT[$i]->earn_salary;
                // hệ số vượt khung
                $HSVK[$i] = (float) $PhuCap_TT[$i]->fe_allowances;
                //trạng thái học tập
                $DiHoc[$i] = (float) $PhuCap_TT[$i]->option_study;
                //trang thái đi làm
                $TrangThai[$i] = (float) $PhuCap_TT[$i]->option_break;

                // Lương cơ bản
                $LuongCoBan = (float) $heso->base_pay;
                //hệ số phụ cấp chức vụ
                $HSPC_CV[$i] = (float) $this->TinhHSPC_CV($Huong_Luong[$i], $Heso_CV[$i]);
                // hệ số phụ cấp vượt khung
                $HSPC_VK[$i] = (float) $this->TinhHSPC_VK($HSVK[$i], $Heso_ML[$i]);
                // hệ số phụ cấp thâm niên
                $HSPC_TN[$i] = (float) $this->TinhHSPC_TN($Heso_ML[$i], $HSPC_CV[$i], $LoaiCB[$i], $ThamNien[$i], $DiHoc[$i]);
                //hệ số nghề
                $PhuCapX = (float) $heso->allowance_x;
                $PhuCapY = (float) $heso->allowance_y;
                $PhuCapZ = (float) $heso->allowance_z;
                $PhuCapKhac = (float) $heso->other_allowance;
                $LoaiPC[$i] = (float) $PhuCap_TT[$i]->option_allowance;

                //hệ số phụ cấp nghề
                $HSPC_Nghe[$i] = (float) $this->TinhHSPC_Nghe($Heso_ML[$i], $HSPC_VK[$i], $HSPC_CV[$i], $PhuCapX, $PhuCapY, $PhuCapZ, $PhuCapKhac, $LoaiPC[$i]);
                //số điện, nước, nhà
                $SoDien[$i] = (float) $GiamTru_CB[$i]->pay_electricity;
                $SoNuoc[$i] = (float) $GiamTru_CB[$i]->water_charges;
                $TienNha[$i] = (float) $GiamTru_CB[$i]->rent;
                //các loại giảm trừ
                $CacKhoan_GT[$i] = $this->GiamTru($heso, $SoDien[$i], $SoNuoc[$i], $Huong_Luong[$i], $LuongCoBan, $Heso_ML[$i], $HSPC_VK[$i], $HSPC_CV[$i], $HSPC_TN[$i], $LoaiCB[$i], $DiHoc[$i], $TrangThai[$i]);
                // các hệ số phu cấp khác
                $ThuNhapTT = (float) $heso->extra_income;
                $HSPC_QD36 = (float) $heso->allowance_36;

                //tạm giữ
                $LoaiTamGiu[$i] = (float) $GiamTru_CB[$i]->detain_type;
                $ThongSo[$i] = (float) $GiamTru_CB[$i]->detain;

                // Hệ số phụ cấp theo quy định 36
                $TienPC_QD36[$i] = $this->TinhPC_QD36($HSPC_QD36, $DiHoc[$i], $TrangThai[$i]);
                //thu nhập tăng thêm
                $TinhThuNhap_TT[$i] = $this->TinhThuNhapTT($Huong_Luong[$i], $Heso_ML[$i], $HSPC_VK[$i], $LuongCoBan, $ThuNhapTT, $DiHoc[$i], $TrangThai[$i]);
                //
                $TTDieuChinhPC[$i] = (float) $PhuCap_TT[$i]->info_allowance;
                $TTDieuChinhLuong[$i] = (float) $PhuCap_TT[$i]->info_payroll;
                //Cộng các loại hệ số
                $TongHS[$i] = $HSPC_CV[$i] + $HSPC_Nghe[$i] + $HSPC_VK[$i] + $HSPC_TN[$i] + $Heso_ML[$i];
                //Tính lương phụ cấp
                $Luong_PC[$i] = $TongHS[$i] * $LuongCoBan;

                $Luong_PC1[$i] = ($Huong_Luong[$i] / 100) * $TongHS[$i] * $LuongCoBan;
                //Cac khoan giam tru
                $TienDien[$i] = $CacKhoan_GT[$i]['TienDien'];
                $TienNuoc[$i] = $CacKhoan_GT[$i]['TienNuoc'];
                $TinhBHXH[$i] = $CacKhoan_GT[$i]['BHXH'];
                $TinhBHYT[$i] = $CacKhoan_GT[$i]['BHYT'];
                $TinhBHTN[$i] = $CacKhoan_GT[$i]['BHTN'];

                $TinhTamGiu[$i] = $this->TinhTamGiu($LoaiTamGiu[$i], $ThongSo[$i], $Luong_PC1[$i]);
                $TienGiamTru[$i] = $TienDien[$i] + $TienNha[$i] + $TienNuoc[$i] + $TinhTamGiu[$i] + $TinhBHTN[$i] + $TinhBHXH[$i] + $TinhBHYT[$i];

                $Luong_PCSau[$i] = $Luong_PC[$i] - $TienGiamTru[$i];

                $TienLuong[$i] = $this->TinhLuong($Luong_PCSau[$i], $TinhThuNhap_TT[$i], $TienPC_QD36[$i], $TTDieuChinhPC[$i], $TTDieuChinhLuong[$i], $TrangThai[$i]);

                $i++;
            }
        }

        if ($Cb && $heso) {
            $this->TienLuong = array(
                "TienLuong_CB" => $TienLuong,
                "HSPC_CV" => $HSPC_CV,
                "HSPV_VK" => $HSPC_VK,
                "HSPC_Nghe" => $HSPC_Nghe,
                "HSML" => $Heso_ML,
                "HSPCTN"=>$HSPC_TN,
                "TongHeSo" => $TongHS,
                "TienLuong_PC" => $Luong_PC,
                "DonVi" => $DonVi,
                "BHXH" => $TinhBHXH,
                "BHYT" => $TinhBHYT,
                "BHTN" => $TinhBHTN,
                "TienNha" => $TienNha,
                "TienDien" => $TienDien,
                "TienNuoc" => $TienNuoc,
                "TamGiu" => $TinhTamGiu,
                "TienGiamTru" => $TienGiamTru,
                "LuongPC" => $Luong_PCSau,
                "TNTT" => $TinhThuNhap_TT,
                "PC36" => $TienPC_QD36,
                "employee_guid" => $employee_guid
            );
        }

        return $this->TienLuong;
    }
/**update payroll
 * 
 * @param type $Cb
 */
    public function mathSalary($Cb = NUll) {
        $i = 0;
        if ($Cb) {
            foreach ($Cb as $value) {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query = 'UPDATE `#__fm_employee_payroll`' .
                        ' SET `payroll` = ' . (float) $this->TienLuong['TienLuong_CB'][$i] .
                        ' WHERE employee_guid = ' . $db->quote($db->escape($value['employee_guid']));
                $db->setQuery($query);
                $result = $db->execute();
                $i++;
            }
        }
    }

  
    /**
     * Hàm lấy tên và ngày vào làm việc của cán bộ
     * @param type $employee_guid//guid của cán bộ
     * @return boolean// ngày được nhận vào làm  nếu có
     */
    public function getEmployee($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select(array($db->quoteName('fullname'), $db->quoteName('date_of_recruitment')))
                    ->from('`#__hrm_employee`')
                    ->where($db->quoteName('guid') . ' = ' . $db->quote($db->escape($employee_guid)));
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

    /*     * Lay don vi can bo
     * 
     * @param type $employee_guid
     */

    public function getDepartment($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('title'))
                    ->from('`#__hrm_departments`')
                    ->innerJoin('#__fm_employee_payroll ON #__fm_employee_payroll.department_guid = #__hrm_departments.guid')
                    ->where($db->quoteName('employee_guid') . ' = ' . $db->quote($db->escape($employee_guid)));
            $db->setQuery($query);
            $results = $db->loadResult();
            if ($results) {
                return $results;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Hàm lấy loại cán bộ
     * @param type $employee_guid//guid của cán bộ
     * @return boolean// trả ra kết quả là loại cán bộ nếu có
     */
    public function getEmployee_type($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('employee_type'))
                    ->from('`#__hrm_payroll`')
                    ->where($db->quoteName('employee_guid') . ' = ' . $db->quote($db->escape($employee_guid)));
            $db->setQuery($query);
            $results = $db->loadResult();
            if ($results) {
                return $results;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Hàm lấy hệ số lương của cán bộ
     * @param type $employee_guid// guid của cán bộ để lấy ngạch và bậc lương ở bảng quá trình lương->hệ số lương 
     * @return boolean //  trả ra kết quả là hệ số mức lương nếu có
     */
    public function getCoefficient($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('coefficient'))
                    ->from('`#__hrm_coefficient`')
                    ->innerJoin('`#__hrm_payroll` ON (#__hrm_payroll.scale_group_guid = #__hrm_coefficient.scale_group_guid OR #__hrm_payroll.scale_type_guid = #__hrm_coefficient.scale_group_guid)
                        AND #__hrm_payroll.wage_guid = #__hrm_coefficient.wage_guid')
                    ->where($db->quoteName('employee_guid') . ' = ' . $db->quote($db->escape($employee_guid)));

            $db->setQuery($query);
            $results = $db->loadResult();
            if ($results) {
                return $results;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Hàm lấy hệ số chức vụ của cán bộ
     * @param type $employee_guid// guid của cán bộ
     * @return boolean //  trả ra kết quả là hệ số chức vụ của cán bộ nếu có
     */
    public function getAllowances($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select($db->quoteName('allowances'))
                    ->from('`#__hrm_positionstype`')
                    ->innerJoin('`#__hrm_position` ON   #__hrm_position.positiontype_guid = #__hrm_positionstype.guid')
                    ->where($db->quoteName('#__hrm_position.employee_guid') . ' = ' . $db->quote($db->escape($employee_guid)));
            $db->setQuery($query);
            $results = $db->loadObjectList();

            if ($results) {
                $n = count($results);
                $max = 0;
                for ($i = 0; $i < $n; $i++) {
                    if ($results[$i]->allowances >= $max) {
                        $max = $results[$i]->allowances;
                    }
                }
                return $max;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Hàm lấy các khoản giảm trừ - hệ số
     * @param type $employee_guid// guid của cán bộ
     * @return boolean // trả ra các khoản giảm trừ, hệ số liên quan tới cán bộ được chọn
     */
    public function getDetain($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select(array($db->quoteName('pay_electricity'), $db->quoteName('water_charges'), $db->quoteName('rent'), $db->quoteName('detain_type'), $db->quoteName('detain')))
                    ->from('`#__fm_revenue_deduction`')
                    ->where($db->quoteName('employee_guid') . ' = ' . $db->quote($db->escape($employee_guid)));
            $db->setQuery($query);
            $results = $db->loadObject();
            if ($results) {
                return $results;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Lấy hệ số phụ cấp, trạng thái làm việc của cán bộ
     * @param type $employee_guid// guid của cán bộ
     * @return boolean //  hệ số phụ cấp của cán bộ
     */
    public function getAllowanceEmployee($employee_guid = NULL) {
        if ($employee_guid) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select(array($db->quoteName('fe_allowances'), $db->quoteName('option_allowance'), $db->quoteName('earn_salary'), $db->quoteName('option_study'), $db->quoteName('option_break'), $db->quoteName('info_payroll'), $db->quoteName('info_allowance')))
                    ->from('`#__fm_e_allowance`')
                    ->where($db->quoteName('employee_guid') . ' = ' . $db->quote($db->escape($employee_guid)));
            $db->setQuery($query);
            $results = $db->loadObject();
            if ($results) {
                return $results;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Hàm tính hệ số thâm niên
     * @param type $date_of_recruitment//  là ngày tháng năm cán bộ được nhận vào làm việc
     * @return int // Số năm thâm niên của cán bộ
     */
    public function TinhThamNien($date_of_recruitment = NULL) {
        if ($date_of_recruitment) {

            $date_now = date('Y-m-d');

            $diff = abs(strtotime($date_now) - strtotime($date_of_recruitment));

            $years = floor($diff / (365 * 60 * 60 * 24));

            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            //return $years;
            //thâm niên
            if ($years >= 5) {
                (float) $thamnien = $years / 100;
            } else {
                $thamnien = 0;
            }
            return $thamnien;
        } else {
            return 0;
        }
    }

    /**
     * Tính phụ cấp chức vụ của cán bộ
     * @param type $earn_salary // hệ số hưởng lương
     * @param type $hesocv //là hệ số phụ cấp chức vụ
     * @return float //Trả về hệ số kiểu float
     */
    public function TinhHSPC_CV($earn_salary = NULL, $hesocv = NULL) {
        if ($earn_salary && $hesocv) {
            $HSPC_CV = $hesocv * $earn_salary / 100;
            return $HSPC_CV;
        } else {
            return 0.0;
        }
    }

    /**
     * Tính hệ số phụ cấp vượt khung của cán bộ
     * @param type $hsvk // hệ số vượt khung 
     * @param type $HSML // hệ số mực lương
     * @return float // hệ số phụ cấp vượt khung
     */
    public function TinhHSPC_VK($hsvk = NULL, $HSML = NULL) {
        if ($hsvk && $HSML) {
            $HSPC_VK = $hsvk * $HSML / 100;
            return $HSPC_VK;
        } else {
            return 0.0;
        }
    }

    /**
     * Tính hệ số phụ cấp thâm niên
     * @param type $HSML // hệ số mức lương
     * @param type $HSPC_VK // hệ số phụ cấp vượt khung
     * @param type $HSPC_CV // hệ số phụ cấp chức vụ
     * @param type $loaicanbo // loại cán bộ
     * @param type $thamnien // số năm thâm niên
     * @param type $dihoc //  trạng thái đi học hay không
     * @return float //phụ cấp thâm niên
     */
    public function TinhHSPC_TN($HSML = NULL, $HSPC_CV = NULL, $loaicanbo = NULL, $thamnien = NULL, $dihoc = NULL) {
        $HSPC_TN = ($HSML + $HSPC_CV ) * $thamnien;
        if ($loaicanbo == 2) {
            $HSPC_TN = $HSPC_TN * 0.7;
        }
        if ($dihoc == 2) {
            $HSPC_TN = 0.0;
        }
        return $HSPC_TN;
    }

    /**
     * Tính hệ số phụ cấp nghề
     * @param type $HSML // hế số mức lương
     * @param type $HSPC_VK // hệ số phụ cấp vượt khung
     * @param type $HSPC_CV // hệ số phụ cấp chức vụ
     * @param type $phucapx // hệ số phụ cấp nghề X
     * @param type $phucapy // hệ số phụ cấp nghề Y
     * @param type $phucapz // hệ số phụ cấp nghề Z
     * @param type $phucapkhac // hệ số phụ cấp nghề khác
     * @param type $loaiphucap // loại phụ cấp
     * @return float hệ số phụ cấp nghề của cán bộ
     */
    public function TinhHSPC_Nghe($HSML = NULL, $HSPC_VK = NULL, $HSPC_CV = NULL, $phucapx = NULL, $phucapy = NULL, $phucapz = NULL, $phucapkhac = NULL, $loaiphucap = NULL) {
        if ($loaiphucap == 1) {
            $HSPC_Nghe = ($HSPC_CV + $HSPC_VK + $HSML) * $phucapx / 100;
        }
        if ($loaiphucap == 2) {
            $HSPC_Nghe = ($HSPC_CV + $HSPC_VK + $HSML) * $phucapy / 100;
        }
        if ($loaiphucap == 3) {
            $HSPC_Nghe = ($HSPC_CV + $HSPC_VK + $HSML) * $phucapz / 100;
        }

        $HSPC_Nghe = $HSPC_Nghe + $phucapkhac / 100;


        return $HSPC_Nghe;
    }

    /**
     * Tính các khoản giảm trừ
     * @param type $heso // mảng cá hệ số
     * @param type $pay_electricity // số điện
     * @param type $water_charges // số nước
     * @param type $rent // tiền nhà
     * @param type $Huong_Luong // hệ số hưởng lương
     * @param type $LuongCoBan // Lương cơ bản
     * @param type $HSML // hệ số mức lương
     * @param type $HSPC_VK // hệ số phụ cấp vượt khung
     * @param type $HSPC_CV // hệ số phụ cấp chức vụ
     * @param type $HSPC_TN // hệ số phụ cấp thâm niên
     * @param type $loaicanbo // loại cán bộ
     * @param type $dihoc // trạng thái đi học hay không
     * @param type $trangthai // trạng thái đi làm hay nghỉ
     * @return array // mảng các loại giảm trừ
     */
    public function GiamTru($heso = array(), $pay_electricity = NULL, $water_charges = NULL, $Huong_Luong = NULL, $LuongCoBan = NULL, $HSML = NULL, $HSPC_VK = NULL, $HSPC_CV = NULL, $HSPC_TN = NULL, $loaicanbo = Null, $dihoc = NULL, $trangthai = Null) {
        if ($pay_electricity || $water_charges) {
            $TienDien = $pay_electricity * (float) $heso->electricity_1;

            $TienNuoc = $water_charges * (float) $heso->cost_water;
        } else {
            $TienDien = 0;
            $TienNuoc = 0;
        }

        $HS_BHXH = (float) $heso->social_insurance_employee;
        $HS_BHYT = (float) $heso->medical_insurance_employee;
        $HS_BHTN = (float) $heso->unemployment_insurance_employee;
        // $HoTroBHXH = (float) $heso->social_insurance_support;
        // $HoTroBHYT = (float) $heso->medical_insurance_support;
        // $HoTroBHTN = (float) $heso->unemployment_insurance_support;

        if ($loaicanbo == 1) {
            $TinhBHXH = ($HS_BHXH / 100) * ($Huong_Luong / 100) * ($LuongCoBan * ($HSPC_CV + $HSML + $HSPC_VK + $HSPC_TN));
            $TinhBHYT = ($HS_BHYT / 100) * ($Huong_Luong / 100) * ($LuongCoBan * ($HSPC_CV + $HSML + $HSPC_VK + $HSPC_TN));
            $TinhBHTN = ($HS_BHTN / 100) * ($Huong_Luong / 100) * ($LuongCoBan * ($HSPC_CV + $HSML + $HSPC_VK + $HSPC_TN));
            if ($dihoc == 2) {
                $TinhBHXH = ($Huong_Luong / 100) * $HSML * ($HS_BHXH / 100) + ((100 - $Huong_Luong) / 100) * $HSML * (($HS_BHXH ) / 100) * $LuongCoBan;
                $TinhBHYT = ($Huong_Luong / 100) * $HSML * ($HS_BHYT / 100) + ((100 - $Huong_Luong) / 100) * $HSML * (($HS_BHYT ) / 100) * $LuongCoBan;
                $TinhBHTN = ($Huong_Luong / 100) * $HSML * ($HS_BHTN / 100) + ((100 - $Huong_Luong) / 100) * $HSML * (($HS_BHTN ) / 100) * $LuongCoBan;
            }
        } else {
            $TinhBHXH = ($HS_BHXH / 100) * ($Huong_Luong / 100) * ($LuongCoBan * ($HSPC_CV + $HSML + $HSPC_VK ));
            $TinhBHYT = ($HS_BHYT / 100) * ($Huong_Luong / 100) * ($LuongCoBan * ($HSPC_CV + $HSML + $HSPC_VK ));
            $TinhBHTN = ($HS_BHTN / 100) * ($Huong_Luong / 100) * ($LuongCoBan * ($HSPC_CV + $HSML + $HSPC_VK ));
            if ($dihoc == 2) {
                $TinhBHXH = ($Huong_Luong / 100) * $HSML * ($HS_BHXH / 100) + ((100 - $Huong_Luong) / 100) * $HSML * (($HS_BHXH ) / 100) * $LuongCoBan;
                $TinhBHYT = ($Huong_Luong / 100) * $HSML * ($HS_BHYT / 100) + ((100 - $Huong_Luong) / 100) * $HSML * (($HS_BHYT ) / 100) * $LuongCoBan;
                $TinhBHTN = ($Huong_Luong / 100) * $HSML * ($HS_BHTN / 100) + ((100 - $Huong_Luong) / 100) * $HSML * (($HS_BHTN ) / 100) * $LuongCoBan;
            }
        }

        if ($trangthai == 2 || $trangthai == 3) {
            $TinhBHTN = 0;
            $TinhBHXH = 0;
            $TinhBHYT = 0;
        }

        $TinhGiamTru = array(
            "TienDien" => $TienDien,
            "TienNuoc" => $TienNuoc,
            "BHYT" => $TinhBHYT,
            "BHXH" => $TinhBHXH,
            "BHTN" => $TinhBHTN
        );
        return $TinhGiamTru;
    }

    /**
     * Tính số tiền tạm giữ
     * @param type $LoaiTamGiu// kiểu tạm giữ
     * @param type $ThongSo // số tiền tạm giữ or số ngày lương tạm giữ
     * @return float //tiền tạm giữ
     */
    public function TinhTamGiu($LoaiTamGiu = NULL, $ThongSo = Null, $LuongPC = NULL) {
        $TamGiu = 0;
        if ($LoaiTamGiu == 1) {
            $TamGiu = $ThongSo * ($LuongPC / 21);
        } else {
            $TamGiu = $ThongSo;
        }
        return $TamGiu;
    }

    /**
     * Tính thu nhập tặng thêm
     * @param type $Huong_Luong // hệ số hưởng lương
     * @param type $HSML // hệ số mức lương
     * @param type $HSPC_VK // hệ số phụ cấp vượt khung
     * @param type $LuongCoBan // lương cơ bản
     * @param type $ThuNhapTT // hệ số thu nhập tăng thêm
     * @param type $DiHoc // trạng thái đi học
     * @param type $TrangThai // trạng thái nghỉ
     * @return float // tiền thu nhập tặng thêm
     */
    public function TinhThuNhapTT($Huong_Luong = Null, $HSML = NULL, $HSPC_VK = NULL, $LuongCoBan = NULL, $ThuNhapTT = NUll, $DiHoc = NULL, $TrangThai = NULL) {
        $ThuNhapTangThem = (float) ($Huong_Luong / 100 * ($HSML + $HSPC_VK) * $LuongCoBan * $ThuNhapTT / 100);
        if ($TrangThai == 2 || $TrangThai == 3 || $DiHoc == 2) {
            $ThuNhapTangThem = 0;
        }
        return $ThuNhapTangThem;
    }

    /**
     * Tính phụ cấp theo quy định 36
     * @param type $HSPC_QD36 // hệ sô theo quy dịnh 36
     * @param type $DiHoc // trạng thái đi học
     * @param type $TrangThai // trạng thái đi làm
     * @return float // hệ số
     */
    public function TinhPC_QD36($HSPC_QD36 = NULL, $DiHoc = NULL, $TrangThai = NULL) {
        $PC_QD36 = $HSPC_QD36;
        if ($DiHoc == 1) {
            $PC_QD36 = $PC_QD36 * 0.8;
        }
        if ($TrangThai == 2 || $TrangThai == 3 || $DiHoc == 2) {
            $PC_QD36 = 0;
        }
        return $PC_QD36;
    }

    /**
     * Tính tiền lương
     * @param type $Luong_PCSau
     * @param type $ThuNhapTT
     * @param type $Tien_PC36
     * @param type $TTDieuChinhPC
     * @param type $TTDieuChinhLuong
     * @param type $TrangThai
     * @return float
     */
    public function TinhLuong($Luong_PCSau = NULL, $ThuNhapTT = NULL, $Tien_PC36 = NULL, $TTDieuChinhPC = NULl, $TTDieuChinhLuong = NULL, $TrangThai = NULL) {
        $TienLuong = $Luong_PCSau + $ThuNhapTT + $Tien_PC36 + $TTDieuChinhLuong + $TTDieuChinhPC;
        if ($TrangThai == 2 || $TrangThai == 3) {
            $TienLuong = 0;
        }
        return $TienLuong;
    }

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

    public function getPayroll() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select(array($db->quoteName('employee_guid'), $db->quoteName('department_guid'), $db->quoteName('payroll')))
                ->from('`#__fm_employee_payroll`');
        $db->setQuery($query);
        $results = $db->loadAssocList();
        return $results;
    }

}
