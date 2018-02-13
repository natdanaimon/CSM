<?php

@session_start();

class commonService {

    function DDLStatus() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'CS' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function CheckBoxCheckRepair() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_repair_item where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLPayType() {
        $db = new ConnectDB();
        $strSql = "select * from tb_pay where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLDamage() {
        $db = new ConnectDB();
        $strSql = "select * from tb_damage where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLCAPITAL() {
        $db = new ConnectDB();
        $strSql = "select * from tb_damage where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLStatusActive() {
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'ACTIVE' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLStatusRepart() {
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'REPAIR' order by i_index asc";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLDepartment() {
        $db = new ConnectDB();
        $strSql = "select * from tb_department where s_status = 'A' order by i_index asc , s_dept_th asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLProvince($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_provinces order by i_province , s_name_th asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLAmphure($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_amphures where i_province = $info[i_province] order by i_amphure , s_name_th asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLDistrict($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_districts where i_amphure =  $info[i_amphure] order by i_district asc";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLZipcode($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_districts where i_district =  $info[i_district] ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLTitle() {
        $db = new ConnectDB();
        $strSql = "select * from tb_title ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLPosition() {
        $db = new ConnectDB();
        $strSql = "select * from tb_position ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLCompulsory() {
        $db = new ConnectDB();
        $strSql = "select * from tb_compulsory ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLYear() {
        $db = new ConnectDB();
        $strSql = "select * from tb_car_year where s_status = 'A' order by i_year desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLBrand() {
        $db = new ConnectDB();
        $strSql = "select * from tb_car_brand where s_status = 'A' order by i_brand asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLGenerationSelect($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_car_generation where s_brand_code = '$info[s_brand_code]' and s_status = 'A' order by s_gen_code asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLGeneration() {
        $db = new ConnectDB();
        $strSql = "select * from tb_car_generation where s_status = 'A' order by s_gen_code asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLSub() {
        $db = new ConnectDB();
        $strSql = "select * from tb_car_sub where s_status = 'A' order by s_sub_code asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLCar() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        m.s_car_code s_code , CONCAT(b.s_brand_name,' : ',y.i_year,' : ',g.s_gen_name,' : ',s.s_sub_name ) as s_name , b.s_image ";
        $strSql .= "        FROM    ";
        $strSql .= "        tb_car_map m , tb_car_year y , tb_car_brand b , tb_car_generation g , tb_car_sub s , tb_status st   ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND m.i_year = y.i_year   ";
        $strSql .= "        AND m.s_brand_code = b.s_brand_code   ";
        $strSql .= "        AND m.s_gen_code = g.s_gen_code   ";
        $strSql .= "        AND m.s_sub_code = s.s_sub_code   ";
        $strSql .= "        AND m.s_status = st.s_status   ";
        $strSql .= "        AND st.s_type   =  'ACTIVE'   ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLInsurance() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_comp where s_status = 'A' order by i_ins_comp asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLInsuranceType() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_type where s_status = 'A' order by i_ins_type asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLInsurancePromotion() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_promotion where s_status = 'A' order by i_ins_promotion asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLInsuranceRepair() {
        $db = new ConnectDB();
        $strSql = "select * from tb_insurance_repair_type where s_status = 'A' order by i_repair asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLPartnercomp() {
        $db = new ConnectDB();
        $strSql = "select * from tb_partner_comp where s_status = 'A' order by i_part_comp asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLEmployee() {
        $db = new ConnectDB();
        $strSql = "select * from tb_employee where s_status = 'A' order by i_emp asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
