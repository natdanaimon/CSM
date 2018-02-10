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

    function dataTableEx() {
        $db = new ConnectDB();
        $strSql = "select b.s_brand_code s_code , b.s_brand_name s_name ";
        $strSql .= " from   tb_car_brand b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
        $strSql .= " order by b.s_brand_name asc ";
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
        $strSql = "SELECT * FROM tb_car_brand WHERE s_brand_code = '" . $info[s_brand_code] . "' ";
        $strSql .= ($info[func] == 'edit' ? " and i_brand <> $info[id] " : "");
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
        $strSql .= "    s_brand_code='$info[s_brand_code]', ";
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
        $strSql .= "    s_brand_code, ";
        $strSql .= "    s_brand_name, ";
        $strSql .= "    s_image, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_brand_code]', ";

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

    function import($db, $fileImport) {
        $myfile = fopen("../../logs/logImportBrand.txt", "w");
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
            $col0 = ( (isset($r[0])) ? trim($r[0]) : NULL );
            $col1 = ( (isset($r[1])) ? trim($r[1]) : NULL );
            $col2 = ( (isset($r[2])) ? trim($r[2]) : NULL );

            if ($k == 0) {
                if ($col0 != NULL && $col1 != NULL && $col2 != NULL) {
                    if ($col0 == "NO" && $col1 == "BRAND CODE" && $col2 == "BRAND NAME") {
                        continue;
                    } else {
                        $txt .= "Header format not found.\r\n";
                        break;
                    }
                } else {
                    $txt .= "Header format not found.\r\n";
                    break;
                }
            }

            if ($col0 != NULL && $col1 != NULL && $col2 != NULL) {


                if ($this->isDupplicateExcel($db, $col1)) {
                    $txt .= "No=" . $col0 . "|Desc= [Brand:$col1] Data Dupplicate.\r\n";
                    continue;
                }

                if (trim($col0) == "") {
                    continue;
                }

                $state = $this->createStatement($db, $col1, $col2);
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

    function isDupplicateExcel($db, $brand) {
        $strSql = "SELECT count(*) cnt FROM tb_car_brand WHERE 1=1 ";
        $strSql .= "and s_brand_code = '" . $brand . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function createStatement($db, $col1, $col2, $col3, $col4) {
        $sql = " insert into tb_car_brand ( s_brand_code , s_brand_name, d_create , d_update , s_create_by , s_update_by ,s_status) ";
        $sql .= " values ";
        $sql .= " ('$col1' , '$col2' ," . $db->Sysdate(TRUE) . " ," . $db->Sysdate(TRUE) . " ,'$_SESSION[username]','$_SESSION[username]','A' ) ";
        return array("query" => "$sql");
    }

}
