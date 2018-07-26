<?php
@session_start();



include('../barcode/src/BarcodeGenerator.php');
include('../barcode/src/BarcodeGeneratorPNG.php');
include('../barcode/src/BarcodeGeneratorSVG.php');
include('../barcode/src/BarcodeGeneratorJPG.php');
include('../barcode/src/BarcodeGeneratorHTML.php');




/*$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
echo $barcode =  $generator->getBarcode($_data[0][ref_no], $generator::TYPE_CODE_128);
*/
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
$title_name = date('ymdHis').'_'.$_GET[id].'_repair';

?>