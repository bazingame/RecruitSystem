<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include_once "config.php";
include_once "db.class.php";
include_once "MSGoperate.php";

$MSG = new MSGoperate();
$DB = new DB_operate();
echo "<pre>";
//print_r($DB->reviseAdmitStatus('sky31',1,'技术开发部',2));
echo "<br>";
//print_r($DB->getPersonalInfo('sky31',0,3));
//print_r($DB->getNamePhone('sky31',0,0));
//$DB->getPersonalInfo('sky31',0,0);
//header("Content-Type: text/html;charset=utf-8");
//$like ='信工';
//$like = utf8_encode($like);
//print_r($DB->search('sky31','技术开发部','信工'));
//$data = array('org_key'=>'sky35','org_name'=>'balibala','admin_name'=>'saaa','admin_sid'=>'66');
//print_r($DB->addOrgan_r('211'));

//print_r($DB->delOrgan_r('sky356'));
//$data = array('org_name'=>'balibala','admin_name'=>'65515','admin_sid'=>'6689465');
//print_r($DB->reviseOrgan_r('sky3455',$data));
//$data = array('introduction'=>'sky35','introduction_detail'=>'baliwewewqeqwbala');
//    print_r($DB->addOrganInfo_a('1',$data));
//print_r($DB->addOrganInfoDetail_a('sky31','98465312'));
//print_r($DB->getOrganInfo('sky31')['introduction_detail']);
//$data = array('org_name' =>'sky33','dep_name'=>'asdasd');
//print_r($DB->addDepartment($data));
//$data = array('org_key'=>'sky33','dep_id'=>1,'ministor_name'=>'sadas','ministor_sid'=>'ministor_sid');
//print_r($DB->addMinistor($data));
//print_r($DB->deleteMinistor(1));
//print_r($DB->deleteDepartment(29));
//print_r($DB->addInterviewRecord('sky31',2,'asbjdbasdb65584'));
//print_r($DB->countRegisterWay('sky31'));

//print_r($DB->countRegister('sky31','0'));


//print_r($DB->getOrgan_r());

//print_r($DB->checkAuthority(2016501307));

//test edu system sid and password
//$url = JWXTAPI_URL.'sid=201&password=fenghuayu0528';
//$ch = curl_init();
//curl_setopt($ch,CURLOPT_URL,$url);
//curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//$data = curl_exec($ch);
//curl_close($ch);
//$data = json_decode($data,true);
//print_r($data);
//print_r($DB->getDepList('sky31'));

//print_r($DB->getOrganListDetail_r());
//print_r($DB->getMinistorList('sky31'));

//print_r($DB->getOrgRegList('sky31'));

//print_r($DB->getDepNum('sky31'));
//print_r($DB->changeLogoPath('sky31','/images/org_key/sky31'));

//echo '<button type="button" id="org_itd_dtl_revise_btn">eweqw</button>
//<div id = "content" style="width=1000px;height: 1000px;"></div>
//<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script><script src="js/getinfo.js"></script>
//<script>
//
//$("#org_itd_dtl_revise_btn").on("click",function () {
////    var org_key = $("#org_key").text();
//    var url ="test2.php";
//    changeContent(url);
//})
//
//function changeContent(url) {
//    $.get(url,
//        function(data){
//            $("#content").html(data);
//        });}
//</script>
//
//';

//echo '<iframe src="test2.php" width="1000px" height="500px" frameborder="0"></iframe>';

//print_r($DB->delOrgRegList('sky31',0));
//print_r($DB->getOrgRegListDef('sky31',2));
//print_r($DB->getOrgRegListAll('sky31'));
//$res = $DB->getApikey('sky31')[0];
//if(isset($res)){
//    echo 1;
//}else{
//    echo 0;
//
//}
//$MSG->test();
//$apikey = '19a6b6334bfdc6bb2533ebbc7996bd9a';
//print_r($MSG->delModel($apikey,'1561778'));
//print_r($MSG->addModel($apikey,'【三翼工作室】亲爱的#name#你好，当你看到这条短信时，就标志着咱们的招新系统功能大体完成，感谢一路有你'));
//print_r($MSG->getMsgModel('19a6b6334bfdc6bb2533ebbc7996bd9a','1619852')['tpl_content']);
//$tpl_value = urlencode('#name#').'='.urlencode('fhy').'&'.urlencode('#department#').'='.urlencode('无敌技术部');
//print_r($MSG->sendMessage($apikey,'18670999799','1561830',$tpl_value));

