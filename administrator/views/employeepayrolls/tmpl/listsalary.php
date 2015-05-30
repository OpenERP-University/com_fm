<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//<form class = "form-inline">
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_fm/assets/css/fm.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function () {
        js('#exportexcelselect').click(function () {
            var val = [];
            js(':checkbox:checked').each(function (i) {
                val[i] = js(this).val()+"_";
            });
            var id = "id=" + val.toString();
            var year = js('#year').val();
            var month = js('#month').val();
            var data = "&month=" + month + "&year=" + year;
            router = 'index.php?option=com_fm&task=exportExcelEmployee&' + id + data;
            window.open(router);
            
        });
        js('#checkall').click(function(){
            $(":checkbox").prop( "checked", true );
        });

        function getListPayroll(data) {
            var year = js('#year').val();
            var month = js('#month').val();
            var data = "month=" + month + "&year=" + year;
            js.ajax({
                type: "POST",
                url: "index.php?option=com_fm&task=view_salary",
                data: data,
                datatype: "json",
                success: function (results) {
                    console.log(results);
                    var parsed = js.parseJSON(results);
                    if (results) {

                        if (parsed.salary)
                        {

                            var trHTML = '';
                            var i = 0;

                            if (month && !year)
                            {
                                trHTML += '<table id ="viewtable" class ="table table-hover">' + '<tr><th><?php
echo JText::_('COM_FM_SALARY_INFO');
echo JText::_('COM_FM_SALARY_INFO_MONTH');
?> ' + month + '</th><th> </th><th></th></tr>' + '<tr> <th><?php echo JText::_('COM_FM_SELECT_EMPLOYEE'); ?></th><th><?php echo JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'); ?></th>  <th><?php echo JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'); ?></th><th><?php echo JText::_('COM_FM_EMPLOYEEPAYROLLS_PAYROLL'); ?></th><th><?php echo JText::_('COM_FM_SALARY_INFO_YEAR'); ?></th></tr>'

                            }
                            if (year && !month)
                            {
                                trHTML += '<table id ="viewtable" class ="table table-hover">' + '<tr><th><?php
echo JText::_('COM_FM_SALARY_INFO');
echo JText::_('COM_FM_SALARY_INFO_YEAR');
?> ' + year + '</th><th> </th><th></th></tr>' + '<tr> <th><?php echo JText::_('COM_FM_SELECT_EMPLOYEE'); ?></th><th><?php echo JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'); ?></th>  <th><?php echo JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'); ?></th><th><?php echo JText::_('COM_FM_EMPLOYEEPAYROLLS_PAYROLL'); ?></th><th><?php echo JText::_('COM_FM_SALARY_INFO_MONTH'); ?></th></tr>'


                            }
                            if (month && year) {
                                trHTML += '<table id ="viewtable" class ="table table-hover">' + '<tr><th><?php
echo JText::_('COM_FM_SALARY_INFO');
echo JText::_('COM_FM_SALARY_INFO_MONTH');
?> ' + month + ' <?php echo JText::_('COM_FM_SALARY_INFO_YEAR'); ?> ' + year + '</th><th> </th><th></th></tr>' + '<tr> <th><?php echo JText::_('COM_FM_SELECT_EMPLOYEE'); ?></th><th><?php echo JText::_('COM_FM_REVENUEDEDUCTIONS_EMPLOYEE_GUID'); ?></th>  <th><?php echo JText::_('COM_FM_EMPLOYEEPAYROLLS_DEPARTMENT_GUID'); ?></th><th><?php echo JText::_('COM_FM_EMPLOYEEPAYROLLS_PAYROLL'); ?></th></tr>'
                            }
                            js.each(parsed.salary, function (k, item) {
                                if (month && !year)
                                {
                                    trHTML += '<tr><td><input type="checkbox" name="select[]" value="' + i + '"></td><td>' + parsed.fullname[i] + '</td><td>' + parsed.department[i] + '</td><td>' + parsed.salary[i] + '</td><td>' + parsed.years[i] + '</td></tr>';
                                    i++;
                                }
                                if (year && !month)
                                {
                                    trHTML += '<tr><td><input type="checkbox" name="select[]" value="' + i + '"></td><td>' + parsed.fullname[i] + '</td><td>' + parsed.department[i] + '</td><td>' + parsed.salary[i] + '</td><td>' + parsed.month[i] + '</td></tr>';
                                    i++;
                                }
                                if (month && year)
                                {
                                    trHTML += '<tr><td><input type="checkbox" name="select[]" value="' + i + '"></td><td>' + parsed.fullname[i] + '</td><td>' + parsed.department[i] + '</td><td>' + parsed.salary[i] + '</td></tr>';
                                    i++;
                                }
                            });
                            trHTML += '</table>'
                            if (js("#viewtable").attr('id') != 'viewtable')
                            {
                                js('#records_table').append(trHTML);
                            }
                        }
                    }
                    else {
                        //js('#records_table').remove();
                    }
                    js("#year").change(function () {
                        js('#viewtable').remove();
                    });
                    js("#month").change(function () {
                        js('#viewtable').remove();
                    });
                }


            });
        }
        js("#submit").click(function () {
            var year = js('#year').val();
            var month = js('#month').val();
            var data = "month=" + month + "&year=" + year;
            getListPayroll(data);
        });
        js("#exportexcel").click(function () {
            var year = js('#year').val();
            var month = js('#month').val();
            var data = "month=" + month + "&year=" + year;
            var router = 'index.php?option=com_fm&task=exportExcel&' + data;
            window.open(router);
        });
        js('#filter_search').keyup(function ()
        {
            searchTable(js(this).val());
        });
        js("#print").click(function () {
            js('#toolbar-button').remove();
        });
        //excel


    });

    // search info
    function searchTable(inputVal)
    {
        var table = js('#viewtable');
        table.find('tr').each(function (index, row)
        {
            var allCells = js(row).find('td');
            if (allCells.length > 0)
            {
                var found = false;
                allCells.each(function (index, td)
                {
                    var regExp = new RegExp(inputVal, 'i');
                    if (regExp.test(js(td).text()))
                    {
                        found = true;
                        return false;
                    }
                });
                if (found == true)
                    js(row).show();
                else
                    js(row).hide();
            }
        });
    }


