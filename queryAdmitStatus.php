<<<<<<< HEAD
<?php
include_once "db.class.php";
include_once "config.php";

header("Content-Type: text/html; charset=UTF-8");
$org_key = $_GET['org_key'];

$name = $_GET['name'];
$phone = $_GET['phone'];
// echo $org_key;
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

=======
<?php
include_once "db.class.php";
include_once "config.php";

header("Content-Type: text/html; charset=UTF-8");
$org_key = $_GET['org_key'];

$name = $_GET['name'];
$phone = $_GET['phone'];
// echo $org_key;
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

>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
print_r($result);