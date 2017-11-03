<?php

@session_start();

class brandService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_car_brand b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_car_brand where i_brand =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_image from tb_car_brand ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_car_brand WHERE i_brand = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {
        $strSQL = "DELETE FROM tb_car_brand WHERE i_brand in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_car_brand WHERE i_brand = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function isDupplicate($db, $info) {
        $strSql = "SELECT * FROM tb_car_brand WHERE s_brand_name = '" . $info[s_brand_name] . "' ";
        $strSql .= ($info[func]=='edit'?" and i_brand <> $info[id] ":"");
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data != NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_car_brand  WHERE i_brand in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info, $img1) {
        if ($img1 == NULL) {
            $img1 = "";
        }

        $strSql = "";
        $strSql .= "update tb_car_brand ";
        $strSql .= "set  ";
        $strSql .= "    s_brand_name='$info[s_brand_name]', ";
        $strSql .= "    s_image='$img1', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_brand = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info, $img1) {
        if ($img1 == NULL) {
            $img1 = "";
        }


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_car_brand( ";
        $strSql .= "    s_brand_name, ";
        $strSql .= "    s_image, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";

        $strSql .= "  '$info[s_brand_name]', ";
        $strSql .= "  '$img1', ";

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

}
