<?php

@session_start();

class productService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT  ";
        $strSql .= "m.*, st.s_detail_th status_th, st.s_detail_en status_en , c.s_comp_th , c.s_image , t.s_name s_type_name , p.s_promotion , rp.s_name s_repair_type";
        $strSql .= " , '' as s_cartype ";
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

    function searchCar($year, $brandCode, $genCode) {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        CONCAT(b.s_brand_name,' : ','$year',' : ',g.s_gen_name ) as s_name";
        $strSql .= "        FROM    ";
        $strSql .= "        tb_car_brand b , tb_car_generation g  ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND b.s_brand_code = g.s_brand_code   ";
        $strSql .= "        AND b.s_brand_code = '$brandCode'   ";
        $strSql .= "        AND g.s_gen_code = '$genCode' ";

        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return ($_data[0]['s_name'] != NULL ? $_data[0]['s_name'] : '');
    }

    function dataTableEx() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        m.s_car_code s_code , CONCAT(b.s_brand_name,' : ',y.i_year,' : ',g.s_gen_name,' : ',s.s_sub_name ) as s_name ";
        $strSql .= "        FROM    ";
        $strSql .= "        tb_insurance m , tb_car_year y , tb_car_brand b , tb_car_generation g , tb_car_sub s , tb_status st    ";
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
//        $strSql .= "    s_car_code='$info[s_car_code]', ";
        $strSql .= "    i_year=$info[i_year], ";
        $strSql .= "    s_brand_code='$info[s_brand_code]', ";
        $strSql .= "    s_gen_code='$info[s_gen_code]', ";

        $strSql .= "    i_ins_promotion=$info[i_ins_promotion], ";
        $strSql .= "    f_price=$info[f_price], ";
        $strSql .= "    f_discount=$info[f_discount], ";
        $strSql .= "    f_point=$info[f_point], ";
        $strSql .= "    i_compu=$info[i_compu], ";


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

        $strSql .= "    s_prother_1_txt='$info[s_prother_1_txt]', ";
        $strSql .= "    s_prother_2_txt='$info[s_prother_2_txt]', ";
        $strSql .= "    s_prother_3_txt='$info[s_prother_3_txt]', ";
        $strSql .= "    s_prother_1_val='$info[s_prother_1_val]', ";
        $strSql .= "    s_prother_2_val='$info[s_prother_2_val]', ";
        $strSql .= "    s_prother_3_val='$info[s_prother_3_val]', ";




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
//        $strSql .= "    s_car_code, ";
        $strSql .= "    i_year, ";
        $strSql .= "    s_brand_code, ";
        $strSql .= "    s_gen_code, ";

        $strSql .= "    i_ins_promotion, ";
        $strSql .= "    f_price, ";
        $strSql .= "    f_discount, ";
        $strSql .= "    f_point, ";
        $strSql .= "    i_compu, ";

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

        $strSql .= "    s_prother_1_txt, ";
        $strSql .= "    s_prother_2_txt, ";
        $strSql .= "    s_prother_3_txt, ";

        $strSql .= "    s_prother_1_val, ";
        $strSql .= "    s_prother_2_val, ";
        $strSql .= "    s_prother_3_val, ";


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
//        $strSql .= "  '$info[s_car_code]', ";
        $strSql .= "  $info[i_year], ";
        $strSql .= "  '$info[s_brand_code]', ";
        $strSql .= "  '$info[s_gen_code]', ";


        $strSql .= "   $info[i_ins_promotion], ";
        $strSql .= "   $info[f_price], ";
        $strSql .= "   $info[f_discount], ";
        $strSql .= "   $info[f_point], ";
        $strSql .= "   $info[i_compu], ";

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

        $strSql .= "  '$info[s_prother_1_txt]', ";
        $strSql .= "  '$info[s_prother_2_txt]', ";
        $strSql .= "  '$info[s_prother_3_txt]', ";

        $strSql .= "  '$info[s_prother_1_val]', ";
        $strSql .= "  '$info[s_prother_2_val]', ";
        $strSql .= "  '$info[s_prother_3_val]', ";




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
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function import($db, $fileImport) {

        $myfile = fopen("../../logs/logImportInsurance.txt", "w");
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
        $hcol = $this->setHeadCol();
        foreach ($xlsx->rows() as $k => $r) {
            $col[] = array();
            $col[0] = ( (isset($r[0])) ? $r[0] : NULL );
            $col[1] = ( (isset($r[1])) ? $r[1] : NULL );
            $col[2] = ( (isset($r[2])) ? $r[2] : NULL );
            $col[3] = ( (isset($r[3])) ? $r[3] : NULL );
            $col[4] = ( (isset($r[4])) ? $r[4] : NULL );
            $col[5] = ( (isset($r[5])) ? $r[5] : NULL );
            $col[6] = ( (isset($r[6])) ? $r[6] : NULL );
            $col[7] = ( (isset($r[7])) ? $r[7] : NULL );
            $col[8] = ( (isset($r[8])) ? $r[8] : NULL );
            $col[9] = ( (isset($r[9])) ? $r[9] : NULL );
            $col[10] = ( (isset($r[10])) ? $r[10] : NULL );
            $col[11] = ( (isset($r[11])) ? $r[11] : NULL );
            $col[12] = ( (isset($r[12])) ? $r[12] : NULL );
            $col[13] = ( (isset($r[13])) ? $r[13] : NULL );
            $col[14] = ( (isset($r[14])) ? $r[14] : NULL );
            $col[15] = ( (isset($r[15])) ? $r[15] : NULL );
            $col[16] = ( (isset($r[16])) ? $r[16] : NULL );
            $col[17] = ( (isset($r[17])) ? $r[17] : NULL );
            $col[18] = ( (isset($r[18])) ? $r[18] : NULL );
            $col[19] = ( (isset($r[19])) ? $r[19] : NULL );
            $col[20] = ( (isset($r[20])) ? $r[20] : NULL );
            $col[21] = ( (isset($r[21])) ? $r[21] : NULL );
            $col[22] = ( (isset($r[22])) ? $r[22] : NULL );
            $col[23] = ( (isset($r[23])) ? $r[23] : NULL );

            if ($k == 0) {
                $flgContinue = FALSE;
                $flgContinue = (count($col) == 24 ? FALSE : TRUE);
                if ($flgContinue) {
                    $txt .= "Header format not found.\r\n";
                    break;
                }

                $flgCheckColNotMatch = FALSE;
                for ($l = 0; $l < count($col); $l++) {
                    if ($col[$l] != $hcol[$l]) {
                        $flgCheckColNotMatch = TRUE;
                    }
                }
                if ($flgCheckColNotMatch) {
                    $txt .= "Header format not found.\r\n";
                    break;
                } else {
                    continue;
                }
            }

            $rowNotNull = TRUE;
            for ($l = 0; $l < 24; $l++) {
                if ($col[$l] == NULL || $col[$l] == "") {
                    $rowNotNull = FALSE;
                }
            }

            if ($rowNotNull) {


                if ($this->isNotMsComp($db, $col[2])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 2 =  Insurance Company [" . $col[2] . "] is not master data.\r\n";
                    continue;
                }
                if ($this->isNotMsType($db, $col[3])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 3 = Insurance Type [" . $col[3] . "] is not master data.\r\n";
                    continue;
                }

                if ($this->isNotMsYear($db, $col[4])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 4 = Yea Info [" . $col[4] . "] is not master data.\r\n";
                    continue;
                }


                if ($this->isNotMsCar($db, $col[5], $col[6])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 5-6 = Car Info [" . $col[5] . "," . $col[6] . "] is not master data.\r\n";
                    continue;
                }



                if ($this->isNotMsPromotion($db, $col[7])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 7 = Promotion [" . $col[7] . "] is not master data.\r\n";
                    continue;
                }
                if ($this->isNotMsRepair($db, $col[8])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 8 = Repair Type [" . $col[8] . "] is not master data.\r\n";
                    continue;
                }

                if ($this->isNotMsCompulsory($db, $col[22])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 22 = Compulsory [" . $col[22] . "] is not master data.\r\n";
                    continue;
                }

                if ($this->isNotMsStatus($db, $col[23])) {
                    $txt .= "No=" . $col[0] . "|Desc Column 23 = Status [" . $col[23] . "] is not master data.\r\n";
                    continue;
                }

                $isNumber = TRUE;
                for ($l = 7; $l < 23; $l++) {
                    if (!is_numeric($col[$l])) {
                        $txt .= "No=" . $col[0] . "|Desc Column " . ($l + 1) . " = [" . $col[$l] . "] is not number.\r\n";
                        $isNumber = FALSE;
                    }
                }

                if (!$isNumber) {
                    continue;
                }


                if (trim($col[0]) == "") {
                    continue;
                }
                $newData = FALSE;


                $newData = $this->checkforUpdate($db, $col);

                if ($newData) {
                    $state = $this->updateStatement($db, $col);
                } else {
                    $state = $this->createStatement($db, $col);
                }






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
        fwrite($myfile, utf8_encode($txt));
        fclose($myfile);


        return $reslut;
    }

    function checkforUpdate($db, $col) {
        $strSql = "SELECT count(*) cnt FROM tb_insurance WHERE 1=1 ";
        $strSql .= "and s_insurance_htext = '" . $col[1] . "' ";
        $strSql .= "and i_ins_comp = " . $col[2] . " ";
        $strSql .= "and i_ins_type = " . $col[3] . " ";
        $strSql .= "and i_year = " . $col[4] . " ";
        $strSql .= "and s_brand_code = '" . $col[5] . "' ";
        $strSql .= "and s_gen_code = '" . $col[6] . "' ";
        $strSql .= "and s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? FALSE : TRUE);
    }

    function createStatement($db, $col) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_insurance( ";
        $strSql .= "    s_insurance_htext, ";   //1
        $strSql .= "    i_ins_comp, ";          //2
        $strSql .= "    i_ins_type, ";          //3
//        $strSql .= "    s_car_code, ";
        $strSql .= "    i_year, ";              //4
        $strSql .= "    s_brand_code, ";        //5
        $strSql .= "    s_gen_code, ";          //6

        $strSql .= "    i_ins_promotion, ";     //7
        $strSql .= "    f_price, ";             //9
        $strSql .= "    f_discount, ";          //10

        $strSql .= "    f_point, ";             //11
        $strSql .= "    s_prcar_base, ";        //12
        $strSql .= "    s_prcar_fire, ";        //13
        $strSql .= "    s_prcar_water, ";       //14
        $strSql .= "    s_prcar_repair, ";      //15
        $strSql .= "    i_prcar_repair_type, "; //8
        $strSql .= "    s_prperson_per, ";      //16
        $strSql .= "    s_prperson_pertimes, "; //17
        $strSql .= "    s_prperson_outsider, "; //18
        $strSql .= "    s_prother_personal, ";  //19
        $strSql .= "    s_prother_insurance, "; //20
        $strSql .= "    s_prother_medical, ";   //21
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status, ";           //23
        $strSql .= "    i_compu ";             //22
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$col[1]', ";
        $strSql .= "   $col[2], ";
        $strSql .= "   $col[3], ";
//        $strSql .= "  '$col[4]', ";
        $strSql .= "  '$col[4]', ";
        $strSql .= "   $col[5], ";
        $strSql .= "   $col[6], ";



        $strSql .= "   $col[7], ";
        $strSql .= "   $col[9], ";
        $strSql .= "   $col[10], ";

        $strSql .= "  '$col[11]', ";
        $strSql .= "  '$col[12]', ";
        $strSql .= "  '$col[13]', ";
        $strSql .= "  '$col[14]', ";
        $strSql .= "  '$col[15]', ";

        $strSql .= "  '$col[8]', ";


        $strSql .= "  '$col[16]', ";
        $strSql .= "  '$col[17]', ";
        $strSql .= "  '$col[18]', ";
        $strSql .= "  '$col[19]', ";
        $strSql .= "  '$col[20]', ";
        $strSql .= "  '$col[21]', ";


        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '" . trim($col[23]) . "' , ";
        $strSql .= "  $col[22] ";
        $strSql .= ") ";
        return array("query" => "$strSql");
    }

    function updateStatement($db, $col) {
        $strSql = "";
        $strSql .= "UPDATE tb_insurance ";
        $strSql .= "SET ";

        $strSql .= "    i_ins_promotion=$col[7], ";
        $strSql .= "    f_price=$col[9], ";
        $strSql .= "    f_discount=$col[10], ";
        $strSql .= "    f_point=$col[11], ";
        $strSql .= "    s_prcar_base='$col[12]', ";
        $strSql .= "    s_prcar_fire='$col[13]', ";
        $strSql .= "    s_prcar_water='$col[14]', ";
        $strSql .= "    s_prcar_repair='$col[15]', ";
        $strSql .= "    i_prcar_repair_type=$col[8], ";
        $strSql .= "    s_prperson_per='$col[16]', ";
        $strSql .= "    s_prperson_pertimes='$col[17]', ";
        $strSql .= "    s_prperson_outsider='$col[18]', ";
        $strSql .= "    s_prother_personal='$col[19]', ";
        $strSql .= "    s_prother_insurance='$col[20]', ";
        $strSql .= "    s_prother_medical='$col[21]', ";
        $strSql .= "    d_update= " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "    s_update_by=  '$_SESSION[username]', ";
        $strSql .= "    s_status='" . trim($col[23]) . "',";
        $strSql .= "    i_compu=" . $col[22];

        $strSql .= " WHERE 1=1  ";
        $strSql .= " and s_insurance_htext = '" . $col[1] . "' ";
        $strSql .= " and i_ins_comp = " . $col[2] . " ";
        $strSql .= " and i_ins_type = " . $col[3] . " ";
//        $strSql .= " and s_car_code = '" . $col[4] . "' ";
        $strSql .= " and i_year = '" . $col[4] . "' ";
        $strSql .= " and s_brand_code = '" . $col[5] . "' ";
        $strSql .= " and s_gen_code = '" . $col[6] . "' ";
        $strSql .= " and s_status = 'A' ";
        return array("query" => "$strSql");
    }

    //------------------------------------------ isNot Master ----------------------------------------

    function isNotMsYear($db, $i_year) {
        $strSql = "SELECT count(*) cnt FROM tb_car_year WHERE 1=1 ";
        $strSql .= "and i_year = $i_year ";

        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsCar($db, $brandCode, $genCode) {
        $strSql = "SELECT count(*) cnt FROM tb_car_brand b , tb_car_generation g WHERE 1=1 ";
        $strSql .= "and b.s_brand_code = g.s_brand_code ";
        $strSql .= "and b.s_brand_code = '$brandCode' ";
        $strSql .= "and g.s_gen_code = '$genCode' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsComp($db, $i_ins_comp) {
        $strSql = "SELECT count(*) cnt FROM tb_insurance_comp WHERE 1=1 ";
        $strSql .= "and i_ins_comp = " . $i_ins_comp . " ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsType($db, $i_ins_type) {
        $strSql = "SELECT count(*) cnt FROM tb_insurance_type WHERE 1=1 ";
        $strSql .= "and i_ins_type = " . $i_ins_type . " ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsPromotion($db, $i_ins_promotion) {
        $strSql = "SELECT count(*) cnt FROM tb_insurance_promotion WHERE 1=1 ";
        $strSql .= "and i_ins_promotion = " . $i_ins_promotion . " ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsRepair($db, $i_repair) {
        $strSql = "SELECT count(*) cnt FROM tb_insurance_repair_type WHERE 1=1 ";
        $strSql .= "and i_repair = " . $i_repair . " ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsCompulsory($db, $i_compu) {
        $strSql = "SELECT count(*) cnt FROM tb_compulsory WHERE 1=1 ";
        $strSql .= "and i_compu = " . $i_compu . " ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    function isNotMsStatus($db, $status) {
        $strSql = "SELECT count(*) cnt FROM tb_status WHERE 1=1 ";
        $strSql .= "and s_status = '" . $status . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return ($_data[0]['cnt'] == 0 ? TRUE : FALSE);
    }

    //--------------------------------------- Export Master ---------------------------------------

    function MsCarYear() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        i_year  ";
        $strSql .= "        FROM    ";
        $strSql .= "        tb_car_year m , tb_status st   ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND m.s_status = st.s_status   ";
        $strSql .= "        AND st.s_type   =  'ACTIVE'   ";
        $strSql .= "        order by  i_year desc  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsCarBrand() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        m.s_brand_code , m.s_brand_name  ";
        $strSql .= "        FROM    ";
        $strSql .= "         tb_car_brand  m, tb_status st   ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND m.s_status = st.s_status   ";
        $strSql .= "        AND st.s_type   =  'ACTIVE'   ";
        $strSql .= "        order by  m.i_brand asc  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsCarGen() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        m.s_gen_code , b.s_brand_name , m.s_gen_name  ";
        $strSql .= "        FROM    ";
        $strSql .= "         tb_car_generation  m , tb_car_brand b , tb_status st   ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND m.s_status = st.s_status   ";
        $strSql .= "        AND st.s_type   =  'ACTIVE'   ";
        $strSql .= "        AND m.s_brand_code = b.s_brand_code   ";
        $strSql .= "        order by m.s_gen_code asc  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsInsurance() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_comp where s_status = 'A' order by i_ins_comp asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsInsuranceType() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_type where s_status = 'A' order by i_ins_type asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsInsurancePromotion() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_promotion where s_status = 'A' order by i_ins_promotion asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsInsuranceRepair() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_repair_type where s_status = 'A' order by i_repair asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsCompulsory() {
        $db = new ConnectDB();
        $strSql = "select * from tb_compulsory where s_status = 'A' order by i_compu asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function MsStatus() {
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'ACTIVE' order by s_status asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    //--------------------------------------- Export Master ---------------------------------------


    function setHeadCol() {
        $head = array();
        $head[0] = "ลำดับ";
        $head[1] = "แคมเปญ";
        $head[2] = "บริษัทประกันภัย";
        $head[3] = "ประเภทประกันภัย";
        $head[4] = "ปีรถ";
        $head[5] = "ข้อมูลรหัสแบรนด์";
        $head[6] = "ข้อมูลรหัสรุ่น";
        $head[7] = "โปรโมชั่น";
        $head[8] = "ประเภทการซ่อม";
        $head[9] = "ราคา";
        $head[10] = "ส่วนลด";
        $head[11] = "คะแนน";
        $head[12] = "ทุนประกัน";
        $head[13] = "คุ้มครองไฟไหม้";
        $head[14] = "คุ้มครองน้ำท่วม";
        $head[15] = "ค่าเสียหายส่วนแรก";
        $head[16] = "ชีวิตบุคคลภายนอก/คน";
        $head[17] = "ชีวิตบุคคลภายนอก/ครั้ง";
        $head[18] = "ทรัพย์สินบุคคลภายนอก";
        $head[19] = "อุบัติเหตุส่วนบุคคล";
        $head[20] = "ประกันตัวผู้ขับขี่";
        $head[21] = "ค่ารักษาพยาบาล";
        $head[22] = "ประกันภัยภาคบังคับ";
        $head[23] = "สถานะ";
        return $head;
    }

}
