<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new importController();
switch ($info[func]) {
    case "importCus":
        echo $controller->importCus($info[id]);
        break;
    case "importCar":
        echo $controller->importCar($info);
        break;
    case "editPassowrd":
        echo $controller->editPassword($info);
        break;
    case "editPicture":
        echo $controller->editPicture($info);
        break;
}

class importController {

     public function __construct() {
        include '../common/ConnectDB.php';
        include '../common/Utility.php';
        include '../common/Logs.php';
        include '../common/upload.php';
        include '../service/commonService.php';
    }
    
    
    public function importCus($seq) {
    	
    	$util = new Utility();
    	$db = new ConnectDB();
        $db->conn();
    	
        
        $fileName = "../upload/member_csm.csv";
        $objCSV = fopen($fileName, "r");
        $i = 1;
        ?>
        <table>
        	<tr>
        		<td>#</td>
        		<td>Ref No</td>
        		<td>First Name</td>
        		<td>Last Name</td>
        		<td>Address</td>
        		<td>Phone 1</td>
        		<td>Phone 2</td>
        		
        	</tr>
        <?php
        while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE){
					if($row == 0){ $row++; continue; }
					$ref_no = $objArr[0];
					$full_name = explode(" ",$objArr[8]);
					$s_address = $objArr[9];
					$s_phone_1 = $objArr[10];
					$s_phone_2 = $objArr[11];
					
					
					if(count($full_name) == 3){
						$first_name = $full_name[1];
						$last_name = $full_name[2];
					}else{
						$first_name = $full_name[0];
						$last_name = $full_name[1];
					}
					$s_fullname = $first_name." ".$lastt_name;
					if($ref_no != ''){
						?>
						
						<?php
						$i++;
						
						
						/////////////////// Import
						 $strSql = " select ref_no from tb_customer where ref_no = '" . $ref_no. "' ";
         $_data = $db->Search_Data_FormatJson($strSql);
         $count = count($_data);
        
        if($count < 1){
					
					/////////// Insert
					$strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_customer ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    i_title, ";
        $strSql .= "    s_firstname, ";
        $strSql .= "    s_lastname, ";
        $strSql .= "    s_phone_1, ";
        $strSql .= "    s_phone_2, ";
        $strSql .= "    s_address, ";
        $strSql .= "    i_district, ";
        $strSql .= "    i_amphure, ";
        $strSql .= "    i_province, ";
        $strSql .= "    i_zipcode, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$ref_no', ";
        $strSql .= "  '1', ";
        $strSql .= "  '$first_name', ";
        $strSql .= "  '$last_name', ";
        $strSql .= "  '$s_phone_1', ";
        $strSql .= "  '$s_phone_2', ";
        $strSql .= "  '$s_address', ";
        $strSql .= "  '110103', ";
        $strSql .= "  '52', ";
        $strSql .= "  '2', ";
        $strSql .= "  '10270', ";
        
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  'admin', ";
        $strSql .= "  'admin', ";
        $strSql .= "  'A' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        $last_id = mysql_insert_id();
					?>
					
					<tr>
        		<td><?=$last_id;?></td>
        		<td><?=$ref_no;?></td>
        		<td><?=$first_name;?></td>
        		<td><?=$last_name;?></td>
        		<td><?=$s_address;?></td>
        		<td><?=$s_phone_1;?></td>
        		<td><?=$s_phone_2;?></td>
        	</tr>
					<?php
					
					
					
					
					
					
				}
						
						
						
					}
					
				}
				?>
				</table>
				<?php
    }
    
    
    public function importCar($seq) {
    	
    	$util = new Utility();
    	$db = new ConnectDB();
        $db->conn();
    	
        
        $fileName = "../upload/member_csm.csv";
        $objCSV = fopen($fileName, "r");
        $i = 1;
        ?>
        <table>
        	<tr>
        		<td>#</td>
        		<td>Ref No</td>
        		<td>First Name</td>
        		<td>Last Name</td>
        		<td>Address</td>
        		<td>Phone 1</td>
        		<td>Phone 2</td>
        		
        	</tr>
        <?php
        while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE){
					if($row == 0){ $row++; continue; }
					$ref_no = $objArr[0];
					$full_name = explode(" ",$objArr[8]);
					$s_address = $objArr[9];
					$s_phone_1 = $objArr[10];
					$s_phone_2 = $objArr[11];
					
					
					if(count($full_name) == 3){
						$first_name = $full_name[1];
						$last_name = $full_name[2];
					}else{
						$first_name = $full_name[0];
						$last_name = $full_name[1];
					}
					$s_fullname = $first_name." ".$lastt_name;
					if($ref_no != ''){
						?>
						
						<?php
						$i++;
						
						
						/////////////////// Import
				$strSql = " select ref_no from tb_customer_car where ref_no = '" . $ref_no. "' ";
         $_data = $db->Search_Data_FormatJson($strSql);
         $count = count($_data);
        
        if($count < 1){
					
					/////////// Insert
					$strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_customer_car ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$ref_no', ";        
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  'admin', ";
        $strSql .= "  'admin', ";
        $strSql .= "  'R0' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        $last_id = mysql_insert_id();
					?>
					
					<tr>
        		<td><?=$last_id;?></td>
        		<td><?=$ref_no;?></td>
        		<td><?=$first_name;?></td>
        		<td><?=$last_name;?></td>
        		<td><?=$s_address;?></td>
        		<td><?=$s_phone_1;?></td>
        		<td><?=$s_phone_2;?></td>
        	</tr>
					<?php
					
					
					
					
					
					
				}
						
						
						
					}
					
				}
				?>
				</table>
				<?php
    }
    



}

/*
INSERT INTO `tb_customer` (`i_title`, `s_firstname`, `s_lastname`, `s_phone_1`, `s_phone_2`, `s_email`, `s_line`, `s_image`, `s_address`, `i_district`, `i_amphure`, `i_province`, `i_zipcode`, `d_create`, `d_update`, `s_create_by`, `s_update_by`, `s_status`, `ref_no`) VALUES
( 1, 'กิตติพงศ์', 'ศรีอำไพ', '081-806-7055', '', '', '', 'default.png', 'บางเมือง', 110103, 52, 2, 10270, '2018-06-25 12:55:47', '2018-06-25 12:55:47', 'admin', 'admin', 'A', '1806004');

*/
