<?php

@session_start();

class mappingService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT  ";
        $strSql .= "m.*, st.s_detail_th status_th, st.s_detail_en status_en , b.s_brand_name,b.s_image , g.s_gen_name , s.s_sub_name ";
        $strSql .= "FROM  ";
        $strSql .= "tb_car_map m , tb_car_year y , tb_car_brand b , tb_car_generation g , tb_car_sub s , tb_status st ";
        $strSql .= "WHERE 1=1 ";
        $strSql .= "AND m.i_year = y.i_year ";
        $strSql .= "AND m.s_brand_code = b.s_brand_code ";
        $strSql .= "AND m.s_gen_code = g.s_gen_code ";
        $strSql .= "AND m.s_sub_code = s.s_sub_code ";
        $strSql .= "AND m.s_status = st.s_status ";
        $strSql .= "AND st.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_car_map where i_car =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_image from tb_car_map ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_car_map WHERE i_car = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {
        $strSQL = "DELETE FROM tb_car_map WHERE i_car in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_car_map WHERE i_car = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function isDupplicate($db, $info) {
        $strSql = "SELECT count(*) cnt FROM tb_car_map WHERE 1=1 ";
        $strSql .= "and i_year = " . $info[i_year] . " ";
        $strSql .= "and s_brand_code = '" . $info[s_brand_code] . "' ";
        $strSql .= "and s_gen_code = '" . $info[s_gen_code] . "' ";
        $strSql .= "and s_sub_code = '" . $info[s_sub_code] . "' ";
        $strSql .= ($info[func] == 'edit' ? " and i_car != $info[id] " : "");
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_car_map  WHERE i_car in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info) {

        $strSql = "";
        $strSql .= "update tb_car_map ";
        $strSql .= "set  ";
        $strSql .= "    i_year=$info[i_year], ";
        $strSql .= "    s_brand_code='$info[s_brand_code]', ";
        $strSql .= "    s_gen_code='$info[s_gen_code]', ";
        $strSql .= "    s_sub_code='$info[s_sub_code]', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_car = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info) {


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_car_map( ";
        $strSql .= "    i_year, ";
        $strSql .= "    s_brand_code, ";
        $strSql .= "    s_gen_code, ";
        $strSql .= "    s_sub_code, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  $info[i_year], ";
        $strSql .= "  '$info[s_brand_code]', ";
        $strSql .= "  '$info[s_gen_code]', ";
        $strSql .= "  '$info[s_sub_code]', ";


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
