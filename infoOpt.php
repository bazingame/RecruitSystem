<?php
include_once "config.php";
include_once "db.class.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

if(isset($_GET['org_key'])){
    $org_key = $_GET['org_key'];
}else if(isset($_POST['org_key'])){
    $org_key = $_POST['org_key'];
}

$info_opt = $_GET['info_opt'];

//插入报名人员信息
if($info_opt=='insertInfo'){

    if( isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['birthday']) && isset($_POST['college']) && isset($_POST['profess']) && isset($_POST['phone']) && isset($_POST['qq']) && isset($_POST['introduction']) && $_POST['name'] != '' && $_POST['sex'] != '' && $_POST['birthday'] != '' && $_POST['college'] != '' && $_POST['profess'] != '' && $_POST['phone'] != '' && $_POST['qq'] != '' && $_POST['introduction'] != ''){
        $pass = 1;
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $match = preg_match('/\d/',$name)?0:1;
        if($match){}else $pass=0;

        $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES);
        $match = preg_match('/^男|女$/',$sex);
        if($match){}else $pass=0;

        $birthday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
        $match = preg_match('/^\d{4}-\d{2}-\d{2}$/',$birthday);
        if($match){}else $pass=0;

        $college = htmlspecialchars($_POST['college'], ENT_QUOTES);
        $college_arr = array('材料科学与工程学院','法学院·知识产权学院','公共管理学院','国际交流学院','化工学院','环境与资源学院','化学学院','机械工程学院','历史系·哲学系学院','马克思主义学院','数学与计算科学学院','商学院','体育教学部','土木工程与力学学院','艺术学院','物理与光电工程学院','外国语学院','信息工程学院','兴湘学院','文学与新闻学院','信用管理风险学院');
        if(in_array($college,$college_arr)){
            $match = 1;
        }else{
            $match = 0;
        }
        if($match){}else $pass=0;

        $profess = htmlspecialchars($_POST['profess'], ENT_QUOTES);
//        $match = preg_match('',$profess);
//        if($match){}else $pass=0;

        $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
        $match = preg_match('/^\d{11}$/',$phone);
        if($match){}else $pass=0;

        $qq = htmlspecialchars($_POST['qq'], ENT_QUOTES);
        $match = preg_match('/^\d*$/',$qq);
        if($match){}else $pass=0;

        if($pass==0){
            $result = array('code'=>'-3','msg'=>'param error');
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);
            die($result);
        }

        $introduction = htmlspecialchars($_POST['introduction'], ENT_QUOTES);
        //intention
        $dep_num = $DB->getDepNum($org_key);
        for($i = 1;$i<=$dep_num;$i++){
            $intention_name = 'intention'.$i;
            if(isset($_POST[$intention_name]) && $_POST[$intention_name] !='') {
                if ($_POST[$intention_name] != '未选择') {
                    $dep_name[$i] = htmlspecialchars($_POST[$intention_name], ENT_QUOTES);
                } else {
                    $dep_name[$i] = $i + 5;
                }
                $intention[$dep_name[$i]] = 0;
            }else{
                $result = array('code'=>'-2','msg'=>'param loss');
                $result = json_encode($result,JSON_UNESCAPED_UNICODE);
                die($result);
            }
        }
        $intention = json_encode($intention,JSON_UNESCAPED_UNICODE);

//other_info
        $reg_list = $DB->getOrgRegListAll($org_key);
        for($i = 0;$i<count($reg_list);$i++){
            if( isset($_POST[$reg_list[$i]]) && $_POST[$reg_list[$i]] != ''){
                $other_info[] = htmlspecialchars($_POST[$reg_list[$i]]);
            }else{
                $result = array('code'=>'-2','msg'=>'param loss');
                $result = json_encode($result,JSON_UNESCAPED_UNICODE);
                die($result);
            }
        }

        $other_info = json_encode($other_info,JSON_UNESCAPED_UNICODE);
        $register_time = date('Y-m-d H:i:s',time());
        $register_way = $_POST['register_way'];

        $data = array('org_key'=>$org_key,'name'=>$name,'sex'=>$sex,'birthday'=>$birthday,'college'=>$college,'profess'=>$profess,'phone'=>$phone,'qq'=>$qq,'introduction'=>$introduction,'admit_status'=>$intention,'other_info'=>$other_info,'register_time'=>$register_time,'register_way'=>$register_way);
