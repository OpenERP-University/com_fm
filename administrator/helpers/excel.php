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
jimport('phpexcel.library.PHPExcel');

/**
 * Hrm helper.
 */
class FmHelperExcel {

    public static function ExportExcel($param = array(), $data = array()) {
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set document properties
        $objPHPExcel->getProperties()->setCreator(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'))
                ->setLastModifiedBy(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'))
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory(JText::_('COM_FM_SALARY_INFO'));


// set header

        if ($param['month'] && !$param['year']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', JText::_('COM_FM_EXCEL_TITLE') . JText::_('COM_FM_SALARY_INFO_MONTH_CAP') . $param['month'] . '');
        }
        if ($param['year'] && !$param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', JText::_('COM_FM_EXCEL_TITLE') . JText::_('COM_FM_SALARY_INFO_YEAR_CAP') . $param['year'] . '');
        }
        if ($param['year'] && $param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', JText::_('COM_FM_EXCEL_TITLE') . JText::_('COM_FM_SALARY_INFO_MONTH_CAP') . $param['month'] . JText::_('COM_FM_SALARY_INFO_YEAR_CAP') . $param['year'] . '');
        }
        //set font 
        $objPHPExcel->getActiveSheet()->mergeCells('A1:Y3');
        //creat style title
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        //
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y3')->applyFromArray($style);
        // title table
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y3')->getFont()
                ->setBold(true)
                ->setSize(14)
                ->setName('Times new Roman');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A:Y')->getFont()
                ->setName('Times new Roman')
                ->setSize(8);

// header table

        if ($param['month'] && !$param['year']) {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', JText::_('COM_FM_EXCEL_NUMBER'))
                    ->setCellValue('B5', JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'))
                    ->setCellValue('C5', JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'))
                    ->setCellValue('D5', JText::_('COM_FM_EXCEL_COEFFICIENT'))
                    ->setCellValue('E5', JText::_('COM_FM_EXCEL_ALLOWANCES'))
                    ->setCellValue('F5', JText::_('COM_FM_EXCEL_WORK'))
                    ->setCellValue('G5', JText::_('COM_FM_EXCEL_ALLOWANCES_YEAR'))
                    ->setCellValue('H5', JText::_('COM_FM_EXCEL_EARN'))
                    ->setCellValue('I5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('J5', JText::_('COM_FM_EXCEL_SALARY_ALLOWANCES_TYPES'))
                    ->setCellValue('K5', JText::_('COM_FM_EXCEL_SOCIAL_INSURANCE'))
                    ->setCellValue('L5', JText::_('COM_FM_EXCEL_MEDICAL_INSURANCE'))
                    ->setCellValue('M5', JText::_('COM_FM_EXCEL_UNEMPLOYMENT_INSURANCE'))
                    ->setCellValue('N5', JText::_('COM_FM_EXCEL_PAY_WATER'))
                    ->setCellValue('O5', JText::_('COM_FM_EXCEL_PAY_ELICTRIC'))
                    ->setCellValue('P5', JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT_NUMBER'))
                    ->setCellValue('Q5', JText::_('COM_FM_EXCEL_DETAIN'))
                    ->setCellValue('R5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('S5', JText::_('COM_FM_EXCEL_SALARY_REVENUEDEDUCTIONS'))
                    ->setCellValue('T5', JText::_('COM_FM_EXCEL_EXTRA_INCOME'))
                    ->setCellValue('U5', JText::_('COM_FM_EXCEL_ALLOWANCES_36'))
                    ->setCellValue('V5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_YEAR'))
                    ->setCellValue('X5', JText::_('COM_FM_EXCEL_NOTE'));


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D4', JText::_('COM_FM_EXCEL_ALLOWANCES_TYPES'))
                    ->setCellValue('K4', JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'))
                    ->setCellValue('S4', JText::_('COM_FM_EXCEL_SALARY_RECIVE'));

            $objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K4:R4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('S4:V4')->applyFromArray($style);
        }
        if ($param['year'] && !$param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', JText::_('COM_FM_EXCEL_NUMBER'))
                    ->setCellValue('B5', JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'))
                    ->setCellValue('C5', JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'))
                    ->setCellValue('D5', JText::_('COM_FM_EXCEL_COEFFICIENT'))
                    ->setCellValue('E5', JText::_('COM_FM_EXCEL_ALLOWANCES'))
                    ->setCellValue('F5', JText::_('COM_FM_EXCEL_WORK'))
                    ->setCellValue('G5', JText::_('COM_FM_EXCEL_ALLOWANCES_YEAR'))
                    ->setCellValue('H5', JText::_('COM_FM_EXCEL_EARN'))
                    ->setCellValue('I5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('J5', JText::_('COM_FM_EXCEL_SALARY_ALLOWANCES_TYPES'))
                    ->setCellValue('K5', JText::_('COM_FM_EXCEL_SOCIAL_INSURANCE'))
                    ->setCellValue('L5', JText::_('COM_FM_EXCEL_MEDICAL_INSURANCE'))
                    ->setCellValue('M5', JText::_('COM_FM_EXCEL_UNEMPLOYMENT_INSURANCE'))
                    ->setCellValue('N5', JText::_('COM_FM_EXCEL_PAY_WATER'))
                    ->setCellValue('O5', JText::_('COM_FM_EXCEL_PAY_ELICTRIC'))
                    ->setCellValue('P5', JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT_NUMBER'))
                    ->setCellValue('Q5', JText::_('COM_FM_EXCEL_DETAIN'))
                    ->setCellValue('R5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('S5', JText::_('COM_FM_EXCEL_SALARY_REVENUEDEDUCTIONS'))
                    ->setCellValue('T5', JText::_('COM_FM_EXCEL_EXTRA_INCOME'))
                    ->setCellValue('U5', JText::_('COM_FM_EXCEL_ALLOWANCES_36'))
                    ->setCellValue('V5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_MONTH'))
                    ->setCellValue('X5', JText::_('COM_FM_EXCEL_NOTE'));


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D4', JText::_('COM_FM_EXCEL_ALLOWANCES_TYPES'))
                    ->setCellValue('K4', JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'))
                    ->setCellValue('S4', JText::_('COM_FM_EXCEL_SALARY_RECIVE'));

            $objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K4:R4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('S4:V4')->applyFromArray($style);
        }
        if ($param['year'] && $param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', JText::_('COM_FM_EXCEL_NUMBER'))
                    ->setCellValue('B5', JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'))
                    ->setCellValue('C5', JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'))
                    ->setCellValue('D5', JText::_('COM_FM_EXCEL_COEFFICIENT'))
                    ->setCellValue('E5', JText::_('COM_FM_EXCEL_ALLOWANCES'))
                    ->setCellValue('F5', JText::_('COM_FM_EXCEL_WORK'))
                    ->setCellValue('G5', JText::_('COM_FM_EXCEL_ALLOWANCES_YEAR'))
                    ->setCellValue('H5', JText::_('COM_FM_EXCEL_EARN'))
                    ->setCellValue('I5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('J5', JText::_('COM_FM_EXCEL_SALARY_ALLOWANCES_TYPES'))
                    ->setCellValue('K5', JText::_('COM_FM_EXCEL_SOCIAL_INSURANCE'))
                    ->setCellValue('L5', JText::_('COM_FM_EXCEL_MEDICAL_INSURANCE'))
                    ->setCellValue('M5', JText::_('COM_FM_EXCEL_UNEMPLOYMENT_INSURANCE'))
                    ->setCellValue('N5', JText::_('COM_FM_EXCEL_PAY_WATER'))
                    ->setCellValue('O5', JText::_('COM_FM_EXCEL_PAY_ELICTRIC'))
                    ->setCellValue('P5', JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT_NUMBER'))
                    ->setCellValue('Q5', JText::_('COM_FM_EXCEL_DETAIN'))
                    ->setCellValue('R5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('S5', JText::_('COM_FM_EXCEL_SALARY_REVENUEDEDUCTIONS'))
                    ->setCellValue('T5', JText::_('COM_FM_EXCEL_EXTRA_INCOME'))
                    ->setCellValue('U5', JText::_('COM_FM_EXCEL_ALLOWANCES_36'))
                    ->setCellValue('V5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    //->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_MONTH'))
                    ->setCellValue('W5', JText::_('COM_FM_EXCEL_NOTE'));


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D4', JText::_('COM_FM_EXCEL_ALLOWANCES_TYPES'))
                    ->setCellValue('K4', JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'))
                    ->setCellValue('S4', JText::_('COM_FM_EXCEL_SALARY_RECIVE'));

            $objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K4:R4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('S4:V4')->applyFromArray($style);
        }


        // set font header table
        $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A5:Y5')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4:Y5')->getFont()
                ->setBold(true)
                ->setSize(8)
                ->setName('Times new Roman');
        $objPHPExcel->getActiveSheet()
                ->mergeCells('D4:I4')
                ->mergeCells('K4:R4')
                ->mergeCells('S4:V4');

//set width
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
// TABLE
        //$i=0;

        if ($param['year'] && $param['month']) {

            $n = count($data['fullname']);
            $j = 5;
            for ($i = 0; $i < $n; $i++) {
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $i + 1)
                        ->setCellValue('B' . $j, $data['fullname'][$i])
                        ->setCellValue('C' . $j, $data['department'][$i])
                        ->setCellValue('D' . $j, $data['HSML'][$i])
                        ->setCellValue('E' . $j, $data['HSPC_CV'][$i])
                        ->setCellValue('F' . $j, $data['HSPC_Nghe'][$i])
                        ->setCellValue('G' . $j, $data['HSPCTN'][$i])
                        ->setCellValue('H' . $j, $data['HSPC_VK'][$i])
                        ->setCellValue('I' . $j, $data['TongHeSo'][$i])
                        ->setCellValue('J' . $j, $data['TienLuong_PC'][$i])
                        ->setCellValue('K' . $j, $data['BHXH'][$i])
                        ->setCellValue('L' . $j, $data['BHYT'][$i])
                        ->setCellValue('M' . $j, $data['BHTN'][$i])
                        ->setCellValue('N' . $j, $data['TienNuoc'][$i])
                        ->setCellValue('O' . $j, $data['TienDien'][$i])
                        ->setCellValue('P' . $j, $data['TienNha'][$i])
                        ->setCellValue('Q' . $j, $data['TamGiu'][$i])
                        ->setCellValue('R' . $j, $data['TienGiamTru'][$i])
                        ->setCellValue('S' . $j, $data['LuongPC'][$i])
                        ->setCellValue('T' . $j, $data['TNTT'][$i])
                        ->setCellValue('U' . $j, $data['PC36'][$i])
                        ->setCellValue('V' . $j, $data['salary'][$i]);
                // ->setCellValue('W' . $j, $data['department'][$i]);
                //->setCellValue('W' . $j, $data['salary'][$i]);
                $k = $j;
            }
            $k = $k + 1;
            $dau = 6;
            $cuoi = $k - 1;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, JText::_('COM_FM_EXCEL_SUM_SALARY'))
                    ->setCellValue('V' . $k, '=SUM(V' . $dau . ' : V' . $cuoi . ')');
        }
        if ($param['year'] && !$param['month']) {
            $n = count($data['fullname']);

            $j = 5;
            for ($i = 0; $i < $n; $i++) {
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $i + 1)
                        ->setCellValue('B' . $j, $data['fullname'][$i])
                        ->setCellValue('C' . $j, $data['department'][$i])
                        ->setCellValue('D' . $j, $data['HSML'][$i])
                        ->setCellValue('E' . $j, $data['HSPC_CV'][$i])
                        ->setCellValue('F' . $j, $data['HSPC_Nghe'][$i])
                        ->setCellValue('G' . $j, $data['HSPCTN'][$i])
                        ->setCellValue('H' . $j, $data['HSPC_VK'][$i])
                        ->setCellValue('I' . $j, $data['TongHeSo'][$i])
                        ->setCellValue('J' . $j, $data['TienLuong_PC'][$i])
                        ->setCellValue('K' . $j, $data['BHXH'][$i])
                        ->setCellValue('L' . $j, $data['BHYT'][$i])
                        ->setCellValue('M' . $j, $data['BHTN'][$i])
                        ->setCellValue('N' . $j, $data['TienNuoc'][$i])
                        ->setCellValue('O' . $j, $data['TienDien'][$i])
                        ->setCellValue('P' . $j, $data['TienNha'][$i])
                        ->setCellValue('Q' . $j, $data['TamGiu'][$i])
                        ->setCellValue('R' . $j, $data['TienGiamTru'][$i])
                        ->setCellValue('S' . $j, $data['LuongPC'][$i])
                        ->setCellValue('T' . $j, $data['TNTT'][$i])
                        ->setCellValue('U' . $j, $data['PC36'][$i])
                        ->setCellValue('V' . $j, $data['salary'][$i])
                        ->setCellValue('W' . $j, $data['month'][$i]);
                //->setCellValue('W' . $j, $data['salary'][$i]);
                $k = $j;
            }
            $k = $k + 1;
            $dau = 6;
            $cuoi = $k - 1;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, JText::_('COM_FM_EXCEL_SUM_SALARY'))
                    ->setCellValue('V' . $k, '=SUM(V' . $dau . ' : V' . $cuoi . ')');
        }

        if ($param['month'] && !$param['year']) {
            $n = count($data['fullname']);
            $j = 5;
            for ($i = 0; $i < $n; $i++) {
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $i + 1)
                        ->setCellValue('B' . $j, $data['fullname'][$i])
                        ->setCellValue('C' . $j, $data['department'][$i])
                        ->setCellValue('D' . $j, $data['HSML'][$i])
                        ->setCellValue('E' . $j, $data['HSPC_CV'][$i])
                        ->setCellValue('F' . $j, $data['HSPC_Nghe'][$i])
                        ->setCellValue('G' . $j, $data['HSPCTN'][$i])
                        ->setCellValue('H' . $j, $data['HSPC_VK'][$i])
                        ->setCellValue('I' . $j, $data['TongHeSo'][$i])
                        ->setCellValue('J' . $j, $data['TienLuong_PC'][$i])
                        ->setCellValue('K' . $j, $data['BHXH'][$i])
                        ->setCellValue('L' . $j, $data['BHYT'][$i])
                        ->setCellValue('M' . $j, $data['BHTN'][$i])
                        ->setCellValue('N' . $j, $data['TienNuoc'][$i])
                        ->setCellValue('O' . $j, $data['TienDien'][$i])
                        ->setCellValue('P' . $j, $data['TienNha'][$i])
                        ->setCellValue('Q' . $j, $data['TamGiu'][$i])
                        ->setCellValue('R' . $j, $data['TienGiamTru'][$i])
                        ->setCellValue('S' . $j, $data['LuongPC'][$i])
                        ->setCellValue('T' . $j, $data['TNTT'][$i])
                        ->setCellValue('U' . $j, $data['PC36'][$i])
                        ->setCellValue('V' . $j, $data['salary'][$i])
                        ->setCellValue('W' . $j, $data['years'][$i]);
                //->setCellValue('W' . $j, $data['salary'][$i]);
                $k = $j;
            }
            $k = $k + 1;
            $dau = 6;
            $cuoi = $k - 1;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, JText::_('COM_FM_EXCEL_SUM_SALARY'))
                    ->setCellValue('V' . $k, '=SUM(V' . $dau . ' : V' . $cuoi . ')');
        }
// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'));


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a clientâ€™s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if ($param['month'] && !$param['year']) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO') . JText::_('COM_FM_SALARY_INFO_MONTH') . $param['month'] . '.xlsx"');
        }
        if ($param['year'] && !$param['month']) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO') . JText::_('COM_FM_SALARY_INFO_YEAR') . $param['year'] . '.xlsx"');
        }
        if ($param['year'] && $param['month']) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO') . JText::_('COM_FM_SALARY_INFO_MONTH') . $param['month'] . JText::_('COM_FM_SALARY_INFO_YEAR') . $param['year'] . '.xlsx"');
        }
        // header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public static function tableExcel($param = array(), $data = array()) {


        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set document properties
        $objPHPExcel->getProperties()->setCreator(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'))
                ->setLastModifiedBy(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'))
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory(JText::_('COM_FM_SALARY_INFO'));


// set header

        if ($param['month'] && !$param['year']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', JText::_('COM_FM_EXCEL_TITLE') . JText::_('COM_FM_SALARY_INFO_MONTH_CAP') . $param['month'] . '');
        }
        if ($param['year'] && !$param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', JText::_('COM_FM_EXCEL_TITLE') . JText::_('COM_FM_SALARY_INFO_YEAR_CAP') . $param['year'] . '');
        }
        if ($param['year'] && $param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', JText::_('COM_FM_EXCEL_TITLE') . JText::_('COM_FM_SALARY_INFO_MONTH_CAP') . $param['month'] . JText::_('COM_FM_SALARY_INFO_YEAR_CAP') . $param['year'] . '');
        }
        //set font 
        $objPHPExcel->getActiveSheet()->mergeCells('A1:Y3');
        //creat style title
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        //
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y3')->applyFromArray($style);
        // title table
        $objPHPExcel->getActiveSheet()->getStyle('A1:Y3')->getFont()
                ->setBold(true)
                ->setSize(14)
                ->setName('Times new Roman');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A:Y')->getFont()
                ->setName('Times new Roman')
                ->setSize(8);
        //header table

        if ($param['month'] && !$param['year']) {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', JText::_('COM_FM_EXCEL_NUMBER'))
                    ->setCellValue('B5', JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'))
                    ->setCellValue('C5', JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'))
                    ->setCellValue('D5', JText::_('COM_FM_EXCEL_COEFFICIENT'))
                    ->setCellValue('E5', JText::_('COM_FM_EXCEL_ALLOWANCES'))
                    ->setCellValue('F5', JText::_('COM_FM_EXCEL_WORK'))
                    ->setCellValue('G5', JText::_('COM_FM_EXCEL_ALLOWANCES_YEAR'))
                    ->setCellValue('H5', JText::_('COM_FM_EXCEL_EARN'))
                    ->setCellValue('I5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('J5', JText::_('COM_FM_EXCEL_SALARY_ALLOWANCES_TYPES'))
                    ->setCellValue('K5', JText::_('COM_FM_EXCEL_SOCIAL_INSURANCE'))
                    ->setCellValue('L5', JText::_('COM_FM_EXCEL_MEDICAL_INSURANCE'))
                    ->setCellValue('M5', JText::_('COM_FM_EXCEL_UNEMPLOYMENT_INSURANCE'))
                    ->setCellValue('N5', JText::_('COM_FM_EXCEL_PAY_WATER'))
                    ->setCellValue('O5', JText::_('COM_FM_EXCEL_PAY_ELICTRIC'))
                    ->setCellValue('P5', JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT_NUMBER'))
                    ->setCellValue('Q5', JText::_('COM_FM_EXCEL_DETAIN'))
                    ->setCellValue('R5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('S5', JText::_('COM_FM_EXCEL_SALARY_REVENUEDEDUCTIONS'))
                    ->setCellValue('T5', JText::_('COM_FM_EXCEL_EXTRA_INCOME'))
                    ->setCellValue('U5', JText::_('COM_FM_EXCEL_ALLOWANCES_36'))
                    ->setCellValue('V5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_YEAR'))
                    ->setCellValue('X5', JText::_('COM_FM_EXCEL_NOTE'));


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D4', JText::_('COM_FM_EXCEL_ALLOWANCES_TYPES'))
                    ->setCellValue('K4', JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'))
                    ->setCellValue('S4', JText::_('COM_FM_EXCEL_SALARY_RECIVE'));

            $objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K4:R4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('S4:V4')->applyFromArray($style);
         
        }
        if ($param['year'] && !$param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', JText::_('COM_FM_EXCEL_NUMBER'))
                    ->setCellValue('B5', JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'))
                    ->setCellValue('C5', JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'))
                    ->setCellValue('D5', JText::_('COM_FM_EXCEL_COEFFICIENT'))
                    ->setCellValue('E5', JText::_('COM_FM_EXCEL_ALLOWANCES'))
                    ->setCellValue('F5', JText::_('COM_FM_EXCEL_WORK'))
                    ->setCellValue('G5', JText::_('COM_FM_EXCEL_ALLOWANCES_YEAR'))
                    ->setCellValue('H5', JText::_('COM_FM_EXCEL_EARN'))
                    ->setCellValue('I5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('J5', JText::_('COM_FM_EXCEL_SALARY_ALLOWANCES_TYPES'))
                    ->setCellValue('K5', JText::_('COM_FM_EXCEL_SOCIAL_INSURANCE'))
                    ->setCellValue('L5', JText::_('COM_FM_EXCEL_MEDICAL_INSURANCE'))
                    ->setCellValue('M5', JText::_('COM_FM_EXCEL_UNEMPLOYMENT_INSURANCE'))
                    ->setCellValue('N5', JText::_('COM_FM_EXCEL_PAY_WATER'))
                    ->setCellValue('O5', JText::_('COM_FM_EXCEL_PAY_ELICTRIC'))
                    ->setCellValue('P5', JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT_NUMBER'))
                    ->setCellValue('Q5', JText::_('COM_FM_EXCEL_DETAIN'))
                    ->setCellValue('R5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('S5', JText::_('COM_FM_EXCEL_SALARY_REVENUEDEDUCTIONS'))
                    ->setCellValue('T5', JText::_('COM_FM_EXCEL_EXTRA_INCOME'))
                    ->setCellValue('U5', JText::_('COM_FM_EXCEL_ALLOWANCES_36'))
                    ->setCellValue('V5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_MONTH'))
                    ->setCellValue('X5', JText::_('COM_FM_EXCEL_NOTE'));


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D4', JText::_('COM_FM_EXCEL_ALLOWANCES_TYPES'))
                    ->setCellValue('K4', JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'))
                    ->setCellValue('S4', JText::_('COM_FM_EXCEL_SALARY_RECIVE'));

            $objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K4:R4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('S4:V4')->applyFromArray($style);
          
        }
        if ($param['year'] && $param['month']) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', JText::_('COM_FM_EXCEL_NUMBER'))
                    ->setCellValue('B5', JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'))
                    ->setCellValue('C5', JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'))
                    ->setCellValue('D5', JText::_('COM_FM_EXCEL_COEFFICIENT'))
                    ->setCellValue('E5', JText::_('COM_FM_EXCEL_ALLOWANCES'))
                    ->setCellValue('F5', JText::_('COM_FM_EXCEL_WORK'))
                    ->setCellValue('G5', JText::_('COM_FM_EXCEL_ALLOWANCES_YEAR'))
                    ->setCellValue('H5', JText::_('COM_FM_EXCEL_EARN'))
                    ->setCellValue('I5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('J5', JText::_('COM_FM_EXCEL_SALARY_ALLOWANCES_TYPES'))
                    ->setCellValue('K5', JText::_('COM_FM_EXCEL_SOCIAL_INSURANCE'))
                    ->setCellValue('L5', JText::_('COM_FM_EXCEL_MEDICAL_INSURANCE'))
                    ->setCellValue('M5', JText::_('COM_FM_EXCEL_UNEMPLOYMENT_INSURANCE'))
                    ->setCellValue('N5', JText::_('COM_FM_EXCEL_PAY_WATER'))
                    ->setCellValue('O5', JText::_('COM_FM_EXCEL_PAY_ELICTRIC'))
                    ->setCellValue('P5', JText::_('COM_FM_FORM_LBL_REVENUEDEDUCTION_RENT_NUMBER'))
                    ->setCellValue('Q5', JText::_('COM_FM_EXCEL_DETAIN'))
                    ->setCellValue('R5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    ->setCellValue('S5', JText::_('COM_FM_EXCEL_SALARY_REVENUEDEDUCTIONS'))
                    ->setCellValue('T5', JText::_('COM_FM_EXCEL_EXTRA_INCOME'))
                    ->setCellValue('U5', JText::_('COM_FM_EXCEL_ALLOWANCES_36'))
                    ->setCellValue('V5', JText::_('COM_FM_EXCEL_SUM_ALLOWANCES'))
                    //->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_MONTH'))
                    ->setCellValue('W5', JText::_('COM_FM_EXCEL_NOTE'));


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D4', JText::_('COM_FM_EXCEL_ALLOWANCES_TYPES'))
                    ->setCellValue('K4', JText::_('COM_FM_TITLE_REVENUEDEDUCTIONS'))
                    ->setCellValue('S4', JText::_('COM_FM_EXCEL_SALARY_RECIVE'));

            $objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('K4:R4')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('S4:V4')->applyFromArray($style);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W5', JText::_('COM_FM_SALARY_INFO_MONTH'));
           
        }


        // set font header table
        $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A5:Y5')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4:Y5')->getFont()
                ->setBold(true)
                ->setSize(8)
                ->setName('Times new Roman');
        $objPHPExcel->getActiveSheet()
                ->mergeCells('D4:I4')
                ->mergeCells('K4:R4')
                ->mergeCells('S4:V4');

//set width
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
// TABLE
        //$i=0;

        if ($param['year'] && $param['month']) {

            $n = count($data['fullname']);
            $j = 5;
            for ($i = 0; $i < $n; $i++) {
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $i + 1)
                        ->setCellValue('B' . $j, $data['fullname'][$i])
                        ->setCellValue('C' . $j, $data['department'][$i])
                        ->setCellValue('D' . $j, $data['HSML'][$i])
                        ->setCellValue('E' . $j, $data['HSPC_CV'][$i])
                        ->setCellValue('F' . $j, $data['HSPC_Nghe'][$i])
                        ->setCellValue('G' . $j, $data['HSPCTN'][$i])
                        ->setCellValue('H' . $j, $data['HSPC_VK'][$i])
                        ->setCellValue('I' . $j, $data['TongHeSo'][$i])
                        ->setCellValue('J' . $j, $data['TienLuong_PC'][$i])
                        ->setCellValue('K' . $j, $data['BHXH'][$i])
                        ->setCellValue('L' . $j, $data['BHYT'][$i])
                        ->setCellValue('M' . $j, $data['BHTN'][$i])
                        ->setCellValue('N' . $j, $data['TienNuoc'][$i])
                        ->setCellValue('O' . $j, $data['TienDien'][$i])
                        ->setCellValue('P' . $j, $data['TienNha'][$i])
                        ->setCellValue('Q' . $j, $data['TamGiu'][$i])
                        ->setCellValue('R' . $j, $data['TienGiamTru'][$i])
                        ->setCellValue('S' . $j, $data['LuongPC'][$i])
                        ->setCellValue('T' . $j, $data['TNTT'][$i])
                        ->setCellValue('U' . $j, $data['PC36'][$i])
                        ->setCellValue('V' . $j, $data['salary'][$i]);
                // ->setCellValue('W' . $j, $data['department'][$i]);
                //->setCellValue('W' . $j, $data['salary'][$i]);
                $k = $j;
            }
            $k = $k + 1;
            $dau = 6;
            $cuoi = $k - 1;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, JText::_('COM_FM_EXCEL_SUM_SALARY'))
                    ->setCellValue('V' . $k, '=SUM(V' . $dau . ' : V' . $cuoi . ')');
        }
        if ($param['year'] && !$param['month']) {
            $n = count($data['fullname']);

            $j = 5;
            for ($i = 0; $i < $n; $i++) {
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $i + 1)
                        ->setCellValue('B' . $j, $data['fullname'][$i])
                        ->setCellValue('C' . $j, $data['department'][$i])
                        ->setCellValue('D' . $j, $data['HSML'][$i])
                        ->setCellValue('E' . $j, $data['HSPC_CV'][$i])
                        ->setCellValue('F' . $j, $data['HSPC_Nghe'][$i])
                        ->setCellValue('G' . $j, $data['HSPCTN'][$i])
                        ->setCellValue('H' . $j, $data['HSPC_VK'][$i])
                        ->setCellValue('I' . $j, $data['TongHeSo'][$i])
                        ->setCellValue('J' . $j, $data['TienLuong_PC'][$i])
                        ->setCellValue('K' . $j, $data['BHXH'][$i])
                        ->setCellValue('L' . $j, $data['BHYT'][$i])
                        ->setCellValue('M' . $j, $data['BHTN'][$i])
                        ->setCellValue('N' . $j, $data['TienNuoc'][$i])
                        ->setCellValue('O' . $j, $data['TienDien'][$i])
                        ->setCellValue('P' . $j, $data['TienNha'][$i])
                        ->setCellValue('Q' . $j, $data['TamGiu'][$i])
                        ->setCellValue('R' . $j, $data['TienGiamTru'][$i])
                        ->setCellValue('S' . $j, $data['LuongPC'][$i])
                        ->setCellValue('T' . $j, $data['TNTT'][$i])
                        ->setCellValue('U' . $j, $data['PC36'][$i])
                        ->setCellValue('V' . $j, $data['salary'][$i])
                        ->setCellValue('W' . $j, $data['month'][$i]);
                //->setCellValue('W' . $j, $data['salary'][$i]);
                $k = $j;
            }
            $k = $k + 1;
            $dau = 6;
            $cuoi = $k - 1;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, JText::_('COM_FM_EXCEL_SUM_SALARY'))
                    ->setCellValue('V' . $k, '=SUM(V' . $dau . ' : V' . $cuoi . ')');
        }

        if ($param['month'] && !$param['year']) {
            $n = count($data['fullname']);
            $j = 5;
            for ($i = 0; $i < $n; $i++) {
                $j++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $j, $i + 1)
                        ->setCellValue('B' . $j, $data['fullname'][$i])
                        ->setCellValue('C' . $j, $data['department'][$i])
                        ->setCellValue('D' . $j, $data['HSML'][$i])
                        ->setCellValue('E' . $j, $data['HSPC_CV'][$i])
                        ->setCellValue('F' . $j, $data['HSPC_Nghe'][$i])
                        ->setCellValue('G' . $j, $data['HSPCTN'][$i])
                        ->setCellValue('H' . $j, $data['HSPC_VK'][$i])
                        ->setCellValue('I' . $j, $data['TongHeSo'][$i])
                        ->setCellValue('J' . $j, $data['TienLuong_PC'][$i])
                        ->setCellValue('K' . $j, $data['BHXH'][$i])
                        ->setCellValue('L' . $j, $data['BHYT'][$i])
                        ->setCellValue('M' . $j, $data['BHTN'][$i])
                        ->setCellValue('N' . $j, $data['TienNuoc'][$i])
                        ->setCellValue('O' . $j, $data['TienDien'][$i])
                        ->setCellValue('P' . $j, $data['TienNha'][$i])
                        ->setCellValue('Q' . $j, $data['TamGiu'][$i])
                        ->setCellValue('R' . $j, $data['TienGiamTru'][$i])
                        ->setCellValue('S' . $j, $data['LuongPC'][$i])
                        ->setCellValue('T' . $j, $data['TNTT'][$i])
                        ->setCellValue('U' . $j, $data['PC36'][$i])
                        ->setCellValue('V' . $j, $data['salary'][$i])
                        ->setCellValue('W' . $j, $data['years'][$i]);
                //->setCellValue('W' . $j, $data['salary'][$i]);
                $k = $j;
            }
            $k = $k + 1;
            $dau = 6;
            $cuoi = $k - 1;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, JText::_('COM_FM_EXCEL_SUM_SALARY'))
                    ->setCellValue('V' . $k, '=SUM(V' . $dau . ' : V' . $cuoi . ')');
        }
// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle(JText::_('COM_FM_TITLE_EMPLOYEEPAYROLLS'));


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

 $n = count($data['fullname']);
 //var_dump($data['fullname'][0]);die();
// Redirect output to a clientâ€™s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        
         if ($param['month'] && !$param['year']&& $n==1) {
             
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO_EMPLOYEE').$data['fullname'][0]. JText::_('COM_FM_SALARY_INFO_MONTH') . $param['month'] . '.xlsx"' );
        }
        if ($param['year'] && !$param['month']&& $n==1 ) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO_EMPLOYEE').$data['fullname'][0] . JText::_('COM_FM_SALARY_INFO_YEAR') . $param['year'] . '.xlsx"' );
        }
        if ($param['year'] && $param['month']&& $n==1) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO_EMPLOYEE') .$data['fullname'][0]. JText::_('COM_FM_SALARY_INFO_MONTH') . $param['month'] . JText::_('COM_FM_SALARY_INFO_YEAR') . $param['year'] . '.xlsx"' );
        }
        if ($param['month'] && !$param['year'] &&$n>1) {
           
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO_EMPLOYEE'). JText::_('COM_FM_SALARY_INFO_MONTH') . $param['month'] . '.xlsx"' . '"');
        }
        if ($param['year'] && !$param['month'] &&$n>1 ) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO_EMPLOYEE') . JText::_('COM_FM_SALARY_INFO_YEAR') . $param['year'] . '.xlsx"' . '"');
        }
        if ($param['year'] && $param['month']&& $n>1) {
            header('Content-Disposition: attachment;filename="' . JText::_('COM_FM_SALARY_INFO_EMPLOYEE') . JText::_('COM_FM_SALARY_INFO_MONTH') . $param['month'] . JText::_('COM_FM_SALARY_INFO_YEAR') . $param['year'] . '.xlsx"' );
        }
        // header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

   
}
