<?php

@session_start();

class employeeService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = " select u.*,s.s_detail_th status_th, s.s_detail_en status_en , d.s_dept_th s_dept  ";
        $strSql .= "from tb_employee u , tb_status s , tb_department d ";
        $strSql .= "where u.s_status = s.s_status ";
        $strSql .= "and s.s_type = 'ACTIVE' ";
        $strSql .= "and u.i_dept = d.i_dept ";
        $strSql .= "order by u.d_create desc , u.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_employee where i_emp =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function validUser($db, $info) {
        $strSql = " select count(*) cnt from tb_employee where s_phone ='" . $info[s_phone] . "' ";
        if ($info[func] == "edit") {
            $strSql .= " and i_emp != $info[id]  ";
        }
        $strSql .= " and s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_employee WHERE i_emp = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_employee WHERE i_emp in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_employee WHERE i_emp = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_employee WHERE i_emp in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function add($db, $info, $imgProfile) {


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_employee ( ";
        $strSql .= "    s_firstname, ";
        $strSql .= "    s_lastname, ";
        $strSql .= "    i_salary_minute, ";
        $strSql .= "    i_ot_minute, ";
        $strSql .= "    s_phone, ";
        $strSql .= "    s_email, ";
        $strSql .= "    s_line, ";



        $strSql .= "    i_dept, ";
        $strSql .= "    s_image, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_firstname]', ";
        $strSql .= "  '$info[s_lastname]', ";
        $strSql .= "  '$info[i_salary_minute]', ";
        $strSql .= "  '$info[i_ot_minute]', ";
        $strSql .= "  '$info[s_phone]', ";
        $strSql .= "  '$info[s_email]', ";
        $strSql .= "  '$info[s_line]', ";

        $strSql .= "  $info[i_dept], ";
        $strSql .= "  '$imgProfile', ";


        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function edit($db, $info, $imageProfile) {
        $strSql = "";
        $strSql .= "update tb_employee ";
        $strSql .= "set  ";
        $strSql .= "s_firstname = '$info[s_firstname]', ";
        $strSql .= "s_lastname = '$info[s_lastname]', ";
        $strSql .= "i_salary_minute = '$info[i_salary_minute]', ";
        $strSql .= "i_ot_minute = '$info[i_ot_minute]', ";
        $strSql .= "s_phone = '$info[s_phone]', ";
        $strSql .= "s_email = '$info[s_email]', ";
        $strSql .= "s_line = '$info[s_line]', ";


        $strSql .= "i_dept = $info[i_dept], ";

        if ($imageProfile != NULL) {
            $strSql .= "s_image = '$imageProfile', ";
        }

        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_emp = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