// print_r($data);
        $res = $DB->addInfo($org_key,$data);

        if($res == 1){
            $result = array('code' =>'0' ,'msg'=>'success');
        }else if($res == 0){
            $result = array('code' =>'1' ,'msg'=>'fail');
        }else if($res == -1){
            $result = array('code' =>'-1' ,'msg'=>'info repeated');
        }
        $result = json_encode($result,JSON_UNESCAPED_UNICODE);
        echo $result;
    }else {
        $result = array('code'=>'-2','msg'=>'param loss');
        $result = json_encode($result,JSON_UNESCAPED_UNICODE);
        die($result);
    }

    //修改更新报名人员信息
}else if($info_opt=='updateInfo'){
    if( isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['birthday']) && isset($_POST['college']) && isset($_POST['profess']) && isset($_POST['phone']) && isset($_POST['qq']) && isset($_POST['introduction']) && $_POST['name'] != '' && $_POST['sex'] != '' && $_POST['birthday'] != '' && $_POST['college'] != '' && $_POST['profess'] != '' && $_POST['phone'] != '' && $_POST['qq'] != '' && $_POST['introduction'] != ''){
        $pass = 1;
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $match = preg_match('/\d/',$name)?0:1;
        if($match){}else $pass=0;

        $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES);
        $match = preg_match('/^男|女$/',$sex);
        if($match){}else $pass=0;

        $birthday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
        $match = preg_match('/^\d{4}-\d{2}-\d{2}$/',$birthday);
        if($match){}else $pass=0;

        $college = htmlspecialchars($_POST['college'], ENT_QUOTES);
        $college_arr = array('材料科学与工程学院','法学院·知识产权学院','公共管理学院','国际交流学院','化工学院','环境与资源学院','化学学院','机械工程学院','历史系·哲学系学院','马克思主义学院','数学与计算科学学院','商学院','体育教学部','土木工程与力学学院','艺术学院','物理与光电工程学院','外国语学院','信息工程学院','兴湘学院','文学与新闻学院','信用管理风险学院');
        if(in_array($college,$college_arr)){
            $match = 1;
        }else{
            $match = 0;
        }
        if($match){}else $pass=0;

        $profess = htmlspecialchars($_POST['profess'], ENT_QUOTES);
//        $match = preg_match('',$profess);
//        if($match){}else $pass=0;

        $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
        $match = preg_match('/^\d{11}$/',$phone);
        if($match){}else $pass=0;

        $qq = htmlspecialchars($_POST['qq'], ENT_QUOTES);
        $match = preg_match('/^\d*$/',$qq);
        if($match){}else $pass=0;

        if($pass==0){
            $result = array('code'=>'-3','msg'=>'param error');
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);
            die($result);
        }

        $introduction = htmlspecialchars($_POST['introduction'], ENT_QUOTES);
        //intention
        $dep_num = $DB->getDepNum($org_key);
        for($i = 1;$i<=$dep_num;$i++){
            $intention_name = 'intention'.$i;
            if(isset($_POST[$intention_name]) && $_POST[$intention_name] !='') {
                if ($_POST[$intention_name] != '未选择') {
                    $dep_name[$i] = htmlspecialchars($_POST[$intention_name], ENT_QUOTES);
                } else {
                    $dep_name[$i] = $i + 5;
                }
                $intention[$dep_name[$i]] = 0;
            }else{
                $result = array('code'=>'-2','msg'=>'param loss');
                $result = json_encode($result,JSON_UNESCAPED_UNICODE);
                die($result);
            }
        }
        $intention = json_encode($intention,JSON_UNESCAPED_UNICODE);

//other_info
        $reg_list = $DB->getOrgRegListAll($org_key);
        for($i = 0;$i<count($reg_list);$i++){
            if( isset($_POST[$reg_list[$i]]) && $_POST[$reg_list[$i]] != ''){
                $other_info[] = htmlspecialchars($_POST[$reg_list[$i]]);
            }else{
                $result = array('code'=>'-2','msg'=>'param loss');
                $result = json_encode($result,JSON_UNESCAPED_UNICODE);
                die($result);
            }
        }

        $other_info = json_encode($other_info,JSON_UNESCAPED_UNICODE);
        $register_time = date('Y-m-d H:i:s',time());
        $register_way = $_POST['register_way'];

        $data = array('org_key'=>$org_key,'name'=>$name,'sex'=>$sex,'birthday'=>$birthday,'college'=>$college,'profess'=>$profess,'phone'=>$phone,'qq'=>$qq,'introduction'=>$introduction,'admit_status'=>$intention,'other_info'=>$other_info,'register_time'=>$register_time,'register_way'=>$register_way);
