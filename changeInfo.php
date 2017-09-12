<<<<<<< HEAD
<?php
include_once "config.php";
include_once "db.class.php";
include_once "MSGoperate.php";
$MSG = new MSGoperate();
$change_type = $_GET['change_type'];
session_start();
header("Content-Type: text/html; charset=UTF-8");
    //组织列表添加
    if($change_type == 'org_add'){
        $data = array('org_key'=>htmlspecialchars($_POST['org_key'],ENT_QUOTES),'org_name'=>htmlspecialchars($_POST['org_name'],ENT_QUOTES),'admin_name'=>htmlspecialchars($_POST['admin_name'],ENT_QUOTES),'admin_sid'=>htmlspecialchars($_POST['admin_sid']),ENT_QUOTES);
        $empty = checkEmpty($data);
        if($empty){
            echo "<script>alert('插入失败，请完善信息！');history.go(-1);</script>";
        }else{
            $res = $DB->addOrgan_r($data);
            if($res == 0){
                echo "<script>alert('插入失败');</script>";
            }else{
                echo "<script>alert('插入成功');history.go(-1);</script>";
            }
        }
    //删除组织
    }else if($change_type == 'org_del'){
        $org_key = htmlspecialchars($_GET['org_key'],ENT_QUOTES);
        $res = $DB->delOrgan_r($org_key);
        echo $res;
    //修改组织
    }else if($change_type == 'org_revise'){
        $org_key = $_GET['org_key'];
        $data = array('org_name'=>htmlspecialchars($_POST['org_name'], ENT_QUOTES),'admin_name'=>htmlspecialchars($_POST['admin_name'],ENT_QUOTES),'admin_sid'=>htmlspecialchars($_POST['admin_sid'],ENT_QUOTES),'org_new_key'=>htmlspecialchars($_POST['org_new_key']),ENT_QUOTES);
        $res = $DB->reviseOrgan_r($org_key,$data);
        if($res == 0){
            echo "<script>alert('修改失败');history.go(-1);</script>";
        }else{
            echo "<script>alert('修改成功');history.go(-1);</script>";
        }
    //整体介绍修改
    }else if($change_type == 'org_itd_revise'){
        $org_key = $_SESSION['org_key'];
        $data = htmlspecialchars($_POST['org_introduction'], ENT_QUOTES);
        $res = $DB->addOrganInfo_a($org_key,$data);
        if($res == 0){
            echo "0";
        }else{
            echo "1";
        }
    //组织详细介绍修改
    }else if($change_type == 'org_itd_dtl_revise'){
        $data = file_get_contents("php://input");
        $org_key = $_GET['org_key'];
//        $data = $_POST['org_itd_dtl'];
        $res = $DB->addOrganInfoDetail_a($org_key,$data);
        echo 1;
        return $res;
//        if($res == 0){
//            echo "<script>alert('组织详细介绍修改失败');history.go(-1);</script>";
//        }else{
//            echo "<script>alert('组织详细介绍修改成功');history.go(-1);</script>";
//        }
        //部门删除
    }else if($change_type == 'dep_del'){
        $dep_id = $_GET['dep_id'];
        $res = $DB->deleteDepartment($dep_id);
        echo $res;
        //部长删除
    }else if($change_type == 'ministor_del'){
        $ministor_id = $_GET['ministor_id'];
        $res = $DB->deleteMinistor($ministor_id);
        echo $res;
        //报名表删除
    }else if($change_type == 'register_form_del'){
        $register_id = $_GET['register_id'];
        $res = $DB->delOrgRegList($_SESSION['org_key'],$register_id);
        echo $res;
        //报名表意向部门数量修改
    }else if($change_type == 'dep_num_revise'){
        $dep_num = $_GET['dep_num'];
        $res = $DB->reviseDepNum($_SESSION['org_key'],$dep_num);
        if($res == 0){
            echo "0";
        }else{
            echo "1";
        }
        //部门添加
    }else if($change_type == 'dep_add'){
        $data = array('org_key'=>$_SESSION['org_key'],'dep_name'=>$_POST['dep_name']);
        $empty = checkEmpty($data);
        if($empty){
            echo "<script>alert('添加失败，请完善信息！');</script>";
        }else{
            $res = $DB->addDepartment($data);
            if($res == 0){
                echo 0;
            }else{
                echo 1;
            }
        }
        //部长添加
    }else if($change_type == 'ministor_add'){
        $dep_list = $DB->getDepList($_SESSION['org_key']);
        for($i = 0;$i<count($dep_list);$i++){
            if($_POST['dep_id'] == $dep_list[$i]['Id']){
                $dep_name = $dep_list[$i]['dep_name'];
            }
        }
        $data = array('org_key'=>$_SESSION['org_key'],'dep_id'=>$_POST['dep_id'],'dep_name'=>$dep_name,'ministor_name'=>$_POST['ministor_name'],'ministor_sid'=>$_POST['ministor_sid']);
        $checkSid = preg_match('/^\d{10}$/',$_POST['ministor_sid']);
        if($checkSid==0){
            echo "-2";
        }else {
            $empty = checkEmpty($data);
            if ($empty) {
                echo "-1";
            } else {
                $res = $DB->addMinistor($data);
                if ($res == 0) {
                    echo "0";
                } else {
                    echo "1";
                }
            }
        }
        //报名表项目添加
    }else if($change_type == 'register_form_add'){
        $data = array('org_key'=>$_SESSION['org_key'],'register_form_name'=>$_POST['register_form_name']);
        $empty = checkEmpty($data);
        if($empty){
            echo "<script>alert('添加失败，请完善信息！');</script>";
        }else{
            $res = $DB->addRegisterForm($_SESSION['org_key'],$data['register_form_name']);
            if($res == 0){
                echo "0";
            }else{
                echo "1";
            }
        }
        //报名表项目修改
    }else if($change_type == 'register_form_revise') {
        $register_id = $_POST['register_id'];
        $data = $_POST['register_form_name'];
        $res = $DB->reviseOrgRegListDef($_SESSION
            ['org_key'],$register_id,$data);
        if ($res == 0) {
            echo "0";
        } else {
            echo "1";
        }
    //  修改api_key
    }else if($change_type == 'api_key_revise'){
        $org_key = $_SESSION['org_key'];
        $new_apikey = $_POST['new_apikey'];
        $check = $MSG->checkApiKey($new_apikey);
        if($check == 1){
            $res = $DB->reviseApikey($org_key,$new_apikey);
            if ($res == 0) {
                echo "0";
            } else {
                echo "1";
            }
        }else{
            echo "-1";
        }

        //添加api_key
    }else if($change_type == 'api_key_add'){
        $org_key = $_SESSION['org_key'];
        $apikey = $_POST['apikey'];
        $check = $MSG->checkApiKey($apikey);
        if($check == 1){
            $res = $DB->reviseApikey($org_key,$apikey);
            if ($res == 0) {
                echo "<script>alert('APIKEY添加失败');history.go(-1);</script>";
            } else {
                echo "<script>alert('APIKEY添加成功');history.go(-1);</script>";
            }
        }else{
            echo "<script>alert('假的！');history.go(-1);</script>";
        }

        //删除模板
    }else if($change_type == 'model_del'){
        include_once "MSGoperate.php";
        $MSG = new MSGoperate();
        $tpl_id = $_GET['tpl_id'];
        $apikey = $_GET['apikey'];
        $res = $MSG->delModel($apikey,$tpl_id);
        if (isset($res['http_status_code'])){
            echo "0";
        } else {
            echo "1";
        }
        //短信模板添加
    }else if($change_type == 'msg_model_add'){
        include_once "MSGoperate.php";
        $MSG = new MSGoperate();
        $apikey = $_GET['api_key'];
        $model = $_POST['new_model'];
        $res = $MSG->addModel($apikey,$model);
        if (isset($res['http_status_code'])){
            $msg = $res['msg'];
            echo '<script>alert("添加失败，请检查添加的模板内容");history.go(-1);</script>';
        } else {
            echo 1;
            echo "<script>alert('模板添加成功，请在列表查看状态');history.go(-1);</script>";
        }
        //修改面试记录
    }else if($change_type == 'interview_record_revise'){
        $interview_record = $_GET['interview_record'];
        $personal_id = $_GET['personal_id'];
        $res = $DB->changeInterviewRecord($_SESSION['org_key'],$personal_id,$interview_record);
        echo $res;
        //状态更改
    }else if($change_type=='admit_status_revise'){
        $personal_id = $_GET['personal_id'];
        $admit_status = $_GET['admit_status'];
        $dep_name = $_GET['dep_name'];
        $res = $DB->reviseAdmitStatus($_SESSION['org_key'],$personal_id,$dep_name,$admit_status);
        echo $res;
        //负责人删除
    }else if($change_type=='admin_del'){
        $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
        $org_key = htmlspecialchars($_GET['org_key'],ENT_QUOTES);
        $res = $DB->delAdmin($org_key,$id);
        echo $res;
        //负责人修改
    }else if($change_type=='admin_revise'){
        $id = $_GET['id'];
        $admin_name = htmlspecialchars($_POST['admin_name'],ENT_QUOTES);
        $admin_sid = htmlspecialchars($_POST['admin_sid'],ENT_QUOTES);
        $checkSid = preg_match('/^\d{10}$/',$admin_sid);
        if($checkSid==0){
            echo "<script>alert('这不是学号吧……');history.go(-1);</script>";
        }else {
            $res = $DB->reviseAdmin($id, $admin_name, $admin_sid);
            echo $res;
            if ($res == 0) {
                echo "<script>alert('修改失败');history.go(-1);</script>";
            } else {
                echo "<script>alert('修改成功');history.go(-1);</script>";
            }
        }
        //负责人添加
    }else if($change_type=='admin_add'){
        $org_key = $_GET['org_key'];
        $admin_name = htmlspecialchars($_POST['admin_name'],ENT_QUOTES);
        $admin_sid = htmlspecialchars($_POST['admin_sid'],ENT_QUOTES);

        $checkSid = preg_match('/^\d{10}$/',$admin_sid);
        if($checkSid==0){
            echo "<script>alert('这不是学号吧……');history.go(-1);</script>";
        }else {
            $res = $DB->addAdmin($org_key, $admin_name, $admin_sid);
            if ($res == 0) {
                echo "<script>alert('添加失败');history.go(-1);</script>";
            } else {
                echo "<script>alert('添加成功');history.go(-1);</script>";
            }
        }
    }else if($change_type=='selected_num'){
        $org_key = $_SESSION['org_key'];
        $dep_name = $_GET['dep_name'];
        $status = $_GET['status'];
        $num = $DB->getNum($org_key,$dep_name,$status);
        echo $num;
    }

    function checkEmpty($data){
        $res = 0;
        foreach ($data as $val){
            if($val == ''){
                $res = 1;
            }
        }
        return $res;
    }
