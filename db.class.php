<<<<<<< HEAD
<?php

 class DB_operate{
     public $pdo;
     public function __construct(){
         try {
             $dbr = "mysql:host=localhost;dbname=zhaoxin2017";
             $username = "root";
              $password = "NIUBSky3!.comr720";
//            $password = "root";
             $this->pdo = new PDO($dbr, $username, $password, array(PDO::ATTR_PERSISTENT => true));
             $this->pdo->exec("set names utf8");
         }catch(PDOException $e){
             echo 'Connet db Failed'.$e->getMessage();
         }
     }

     //插入报名人员信息
     public function addInfo($org_key,$data){
         $table = $org_key.'_personal_info';
         $sql = "SELECT * FROM $table WHERE name = ? AND phone = ?";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$data['name']);
         $pre->bindParam(2,$data['phone']);
         $pre->execute();
         $res_num = $pre->rowCount();
         if($res_num == 0){
             $sql = "INSERT INTO $table (org_key,name,sex,birthday,college,profess,phone,qq,introduction,admit_status,other_info,register_time,register_way) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
             $pre = $this->pdo->prepare($sql);
             $pre->bindParam(1,$data['org_key']);
             $pre->bindParam(2,$data['name']);
             $pre->bindParam(3,$data['sex']);
             $pre->bindParam(4,$data['birthday']);
             $pre->bindParam(5,$data['college']);
             $pre->bindParam(6,$data['profess']);
             $pre->bindParam(7,$data['phone']);
             $pre->bindParam(8,$data['qq']);
             $pre->bindParam(9,$data['introduction']);
             $pre->bindParam(10,$data['admit_status']);
             $pre->bindParam(11,$data['other_info']);
             $pre->bindParam(12,$data['register_time']);
             $pre->bindParam(13,$data['register_way']);
             $pre->execute();
             $res = $pre->rowCount();
             if($res != 0){
                 return 1;
             }else{
                 return 0;
             }
         }else{
             return -1;
         }


     }

     //更新修改报名人员信息
     public function updateInfo($org_key,$name,$phone,$data){
         $table = $org_key.'_personal_info';
         $sql = "UPDATE $table SET org_key = ?,name = ?,sex = ?,birthday = ?,college = ?,profess = ?,phone = ?,qq = ?,introduction = ?,admit_status = ?,other_info = ?,register_time = ?,register_way = ?  WHERE name = '$name' AND phone = '$phone'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$data['org_key']);
         $pre->bindParam(2,$data['name']);
         $pre->bindParam(3,$data['sex']);
         $pre->bindParam(4,$data['birthday']);
         $pre->bindParam(5,$data['college']);
         $pre->bindParam(6,$data['profess']);
         $pre->bindParam(7,$data['phone']);
         $pre->bindParam(8,$data['qq']);
         $pre->bindParam(9,$data['introduction']);
         $pre->bindParam(10,$data['admit_status']);
         $pre->bindParam(11,$data['other_info']);
         $pre->bindParam(12,$data['register_time']);
         $pre->bindParam(13,$data['register_way']);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }


     //查询录取状态
     public function queryAdmitStatus($org_key,$name,$phone){
        $table = $org_key.'_personal_info';
        $sql = "SELECT * FROM $table WHERE name = :name AND phone = :phone" ;
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(':name',$name);
        $pre->bindParam(':phone',$phone);
        $res = $pre->execute();
        $resnum = $pre->rowCount();
        $resArr = $pre->fetch(PDO::FETCH_ASSOC);
        $admit_status = $resArr['admit_status'];
        if($resnum != 0){
            return $admit_status;
        }else{
            return 0;
        }
     }

     //按部门和录取状态获取人员信息 status为0时,获取全部 dep_name为0时获取全部
     public function getPersonalInfo($org_key,$dep_name,$status){
         $table = $org_key."_personal_info";
         if($dep_name == '0'){
             if($status == 0){
                 $like = "%%";
             }else{
                 $like = "%".$status."%";
             }
         }else{
             if($status == 0){
                 $like = "%".$dep_name."%";
             }else{
//                 $like = "%".$dep_name.""":".$status."%";
                 $like = '%'.$dep_name.'":'.$status.'%';
             }
         }
         $sql = "SELECT * FROM $table WHERE admit_status LIKE '$like' ORDER BY 	register_time   ";
         $res = $this->pdo->query($sql);
         $info_list = $this->reOrder($res);
         return $info_list;
     }

     //获取详细信息通过Id
     public function getPersonalById($org_key,$personal_id){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table WHERE Id = '$personal_id'";
         $res = $this->pdo->query($sql);
         $info_list = $this->reOrder($res);
         return $info_list;
     }

     //获取详细信息通过姓名电话
     public function getPersonalByNamePhone($org_key,$name,$phone){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table WHERE name ='$name' AND phone = '$phone'";
         $res = $this->pdo->query($sql);
         $info_list = $this->reOrder($res);
         return $info_list;
     }


     //获取姓名和电话
     public function getNamePhone($org_key,$dep_name,$status,$no_start,$no_end){
        $allInfo = $this->getPersonalInfo($org_key,$dep_name,$status);
        $NamePhone = array();
        if($no_start!='null' && $no_end!='null'){
            for($i = ($no_start-1);$i<=($no_end-1);$i++){
                $NamePhone_solo = array($allInfo[$i][1],$allInfo[$i][6]);
                $NamePhone[] = $NamePhone_solo;
            }
        }else{
            foreach ($allInfo as $val){
                $NamePhone_solo = array($val[1],$val[6]);
                $NamePhone[] = $NamePhone_solo;
            }
        }
        return $NamePhone;
     }

     //获取人数通过部门、状态
     public function getNum($org_key,$dep_name,$status){
         $allInfo = $this->getPersonalInfo($org_key,$dep_name,$status);
         $res = count($allInfo);
         return $res;
     }

     //搜索 若dep_name为0,则在整个table中查询
     public function search($org_key,$dep_name,$like){
         $table = $org_key."_personal_info";
         $like = '%'.$like.'%';
         if($dep_name == '0'){
             $sql = "SELECT * FROM $table WHERE (name LIKE :like OR sex LIKE :like  OR college LIKE :like OR profess LIKE :like OR phone LIKE :like OR qq LIKE :like OR introduction LIKE :like OR other_info LIKE :like OR admit_status LIKE :like OR interview_record LIKE :like)";
             $pre = $this->pdo->prepare($sql);
             $pre->bindParam(':like',$like);
         }else{
             $dep_name = '%'.$dep_name.'%';
             $sql = "SELECT * FROM $table WHERE (admit_status LIKE '$dep_name') AND (name LIKE :like OR sex LIKE :like  OR college LIKE :like OR profess LIKE :like OR phone LIKE :like OR qq LIKE :like OR introduction LIKE :like OR other_info LIKE :like OR admit_status LIKE :like OR interview_record LIKE :like)";
             $pre = $this->pdo->prepare($sql);
             $pre->bindParam(':like',$like);
             $pre->bindParam(':dep_name',$dep_name);
         }
         $pre->execute();
         $resArr = $pre->fetchAll(PDO::FETCH_ASSOC);
         $info_list = $this->reOrder($resArr);
         return $info_list;
     }

     //人员信息重新结合方法
     public function reOrder($resArr){
         $info_list = array();
         foreach ($resArr as $value){
             $info_list_p = array();
             $other_info = json_decode($value['other_info'],true);
             $admit_status = json_decode($value['admit_status'],true);
             $info_list_p[] = $value['Id'];
             $info_list_p[] = $value['name'];
             $info_list_p[] = $value['sex'];
             $info_list_p[] = $value['birthday'];
             $info_list_p[] = $value['college'];
             $info_list_p[] = $value['profess'];
             $info_list_p[] = $value['phone'];
             $info_list_p[] = $value['qq'];
             $info_list_p[] = $value['introduction'];
             if(is_array($admit_status)) {
                 foreach ($admit_status as $key => $val) {
                     $info_list_p[] = array($key,$val);
                 }
             }
             if(is_array($other_info)) {
                 foreach ($other_info as $val) {
                     $info_list_p[] = $val;
                 }
             }
             $info_list_p[count($info_list_p)] = $value['interview_record'];
             $info_list[] = $info_list_p;
         }
         return $info_list;
     }

     //获取回复列表
     public function getReplyList($org_key){
         $sql = "SELECT * FROM msg_reply_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetchAll();
         return $res;
     }

     //根据手机号，查询姓名
     public function getNameByPhone($org_key,$phone){
         $table = $org_key."_personal_info";
         $sql = "SELECT name FROM $table WHERE phone = $phone";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res =$pre->fetch();
         $num = $pre ->rowCount();
         if($num ==1){
             return $res[0];
         }else if($num ==0){
             return 'none';
         }else if($num > 1){
             return 'overflow';
         }
//         return $name;
     }


     //修改面试记录
     public function changeInterviewRecord($org_key,$personal_id,$interview_record){
         $table = $org_key."_personal_info";
         $sql = "UPDATE  $table SET interview_record = '$interview_record' WHERE Id ='$personal_id'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //查询人员权限
     public function checkAuthority($sid){
         $sql_1 = "SELECT * FROM organization_list WHERE admin_sid = '$sid'";
         $pre_1 = $this->pdo->prepare($sql_1);
         $pre_1->execute();
         $res_1 = $pre_1->rowCount();
         $sql_2 = "SELECT * FROM admin_list WHERE admin_sid = '$sid'";
         $pre_2 = $this->pdo->prepare($sql_2);
         $pre_2->execute();
         $res_2 = $pre_2->rowCount();
         if( $res_1 != 0 && $res_2 == 0){
             $authority = 'admin';
             $org_data = $pre_1->fetchAll(PDO::FETCH_BOTH);
             $res = array($authority,$org_data[0]);
             return $res;
         }else if ($res_1 == 0 && $res_2 != 0){
             $authority = 'admin';
             $org_data = $pre_2->fetchAll(PDO::FETCH_BOTH);
             $org_data_res = array(1,1,$org_data[0]['org_key'],$org_data[0]['admin_name']);
             $res = array($authority,$org_data_res);
             return $res;
         }else{
             $sql = "SELECT * FROM ministor_list WHERE ministor_sid =$sid";
             $pre = $this->pdo->prepare($sql);
             $pre->execute();
             if($pre->rowCount() != 0){
                 $authority = 'ministor';
                 $dep_data = $pre->fetchAll(PDO::FETCH_BOTH);
                 $res = array($authority,$dep_data[0]);
                 return $res;
             }else{
                 $authority = 'none';
                 $res = array($authority);
                 return $res;
             }
         }
     }

     //获取组织报名表信息
     public function getOrgRegList($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $dep_num = $res['dep_num'];
         $res = json_decode($res['register_list'],true);
         $register_list = array('姓名','性别','生日','院系','专业','电话','qq','个人简介');
         for($i =0; $i < $dep_num;$i++){
             $j = 8+$i;
             $temp = $i+1;
             $register_list[$j] = '意向'.$temp;
         }
         for($i = 0;$i < count($res);$i++){
             $j = $i+$dep_num+8;
             $register_list[$j] = $res[$i];
         }
         return $register_list;
     }

     //获取组织报名表信息English version...
     public function getOrgRegList_e($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetchAll();
//         return count($res);
         if(count($res) != 0){
             $dep_num = $res[0]['dep_num'];
             $res = json_decode($res[0]['register_list'],true);
             $register_list = array('name','sex','birthday','college','profess','phone','qq','introduction',$dep_num);
//             for($i =0; $i < $dep_num;$i++){
//                 $j = 8+$i;
//                 $temp = $i+1;
//                 $register_list[$j] = 'intention'.$temp;
//             }
             for($i = 0;$i < count($res);$i++){
                 $j = $i+9;
                 $register_list[$j] = $res[$i];
             }
             return $register_list;
         }else{
             return 0;
         }
     }

     //获取报名表自定义部分信息
     public function getOrgRegListDef($org_key,$register_id){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $res = $res[$register_id];
         return $res;
     }


     //获取报名表列表
     public function getOrgRegListAll($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         return $res;
     }


     //修改报名表自定义部分信息
     public function reviseOrgRegListDef($org_key,$register_id,$content){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $res[$register_id] = $content;
         $res = json_encode($res,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE organization_list SET register_list = '$res' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
         return $res;
     }

     //删除报名表信息
     public function delOrgRegList($org_key,$register_no){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $new_register_list = array();
         $j = 0;
         for($i = 0;$i < count($res); $i++){
             if($i == $register_no){
                 $i++;
                 if($i < count($res)){
                     $new_register_list[$j] = $res[$i];
                     $j++;
                 }
             }else{
                 $new_register_list[$j] = $res[$i];
                 $j++;
             }
         }
         $new_register_list_json = json_encode($new_register_list,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE organization_list SET register_list = '$new_register_list_json' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
         return $res;
     }
     //添加报名表信息
     public function addRegisterForm($org_key,$register_form_name){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $no = count($res);
         $res[$no] = $register_form_name;
         $res = json_encode($res,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE organization_list SET register_list = '$res' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
         return $res;
     }

     //获取意向数量
     public function getDepNum($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $dep_num = $res['dep_num'];
         return $dep_num;
     }

     //修改意向数量
     public function reviseDepNum($org_key,$dep_num){
         $sql = "UPDATE organization_list SET dep_num = '$dep_num' WHERE org_key ='$org_key'";
         $res = $this->pdo->exec($sql);
         if($res != 0) {
             return 1;
         }else{
             return 0;
         }
     }

     //获取apikey
     public function getApikey($org_key){
         $sql = "SELECT api_key FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetch();
         return $res;
     }
     
     //修改apikey
     public function reviseApikey($org_key,$api_key)
     {
         $sql = "UPDATE organization_list SET api_key = :api_key WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(':api_key', $api_key);
         $pre->execute();
         $res = $pre->rowCount();
         if ($res != 0) {
             return 1;
         } else {
             return 0;
         }
     }

     //root账户添加组织
     public function addOrgan_r($data){
         $org_key = $data['org_key'];
         $org_name = $data['org_name'];
         $admin_name = $data['admin_name'];
         $admin_sid = $data['admin_sid'];
         $dep_num = 1;
         $logo_path = 'xtu.png';
         $creat_time = date('Y-m-d H:i:s',time());
         $sql = "INSERT INTO organization_list (org_key,org_name,admin_name,admin_sid,dep_num,logo_path,creat_time) VALUES (?,?,?,?,?,?,?)";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_key);
         $pre->bindParam(2,$org_name);
         $pre->bindParam(3,$admin_name);
         $pre->bindParam(4,$admin_sid);
         $pre->bindParam(5,$dep_num);
         $pre->bindParam(6,$logo_path);
         $pre->bindParam(7,$creat_time);
         $res = $pre->execute();
         //新建表
         $table = $org_key.'_personal_info';
         $sql = "CREATE table ".$table." (
                   Id int(11) NOT NULL  AUTO_INCREMENT, 
                   org_key MediumText,       
                   name MediumText,
                   sex MediumText,
                   birthday Date,
                   college MediumText,
                   profess MediumText,
                   phone MediumText,
                   qq MediumText,
                   introduction MediumText,
                   other_info MediumText,
                   admit_status MediumText,
                   interview_record MediumText,
                   register_time datetime,
                   register_way MediumText,
                   PRIMARY KEY (Id));";
         $res_2 = $this->pdo->query($sql);
         if ($res != 0 && $res_2 != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //root账户获取组织列表详情
     public function getOrganListDetail_r(){
         $sql = "SELECT * FROM organization_list ORDER BY Id";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         foreach ($pre as $val){
             $res[] = $val;
         }
         return $res;
     }
     //root账户获取组织列表,仅名称
     public function getOrganList_r(){
         $sql = "SELECT * FROM organization_list";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         foreach ($pre as $val){
             $res[$val[2]] = $val[1];
         }
         return $res;
     }
     //root账户删除组织
     public function delOrgan_r($org_key){
         $table = $org_key."_personal_info";
        $sql = "DELETE FROM organization_list WHERE org_key = '$org_key'";
        $res = $this->pdo->exec($sql);
        $sql = "DELETE FROM ministor_list WHERE org_key = '$org_key'";
        $res_2 = $this->pdo->exec($sql);
        $sql = "DROP TABLE ".$table;
        $res_3 = $this->pdo->exec($sql);
        if($res != 0 ){
            return 1;
        }else {
            return 0;
        }
     }

     //root账户修改组织
     public function reviseOrgan_r($org_key,$data){
         $org_name = $data['org_name'];
         $org_new_key = $data['org_new_key'];
         $admin_name = $data['admin_name'];
         $admin_sid = $data['admin_sid'];
         $sql = "UPDATE organization_list SET org_name = ?,admin_name = ?,admin_sid = ? ,org_key = ? WHERE org_key = ?";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_name);
         $pre->bindParam(2,$admin_name);
         $pre->bindParam(3,$admin_sid);
         $pre->bindParam(4,$org_new_key);
         $pre->bindParam(5,$org_key);
         $pre->execute();
         $res = $pre->rowCount();
         if ($res != 0){
             return 1;
         }else{
             return 0;
         }

     }

     //root账户查看负责人列表
     public function getOrgAdmin($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetch();
         $main_admin = array($res['admin_name'],$res['admin_sid']);
         $sql = "SELECT * FROM admin_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $other_admin = $pre->fetchAll();
         $res = array($main_admin);
         foreach ($other_admin as $val){
             $sid_name = array($val['admin_name'],$val['admin_sid'],$val['Id'],$val['org_key']);
             $res[] = $sid_name;
         }
         return $res;
     }


     //root查看负责人信息
     public function getAdmin($id){
         $sql ="SELECT * FROM admin_list WHERE Id ='$id'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetch();
         return $res;
     }

     //root修改负责人信息
     public function reviseAdmin($id,$admin_name,$admin_sid){
        $sql = "UPDATE admin_list SET admin_name = ?, admin_sid =? WHERE Id = '$id'";
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(1,$admin_name);
        $pre->bindParam(2,$admin_sid);
        $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //root账户删除负责人
     public function delAdmin($org_key,$id){
         $sql = "DELETE FROM admin_list WHERE Id = '$id'";
         $res = $this->pdo->exec($sql);
         if($res != 0 ){
             return 1;
         }else {
             return 0;
         }
     }

     //root账户添加负责人
     public function addAdmin($org_key,$admin_name,$admin_sid){
         $creat_time = date('Y-m-d H:i:s',time());
         $sql = "INSERT INTO  admin_list (org_key,admin_name,admin_sid,creat_time) VALUES (?,?,?,?)";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_key);
         $pre->bindParam(2,$admin_name);
         $pre->bindParam(3,$admin_sid);
         $pre->bindParam(4,$creat_time);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }
     //admin账户获取部门列表（详情）
     public function getDepList($org_key){
         $sql = "SELECT * FROM department_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetchAll();
         return $res;
     }

     //获取部门列表（仅名称）
     public function getDepListArr($org_key){
         $all = $this->getDepList($org_key);
         foreach ($all as $val){
             $res[] = $val['dep_name'];
         }
         return $res;
     }

     //admin账户获取部长列表
     public function getMinistorList($org_key){
         $sql = "SELECT * FROM ministor_list WHERE org_key = '$org_key' ORDER BY dep_id";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetchAll();
         return $res;
     }

     //admin账户修改组织整体介绍
     public function addOrganInfo_a($org_key,$introduction){
         $sql =  "UPDATE organization_list SET introduction = ? WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$introduction);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //admin账户修改组织详细介绍
     public function addOrganInfoDetail_a($org_key,$introduction_detail){
         $sql =  "UPDATE organization_list SET introduction_detail = ? WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$introduction_detail);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //admin账户获取组织信息
     public function getOrganInfo($org_key){
        $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
        $pre = $this->pdo->prepare($sql);
        $pre->execute();
        $resArr =$pre->fetchAll();
        return $resArr[0];
     }

     //admin账户添加部门
     public function addDepartment($data){
        $org_key = $data['org_key'];
        $dep_name = $data['dep_name'];
        $creat_time = date('Y-m-d H:i:s',time());
        $sql = "INSERT INTO department_list (org_key,dep_name,creat_time) VALUES (?,?,?)";
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(1,$org_key);
        $pre->bindParam(2,$dep_name);
        $pre->bindParam(3,$creat_time);
        $pre->execute();
        $res = $pre->rowCount();
        if($res != 0){
            return 1;
        }else{
            return 0;
        }
     }



     //admin账户添加部长级
     public function addMinistor($data){
        $org_name = $data['org_key'];
        $dep_id = $data['dep_id'];
        $ministor_name = $data['ministor_name'];
        $ministor_sid = $data['ministor_sid'];
        $dep_name = $data['dep_name'];
        $creat_time = date('Y-m-d H:i:s',time());
        $sql = "INSERT INTO ministor_list (org_key,dep_id,dep_name,ministor_name,ministor_sid,creat_time) VALUES (?,?,?,?,?,?)";
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(1,$org_name);
        $pre->bindParam(2,$dep_id);
        $pre->bindParam(3,$dep_name);
        $pre->bindParam(4,$ministor_name);
        $pre->bindParam(5,$ministor_sid);
        $pre->bindParam(6,$creat_time);
        $pre->execute();
        $res = $pre->rowCount();
        if($res != 0){
            return 1;
        }else{
            return 0;
        }
     }
     //admin账户修删除部长级
     public function deleteMinistor($id){
        $sql = "DELETE FROM ministor_list WHERE id = $id";
        $res = $this->pdo->exec($sql);
        if($res != 0) {
            return 1;
        }else{
            return 0;
        }
     }

     //amdin账户删除部门
     public function deleteDepartment($id){
         $sql = "DELETE FROM department_list WHERE id = $id";
         $res = $this->pdo->exec($sql);
         $sql = "DELETE FROM ministor_list WHERE dep_id = $id";
         $res_2 = $this->pdo->exec($sql);
         if($res != 0) {
             return 1;
         }else{
             return 0;
         }
     }

     //添加面试记录
     public function addInterviewRecord($org_key,$id,$data){
         $table = $org_key."_personal_info";
         $sql = "UPDATE $table SET interview_record = ? WHERE id = $id ";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$data);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else {
             return 0;
         }
     }

     //admin账户录取状态更改
     public function reviseAdmitStatus($org_key,$id,$dep_name,$status){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table WHERE Id = $id";
         $res = $this->pdo->query($sql);
         $res = $res->fetch(PDO::FETCH_BOTH);
         $admit_status = json_decode($res['admit_status'],true);
         $admit_status[$dep_name] = (int)$status;
         $admit_status = json_encode($admit_status,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE $table SET admit_status = '$admit_status' WHERE Id =$id";
         $res = $this->pdo->exec($sql);
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //改状态
     public function reviseStatus($org_key,$id,$status){
         $table = $org_key."_personal_info";
//         $sql = "SELECT * FROM $table WHERE Id = $id";
//         $res = $this->pdo->query($sql);
//         $res = $res->fetch(PDO::FETCH_BOTH);
         $sql = "UPDATE $table SET admit_status = '$status' WHERE Id =$id";
         $res = $this->pdo->exec($sql);
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }


     //状态归零
     public function getStatus($org_key){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table" ;
         $pre = $this->pdo->prepare($sql);
         $res = $pre->execute();
         $resnum = $pre->rowCount();
         $resArr = $pre->fetchAll(PDO::FETCH_ASSOC);
         return $resArr;
     }

     //报名方式数据统计
     public function countRegisterWay($org_key){
         $table = $org_key."_personal_info";
         $sql_PC ="SELECT COUNT(*) FROM $table WHERE register_way = 'PC'";
         $sql_PHONE = "SELECT COUNT(*) FROM $table WHERE register_way ='PHONE'";
         $res_PC = $this->pdo->query($sql_PC)->fetch(PDO::FETCH_NUM);
         $res_PHONE = $this->pdo->query($sql_PHONE)->fetch(PDO::FETCH_NUM);
         $res = array('PC'=>$res_PC['0'],'PHONE'=>$res_PHONE['0']);
         return $res;
     }

     //按部门和录取状态统计人员信息dep_name为0时获取全部
     public function countRegister($org_key,$dep_name){
         $table = $org_key."_personal_info";
         if($dep_name == '0'){//获取所有部门信息

             $sql = "SELECT * FROM department_list WHERE org_key = '$org_key'";
             $pre = $this->pdo->prepare($sql);
             $pre->execute();
             $depArr = array();
             $dep_num = 0;

             foreach ($pre as $val) {
                 $depArr[$dep_num] = $val['dep_name'];
                 $dep_num++;
             }                  //获取部门列表

             $statusArr = array(0,0,1,2,3,4,5);
             $countRes = array();
             for($i = 0 ;$i < $dep_num ; $i++){
                  $sum = 0;
                 for($j = 1;$j < 7;$j++){
                     $like = '%'.$depArr[$i].'":'.$statusArr[$j].'%';
                     $sql = "SELECT COUNT(*) FROM $table WHERE admit_status like '$like'";
                     $res = $this->pdo->query($sql)->fetch(PDO::FETCH_NUM);
                     $countRes[$i][$j] = $res[0];
                     $sum += $res[0];
                 }
                 $countRes[$i][0] = $sum;
             }
             return $countRes;
         }else{//获取本部门信息
             $statusArr = array(0,0,1,2,3,4,5);
             $countRes = array();
             $sum = 0;
             for($i = 1;$i < 7;$i++){
                 $like = '%'.$dep_name.'":'.$statusArr[$i].'%';
                 $sql = "SELECT COUNT(*) FROM $table WHERE admit_status like '$like'";
                 $res = $this->pdo->query($sql)->fetch(PDO::FETCH_NUM);
                 $countRes[$i] = $res[0];
                 $sum += $res[0];
             }
             $countRes[0] =$sum;
             return $countRes;
         }
     }

     //修改logo路径
     public  function changeLogoPath($org_key,$path){
         $sql = "UPDATE organization_list SET logo_path = '$path' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $res = $pre->execute();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //插入信息发送记录msg_record
     public function addMsgRecord($org_key,$msg_tpl_id,$dep_name,$status,$no_start,$no_end){
         if($no_start=='null' || $no_end=='null'){
             $no_start='全';
             $no_end='部';
         }
         $sql = "SELECT MAX(send_id) FROM msg_record";
         $res = $this->pdo->query($sql);
         $max_id = $res->fetch()[0];
         $max_id++;
         $time = date('Y-m-d H:i:s',time());
         $sql = "INSERT INTO msg_record (org_key,send_id,send_time,msg_tpl_id,dep_name,status,no_start,no_end) VALUES ('$org_key','$max_id','$time','$msg_tpl_id','$dep_name','$status','$no_start','$no_end')";
         $res = $this->pdo->exec($sql);
         return $max_id;
     }


     //记录单条信息发送记录msg_send_list
     public function addMsgSendList($org_key,$send_id,$name,$tpl_id,$phone,$status){
         $send_time = date('Y-m-d H:i:s');
         $sql = "INSERT INTO msg_send_list (org_key,send_id,name,tpl_id,phone,status,send_time) VALUES ('$org_key','$send_id','$name','$tpl_id','$phone','$status','$send_time')";
         $res = $this->pdo->exec($sql);
         return $res;
     }

     //获取短信发送历史
     public function getMsgHitory($org_key){
        $sql = "SELECT * FROM msg_record WHERE org_key = '$org_key' ORDER BY send_time DESC ";
        $res = $this->pdo->query($sql);
        $send_record = $res->fetchAll();
        $count = array();
        foreach ($send_record as $val){
            $sql = "SELECT COUNT(*) FROM msg_send_list WHERE send_id ='$val[2]'";
            $sum = $this->pdo->query($sql);
            $sum = $sum->fetchAll(PDO::FETCH_NUM)[0];
//            print_r($sum);
            $sql = "SELECT COUNT(*) FROM msg_send_list WHERE status ='SUCCESS' AND send_id='$val[2]'";
            $success_num = $this->pdo->query($sql);
            $success_num = $success_num->fetchAll(PDO::FETCH_NUM)[0];
            $fail_num = $sum[0]-$success_num[0];
            $fail_res = array();
            if($fail_num>0){
                $sql = "SELECT * FROM msg_send_list WHERE status <> 'SUCCESS' AND send_id='$val[2]'";
                $fail_detail = $this->pdo->query($sql);
                $fail_detail = $fail_detail->fetchAll();
                foreach ($fail_detail as $value){
                    $fail_content = array($value['name'],$value['tpl_id'],$value['phone'],$value['status']);
                    $fail_res[] = $fail_content;
                }
            }
            $res = array('send_time'=>$val['send_time'],'msg_tpl_id'=>$val['msg_tpl_id'],'dep_name'=>$val['dep_name'],'status'=>$val['status'],'no_start'=>$val['no_start'],'no_end'=>$val['no_end'],'sum'=>$sum[0],'success'=>$success_num[0],'fail'=>$fail_num,'fail_detail'=>$fail_res);
            $count[]=$res;
        }
        return $count;
     }

    //上行短信添加至数据库
    function addMsgRecieve($org_key,$data){
         $mobile = $data['mobile'];
         $reply_time = $data['reply_time'];
         $text = $data['text'];
         $name = $this->getNameByPhone($org_key,$data['mobile']);
         $sql = "INSERT INTO msg_reply_list (org_key,name,mobile,reply_time,text) VALUES (?,?,?,?,?)";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_key);
         $pre->bindParam(2,$name);
         $pre->bindParam(3,$mobile);
         $pre->bindParam(4,$reply_time);
         $pre->bindParam(5,$text);
         $res = $pre->execute();
    }

=======
<?php

 class DB_operate{
     public $pdo;
     public function __construct(){
         try {
             $dbr = "mysql:host=localhost;dbname=zhaoxin2017";
             $username = "root";
             $password = "NIUBSky3!.comr720";
             $this->pdo = new PDO($dbr, $username, $password, array(PDO::ATTR_PERSISTENT => true));
             $this->pdo->exec("set names utf8");
         }catch(PDOException $e){
             echo 'Connet db Failed'.$e->getMessage();
         }
     }

     //插入报名人员信息
     public function addInfo($org_key,$data){
         $table = $org_key.'_personal_info';
         $sql = "SELECT * FROM $table WHERE name = ? AND phone = ?";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$data['name']);
         $pre->bindParam(2,$data['phone']);
         $pre->execute();
         $res_num = $pre->rowCount();
         if($res_num == 0){
             $sql = "INSERT INTO $table (org_key,name,sex,birthday,college,profess,phone,qq,introduction,admit_status,other_info,register_time,register_way) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
             $pre = $this->pdo->prepare($sql);
             $pre->bindParam(1,$data['org_key']);
             $pre->bindParam(2,$data['name']);
             $pre->bindParam(3,$data['sex']);
             $pre->bindParam(4,$data['birthday']);
             $pre->bindParam(5,$data['college']);
             $pre->bindParam(6,$data['profess']);
             $pre->bindParam(7,$data['phone']);
             $pre->bindParam(8,$data['qq']);
             $pre->bindParam(9,$data['introduction']);
             $pre->bindParam(10,$data['admit_status']);
             $pre->bindParam(11,$data['other_info']);
             $pre->bindParam(12,$data['register_time']);
             $pre->bindParam(13,$data['register_way']);
             $pre->execute();
             $res = $pre->rowCount();
             if($res != 0){
                 return 1;
             }else{
                 return 0;
             }
         }else{
             return -1;
         }


     }

     //更新修改报名人员信息
     public function updateInfo($org_key,$name,$phone,$data){
         $table = $org_key.'_personal_info';
         $sql = "UPDATE $table SET org_key = ?,name = ?,sex = ?,birthday = ?,college = ?,profess = ?,phone = ?,qq = ?,introduction = ?,admit_status = ?,other_info = ?,register_time = ?,register_way = ?  WHERE name = '$name' AND phone = '$phone'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$data['org_key']);
         $pre->bindParam(2,$data['name']);
         $pre->bindParam(3,$data['sex']);
         $pre->bindParam(4,$data['birthday']);
         $pre->bindParam(5,$data['college']);
         $pre->bindParam(6,$data['profess']);
         $pre->bindParam(7,$data['phone']);
         $pre->bindParam(8,$data['qq']);
         $pre->bindParam(9,$data['introduction']);
         $pre->bindParam(10,$data['admit_status']);
         $pre->bindParam(11,$data['other_info']);
         $pre->bindParam(12,$data['register_time']);
         $pre->bindParam(13,$data['register_way']);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }


     //查询录取状态
     public function queryAdmitStatus($org_key,$name,$phone){
        $table = $org_key.'_personal_info';
        $sql = "SELECT * FROM $table WHERE name = :name AND phone = :phone" ;
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(':name',$name);
        $pre->bindParam(':phone',$phone);
        $res = $pre->execute();
        $resnum = $pre->rowCount();
        $resArr = $pre->fetch(PDO::FETCH_ASSOC);
        $admit_status = $resArr['admit_status'];
        if($resnum != 0){
            return $admit_status;
        }else{
            return 0;
        }
     }

     //按部门和录取状态获取人员信息 status为0时,获取全部 dep_name为0时获取全部
     public function getPersonalInfo($org_key,$dep_name,$status){
         $table = $org_key."_personal_info";
         if($dep_name == '0'){
             if($status == 0){
                 $like = "%%";
             }else{
                 $like = "%".$status."%";
             }
         }else{
             if($status == 0){
                 $like = "%".$dep_name."%";
             }else{
//                 $like = "%".$dep_name.""":".$status."%";
                 $like = '%'.$dep_name.'":'.$status.'%';
             }
         }
         $sql = "SELECT * FROM $table WHERE admit_status LIKE '$like'";
         $res = $this->pdo->query($sql);
         $info_list = $this->reOrder($res);
         return $info_list;
     }

     //获取详细信息通过Id
     public function getPersonalById($org_key,$personal_id){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table WHERE Id = '$personal_id'";
         $res = $this->pdo->query($sql);
         $info_list = $this->reOrder($res);
         return $info_list;
     }

     //获取详细信息通过姓名电话
     public function getPersonalByNamePhone($org_key,$name,$phone){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table WHERE name ='$name' AND phone = '$phone'";
         $res = $this->pdo->query($sql);
         $info_list = $this->reOrder($res);
         return $info_list;
     }


     //获取姓名和电话
     public function getNamePhone($org_key,$dep_name,$status){
        $allInfo = $this->getPersonalInfo($org_key,$dep_name,$status);
        $NamePhone = array();
        foreach ($allInfo as $val){
            $NamePhone_solo = array($val[1],$val[6]);
            $NamePhone[] = $NamePhone_solo;
        }
        return $NamePhone;
     }


     //搜索 若dep_name为0,则在整个table中查询
     public function search($org_key,$dep_name,$like){
         $table = $org_key."_personal_info";
         $like = '%'.$like.'%';
         if($dep_name == '0'){
             $sql = "SELECT * FROM $table WHERE (name LIKE :like OR sex LIKE :like  OR college LIKE :like OR profess LIKE :like OR phone LIKE :like OR qq LIKE :like OR introduction LIKE :like OR other_info LIKE :like OR admit_status LIKE :like OR interview_record LIKE :like)";
             $pre = $this->pdo->prepare($sql);
             $pre->bindParam(':like',$like);
         }else{
             $dep_name = '%'.$dep_name.'%';
             $sql = "SELECT * FROM $table WHERE (admit_status LIKE '$dep_name') AND (name LIKE :like OR sex LIKE :like  OR college LIKE :like OR profess LIKE :like OR phone LIKE :like OR qq LIKE :like OR introduction LIKE :like OR other_info LIKE :like OR admit_status LIKE :like OR interview_record LIKE :like)";
             $pre = $this->pdo->prepare($sql);
             $pre->bindParam(':like',$like);
             $pre->bindParam(':dep_name',$dep_name);
         }
         $pre->execute();
         $resArr = $pre->fetchAll(PDO::FETCH_ASSOC);
         $info_list = $this->reOrder($resArr);
         return $info_list;
     }

     //人员信息重新结合方法
     public function reOrder($resArr){
         $info_list = array();
         foreach ($resArr as $value){
             $info_list_p = array();
             $other_info = json_decode($value['other_info'],true);
             $admit_status = json_decode($value['admit_status'],true);
             $info_list_p[] = $value['Id'];
             $info_list_p[] = $value['name'];
             $info_list_p[] = $value['sex'];
             $info_list_p[] = $value['birthday'];
             $info_list_p[] = $value['college'];
             $info_list_p[] = $value['profess'];
             $info_list_p[] = $value['phone'];
             $info_list_p[] = $value['qq'];
             $info_list_p[] = $value['introduction'];
             if(is_array($admit_status)) {
                 foreach ($admit_status as $key => $val) {
                     $info_list_p[] = array($key,$val);
                 }
             }
             if(is_array($other_info)) {
                 foreach ($other_info as $val) {
                     $info_list_p[] = $val;
                 }
             }
             $info_list_p[count($info_list_p)] = $value['interview_record'];
             $info_list[] = $info_list_p;
         }
         return $info_list;
     }

     //修改面试记录
     public function changeInterviewRecord($org_key,$personal_id,$interview_record){
         $table = $org_key."_personal_info";
         $sql = "UPDATE  $table SET interview_record = '$interview_record' WHERE Id ='$personal_id'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //查询人员权限
     public function checkAuthority($sid){
         $sql_1 = "SELECT * FROM organization_list WHERE admin_sid = '$sid'";
         $pre_1 = $this->pdo->prepare($sql_1);
         $pre_1->execute();
         $res_1 = $pre_1->rowCount();
         $sql_2 = "SELECT * FROM admin_list WHERE admin_sid = '$sid'";
         $pre_2 = $this->pdo->prepare($sql_2);
         $pre_2->execute();
         $res_2 = $pre_2->rowCount();
         if( $res_1 != 0 && $res_2 == 0){
             $authority = 'admin';
             $org_data = $pre_1->fetchAll(PDO::FETCH_BOTH);
             $res = array($authority,$org_data[0]);
             return $res;
         }else if ($res_1 == 0 && $res_2 != 0){
             $authority = 'admin';
             $org_data = $pre_2->fetchAll(PDO::FETCH_BOTH);
             $org_data_res = array(1,1,$org_data[0]['org_key'],$org_data[0]['admin_name']);
             $res = array($authority,$org_data_res);
             return $res;
         }else{
             $sql = "SELECT * FROM ministor_list WHERE ministor_sid =$sid";
             $pre = $this->pdo->prepare($sql);
             $pre->execute();
             if($pre->rowCount() != 0){
                 $authority = 'ministor';
                 $dep_data = $pre->fetchAll(PDO::FETCH_BOTH);
                 $res = array($authority,$dep_data[0]);
                 return $res;
             }else{
                 $authority = 'none';
                 $res = array($authority);
                 return $res;
             }
         }
     }

     //获取组织报名表信息
     public function getOrgRegList($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $dep_num = $res['dep_num'];
         $res = json_decode($res['register_list'],true);
         $register_list = array('姓名','性别','生日','院系','专业','电话','qq','个人简介');
         for($i =0; $i < $dep_num;$i++){
             $j = 8+$i;
             $temp = $i+1;
             $register_list[$j] = '意向'.$temp;
         }
         for($i = 0;$i < count($res);$i++){
             $j = $i+$dep_num+8;
             $register_list[$j] = $res[$i];
         }
         return $register_list;
     }

     //获取组织报名表信息English version...
     public function getOrgRegList_e($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetchAll();
//         return count($res);
         if(count($res) != 0){
             $dep_num = $res[0]['dep_num'];
             $res = json_decode($res[0]['register_list'],true);
             $register_list = array('name','sex','birthday','college','profess','phone','qq','introduction');
             for($i =0; $i < $dep_num;$i++){
                 $j = 8+$i;
                 $temp = $i+1;
                 $register_list[$j] = 'intention'.$temp;
             }
             for($i = 0;$i < count($res);$i++){
                 $j = $i+$dep_num+8;
                 $register_list[$j] = $res[$i];
             }
             return $register_list;
         }else{
             return 0;
         }
     }

     //获取报名表自定义部分信息
     public function getOrgRegListDef($org_key,$register_id){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $res = $res[$register_id];
         return $res;
     }


     //获取报名表列表
     public function getOrgRegListAll($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         return $res;
     }


     //修改报名表自定义部分信息
     public function reviseOrgRegListDef($org_key,$register_id,$content){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $res[$register_id] = $content;
         $res = json_encode($res,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE organization_list SET register_list = '$res' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
         return $res;
     }

     //删除报名表信息
     public function delOrgRegList($org_key,$register_no){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $new_register_list = array();
         $j = 0;
         for($i = 0;$i < count($res); $i++){
             if($i == $register_no){
                 $i++;
                 if($i < count($res)){
                     $new_register_list[$j] = $res[$i];
                     $j++;
                 }
             }else{
                 $new_register_list[$j] = $res[$i];
                 $j++;
             }
         }
         $new_register_list_json = json_encode($new_register_list,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE organization_list SET register_list = '$new_register_list_json' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
         return $res;
     }
     //添加报名表信息
     public function addRegisterForm($org_key,$register_form_name){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $res = json_decode($res['register_list'],true);
         $no = count($res);
         $res[$no] = $register_form_name;
         $res = json_encode($res,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE organization_list SET register_list = '$res' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
         return $res;
     }

     //获取意向数量
     public function getDepNum($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre ->execute();
         $res = $pre->fetch();
         $dep_num = $res['dep_num'];
         return $dep_num;
     }

     //修改意向数量
     public function reviseDepNum($org_key,$dep_num){
         $sql = "UPDATE organization_list SET dep_num = '$dep_num' WHERE org_key ='$org_key'";
         $res = $this->pdo->exec($sql);
         if($res != 0) {
             return 1;
         }else{
             return 0;
         }
     }

     //获取apikey
     public function getApikey($org_key){
         $sql = "SELECT api_key FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetch();
         return $res;
     }
     
     //修改apikey
     public function reviseApikey($org_key,$api_key)
     {
         $sql = "UPDATE organization_list SET api_key = :api_key WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(':api_key', $api_key);
         $pre->execute();
         $res = $pre->rowCount();
         if ($res != 0) {
             return 1;
         } else {
             return 0;
         }
     }

     //root账户添加组织
     public function addOrgan_r($data){
         $org_key = $data['org_key'];
         $org_name = $data['org_name'];
         $admin_name = $data['admin_name'];
         $admin_sid = $data['admin_sid'];
         $dep_num = 1;
         $logo_path = 'xtu.png';
         $creat_time = date('Y-m-d H:i:s',time());
         $sql = "INSERT INTO organization_list (org_key,org_name,admin_name,admin_sid,dep_num,logo_path,creat_time) VALUES (?,?,?,?,?,?,?)";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_key);
         $pre->bindParam(2,$org_name);
         $pre->bindParam(3,$admin_name);
         $pre->bindParam(4,$admin_sid);
         $pre->bindParam(5,$dep_num);
         $pre->bindParam(6,$logo_path);
         $pre->bindParam(7,$creat_time);
         $res = $pre->execute();
         //新建表
         $table = $org_key.'_personal_info';
         $sql = "CREATE table ".$table." (
                   Id int(11) NOT NULL  AUTO_INCREMENT, 
                   org_key MediumText,       
                   name MediumText,
                   sex MediumText,
                   birthday Date,
                   college MediumText,
                   profess MediumText,
                   phone MediumText,
                   qq MediumText,
                   introduction MediumText,
                   other_info MediumText,
                   admit_status MediumText,
                   interview_record MediumText,
                   register_time datetime,
                   register_way MediumText,
                   PRIMARY KEY (Id));";
         $res_2 = $this->pdo->query($sql);
         if ($res != 0 && $res_2 != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //root账户获取组织列表详情
     public function getOrganListDetail_r(){
         $sql = "SELECT * FROM organization_list ORDER BY creat_time";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         foreach ($pre as $val){
             $res[] = $val;
         }
         return $res;
     }
     //root账户获取组织列表,仅名称
     public function getOrganList_r(){
         $sql = "SELECT * FROM organization_list";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         foreach ($pre as $val){
             $res[$val[2]] = $val[1];
         }
         return $res;
     }
     //root账户删除组织
     public function delOrgan_r($org_key){
         $table = $org_key."_personal_info";
        $sql = "DELETE FROM organization_list WHERE org_key = '$org_key'";
        $res = $this->pdo->exec($sql);
        $sql = "DELETE FROM ministor_list WHERE org_key = '$org_key'";
        $res_2 = $this->pdo->exec($sql);
        $sql = "DROP TABLE ".$table;
        $res_3 = $this->pdo->exec($sql);
        if($res != 0 ){
            return 1;
        }else {
            return 0;
        }
     }

     //root账户修改组织
     public function reviseOrgan_r($org_key,$data){
         $org_name = $data['org_name'];
         $org_new_key = $data['org_new_key'];
         $admin_name = $data['admin_name'];
         $admin_sid = $data['admin_sid'];
         $sql = "UPDATE organization_list SET org_name = ?,admin_name = ?,admin_sid = ? ,org_key = ? WHERE org_key = ?";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_name);
         $pre->bindParam(2,$admin_name);
         $pre->bindParam(3,$admin_sid);
         $pre->bindParam(4,$org_new_key);
         $pre->bindParam(5,$org_key);
         $pre->execute();
         $res = $pre->rowCount();
         if ($res != 0){
             return 1;
         }else{
             return 0;
         }

     }

     //root账户查看负责人列表
     public function getOrgAdmin($org_key){
         $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetch();
         $main_admin = array($res['admin_name'],$res['admin_sid']);
         $sql = "SELECT * FROM admin_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $other_admin = $pre->fetchAll();
         $res = array($main_admin);
         foreach ($other_admin as $val){
             $sid_name = array($val['admin_name'],$val['admin_sid'],$val['Id'],$val['org_key']);
             $res[] = $sid_name;
         }
         return $res;
     }


     //root查看负责人信息
     public function getAdmin($id){
         $sql ="SELECT * FROM admin_list WHERE Id ='$id'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetch();
         return $res;
     }

     //root修改负责人信息
     public function reviseAdmin($id,$admin_name,$admin_sid){
        $sql = "UPDATE admin_list SET admin_name = ?, admin_sid =? WHERE Id = '$id'";
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(1,$admin_name);
        $pre->bindParam(2,$admin_sid);
        $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //root账户删除负责人
     public function delAdmin($org_key,$id){
         $sql = "DELETE FROM admin_list WHERE Id = '$id'";
         $res = $this->pdo->exec($sql);
         if($res != 0 ){
             return 1;
         }else {
             return 0;
         }
     }

     //root账户添加负责人
     public function addAdmin($org_key,$admin_name,$admin_sid){
         $creat_time = date('Y-m-d H:i:s',time());
         $sql = "INSERT INTO  admin_list (org_key,admin_name,admin_sid,creat_time) VALUES (?,?,?,?)";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$org_key);
         $pre->bindParam(2,$admin_name);
         $pre->bindParam(3,$admin_sid);
         $pre->bindParam(4,$creat_time);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }
     //admin账户获取部门列表
     public function getDepList($org_key){
         $sql = "SELECT * FROM department_list WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetchAll();
         return $res;
     }

     //admin账户获取部长列表
     public function getMinistorList($org_key){
         $sql = "SELECT * FROM ministor_list WHERE org_key = '$org_key' ORDER BY dep_id";
         $pre = $this->pdo->prepare($sql);
         $pre->execute();
         $res = $pre->fetchAll();
         return $res;
     }

     //admin账户修改组织整体介绍
     public function addOrganInfo_a($org_key,$introduction){
         $sql =  "UPDATE organization_list SET introduction = ? WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$introduction);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //admin账户修改组织详细介绍
     public function addOrganInfoDetail_a($org_key,$introduction_detail){
         $sql =  "UPDATE organization_list SET introduction_detail = ? WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$introduction_detail);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //admin账户获取组织信息
     public function getOrganInfo($org_key){
        $sql = "SELECT * FROM organization_list WHERE org_key = '$org_key'";
        $pre = $this->pdo->prepare($sql);
        $pre->execute();
        $resArr =$pre->fetchAll();
        return $resArr[0];
     }

     //admin账户添加部门
     public function addDepartment($data){
        $org_key = $data['org_key'];
        $dep_name = $data['dep_name'];
        $creat_time = date('Y-m-d H:i:s',time());
        $sql = "INSERT INTO department_list (org_key,dep_name,creat_time) VALUES (?,?,?)";
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(1,$org_key);
        $pre->bindParam(2,$dep_name);
        $pre->bindParam(3,$creat_time);
        $pre->execute();
        $res = $pre->rowCount();
        if($res != 0){
            return 1;
        }else{
            return 0;
        }
     }



     //admin账户添加部长级
     public function addMinistor($data){
        $org_name = $data['org_key'];
        $dep_id = $data['dep_id'];
        $ministor_name = $data['ministor_name'];
        $ministor_sid = $data['ministor_sid'];
        $dep_name = $data['dep_name'];
        $creat_time = date('Y-m-d H:i:s',time());
        $sql = "INSERT INTO ministor_list (org_key,dep_id,dep_name,ministor_name,ministor_sid,creat_time) VALUES (?,?,?,?,?,?)";
        $pre = $this->pdo->prepare($sql);
        $pre->bindParam(1,$org_name);
        $pre->bindParam(2,$dep_id);
        $pre->bindParam(3,$dep_name);
        $pre->bindParam(4,$ministor_name);
        $pre->bindParam(5,$ministor_sid);
        $pre->bindParam(6,$creat_time);
        $pre->execute();
        $res = $pre->rowCount();
        if($res != 0){
            return 1;
        }else{
            return 0;
        }
     }
     //admin账户修删除部长级
     public function deleteMinistor($id){
        $sql = "DELETE FROM ministor_list WHERE id = $id";
        $res = $this->pdo->exec($sql);
        if($res != 0) {
            return 1;
        }else{
            return 0;
        }
     }

     //amdin账户删除部门
     public function deleteDepartment($id){
         $sql = "DELETE FROM department_list WHERE id = $id";
         $res = $this->pdo->exec($sql);
         $sql = "DELETE FROM ministor_list WHERE dep_id = $id";
         $res_2 = $this->pdo->exec($sql);
         if($res != 0) {
             return 1;
         }else{
             return 0;
         }
     }

     //添加面试记录
     public function addInterviewRecord($org_key,$id,$data){
         $table = $org_key."_personal_info";
         $sql = "UPDATE $table SET interview_record = ? WHERE id = $id ";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$data);
         $pre->execute();
         $res = $pre->rowCount();
         if($res != 0){
             return 1;
         }else {
             return 0;
         }
     }

     //admin账户录取状态更改
     public function reviseAdmitStatus($org_key,$id,$dep_name,$status){
         $table = $org_key."_personal_info";
         $sql = "SELECT * FROM $table WHERE Id = $id";
         $res = $this->pdo->query($sql);
         $res = $res->fetch(PDO::FETCH_BOTH);
         $admit_status = json_decode($res['admit_status'],true);
         $admit_status[$dep_name] = (int)$status;
         $admit_status = json_encode($admit_status,JSON_UNESCAPED_UNICODE);
         $sql = "UPDATE $table SET admit_status = '$admit_status' WHERE Id =$id";
         $res = $this->pdo->exec($sql);
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //报名方式数据统计
     public function countRegisterWay($org_key){
         $table = $org_key."_personal_info";
         $sql_PC ="SELECT COUNT(*) FROM $table WHERE register_way = 'PC'";
         $sql_PHONE = "SELECT COUNT(*) FROM $table WHERE register_way ='PHONE'";
         $res_PC = $this->pdo->query($sql_PC)->fetch(PDO::FETCH_NUM);
         $res_PHONE = $this->pdo->query($sql_PHONE)->fetch(PDO::FETCH_NUM);
         $res = array('PC'=>$res_PC['0'],'PHONE'=>$res_PHONE['0']);
         return $res;
     }

     //按部门和录取状态统计人员信息dep_name为0时获取全部
     public function countRegister($org_key,$dep_name){
         $table = $org_key."_personal_info";
         if($dep_name == '0'){//获取所有部门信息

             $sql = "SELECT * FROM department_list WHERE org_key = '$org_key'";
             $pre = $this->pdo->prepare($sql);
             $pre->execute();
             $depArr = array();
             $dep_num = 0;

             foreach ($pre as $val) {
                 $depArr[$dep_num] = $val['dep_name'];
                 $dep_num++;
             }                  //获取部门列表

             $statusArr = array(0,0,1,2,3,4,5);
             $countRes = array();
             for($i = 0 ;$i < $dep_num ; $i++){
                  $sum = 0;
                 for($j = 1;$j < 7;$j++){
                     $like = '%'.$depArr[$i].'":'.$statusArr[$j].'%';
                     $sql = "SELECT COUNT(*) FROM $table WHERE admit_status like '$like'";
                     $res = $this->pdo->query($sql)->fetch(PDO::FETCH_NUM);
                     $countRes[$i][$j] = $res[0];
                     $sum += $res[0];
                 }
                 $countRes[$i][0] = $sum;
             }
             return $countRes;
         }else{//获取本部门信息
             $statusArr = array(0,0,1,2,3,4,5);
             $countRes = array();
             $sum = 0;
             for($i = 1;$i < 7;$i++){
                 $like = '%'.$dep_name.'":'.$statusArr[$i].'%';
                 $sql = "SELECT COUNT(*) FROM $table WHERE admit_status like '$like'";
                 $res = $this->pdo->query($sql)->fetch(PDO::FETCH_NUM);
                 $countRes[$i] = $res[0];
                 $sum += $res[0];
             }
             $countRes[0] =$sum;
             return $countRes;
         }
     }

     //修改logo路径
     public  function changeLogoPath($org_key,$path){
         $sql = "UPDATE organization_list SET logo_path = '$path' WHERE org_key = '$org_key'";
         $pre = $this->pdo->prepare($sql);
         $res = $pre->execute();
         if($res != 0){
             return 1;
         }else{
             return 0;
         }
     }

     //插入信息发送记录msg_record
     public function addMsgRecord($org_key){
         $sql = "SELECT MAX(send_id) FROM msg_record";
         $res = $this->pdo->query($sql);
         $max_id = $res->fetch()[0];
         $max_id++;
         $time = date('Y-m-d H:i:s',time());
         $sql = "INSERT INTO msg_record (org_key,send_id,send_time) VALUES ('$org_key','$max_id','$time')";
         $res = $this->pdo->exec($sql);
         return $max_id;
     }


     //记录单条信息发送记录msg_send_list
     public function addMsgSendList($org_key,$send_id,$name,$tpl_id,$phone,$status){
         $send_time = date('Y-m-d H:i:s');
         $sql = "INSERT INTO msg_send_list (org_key,send_id,name,tpl_id,phone,status,send_time) VALUES ('$org_key','$send_id','$name','$tpl_id','$phone','$status','$send_time')";
         $res = $this->pdo->exec($sql);
         return $res;
     }

     //获取短信发送历史
     public function getMsgHitory($org_key){
        $sql = "SELECT * FROM msg_record WHERE org_key = '$org_key' ORDER BY send_time DESC ";
        $res = $this->pdo->query($sql);
        $send_record = $res->fetchAll();
        $count = array();
        foreach ($send_record as $val){
            $sql = "SELECT COUNT(*) FROM msg_send_list WHERE send_id ='$val[2]'";
            $sum = $this->pdo->query($sql);
            $sum = $sum->fetchAll(PDO::FETCH_NUM)[0];
//            print_r($sum);
            $sql = "SELECT COUNT(*) FROM msg_send_list WHERE status ='SUCCESS' AND send_id='$val[2]'";
            $success_num = $this->pdo->query($sql);
            $success_num = $success_num->fetchAll(PDO::FETCH_NUM)[0];
            $fail_num = $sum[0]-$success_num[0];
            $fail_res = array();
            if($fail_num>0){
                $sql = "SELECT * FROM msg_send_list WHERE status <> 'SUCCESS' AND send_id='$val[2]'";
                $fail_detail = $this->pdo->query($sql);
                $fail_detail = $fail_detail->fetchAll();
                foreach ($fail_detail as $value){
                    $fail_content = array($value['name'],$value['tpl_id'],$value['phone'],$value['status']);
                    $fail_res[] = $fail_content;
                }
            }
            $res = array('send_time'=>$val['send_time'],'sum'=>$sum[0],'success'=>$success_num[0],'fail'=>$fail_num,'fail_detail'=>$fail_res);
            $count[]=$res;
        }
        return $count;
     }

    //上行短信添加至数据库
    function addMsgRecieve($data){
         $mobile = $data['mobile'];$reply_time = $data['reply_time'];$text = $data['text'];
         $sql = "INSERT INTO msg_reply_list (mobile,reply_time,text) VALUES (?,?,?)";
         $pre = $this->pdo->prepare($sql);
         $pre->bindParam(1,$mobile);
         $pre->bindParam(2,$reply_time);
         $pre->bindParam(3,$text);
         $res = $pre->execute();
    }




>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
 }//end class