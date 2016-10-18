<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 09.12.2015
 * Time: 17:41
 */

session_start(); ob_start();
include("include.php");
oturum_koru();

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Istanbul');
if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel.php';

function exportExcel($filename='ExportExcel',$columns=array(),$data=array(),$replaceDotCol=array()){

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set document properties
    $objPHPExcel->getProperties()->setCreator("GoInteraktif Panel")
        ->setLastModifiedBy("Go Interaktif Panel")
        ->setTitle("Office 2007 XLSX GoInteraktif Panel Kargo Export")
        ->setSubject("Office 2007 XLSX GoInteraktif Panel Kargo Export")
        ->setDescription("GoInteraktif Panel Kargo Export Office 2007 XLSX, generated by GoInteraktif Panel using PHP.")
        ->setKeywords("GoInteraktif Panel Kargo Export")
        ->setCategory("GoInteraktif Panel Kargo Export");

    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $say=count($columns);

    $alphas = range('A', 'Z');

    foreach($columns AS $index => $value){

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$index]."1", $value);

        foreach($data AS $i => $d){

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$index].($i+2), @$d[$index]);

        }

    }

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle($filename);

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

    exit;
}

$replaceDotCol=array(3);


/* Sütun Başlıkları */
$columns=array(
    'HEDEF KODU',
    'MÜŞTERİ BARKODU',
    'ADI SOYADI',
    'TELEFON1',
    'TELEFON2',
    'İLÇE',
    'İL',
    'ADRES',
    "ADET",
    "DESİ",
    "ÜRÜN",
    "FİYAT",
    "AÇIKLAMA",
    "ÖDEME ŞEKLİ",
    "SIPARIS NO",
    "SATICI",
    "FATURA KESİLSİN",
    "FATURA KDV",
);

function part($t){
    $xx =explode("/",$t);
    $k=  $xx["2"]."-".$xx["1"]."-".$xx["0"];
    return $k;
}


/*$tarih = mysql_real_escape_string(strip_tags($_GET["tarih"]));
if(empty($tarih)){
    exit();
}

$tarih = part($_GET["tarih"]);*/

$Apis = $db->get_results("SELECT `api_users`.`name` AS `api_name`, `api_applications`.* FROM `api_users` LEFT JOIN `api_applications` ON `api_users`.`id` = `api_applications`.`user_id` WHERE `api_users`.`name` = '".@$_GET["api_name"]."' AND `api_applications`.`active` = 1");

$data = array();

if($Apis){
    foreach ($Apis as $Api) {
        $Orders = $db->get_results("SELECT * FROM siparisler WHERE (siparis_durumu = 6 OR siparis_durumu = 7 OR siparis_durumu = 8) AND private_api = '".$Api->id."' AND (kal_kontrol = '1' AND api_kargo_kuyruk_exported = '0') ".$sql_statu."  ORDER BY satis_tarihi ASC");
        if($Orders){
            foreach($Orders as $Order){
                $data[]=array(
                    "",
                    "",
                    $Order->ad_soyad,
                    $Order->Telefon_no,
                    0,
                    $Order->ilce,
                    $Order->il,
                    $Order->adres,
                    $Order->urun_adeti,
                    1,
                    $Order->urunun_adi,
                    $Order->fiyat,
                    "Telefon İhbarlı",
                    "Kredi Kartı",
                    $Order->siparis_id,
                    "",
                    "",
                    ""
                );
                $db->query("UPDATE `siparisler` SET `api_kargo_kuyruk_exported` = '1' WHERE siparis_id = '".$Order->siparis_id."'");
            }
        }
    }}






$DosyaAdi = "api-kargo-kuyrugu-".rand(1,999);

exportExcel($DosyaAdi, $columns, $data, $replaceDotCol);

exit;