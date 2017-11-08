<?php

@session_start();

class productService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT  ";
        $strSql .= "m.*, st.s_detail_th status_th, st.s_detail_en status_en , c.s_comp_th , c.s_image , t.s_name s_type_name , p.s_promotion , rp.s_name s_repair_type";
        $strSql .= " FROM  ";
        $strSql .= "tb_insurance m  , tb_insurance_comp c , tb_insurance_type t, tb_status st ,tb_insurance_promotion p , tb_insurance_repair_type rp ";
        $strSql .= "WHERE 1=1 ";
        $strSql .= "AND m.i_ins_comp = c.i_ins_comp ";
        $strSql .= "AND m.i_ins_type = t.i_ins_type ";
        $strSql .= "AND m.i_ins_promotion = p.i_ins_promotion ";
        $strSql .= "AND m.i_prcar_repair_type = rp.i_repair ";
        $strSql .= "AND m.s_status = st.s_status ";
        $strSql .= "AND st.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function dataTableEx() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        m.s_car_code s_code , CONCAT(b.s_brand_name,' : ',y.i_year,' : ',g.s_gen_name,' : ',s.s_sub_name ) as s_name ";
        $strSql .= "        FROM    ";
        $strSql .= "        tb_insurance m , tb_car_year y , tb_car_brand b , tb_car_generation g , tb_car_sub s , tb_status st   ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND m.i_year = y.i_year   ";
        $strSql .= "        AND m.s_brand_code = b.s_brand_code   ";
        $strSql .= "        AND m.s_gen_code = g.s_gen_code   ";
        $strSql .= "        AND m.s_sub_code = s.s_sub_code   ";
        $strSql .= "        AND m.s_status = st.s_status   ";
        $strSql .= "        AND st.s_type   =  'ACTIVE'   ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_insurance where i_insurance =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_image from tb_insurance ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_insurance WHERE i_insurance = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {
        $strSQL = "DELETE FROM tb_insurance WHERE i_insurance in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_insurance WHERE i_insurance = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function isDupplicate($db, $info) {
        $strSql = "SELECT count(*) cnt FROM tb_insurance WHERE 1=1 ";
        $strSql .= "and i_year = " . $info[i_year] . " ";
        $strSql .= "and s_brand_code = '" . $info[s_brand_code] . "' ";
        $strSql .= "and s_gen_code = '" . $info[s_gen_code] . "' ";
        $strSql .= "and s_sub_code = '" . $info[s_sub_code] . "' ";
        $strSql .= ($info[func] == 'edit' ? " and i_insurance != $info[id] " : "");
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_insurance  WHERE i_insurance in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info) {

        $strSql = "";
        $strSql .= "update tb_insurance ";
        $strSql .= "set  ";

        $strSql .= "    s_insurance_htext='$info[s_insurance_htext]', ";
        $strSql .= "    i_ins_comp=$info[i_ins_comp], ";
        $strSql .= "    i_ins_type=$info[i_ins_type], ";
        $strSql .= "    s_car_code='$info[s_car_code]', ";
        $strSql .= "    i_ins_promotion=$info[i_ins_promotion], ";
        $strSql .= "    f_price=$info[f_price], ";
        $strSql .= "    f_discount=$info[f_discount], ";
        $strSql .= "    f_point=$info[f_point], ";


        $strSql .= "    s_prcar_base='$info[s_prcar_base]', ";
        $strSql .= "    s_prcar_fire='$info[s_prcar_fire]', ";
        $strSql .= "    s_prcar_water='$info[s_prcar_water]', ";
        $strSql .= "    s_prcar_repair='$info[s_prcar_repair]', ";
        $strSql .= "    i_prcar_repair_type=$info[i_prcar_repair_type], ";

        $strSql .= "    s_prperson_per='$info[s_prperson_per]', ";
        $strSql .= "    s_prperson_pertimes='$info[s_prperson_pertimes]', ";
        $strSql .= "    s_prperson_outsider='$info[s_prperson_outsider]', ";

        $strSql .= "    s_prother_personal='$info[s_prother_personal]', ";
        $strSql .= "    s_prother_insurance='$info[s_prother_insurance]', ";
        $strSql .= "    s_prother_medical='$info[s_prother_medical]', ";



        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_insurance = $info[id] ";
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
        $strSql .= "  tb_insurance( ";
        $strSql .= "    s_insurance_htext, ";
        $strSql .= "    i_ins_comp, ";
        $strSql .= "    i_ins_type, ";
        $strSql .= "    s_car_code, ";
        $strSql .= "    i_ins_promotion, ";
        $strSql .= "    f_price, ";
        $strSql .= "    f_discount, ";
        $strSql .= "    f_point, ";


        $strSql .= "    s_prcar_base, ";
        $strSql .= "    s_prcar_fire, ";
        $strSql .= "    s_prcar_water, ";
        $strSql .= "    s_prcar_repair, ";
        $strSql .= "    i_prcar_repair_type, ";

        $strSql .= "    s_prperson_per, ";
        $strSql .= "    s_prperson_pertimes, ";
        $strSql .= "    s_prperson_outsider, ";

        $strSql .= "    s_prother_personal, ";
        $strSql .= "    s_prother_insurance, ";
        $strSql .= "    s_prother_medical, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_insurance_htext]', ";
        $strSql .= "   $info[i_ins_comp], ";
        $strSql .= "   $info[i_ins_type], ";
        $strSql .= "  '$info[s_car_code]', ";
        $strSql .= "   $info[i_ins_promotion], ";
        $strSql .= "   $info[f_price], ";
        $strSql .= "   $info[f_discount], ";
        $strSql .= "   $info[f_point], ";

        $strSql .= "  '$info[s_prcar_base]', ";
        $strSql .= "  '$info[s_prcar_fire]', ";
        $strSql .= "  '$info[s_prcar_water]', ";
        $strSql .= "  '$info[s_prcar_repair]', ";
        $strSql .= "   $info[i_prcar_repair_type], ";

        $strSql .= "  '$info[s_prperson_per]', ";
        $strSql .= "  '$info[s_prperson_pertimes]', ";
        $strSql .= "  '$info[s_prperson_outsider]', ";

        $strSql .= "  '$info[s_prother_personal]', ";
        $strSql .= "  '$info[s_prother_insurance]', ";
        $strSql .= "  '$info[s_prother_medical]', ";


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
        $strSql = "SELECT count(*) cnt FROM tb_insurance WHERE 1=1 ";
        $strSql .= "and i_year = " . $year . " ";
        $strSql .= "and s_brand_code = '" . $brand . "' ";
        $strSql .= "and s_gen_code = '" . $gen . "' ";
        $strSql .= "and s_sub_code = '" . $sub . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function import($db, $fileImport) {
        $myfile = fopen("../../logs/logImportMap.txt", "w");
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

                if (trim($col0) == "") {
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
        $sql = " insert into tb_insurance (i_year , s_brand_code , s_gen_code , s_sub_code , d_create , d_update , s_create_by , s_update_by ,s_status) ";
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
