<?php

@session_start();

class reportUserService {

    function searchListUser($db, $info, $_u, $_n) {
        $strSql = "";
        $strSql .= " SELECT   ";
        $strSql .= " u.s_username,";
        $strSql .= " CONCAT(u.s_firstname, ' ', u.s_lastname) s_fullname";
        $strSql .= " FROM tb_cs_user u ";
        $strSql .= " WHERE 1=1 ";
        if ($_u) {
            $strSql .= "AND u.s_username like '%$info[s_username]%' ";
        }

        if ($_n) {
            $strSql .= "AND CONCAT(u.s_firstname, ' ', u.s_lastname) like '%$info[fullname]%' ";
        }

        $strSql .= "order by u.s_username , s_fullname";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function searchDeposit($db, $_u, $_s) {
        $strSql = "";
        $strSql .= "SELECT ";
        $strSql .= "  u.s_username, ";
        $strSql .= "  IFNULL(sum(d.f_total),0) f_amount, ";
        $strSql .= "  IFNULL(sum(d.f_bonus),0) f_bonus, ";
        $strSql .= "  IFNULL(sum(d.f_special_bonus),0) f_bonus_special ";
        $strSql .= "FROM ";
        $strSql .= "  tb_cs_user u, ";
        $strSql .= "  tb_cs_dp d, ";
        $strSql .= "  tb_status s ";
        $strSql .= "WHERE ";
        $strSql .= "  u.s_username = d.s_username  ";
        $strSql .= "  AND d.s_status = s.s_status ";
        $strSql .= "  AND d.s_username= '$_u' ";
        $strSql .= "  AND d.s_status = '$_s' ";
        $strSql .= "GROUP BY d.s_username ";
        $strSql .= "ORDER BY ";
        $strSql .= "  d.s_username ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function searchWithdraw($db, $_u, $_s) {
        $strSql = "";
        $strSql .= "SELECT ";
        $strSql .= "  u.s_username, ";
        $strSql .= "  IFNULL(sum(w.f_amount),0) f_amount ";
        $strSql .= "FROM ";
        $strSql .= "  tb_cs_user u, ";
        $strSql .= "  tb_cs_wd w, ";
        $strSql .= "  tb_status s ";
        $strSql .= "WHERE ";
        $strSql .= "  u.s_username = w.s_username  ";
        $strSql .= "  AND w.s_status = s.s_status ";
        $strSql .= "  AND w.s_username= '$_u' ";
        $strSql .= "  AND w.s_status = '$_s' ";
        $strSql .= "GROUP BY w.s_username ";
        $strSql .= "ORDER BY ";
        $strSql .= "  w.s_username ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