// print_r($data);
        $res = $DB->updateInfo($org_key,$name,$phone,$data);
        if($res == 1){
            $result = array('code' =>'0' ,'msg'=>'success');
        }else if($res == 0){
            $result = array('code' =>'-1' ,'msg'=>'fail');
        }
        $result = json_encode($result,JSON_UNESCAPED_UNICODE);
        echo $result;
    }else {
        $result = array('code'=>'-2','msg'=>'param loss');
        $result = json_encode($result,JSON_UNESCAPED_UNICODE);
        die($result);
    }
    $res = $DB->updateInfo($org_key,$name,$phone,$data);
    //通过姓名电话获取人员信息
}else if($info_opt=='getInfo'){
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $res = $DB->getPersonalByNamePhone($org_key,$name,$phone)[0];
    if(count($res)==0){
        $result = array('code' =>'1' ,'msg'=>'fail','data'=>'');
    }else{
        $data['name'] = $res[1];
        $data['sex'] = $res[2];
        $data['birthday'] = $res[3];
        $data['college'] = $res[4];
        $data['profess'] = $res[5];
        $data['phone'] = $res[6];
        $data['qq'] = $res[7];
        $data['introduction'] = $res[8];
        //intention
        $dep_num = $DB->getDepNum($org_key);
        for($i = 1;$i<=$dep_num;$i++){
            $intention_name = 'intention'.$i;
            if(strlen($res[($i+8)][0])==1){
                $data[$intention_name] = '未选择';
            }else{
                $data[$intention_name] = $res[($i+8)][0];
            }
        }
        //other_info
        $reg_list = $DB->getOrgRegListAll($org_key);
        for($i = 0;$i<count($reg_list);$i++){
            $data[$reg_list[$i]] = $res[($i+9+$dep_num)];
        }
        $result = array('code'=>'0','msg'=>'success','data'=>$data);
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
    //姓名电话录取状态查询
}else if($info_opt=='getAdmitStatus'){
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');

    if(isset($org_key)&&isset($name)&&isset($phone)){
        $res = $DB->queryAdmitStatus($org_key,$name,$phone);
        $resArr = json_decode($res,true);
        if($resArr == 0){
            $result = array('code' =>'1' ,'msg'=>'fail','data'=>'无报名信息');
        }else{
            foreach ($resArr as $key => $value) {
                if(strlen($key) ==1){
                    $each[0] ='未选择';
                }else{
                    $each[0] =$key;
                }

                $each[1]  =$admit_status[$value];
                $data[] = $each;
            }
            $result = array('code' =>'0' ,'msg'=>'success','data'=>$data);
        }
    }else{
        $result = array('code' =>'-1' ,'msg'=>'fail','data'=>'缺失参数');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
    //获取所有组织列表信息
}else if($info_opt=='getOrgList'){
    $org_list = $DB->getOrganListDetail_r();
    if(count($org_list) != 0){
        foreach ($org_list as $value){
            $org_info['org_key'] = $value['org_key'];
            $org_info['org_name'] = $value['org_name'];
            $org_info['logo_path'] = $value['logo_path'];
            $res[] = $org_info;
            $org_info = '';
        }
        $result = array('code'=>'0','msg'=>'success','data'=>$res);
    }else{
        $result = array('code'=>'1','msg'=>'fail');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
    //获取单独组织的信息
}else if($info_opt=='orgInfo'){
    $org_key = $_GET['org_key'];
    $org_info = $DB->getOrganInfo($org_key);
    if(count($org_info) != 0){
        $res['org_name'] = $org_info['org_name'];
        $res['introduction'] = $org_info['introduction'];
        $res['logo_path'] = $org_info['logo_path'];
        $res['introduction_detail'] = $org_info['introduction_detail'];
        $result = array('code'=>'0','msg'=>'success','data'=>$res);
    }else{
        $result = array('code'=>'1','msg'=>'fail');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
//    获取组织报名表信息
}else if($info_opt=='registerList') {
    $org_key = $_GET['org_key'];
    $register_list = $DB->getOrgRegList_e($org_key);
    if($register_list != 0){
        $result = array('code'=>'0','msg'=>'success','data'=>$register_list);
    }else{
        $result = array('code'=>'1','msg'=>'fail');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
}


