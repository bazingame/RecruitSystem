<?php
include_once "config.php";
include_once "db.class.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
$org_key = $_GET['org_key'];
$org_opt = $_GET['info_opt'];

if($org_opt=='org_list'){

}
