<?php
include_once "config.php";
include_once "db.class.php";

if(isset($_POST['sms_reply'])){
    echo "0";
    $sms_reply = urldecode($_POST['sms_reply']);
    $sms_reply = json_decode($sms_reply,true);
    $DB->addMsgRecieve($sms_reply);
}else{
    exit();
}



