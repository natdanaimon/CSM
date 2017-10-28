<?php

@session_start();

class vipTodayService {

    //($info, $date, $menu, $action, $user, $other);
    function searchAllUsers($db) {
        $strSql = "";
        $strSql .= " select   ";
        $strSql .= " s_user  ";
        $strSql .= " from tb_cs_excel   ";
        $strSql .= " group by s_user  ";
        $strSql .= " union";
        $strSql .= " select   ";
        $strSql .= " s_main s_user  ";
        $strSql .= " from tb_cs_user_map   ";
        $strSql .= " group by s_main  ";
        $strSql .= " order by s_user ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
    function getTurnOver($db , $month , $user){
        $strSql = "";
        $strSql .= " select   ";
        $strSql .= " IFNULL(sum(f_turnover),0) f_turnover  ";
        $strSql .= " from tb_cs_excel   ";
        $strSql .= " where s_date_range = '$month' ";
        $strSql .= " and s_user = '$user' ";
        $strSql .= " group by s_user  ";
        $turnOver = $db->Search_Data_FormatJson($strSql);
        if ($turnOver != "" && count($turnOver)>0) {
            return $turnOver[0][f_turnover];
        } else {
            return 0;
        }
    }

    function getSumLv1_Sports($db, $u, $month) {
        $strSql = "";
        $strSql .= "select  ";
        $strSql .= "IFNULL(sum(ex.f_turnover),0) f_turnover  ";
        $strSql .= "from tb_cs_excel ex ";
        $strSql .= "where exists ( ";
        $strSql .= "select 1 from tb_cs_user_map m ";
        $strSql .= "where m.s_sub = ex.s_user ";
        $strSql .= "and m.s_main = '$u' ";
        $strSql .= ") and ex.s_date_range = '$month' ";
        $turnOver = $db->Search_Data_FormatJson($strSql);
        if ($turnOver != "" && count($turnOver)>0) {
            return $turnOver[0][f_turnover];
        } else {
            return 0;
        }
    }

    function getSumLv1_Casino($db, $u, $month) {
        $strSql = "";
        $strSql .= "select  ";
        $strSql .= "IFNULL(sum(ex.f_gross),0) f_gross  ";
        $strSql .= "from tb_cs_excel ex ";
        $strSql .= "where exists ( ";
        $strSql .= "select 1 from tb_cs_user_map m ";
        $strSql .= "where m.s_sub = ex.s_user ";
        $strSql .= "and m.s_main = '$u' ";
        $strSql .= ") and ex.s_date_range = '$month' ";
        $turnOver = $db->Search_Data_FormatJson($strSql);
        if ($turnOver != "" && count($turnOver)>0) {
            return $turnOver[0][f_gross];
        } else {
            return 0;
        }
    }

    function getSumLv2_Sports($db, $u, $month) {
        $strSql = "";
        $strSql .= "SELECT IFNULL ";
        $strSql .= "  (SUM(ex.f_turnover), ";
        $strSql .= "  0) f_turnover ";
        $strSql .= "FROM ";
        $strSql .= "  tb_cs_excel ex ";
        $strSql .= "WHERE EXISTS ";
        $strSql .= "  ( ";
        $strSql .= "  SELECT ";
        $strSql .= "    1 ";
        $strSql .= "  FROM ";
        $strSql .= "    ( ";
        $strSql .= "    SELECT ";
        $strSql .= "      m.s_sub ";
        $strSql .= "    FROM ";
        $strSql .= "      `tb_cs_user_map` m ";
        $strSql .= "    WHERE EXISTS ";
        $strSql .= "      ( ";
        $strSql .= "      SELECT ";
        $strSql .= "        1 ";
        $strSql .= "      FROM ";
        $strSql .= "        tb_cs_user_map m2 ";
        $strSql .= "      WHERE ";
        $strSql .= "        m2.s_main = '$u' AND m2.s_sub = m.s_main ";
        $strSql .= "    ) ";
        $strSql .= "  ) s ";
        $strSql .= "WHERE ";
        $strSql .= "  s.s_sub = ex.s_user ";
        $strSql .= ") and ex.s_date_range = '$month' ";
        $turnOver = $db->Search_Data_FormatJson($strSql);
        if ($turnOver != "" && count($turnOver)>0) {
            return $turnOver[0][f_turnover];
        } else {
            return 0;
        }
    }

    function getSumLv2_Casino($db, $u, $month) {
        $strSql = "";
        $strSql .= "SELECT IFNULL ";
        $strSql .= "  (SUM(ex.f_gross), ";
        $strSql .= "  0) f_gross ";
        $strSql .= "FROM ";
        $strSql .= "  tb_cs_excel ex ";
        $strSql .= "WHERE EXISTS ";
        $strSql .= "  ( ";
        $strSql .= "  SELECT ";
        $strSql .= "    1 ";
        $strSql .= "  FROM ";
        $strSql .= "    ( ";
        $strSql .= "    SELECT ";
        $strSql .= "      m.s_sub ";
        $strSql .= "    FROM ";
        $strSql .= "      `tb_cs_user_map` m ";
        $strSql .= "    WHERE EXISTS ";
        $strSql .= "      ( ";
        $strSql .= "      SELECT ";
        $strSql .= "        1 ";
        $strSql .= "      FROM ";
        $strSql .= "        tb_cs_user_map m2 ";
        $strSql .= "      WHERE ";
        $strSql .= "        m2.s_main = '$u' AND m2.s_sub = m.s_main ";
        $strSql .= "    ) ";
        $strSql .= "  ) s ";
        $strSql .= "WHERE ";
        $strSql .= "  s.s_sub = ex.s_user ";
        $strSql .= ") and ex.s_date_range = '$month' ";
        $turnOver = $db->Search_Data_FormatJson($strSql);
        if ($turnOver != "" && count($turnOver)>0) {
            return $turnOver[0][f_gross];
        } else {
            return 0;
        }
    }

    function sumLv1($db, $u, $month) {
        return ($this->getSumLv1_Sports($db, $u, $month) * 0.002) + (($this->getSumLv1_Casino($db, $u, $month) / 7) * 2);
    }

    function sumLv2($db, $u, $month) {
        return ($this->getSumLv1_Sports($db, $u, $month) * 0.001) + ($this->getSumLv1_Casino($db, $u, $month) / 7);
    }

//    function sumLevel1_2($db, $u, $month) {
//        return $this->getSumLevel1($db, $u, $month) + $this->getSumLevel2($db, $u, $month);
//    }

    function sumLevel1_2_Percen($db, $u, $month) {
        return $this->sumLv1($db, $u, $month) + $this->sumLv2($db, $u, $month);
    }

}