</script>

<form action="<?php echo JRoute::_('index.php?option=com_fm&view=employeepayrolls&layout=listsalary'); ?>" method="post" name="adminForm" id="adminForm">
    <div>
        <div  class="btn-toolbar" id ="toolbar-button">
            <div  class="btn-group pull-left">
                <select class="input-medium chzn-done" id="year">
                    <option value=""><?php echo JText::_('COM_FM_SELECT_YEAR') ?></option>
                    <?php for ($i = 2014; $i < 2080; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>  
                    <?php }
                    ?>
                </select>
            </div>
            <div style="padding-left: 10px" class="btn-group pull-left">
                <select class="input-medium chzn-done" id="month">
                    <option value=""><?php echo JText::_('COM_FM_SELECT_MONTH') ?></option>
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>  
                    <?php }
                    ?>
                </select>
            </div>
            <div style="padding-left: 10px" class="btn-group pull-left">
                <div class="input-medium chzn-done">
                    <button id ="submit" type="submit" class="btn btn-default" onclick="return false"><?php echo JText::_('COM_FM_SALARY_HISTORY_BUTTON') ?></button>
                </div>
            </div>
            <div class ="filter-search btn-group pull-left">
                <input id="filter_search" type="text" title="Search" placeholder="Search" name="filter_search"> </input>
            </div>
            <div style="padding-left: 10px" class="btn-group pull-left">
                <div class="input-medium chzn-done">
                    <button id ="print" type="submit" class="btn btn-default" onclick="return false"><?php echo JText::_('COM_FM_SALARY_HISTORY_PRINT') ?></button>
                </div>
            </div>
            <div style="padding-left: 10px" class="btn-group pull-left">
                <div class="input-medium chzn-done">
                    <button id ="exportexcel" type="submit" class="btn btn-default" onclick="return false"><?php echo JText::_('COM_FM_SALARY_HISTORY_EXPORT_EXCEL') ?></button>
                </div>
            </div>

            <div style="padding-left: 10px" class="btn-group pull-left">
                <div class="input-medium chzn-done">
                    <button id ="exportexcelselect" type="submit" class="btn btn-default" onclick="return false"><?php echo JText::_('COM_FM_EXPORT_EXCEL_EMPLOYEE') ?></button>
                </div>
            </div>
        </div>

        <div id="records_table" class="clearfix" >

        </div>
    </div>
</form>




