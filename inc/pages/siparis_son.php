<?php

include_once("config.php");

global $db;

$adSoyad = $_POST['adi'];
$siparis_id = $_POST['siparis_id'];
$phone = $_POST['tel'];
$urun = $_POST['urun_id'];
$hediye = $_POST['hediye_urun'];
$indirim = $_POST['indirim'];
$city = $_POST['il'];
$disrict = $_POST['ilce'];
$address = $_POST['adres'];
$note = $_POST['yorum'];
$siparis_durumu = $_POST['siparis_durumu'];

echo $city;exit;

$db->get_results("UPDATE siparisler SET siparis_durumu = {$siparis_durumu} AND ad_soyad = {$adSoyad} AND Telefon_no = {$phone} AND urun_id = {$urun} AND hediye_urun = {$hediye} AND  indirim = {$indirim} AND il = {$city} AND ilce = {$disrict} AND adres = {$address} WHERE siparis_id = '".$siparis_id."'");

$db->get_results("UPDATE siparis_notlari SET siparis_id = {$siparis_id} AND siparis_notu = {$note}");

//$db->get_results("INSERT INTO siparis_notlari (siparis_id, siparis_notu, personel_id, 'islem') VALUES ('$siparis_id', '$note', '0', '0')");




//echo $result;

?>