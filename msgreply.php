<<<<<<< HEAD
<?php
include_once "config.php";
include_once "db.class.php";

if(isset($_POST['sms_reply'])){
    echo "0";
    $org_key = $_GET['org_key'];
    $sms_reply = urldecode($_POST['sms_reply']);
    $sms_reply = json_decode($sms_reply,true);
    $DB->addMsgRecieve($org_key,$sms_reply);
}else{
    exit();
}



=======
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



>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
