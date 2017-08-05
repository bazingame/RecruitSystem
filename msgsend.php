<?php
include_once "MSGoperate.php";
$MSG = new MSGoperate();
include_once "db.class.php";
include_once "config.php";
session_start();

set_time_limit(0);  //防超时
ignore_user_abort(true);  //忽略客户端断开

$apikey = $_POST['apikey'];
$dep_name = $_POST['dep_name'];
$status = $_POST['status'];
$msg_tpl_id = $_POST['msg_tpl_id'];
$org_key =$_POST['org_key'];

//$apikey = '19a6b6334bfdc6bb2533ebbc7996bd9a';
//$dep_name = '技术开发部';
//$status = '0';
//$msg_tpl_id = '1622440';
//$org_key ='sky31';


$text = $MSG->getMsgModel($apikey,$msg_tpl_id)['tpl_content'];
$send_id = $DB->addMsgRecord($org_key);//添加发送记录

//检查模板需要替换的种类 无为0 name为1 dep为2 两者为3
$changeType = 0;
    if(preg_match('/\#name\#/',$text)){
        $changeType = $changeType+1;
    }
    if(preg_match('/\#department\#/',$text)){
        $changeType = $changeType+2;
    }
echo $changeType;
//替换模板并发送
    if($changeType==3){
        $NamePhone_list =$DB->getNamePhone($org_key,$dep_name,$status);
        foreach ($NamePhone_list as $val){
            $text_r = preg_replace('/#name#/',$val[0],$text);
            $text_r = preg_replace('/#department#/',$dep_name,$text_r);
            $res = $MSG->sendMessage($apikey,$val[1],$text_r);
            if($res['code']==0){
                $send_status = 'SUCCESS';
            }else{
                $send_status = $res['msg'].$res['detail'];
            }
            $DB->addMsgSendList($org_key,$send_id,$val[0],$msg_tpl_id,$val[1],$send_status);
        }
    }else if($changeType==2){
        $NamePhone_list =$DB->getNamePhone($org_key,$dep_name,$status);
        foreach ($NamePhone_list as $val){
            $text_r = preg_replace('/#department#/',$dep_name,$text);
            $res = $MSG->sendMessage($apikey,$val[1],$text_r);
            if($res['code']==0){
                $send_status = 'SUCCESS';
            }else{
                $send_status = $res['msg'].$res['detail'];
            }
            $DB->addMsgSendList($org_key,$send_id,$val[0],$msg_tpl_id,$val[1],$send_status);
        }
    }else if($changeType==1){
        $NamePhone_list =$DB->getNamePhone($org_key,$dep_name,$status);
        foreach ($NamePhone_list as $val){
            $text_r = preg_replace('/#name#/',$val[0],$text);
            $res = $MSG->sendMessage($apikey,$val[1],$text_r);
            if($res['code']==0){
                $send_status = 'SUCCESS';
            }else{
                $send_status = $res['msg'].$res['detail'];
            }
            $DB->addMsgSendList($org_key,$send_id,$val[0],$msg_tpl_id,$val[1],$send_status);
        }
    }else if($changeType==0) {
        $NamePhone_list = $DB->getNamePhone($org_key, $dep_name, $status);
        foreach ($NamePhone_list as $val) {
            $res = $MSG->sendMessage($apikey, $val[1], $text);
            if($res['code']==0){
                $send_status = 'SUCCESS';
            }else{
                $send_status = $res['msg'].$res['detail'];
            }
//            print_r($send_status);
            $res = $DB->addMsgSendList($org_key,$send_id,$val[0],$msg_tpl_id,$val[1],$send_status);
        }
    }




?>