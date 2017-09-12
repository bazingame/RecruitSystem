<?php

//大量发送短信时异步处理

include "db.class.php";
include "config.php";
session_start();

$org_key = $_SESSION['org_key'];
$apikey = $DB->getApikey($org_key)[0];
$dep_name = $_POST['dep_name'];
$status = $_POST['status'];
//$no_start = ($_POST['no_start']=='')?$_POST['no_start']:'null';
//$no_end = isset($_POST['no_end'])?$_POST['no_end']:'456';
//$no_start = $_POST['no_start'];
//$no_end = $_POST['no_end'];
if($_POST['no_start']==''){
    $no_start = 'null';
}else{
    $no_start = $_POST['no_start'];
}
if($_POST['no_end']==''){
    $no_end = 'null';
}else{
    $no_end = $_POST['no_end'];
}

$msg_tpl_id = $_POST['msg_tpl_id'];
$url = 'https://zx814.sky31.com/2017/admin/msgsend.php';
$data= array('apikey'=>$apikey,'status'=>$status,'dep_name'=>$dep_name,'no_start'=>$no_start,'no_end'=>$no_end,'msg_tpl_id'=>$msg_tpl_id,'org_key'=>$org_key);



$curl_res = _curl($url,$data);
//echo $curl_res;
//header("Location: ./manage.php");
if($curl_res=='1'){
    echo "1";
}else{
    echo '0';
}

function _curl($url,$data) {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_TIMEOUT,1); //异步处理
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //跳过证书检查
    curl_setopt($ch,CURLOPT_POSTFIELDS,  http_build_query($data));
    $result = curl_exec($ch);
    curl_close($ch);
    return 1;
}