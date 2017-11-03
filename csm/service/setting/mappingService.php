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

    function isDupplicateExcel($db, $year, $brand, $gen, $sub) {
        $strSql = "SELECT count(*) cnt FROM tb_car_map WHERE 1=1 ";
        $strSql .= "and i_year = " . $year . " ";
        $strSql .= "and s_brand_code = '" . $brand . "' ";
        $strSql .= "and s_gen_code = '" . $gen . "' ";
        $strSql .= "and s_sub_code = '" . $sub . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function import($db, $fileImport) {
        $myfile = fopen("../../logs/logImport.txt", "w");
        $txt = "";
        $txt .= "=================== START =======================\r\n";
        $txt .= date("Y-m-d h:i:s") . "\r\n";
        $txt .= "Import File : " . $fileImport['name'] . "\r\n";
        $errorLog = array();
        $arrSQL = array();
        $xlsx = new SimpleXLSX($fileImport['tmp_name']);

        $datestamp = "";
        $i = 1;
        $tp = "";
        foreach ($xlsx->rows() as $k => $r) {
            $col0 = ( (isset($r[0])) ? $r[0] : NULL );
            $col1 = ( (isset($r[1])) ? $r[1] : NULL );
            $col2 = ( (isset($r[2])) ? $r[2] : NULL );
            $col3 = ( (isset($r[3])) ? $r[3] : NULL );
            $col4 = ( (isset($r[4])) ? $r[4] : NULL );
            if ($k == 0) {
                if ($col0 != NULL && $col1 != NULL && $col2 != NULL && $col3 != NULL && $col4 != NULL) {
                    if ($col1 == "YEAR" && $col2 == "BRAND CODE" && $col3 == "GENERATION CODE" && $col4 == "SUB CODE") {
                        continue;
                    }
                }
            }

            if ($col0 != NULL && $col1 != NULL && $col2 != NULL && $col3 != NULL && $col4 != NULL) {

                if ($this->isNotMsYear($db, $col1)) {
                    $txt .= "No=" . $col0 . "|Desc= Year [" . $col1 . "] data is Dupplicate.\r\n";
                    continue;
                }
                if ($this->isNotMsBrand($db, $col2)) {
                    $txt .= "No=" . $col0 . "|Desc= Brand [" . $col2 . "] data is Dupplicate.\r\n";
                    continue;
                }
                if ($this->isNotMsGen($db, $col3)) {
                    $txt .= "No=" . $col0 . "|Desc= Generation [" . $col3 . "] data is Dupplicate.\r\n";
                    continue;
                }
                if ($this->isNotMsSub($db, $col4)) {
                    $txt .= "No=" . $col0 . "|Desc= Sub [" . $col4 . "] data is Dupplicate.\r\n";
                    continue;
                }




                if ($this->isDupplicateExcel($db, $col1, $col2, $col3, $col4)) {
                    $txt .= "No=" . $col0 . "|Desc= [Year:$col1|Brand:$col2|Generation:$col3|Sub:$col4] Data Dupplicate.\r\n";
                    continue;
                }
                $state = $this->createStatement($db, $col1, $col2, $col3, $col4);
                array_push($arrSQL, $state);
            }
        }
        $reslut = FALSE;
        if (count($arrSQL) > 0) {
            $reslut = $db->insert_for_upadte($arrSQL);
        } else {
            $txt .= "List Data:0\r\n";
        }

        $txt .= date("Y-m-d h:i:s") . "\r\n";
        $txt .= "===================== END =======================";
        fwrite($myfile, $txt);
        fclose($myfile);


        return $reslut;
    }

    function createStatement($db, $col1, $col2, $col3, $col4) {
        $sql = " insert into tb_car_map (i_year , s_brand_code , s_gen_code , s_sub_code , d_create , d_update , s_create_by , s_update_by ,s_status) ";
        $sql .= " values ";
        $sql .= " ('$col1' , '$col2' , '$col3' , '$col4' ," . $db->Sysdate(TRUE) . " ," . $db->Sysdate(TRUE) . " ,'$_SESSION[username]','$_SESSION[username]','A' ) ";
        return array("query" => "$sql");
    }

    function isNotMsYear($db, $year) {
        $strSql = "SELECT count(*) cnt FROM tb_car_year WHERE 1=1 ";
        $strSql .= "and i_year = " . $year . " ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsBrand($db, $brand) {
        $strSql = "SELECT count(*) cnt FROM tb_car_brand WHERE 1=1 ";
        $strSql .= "and s_brand_code = '" . $brand . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsGen($db, $gen) {
        $strSql = "SELECT count(*) cnt FROM tb_car_generation WHERE 1=1 ";
        $strSql .= "and s_gen_code = '" . $gen . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsSub($db, $sub) {
        $strSql = "SELECT count(*) cnt FROM tb_car_sub WHERE 1=1 ";
        $strSql .= "and s_sub_code = '" . $sub . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

}
