<?php

@session_start();

class reportTodayService {

    //($info, $date, $menu, $action, $user, $other);
    function search($info, $tb) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= " select   ";
        $strSql .= " s_username , count(*) cnt ";
        $strSql .= " from $tb  ";
        $strSql .= " where 1=1 ";
        $strSql .= " and d_create BETWEEN '$info[d_start] 00:00:00' and '$info[d_start] 23:59:59'  ";
        $strSql .= " group by s_username ";


        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
