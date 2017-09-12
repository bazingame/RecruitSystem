<?php
include_once "config.php";
include_once "db.class.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");

$org_key = $_GET['org_key'];
$info_opt = $_GET['info_opt'];

//插入报名人员信息
if($info_opt=='insertInfo'){

    $name = isset($_POST['name'])?htmlspecialchars($_POST['name'],ENT_QUOTES):'0';
    $sex = isset($_POST['sex'])?htmlspecialchars($_POST['sex'],ENT_QUOTES):'0';
    $birthday = isset($_POST['birthday'])?htmlspecialchars($_POST['birthday'],ENT_QUOTES):'0';
    $college = isset($_POST['college'])?htmlspecialchars($_POST['college'],ENT_QUOTES):'0';
    $profess = isset($_POST['profess'])?htmlspecialchars($_POST['profess'],ENT_QUOTES):'0';
    $phone = isset($_POST['phone'])?htmlspecialchars($_POST['phone'],ENT_QUOTES):'0';
    $qq = isset($_POST['qq'])?htmlspecialchars($_POST['qq'],ENT_QUOTES):'0';
    $introduction = isset($_POST['introduction'])?htmlspecialchars($_POST['introduction'],ENT_QUOTES):'0';

//intention
    $dep_num = $DB->getDepNum($org_key);
    for($i = 1;$i<=$dep_num;$i++){
        $intention_name = 'intention'.$i;
        if(isset($_POST[$intention_name]) && $_POST[$intention_name]!= '未选择'){
            $dep_name[$i] = isset($_POST[$intention_name])?htmlspecialchars($_POST[$intention_name],ENT_QUOTES):'无';
        }else{
            $dep_name[$i] = $i;
        }
        $intention[$dep_name[$i]]=0;
    }
// print_r($intention);

    $intention = json_encode($intention,JSON_UNESCAPED_UNICODE);

//other_info
    $reg_list = $DB->getOrgRegListAll($org_key);
    for($i = 0;$i<count($reg_list);$i++){
        $other_info[] = isset($_POST[$reg_list[$i]])?htmlspecialchars($_POST[$reg_list[$i]]):'';
    }
    $other_info = json_encode($other_info,JSON_UNESCAPED_UNICODE);

    $register_time = date('Y-m-d H:i:s',time());
    $register_way = $_POST['register_way'];

    $data = array('org_key'=>$org_key,'name'=>$name,'sex'=>$sex,'birthday'=>$birthday,'college'=>$college,'profess'=>$profess,'phone'=>$phone,'qq'=>$qq,'introduction'=>$introduction,'admit_status'=>$intention,'other_info'=>$other_info,'register_time'=>$register_time,'register_way'=>$register_way);
// print_r($data);
    $res = $DB->addInfo($org_key,$data);
    if($res == 1){
        $result = array('code' =>'1' ,'msg'=>'success','data'=>'报名成功');
    }else if($res == 0){
        $result = array('code' =>'1' ,'msg'=>'fail','data'=>'报名失败');
    }else if($res == -1){
        $result = array('code' =>'1' ,'msg'=>'fail','data'=>'重复报名');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
    //修改更新报名人员信息
}else if($info_opt=='updateInfo'){
    $name = isset($_POST['name'])?htmlspecialchars($_POST['name'],ENT_QUOTES):'0';
    $sex = isset($_POST['sex'])?htmlspecialchars($_POST['sex'],ENT_QUOTES):'0';
    $birthday = isset($_POST['birthday'])?htmlspecialchars($_POST['birthday'],ENT_QUOTES):'0';
    $college = isset($_POST['college'])?htmlspecialchars($_POST['college'],ENT_QUOTES):'0';
    $profess = isset($_POST['profess'])?htmlspecialchars($_POST['profess'],ENT_QUOTES):'0';
    $phone = isset($_POST['phone'])?htmlspecialchars($_POST['phone'],ENT_QUOTES):'0';
    $qq = isset($_POST['qq'])?htmlspecialchars($_POST['qq'],ENT_QUOTES):'0';
    $introduction = isset($_POST['introduction'])?htmlspecialchars($_POST['introduction'],ENT_QUOTES):'0';

//intention
    $dep_num = $DB->getDepNum($org_key);
    for($i = 1;$i<=$dep_num;$i++){
        $intention_name = 'intention'.$i;
        if(isset($_POST[$intention_name]) && $_POST[$intention_name]!= '未选择'){
            $dep_name[$i] = isset($_POST[$intention_name])?htmlspecialchars($_POST[$intention_name],ENT_QUOTES):'无';
        }else{
            $dep_name[$i] = $i;
        }
        $intention[$dep_name[$i]]=0;
    }
// print_r($intention);

    $intention = json_encode($intention,JSON_UNESCAPED_UNICODE);

//other_info
    $reg_list = $DB->getOrgRegListAll($org_key);
    for($i = 0;$i<count($reg_list);$i++){
        $other_info[] = isset($_POST[$reg_list[$i]])?htmlspecialchars($_POST[$reg_list[$i]]):'';
    }
    $other_info = json_encode($other_info,JSON_UNESCAPED_UNICODE);

    $register_time = date('Y-m-d H:i:s',time());
    $register_way = $_POST['register_way'];

    $data = array('org_key'=>$org_key,'name'=>$name,'sex'=>$sex,'birthday'=>$birthday,'college'=>$college,'profess'=>$profess,'phone'=>$phone,'qq'=>$qq,'introduction'=>$introduction,'admit_status'=>$intention,'other_info'=>$other_info,'register_time'=>$register_time,'register_way'=>$register_way);
// print_r($data);
    $res = $DB->updateInfo($org_key,$name,$phone,$data);
    if($res = 1){
        $result = array('code' =>'1' ,'msg'=>'success','data'=>'修改成功');
    }else{
        $result = array('code' =>'0' ,'msg'=>'fail','data'=>'修改失败');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
    //通过姓名电话获取人员信息
}else if($info_opt=='getInfo'){
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $res = $DB->getPersonalByNamePhone($org_key,$name,$phone)[0];
    if(count($res)==0){
        $result = array('code' =>'0' ,'msg'=>'fail','data'=>'输入错误或信息不存在');
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
            if(strlen($res[($i+9)][0])==1){
                $data[$intention_name] = '未选择';
            }else{
                $data[$intention_name] = $res[($i+9)][0];
            }
        }
        //other_info
        $reg_list = $DB->getOrgRegListAll($org_key);
        for($i = 0;$i<count($reg_list);$i++){
            $data[$reg_list[$i]] = $res[($i+9+$dep_num)];
        }
        $result = array('code'=>'1','msg'=>'success','data'=>$data);
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
            $result = array('code' =>'0' ,'msg'=>'fail','data'=>'无报名信息');
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
            $result = array('code' =>'1' ,'msg'=>'success','data'=>$data);
        }
    }else{
        $result = array('code' =>'-1' ,'msg'=>'fail','data'=>'缺失参数');
    }
    $result = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $result;
}


