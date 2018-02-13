<?php

@session_start();

class cancelService {

    function initialDropzone($table, $ref_no) {
        $db = new ConnectDB();
        $strSql = " select * from $table";
        $strSql .= " where ref_no=" . $ref_no;
        $strSql .= " order by d_create asc";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function addDropzone($table, $db, $info, $filename) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  $table ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    s_image, ";
        $strSql .= "    d_create, ";
        $strSql .= "    s_create_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[ref_no]', ";
        $strSql .= "  '" . $filename . "', ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function delDropzone($table, $db, $info) {
        $strSQL = "DELETE FROM $table WHERE ref_no = '" . $info[ref_no] . "' and s_image = '$info[filename]' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function dataTable() {
        $db = new ConnectDB();
        $strSql = " select *,  i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_customer_car u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'REPAIR'";
        $strSql .= " and s.s_status in ('R0')";
        $strSql .= " ) tb_cust ,";
        $strSql .= " (";
        $strSql .= " select u.i_customer,concat(t.s_title_th, ' ', u.s_firstname, ' ', u.s_lastname) s_fullname,u.s_phone_1";
        $strSql .= " from tb_customer u, tb_status s, tb_title t";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'ACTIVE' and u.i_title = t.i_title ";
        $strSql .= " ) customer";
        $strSql .= " WHERE tb_cust.i_customer = customer.i_customer ";
        $strSql .= " order by tb_cust.d_create desc , tb_cust.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function dataTableKey($id) {
        $db = new ConnectDB();
        $strSql = " select *,  i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_customer_car u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'REPAIR' ";
        $strSql .= " ) tb_cust ,";
        $strSql .= " (";
        $strSql .= " select u.i_customer,concat(t.s_title_th, ' ', u.s_firstname, ' ', u.s_lastname) s_fullname,u.s_phone_1";
        $strSql .= " from tb_customer u, tb_status s, tb_title t";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'ACTIVE' and u.i_title = t.i_title ";
        $strSql .= " ) customer";
        $strSql .= " WHERE tb_cust.i_customer = customer.i_customer ";
        $strSql .= " AND customer.i_customer =  " . $id;
        $strSql .= " order by tb_cust.d_create desc , tb_cust.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getCheckBoxMain($ref_no) {
        $db = new ConnectDB();
        $strSql = " select * from tb_check_repair where ref_no = '$ref_no' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getCheckBoxOther($ref_no) {
        $db = new ConnectDB();
        $strSql = " select * from tb_check_repair_other where ref_no = '$ref_no' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function checkKey($db, $info) {
        $db = new ConnectDB();
        $rtn = FALSE;
        $strSql = " select count(*) cnt from tb_check_repair where ref_no = '$info[ref_no]'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        if ($_data != NULL) {
            if ($_data[0]['cnt'] == 0) {
                $rtn = TRUE;
            }
        }
        return $rtn;
    }

   function getYear($i_year) {
        $db = new ConnectDB();
//        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
//        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_year where i_year =" . $i_year;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['i_year'];
    }

    function getBrand($brandCode) {
        $db = new ConnectDB();
//        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
//        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_brand where s_brand_code ='" . $brandCode . "'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_brand_name'];
    }

    function getGeneration($genCode) {
        $db = new ConnectDB();
//        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
//        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_generation where s_gen_code ='" . $genCode . "'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_gen_name'];
    }

    function getInsurance($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_insurance_comp where i_ins_comp =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_comp_th'];
    }

    function getDamage($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_damage where i_dmg =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_dmg_th'];
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_customer_car where i_cust_car =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function validUser($db, $info) {
        $strSql = " select count(*) cnt from tb_customer_car where s_phone_1 ='" . $info[s_phone] . "' ";
        if ($info[func] == "edit") {
            $strSql .= " and i_cust_car != $info[id]  ";
        }
        $strSql .= " and s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_customer_car WHERE i_cust_car = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_customer_car WHERE i_cust_car in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function getListRepairActive($db) {
        $strSql = "SELECT * FROM tb_repair_item WHERE s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_filename img from tb_check_repair ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function add($db, $info) {
//        $util = new Utility();
//
//        $strSql = "";
//        $strSql .= "INSERT ";
//        $strSql .= "INTO ";
//        $strSql .= "  tb_customer_car ( ";
//        $strSql .= "    i_customer, ";
//        $strSql .= "    ref_no, ";
//        $strSql .= "    s_car_code, ";
//        $strSql .= "    s_license, ";
//        $strSql .= "    d_ins_exp, ";
//        $strSql .= "    i_ins_type, ";
//        $strSql .= "    s_type_capital, ";
//        $strSql .= "    s_pay_type, ";
//
//        $strSql .= "    i_ins_comp, ";
////        $strSql .= "    i_dmg, ";
//        $strSql .= "    d_inbound, ";
//        $strSql .= "    d_outbound_confirm, ";
//
//
//        $strSql .= "    d_create, ";
//        $strSql .= "    d_update, ";
//        $strSql .= "    s_create_by, ";
//        $strSql .= "    s_update_by, ";
//        $strSql .= "    s_status ";
//        $strSql .= "  ) ";
//        $strSql .= "VALUES( ";
//        $strSql .= "  $info[i_customer], ";
//        $strSql .= "  '" . $this->getRunning($db) . "', ";
//        $strSql .= "  '$info[s_car_code]', ";
//        $strSql .= "  '$info[s_license]', ";
//        $strSql .= "  '" . $util->DateSQL($info[d_ins_exp]) . "', ";
//        $strSql .= "  $info[i_ins_type], ";
//        $strSql .= "  '$info[s_type_capital]', ";
//        $strSql .= "  '$info[s_pay_type]', ";
//
//        $strSql .= "  $info[i_ins_comp], ";
////        $strSql .= "  $info[i_dmg], ";
//        $strSql .= "  '" . $util->DateSQL($info[d_inbound]) . "', ";
//        $strSql .= "  '" . $util->DateSQL($info[d_outbound_confirm]) . "', ";
//
//        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
//        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
//        $strSql .= "  '$_SESSION[username]', ";
//        $strSql .= "  '$_SESSION[username]', ";
//        $strSql .= "  '$info[status]' ";
//        $strSql .= ") ";
//        $arr = array(
//            array("query" => "$strSql")
//        );
//        $reslut = $db->insert_for_upadte($arr);
//        return $reslut;
    }

    function edit($db, $info) {
        $arr = array();
        array_push($arr, array("query" => $this->sqlUpdateMain($db, $info)));
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function checkDuppSub($db, $info) {
        $rtn = FALSE;
        $strSql = " select count(*) cnt from tb_check_repair_other where ref_no = '$info[ref_no]'";
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data != NULL) {
            if ($_data[0]['cnt'] > 0) {
                $rtn = TRUE;
            }
        }
        return $rtn;
    }

    function createStatement($db, $ref, $i_repair, $filename, $remark) {


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_check_repair ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    i_repair_item, ";
        $strSql .= "    s_filename, ";
        $strSql .= "    s_remark, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";

        $strSql .= "  '$ref', ";
        $strSql .= "  $i_repair, ";
        $strSql .= "  '$filename', ";
        $strSql .= "  '$remark', ";


        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  'A' ";
        $strSql .= ") ";

        return $strSql;
    }

    function createStatementSub($db, $info) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_check_repair_other ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    s_txt_1, ";
        $strSql .= "    s_txt_2, ";
        $strSql .= "    s_txt_3, ";
        $strSql .= "    s_txt_4, ";
        $strSql .= "    s_txt_5, ";
        $strSql .= "    s_txt_6, ";
        $strSql .= "    s_txt_7, ";
        $strSql .= "    s_txt_8, ";
        $strSql .= "    s_txt_9, ";
        $strSql .= "    s_txt_10, ";
        $strSql .= "    s_txt_11, ";
        $strSql .= "    s_txt_12, ";
        $strSql .= "    s_txt_13, ";
        $strSql .= "    s_filename_1, ";
        $strSql .= "    s_filename_2, ";
        $strSql .= "    s_filename_3, ";
        $strSql .= "    s_filename_4, ";
        $strSql .= "    s_filename_5, ";
        $strSql .= "    s_filename_6, ";
        $strSql .= "    s_filename_7, ";
        $strSql .= "    s_filename_8, ";
        $strSql .= "    s_filename_9, ";
        $strSql .= "    s_filename_10, ";
        $strSql .= "    s_filename_11, ";
        $strSql .= "    s_filename_12, ";
        $strSql .= "    s_filename_13, ";
        $strSql .= "    i_repair_subitem1, ";
        $strSql .= "    i_repair_subitem2, ";
        $strSql .= "    i_repair_subitem3, ";
        $strSql .= "    i_repair_subitem4, ";
        $strSql .= "    i_repair_subitem5, ";
        $strSql .= "    i_repair_subitem6, ";
        $strSql .= "    i_repair_subitem7, ";
        $strSql .= "    i_repair_subitem8, ";
        $strSql .= "    i_repair_subitem9, ";
        $strSql .= "    i_repair_subitem10, ";
        $strSql .= "    i_repair_subitem11, ";
        $strSql .= "    i_repair_subitem12, ";
        $strSql .= "    i_repair_subitem13 ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[ref_no]', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 1) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 2) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 3) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 4) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 5) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 6) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 7) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 8) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 9) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 10) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 11) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 12) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedText($info, 13) . "', ";

        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 1) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 2) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 3) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 4) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 5) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 6) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 7) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 8) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 9) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 10) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 11) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 12) . "', ";
        $strSql .= "  '" . $this->checkSQLSelectedFile($info, 13) . "', ";


        $strSql .= "  '" . $this->checkSQLSelected($info, 1) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 2) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 3) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 4) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 5) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 6) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 7) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 8) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 9) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 10) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 11) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 12) . "', ";
        $strSql .= "  '" . $this->checkSQLSelected($info, 13) . "' ";
        $strSql .= ") ";

        return $strSql;
    }

    function checkSQLSelected($info, $index) {
        if ($info['i_repair_subitem_' . $index] == '' && $info['i_repair_subitem_' . $index] == '0') {
            return '';
        } else {
            return $info['i_repair_subitem_' . $index];
        }
    }

    function checkSQLSelectedFile($info, $index) {
        if ($info['i_repair_subitem_' . $index] == '' && $info['i_repair_subitem_' . $index] == '0') {
            return '';
        } else {
            $keyIndex = 'files_' . $index;
            $temp = explode(".", $_FILES[$keyIndex]["name"]);

            if ($_FILES[$keyIndex]['error'] == 4) {
                $cksKey = 'cks_' . $index;
                if ($info[$cksKey] != '') {
                    return $info[$cksKey];
                } else {
                    return '';
                }
            } else {
                return $info[ref_no] . "_" . $index . "." . end($temp);
            }
//            return ( $_FILES[$keyIndex]['error'] == 4 ? "" : $info[ref_no] . "_" . $index . "." . end($temp));
        }
    }

    function checkSQLSelectedText($info, $index) {
        $tmp = '';
        if ($info['i_repair_subitem_' . $index] == '' && $info['i_repair_subitem_' . $index] == '0') {
            $tmp = '';
        } else {
            $tmp = $info['i_repair_subitem_' . $index];
        }

        if ($tmp != '') {
            return $info['s_repair_subitem_' . $index];
        } else {
            return '';
        }
    }

    function sqlUpdateMain($db, $info) {
        $strSql = "";
        $strSql .= "update tb_customer_car ";
        $strSql .= "set  ";
//        $strSql .= "i_customer = $info[i_customer], ";
//        $strSql .= "s_car_code = '$info[s_car_code]', ";
//        $strSql .= "s_license = '$info[s_license]', ";
//        $strSql .= "d_ins_exp = '" . $util->DateSQL($info[d_ins_exp]) . "', ";
//        $strSql .= "i_ins_type = $info[i_ins_type], ";
//        $strSql .= "s_type_capital = '$info[s_type_capital]', ";
//        $strSql .= "s_pay_type = '$info[s_pay_type]', ";
//        $strSql .= "i_ins_comp = $info[i_ins_comp], ";
//        $strSql .= "i_dmg = $info[i_dmg], ";
//        $strSql .= "d_inbound = '" . $util->DateSQL($info[d_inbound]) . "', ";
//        $strSql .= "d_outbound_confirm = '" . $util->DateSQL($info[d_outbound_confirm]) . "', ";

        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_cust_car = $info[id] ";

        return $strSql;
    }

    function sqlUpdateCheckOther($db, $info) {
        $strSql = "";
        $strSql .= "update tb_check_repair_other ";
        $strSql .= "set  ";


        $strSql .= "s_txt_1 = '" . $this->checkSQLSelectedText($info, 1) . "', ";
        $strSql .= "s_txt_2 = '" . $this->checkSQLSelectedText($info, 2) . "', ";
        $strSql .= "s_txt_3 = '" . $this->checkSQLSelectedText($info, 3) . "', ";
        $strSql .= "s_txt_4 = '" . $this->checkSQLSelectedText($info, 4) . "', ";
        $strSql .= "s_txt_5 = '" . $this->checkSQLSelectedText($info, 5) . "', ";
        $strSql .= "s_txt_6 = '" . $this->checkSQLSelectedText($info, 6) . "', ";
        $strSql .= "s_txt_7 = '" . $this->checkSQLSelectedText($info, 7) . "', ";
        $strSql .= "s_txt_8 = '" . $this->checkSQLSelectedText($info, 8) . "', ";
        $strSql .= "s_txt_9 = '" . $this->checkSQLSelectedText($info, 9) . "', ";
        $strSql .= "s_txt_10 = '" . $this->checkSQLSelectedText($info, 10) . "', ";
        $strSql .= "s_txt_11 = '" . $this->checkSQLSelectedText($info, 11) . "', ";
        $strSql .= "s_txt_12 = '" . $this->checkSQLSelectedText($info, 12) . "', ";
        $strSql .= "s_txt_13 = '" . $this->checkSQLSelectedText($info, 13) . "', ";

        $strSql .= "i_repair_subitem1 = '" . $this->checkSQLSelected($info, 1) . "', ";
        $strSql .= "i_repair_subitem2 = '" . $this->checkSQLSelected($info, 2) . "', ";
        $strSql .= "i_repair_subitem3 = '" . $this->checkSQLSelected($info, 3) . "', ";
        $strSql .= "i_repair_subitem4 = '" . $this->checkSQLSelected($info, 4) . "', ";
        $strSql .= "i_repair_subitem5 = '" . $this->checkSQLSelected($info, 5) . "', ";
        $strSql .= "i_repair_subitem6 = '" . $this->checkSQLSelected($info, 6) . "', ";
        $strSql .= "i_repair_subitem7 = '" . $this->checkSQLSelected($info, 7) . "', ";
        $strSql .= "i_repair_subitem8 = '" . $this->checkSQLSelected($info, 8) . "', ";
        $strSql .= "i_repair_subitem9 = '" . $this->checkSQLSelected($info, 9) . "', ";
        $strSql .= "i_repair_subitem10 = '" . $this->checkSQLSelected($info, 10) . "', ";
        $strSql .= "i_repair_subitem11 = '" . $this->checkSQLSelected($info, 11) . "', ";
        $strSql .= "i_repair_subitem12 = '" . $this->checkSQLSelected($info, 12) . "', ";
        $strSql .= "i_repair_subitem13 = '" . $this->checkSQLSelected($info, 13) . "', ";

        $strSql .= "s_filename_1 = '" . $this->checkSQLSelectedFile($info, 1) . "', ";
        $strSql .= "s_filename_2 = '" . $this->checkSQLSelectedFile($info, 2) . "', ";
        $strSql .= "s_filename_3 = '" . $this->checkSQLSelectedFile($info, 3) . "', ";
        $strSql .= "s_filename_4 = '" . $this->checkSQLSelectedFile($info, 4) . "', ";
        $strSql .= "s_filename_5 = '" . $this->checkSQLSelectedFile($info, 5) . "', ";
        $strSql .= "s_filename_6 = '" . $this->checkSQLSelectedFile($info, 6) . "', ";
        $strSql .= "s_filename_7 = '" . $this->checkSQLSelectedFile($info, 7) . "', ";
        $strSql .= "s_filename_8 = '" . $this->checkSQLSelectedFile($info, 8) . "', ";
        $strSql .= "s_filename_9 = '" . $this->checkSQLSelectedFile($info, 9) . "', ";
        $strSql .= "s_filename_10 = '" . $this->checkSQLSelectedFile($info, 10) . "', ";
        $strSql .= "s_filename_11 = '" . $this->checkSQLSelectedFile($info, 11) . "', ";
        $strSql .= "s_filename_12 = '" . $this->checkSQLSelectedFile($info, 12) . "', ";
        $strSql .= "s_filename_13 = '" . $this->checkSQLSelectedFile($info, 13) . "' ";


        $strSql .= "where ref_no = $info[ref_no] ";

        return $strSql;
    }

    function getRunning($db) {
        $year = substr(date("Y"), 2);
        $month = str_pad("", 2 - strlen(date("m")), "0") . date("m");
        $strSql = "SELECT * FROM tb_master_running WHERE s_year = '" . $year . "' and s_month = '" . $month . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $current = intval($_data[0]['s_running']);
        $run_new = $current + 1; // str_pad($str, 20, ".");
        $run_new = str_pad("", 3 - strlen($run_new), "0") . $run_new;
        $strSql = "UPDATE tb_master_running set s_running='$run_new'  WHERE s_year = '" . $year . "' and s_month = '" . $month . "' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);

        return $year . $month . $run_new;
    }

}