//print_r($DB->getMsgHitory('sky31'));
//print_r($DB->addMsgRecord('sky31'));
//print_r($MSG->checkApiKey('19a6b6334bfdc6bb2533ebbc7996bd9a'));
//print_r($DB->getPersonalById('sky31',2)[0]);
//print_r($DB->changeInterviewRecord('sky31','1','84568562'));
//print_r($DB->getOrgAdmin('sky31'));
//print_r($DB->getAdmin(1));
//$data = array('org_key'=>'1','name'=>'12试一试','sex'=>'2','birthday'=>'2017-2-2 ','college'=>'2','profess'=>'2','phone'=>'2','qq'=>'2','introduction'=>'2','admit_status'=>'2','other_info'=>'2','register_time'=>'2017-2-2 12:12:12','register_way'=>'2');
//print_r($data);
//$res = $DB->addInfo('sky31',$data) ;
//if($res == 1){
//    $result = array('code' =>'1' ,'msg'=>'success','data'=>'报名成功');
//}else if($res == 0){
//    $result = array('code' =>'0' ,'msg'=>'fail','data'=>'报名失败');
//}else if($res == -1){
//    $result = array('code' =>'-1' ,'msg'=>'fail','data'=>'重复报名');
//}
//$result = json_encode($result,JSON_UNESCAPED_UNICODE);
//echo $result;
// print_r( $DB->updateInfo('sky31','试一试一','12345678909',$data) );
//
//$res = $DB->getPersonalByNamePhone('sky31','酱油','12345678909');
//echo count($res);
//print_r($res[0]);


//$res = $DB->getPersonalByNamePhone('sky31','酱油','12345678909')[0];
//$data['name'] = $res[1];
//$data['sex'] = $res[2];
//$data['birthday'] = $res[3];
//$data['college'] = $res[4];
//$data['profess'] = $res[5];
//$data['phone'] = $res[6];
//$data['qq'] = $res[7];
//$data['introduction'] = $res[8];
////intention
//$dep_num = $DB->getDepNum('sky31');
//for($i = 1;$i<=$dep_num;$i++){
//    $intention_name = 'intention'.$i;
//    if(strlen($res[($i+8)][0])==1){
//        $data[$intention_name] = '未选择';
////        print_r($res[($i+9)][0]);
//    }else{
//        $data[$intention_name] = $res[($i+8)][0];
//    }
//}
////other_info
//$reg_list = $DB->getOrgRegListAll('sky31');
//for($i = 0;$i<count($reg_list);$i++){
//    $data[$reg_list[$i]] = $res[($i+9+$dep_num)];
//}
//$result = array('code'=>'','msg'=>'','data'=>$data);
//$result = json_encode($result,JSON_UNESCAPED_UNICODE);
//print_r($result);
//$admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
//$name = '酱油';$phone = '12345678909';$org_key = 'sky31';
//if(isset($org_key)&&isset($name)&&isset($phone)){
//    $res = $DB->queryAdmitStatus($org_key,$name,$phone);
//    $resArr = json_decode($res,true);
//    if($resArr == 0){
//        $result = array('code' =>'0' ,'msg'=>'fail','data'=>'无报名信息');
//    }else{
//        foreach ($resArr as $key => $value) {
//            if(strlen($key) ==1){
//                $each[0] ='未选择';
//            }else{
//                $each[0] =$key;
//            }
//
//            $each[1]  =$admit_status[$value];
//            $data[] = $each;
//        }
//        $result = array('code' =>'1' ,'msg'=>'success','data'=>$data);
//    }
//}else{
//    $result = array('code' =>'-1' ,'msg'=>'fail','data'=>'缺失参数');
//}
//$result = json_encode($result,JSON_UNESCAPED_UNICODE);
//echo $result;
//echo date('dHis');
//$str = '2016501308';
//$res = preg_match('/^\d{10}$/',$str);
//print_r($res);


//print_r(json_encode($DB->getOrganList_r()));
//print_r($DB->getOrganListDetail_r());
//$org_info = $DB->getOrganInfo('sky31');
//print_r($org_info);
//    $result['org_name'] = $org_info['org_name'];
//    $result['introduction'] = $org_info['introduction'];
//    $result['logo_path'] = $org_info['logo_path'];
//    $result['introduction_detail'] = $org_info['introduction_detail'];
//$result = json_encode($result,JSON_UNESCAPED_UNICODE);
//print_r($result);

//print_r($DB->getOrgRegList_e('sky231'));
//$sex = '2017-05-25';
//$match = preg_match('/^\d{4}-\d{2}-\d{2}$/',$sex);
//echo $match;
//$college = '化学学2院';
//$college_arr = array('材料科学与工程学院','法学院·知识产权学院','公共管理学院','国际交流学院','化工学院','环境与资源学院','化学学院','机械工程学院','历史系·哲学系学院','马克思主义学院','数学与计算科学学院','商学院','体育教学部','土木工程与力学学院','艺术学院','物理与光电工程学院','外国语学院','信息工程学院','兴湘学院','文学与新闻学院','信用管理风险学院');
//$res = in_array($college,$college_arr);
//echo $res;
//$name = '发哈开奖5号';
//$match = preg_match('/\d/',$name)?0:1;
//echo $match;
$pass=1;
$phone = '18670929979';
$match = preg_match('/^\d{11}$/',$phone);
if($match){}else $pass=0;
echo $pass.'//'.$phone;