=======
<?php
include_once "config.php";
include_once "db.class.php";
include_once "MSGoperate.php";
$MSG = new MSGoperate();
$change_type = $_GET['change_type'];
session_start();
header("Content-Type: text/html; charset=UTF-8");
    //组织列表添加
    if($change_type == 'org_add'){
        $data = array('org_key'=>htmlspecialchars($_POST['org_key'],ENT_QUOTES),'org_name'=>htmlspecialchars($_POST['org_name'],ENT_QUOTES),'admin_name'=>htmlspecialchars($_POST['admin_name'],ENT_QUOTES),'admin_sid'=>htmlspecialchars($_POST['admin_sid']),ENT_QUOTES);
        $empty = checkEmpty($data);
        if($empty){
            echo "<script>alert('插入失败，请完善信息！');history.go(-1);</script>";
        }else{
            $res = $DB->addOrgan_r($data);
            if($res == 0){
                echo "<script>alert('插入失败');</script>";
            }else{
                echo "<script>alert('插入成功');history.go(-1);</script>";
            }
        }
    //删除组织
    }else if($change_type == 'org_del'){
        $org_key = htmlspecialchars($_GET['org_key'],ENT_QUOTES);
        $res = $DB->delOrgan_r($org_key);
        echo $res;
    //修改组织
    }else if($change_type == 'org_revise'){
        $org_key = $_GET['org_key'];
        $data = array('org_name'=>htmlspecialchars($_POST['org_name'], ENT_QUOTES),'admin_name'=>htmlspecialchars($_POST['admin_name'],ENT_QUOTES),'admin_sid'=>htmlspecialchars($_POST['admin_sid'],ENT_QUOTES),'org_new_key'=>htmlspecialchars($_POST['org_new_key']),ENT_QUOTES);
        $res = $DB->reviseOrgan_r($org_key,$data);
        if($res == 0){
            echo "<script>alert('修改失败');history.go(-1);</script>";
        }else{
            echo "<script>alert('修改成功');history.go(-1);</script>";
        }
    //整体介绍修改
    }else if($change_type == 'org_itd_revise'){
        $org_key = $_SESSION['org_key'];
        $data = htmlspecialchars($_POST['org_introduction'], ENT_QUOTES);
        $res = $DB->addOrganInfo_a($org_key,$data);
        if($res == 0){
            echo "0";
        }else{
            echo "1";
        }
    //组织详细介绍修改
    }else if($change_type == 'org_itd_dtl_revise'){
        $data = file_get_contents("php://input");
        $org_key = $_GET['org_key'];
//        $data = $_POST['org_itd_dtl'];
        $res = $DB->addOrganInfoDetail_a($org_key,$data);
        echo 1;
        return $res;
//        if($res == 0){
//            echo "<script>alert('组织详细介绍修改失败');history.go(-1);</script>";
//        }else{
//            echo "<script>alert('组织详细介绍修改成功');history.go(-1);</script>";
//        }
        //部门删除
    }else if($change_type == 'dep_del'){
        $dep_id = $_GET['dep_id'];
        $res = $DB->deleteDepartment($dep_id);
        echo $res;
        //部长删除
    }else if($change_type == 'ministor_del'){
        $ministor_id = $_GET['ministor_id'];
        $res = $DB->deleteMinistor($ministor_id);
        echo $res;
        //报名表删除
    }else if($change_type == 'register_form_del'){
        $register_id = $_GET['register_id'];
        $res = $DB->delOrgRegList($_SESSION['org_key'],$register_id);
        echo $res;
        //报名表意向部门数量修改
    }else if($change_type == 'dep_num_revise'){
        $dep_num = $_GET['dep_num'];
        $res = $DB->reviseDepNum($_SESSION['org_key'],$dep_num);
        if($res == 0){
            echo "0";
        }else{
            echo "1";
        }
        //部门添加
    }else if($change_type == 'dep_add'){
        $data = array('org_key'=>$_SESSION['org_key'],'dep_name'=>$_POST['dep_name']);
        $empty = checkEmpty($data);
        if($empty){
            echo "<script>alert('添加失败，请完善信息！');</script>";
        }else{
            $res = $DB->addDepartment($data);
            if($res == 0){
                echo 0;
            }else{
                echo 1;
            }
        }
        //部长添加
    }else if($change_type == 'ministor_add'){
        $dep_list = $DB->getDepList($_SESSION['org_key']);
        for($i = 0;$i<count($dep_list);$i++){
            if($_POST['dep_id'] == $dep_list[$i]['Id']){
                $dep_name = $dep_list[$i]['dep_name'];
            }
        }
        $data = array('org_key'=>$_SESSION['org_key'],'dep_id'=>$_POST['dep_id'],'dep_name'=>$dep_name,'ministor_name'=>$_POST['ministor_name'],'ministor_sid'=>$_POST['ministor_sid']);
        $checkSid = preg_match('/^\d{10}$/',$_POST['ministor_sid']);
        if($checkSid==0){
            echo "-2";
        }else {
            $empty = checkEmpty($data);
            if ($empty) {
                echo "-1";
            } else {
                $res = $DB->addMinistor($data);
                if ($res == 0) {
                    echo "0";
                } else {
                    echo "1";
                }
            }
        }
        //报名表项目添加
    }else if($change_type == 'register_form_add'){
        $data = array('org_key'=>$_SESSION['org_key'],'register_form_name'=>$_POST['register_form_name']);
        $empty = checkEmpty($data);
        if($empty){
            echo "<script>alert('添加失败，请完善信息！');</script>";
        }else{
            $res = $DB->addRegisterForm($_SESSION['org_key'],$data['register_form_name']);
            if($res == 0){
                echo "0";
            }else{
                echo "1";
            }
        }
        //报名表项目修改
    }else if($change_type == 'register_form_revise') {
        $register_id = $_POST['register_id'];
        $data = $_POST['register_form_name'];
        $res = $DB->reviseOrgRegListDef($_SESSION
            ['org_key'],$register_id,$data);
        if ($res == 0) {
            echo "0";
        } else {
            echo "1";
        }
    //  修改api_key
    }else if($change_type == 'api_key_revise'){
        $org_key = $_SESSION['org_key'];
        $new_apikey = $_POST['new_apikey'];
        $check = $MSG->checkApiKey($new_apikey);
        if($check == 1){
            $res = $DB->reviseApikey($org_key,$new_apikey);
            if ($res == 0) {
                echo "0";
            } else {
                echo "1";
            }
        }else{
            echo "-1";
        }

        //添加api_key
    }else if($change_type == 'api_key_add'){
        $org_key = $_SESSION['org_key'];
        $apikey = $_POST['apikey'];
        $check = $MSG->checkApiKey($apikey);
        if($check == 1){
            $res = $DB->reviseApikey($org_key,$apikey);
            if ($res == 0) {
                echo "<script>alert('APIKEY添加失败');history.go(-1);</script>";
            } else {
                echo "<script>alert('APIKEY添加成功');history.go(-1);</script>";
            }
        }else{
            echo "<script>alert('假的！');history.go(-1);</script>";
        }

        //删除模板
    }else if($change_type == 'model_del'){
        include_once "MSGoperate.php";
        $MSG = new MSGoperate();
        $tpl_id = $_GET['tpl_id'];
        $apikey = $_GET['apikey'];
        $res = $MSG->delModel($apikey,$tpl_id);
        if (isset($res['http_status_code'])){
            echo "0";
        } else {
            echo "1";
        }
        //短信模板添加
    }else if($change_type == 'msg_model_add'){
        include_once "MSGoperate.php";
        $MSG = new MSGoperate();
        $apikey = $_GET['api_key'];
        $model = $_POST['new_model'];
        $res = $MSG->addModel($apikey,$model);
        if (isset($res['http_status_code'])){
            $msg = $res['msg'];
            echo '<script>alert("添加失败，请检查添加的模板内容");history.go(-1);</script>';
        } else {
            echo 1;
            echo "<script>alert('模板添加成功，请在列表查看状态');history.go(-1);</script>";
        }
        //修改面试记录
    }else if($change_type == 'interview_record_revise'){
        $interview_record = $_GET['interview_record'];
        $personal_id = $_GET['personal_id'];
        $res = $DB->changeInterviewRecord($_SESSION['org_key'],$personal_id,$interview_record);
        echo $res;
        //状态更改
    }else if($change_type=='admit_status_revise'){
        $personal_id = $_GET['personal_id'];
        $admit_status = $_GET['admit_status'];
        $dep_name = $_GET['dep_name'];
        $res = $DB->reviseAdmitStatus($_SESSION['org_key'],$personal_id,$dep_name,$admit_status);
        echo $res;
        //负责人删除
    }else if($change_type=='admin_del'){
        $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
        $org_key = htmlspecialchars($_GET['org_key'],ENT_QUOTES);
        $res = $DB->delAdmin($org_key,$id);
        echo $res;
        //负责人修改
    }else if($change_type=='admin_revise'){
        $id = $_GET['id'];
        $admin_name = htmlspecialchars($_POST['admin_name'],ENT_QUOTES);
        $admin_sid = htmlspecialchars($_POST['admin_sid'],ENT_QUOTES);
        $checkSid = preg_match('/^\d{10}$/',$admin_sid);
        if($checkSid==0){
            echo "<script>alert('这不是学号吧……');history.go(-1);</script>";
        }else {
            $res = $DB->reviseAdmin($id, $admin_name, $admin_sid);
            echo $res;
            if ($res == 0) {
                echo "<script>alert('修改失败');history.go(-1);</script>";
            } else {
                echo "<script>alert('修改成功');history.go(-1);</script>";
            }
        }
        //负责人添加
    }else if($change_type=='admin_add'){
        $org_key = $_GET['org_key'];
        $admin_name = htmlspecialchars($_POST['admin_name'],ENT_QUOTES);
        $admin_sid = htmlspecialchars($_POST['admin_sid'],ENT_QUOTES);

        $checkSid = preg_match('/^\d{10}$/',$admin_sid);
        if($checkSid==0){
            echo "<script>alert('这不是学号吧……');history.go(-1);</script>";
        }else {
            $res = $DB->addAdmin($org_key, $admin_name, $admin_sid);
            if ($res == 0) {
                echo "<script>alert('添加失败');history.go(-1);</script>";
            } else {
                echo "<script>alert('添加成功');history.go(-1);</script>";
            }
        }
    }

    function checkEmpty($data){
        $res = 0;
        foreach ($data as $val){
            if($val == ''){
                $res = 1;
            }
        }
        return $res;
    }
>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
?>