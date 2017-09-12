<<<<<<< HEAD
<?php
require_once "PHPExcel/PHPExcel.php";
include 'PHPExcel/PHPExcel/Writer/Excel2007.php';
require_once "PHPExcel/PHPExcel/Writer/Excel5.php";
require_once "db.class.php";
require_once "config.php";
session_start();
$org_key = $_SESSION['org_key'];
$table = $org_key.'personal_info';
$dep_name = $_POST['dep_name'];
$status = $_POST['status'];

$objPHPExcel = new PHPExcel();
$register_list = $DB->getOrgRegList($org_key);
$info_list = $DB->getPersonalInfo($org_key,$dep_name,$status);
$dep_num = $DB->getDepNum($org_key);
echo '<pre>';
print_r($info_list[0]);
echo "<pre>";
//设定创建人 最后修改人 标题 题目 描述 关键字 种类
$objPHPExcel->getProperties()->setCreator("Sky31 Tech")
                             ->setLastModifiedBy("Sky31 Tech")
                             ->setTitle("Excel")
                             ->setSubject("Excel")
                             ->setDescription("Sky31 Tech ")
                             ->setKeywords("Excel")
                             ->setCategory("Excel");
$objPHPExcel->setActiveSheetIndex(0);

//设定第一行标题
$register_list_num = count($register_list);
for($i = 0,$col = 65;$i < $register_list_num;$i++,$col++){
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).'1',$register_list[$i],PHPExcel_Cell_DataType::TYPE_STRING);
}
//设置面试记录
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr((65+$register_list_num)).'1','面试记录',PHPExcel_Cell_DataType::TYPE_STRING);


//设定内容
$info_list_num = count($info_list);
for($i = 1;$i <= $info_list_num;$i++){
    $col = 65;
    for($j = 1;$j<9;$j++,$col++){  //必有项
        $row = $i+1;
        $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).$row,$info_list[$i-1][$j],PHPExcel_Cell_DataType::TYPE_STRING);
    }
    for($j =0;$j<$dep_num;$j++,$col++){   //部门意向数目
        $row = $i+1;
        $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
        $status = $admit_status[($info_list[$i-1][($j+9)][1])];
        if(strlen($info_list[$i-1][($j+9)][0])==1){
            $dep = '未选择';
        }else{
            $dep = $info_list[$i-1][($j+9)][0];
        }
        $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).$row,$dep.'=>'.$status,PHPExcel_Cell_DataType::TYPE_STRING);
    }
    for($j=(9+$dep_num);$j<=$register_list_num;$j++,$col++){  //附加项
        $row = $i+1;
        $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).$row,$info_list[$i-1][$j],PHPExcel_Cell_DataType::TYPE_STRING);
    }
    //设置面试记录
    $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).($i+1),$info_list[$i-1][($register_list_num+1)],PHPExcel_Cell_DataType::TYPE_STRING);

}

$objActSheet = $objPHPExcel->getActiveSheet();
$date = date('mdHis');
$filename = $org_key.'_'.$date;
ob_end_clean();//清除缓冲区,避免乱码
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save('php://output');






=======
<?php
require_once "PHPExcel/PHPExcel.php";
include 'PHPExcel/PHPExcel/Writer/Excel2007.php';
require_once "PHPExcel/PHPExcel/Writer/Excel5.php";
require_once "db.class.php";
require_once "config.php";
session_start();
$org_key = $_SESSION['org_key'];
$table = $org_key.'personal_info';
$dep_name = $_POST['dep_name'];
$status = $_POST['status'];

$objPHPExcel = new PHPExcel();
$register_list = $DB->getOrgRegList($org_key);
$info_list = $DB->getPersonalInfo($org_key,$dep_name,$status);
$dep_num = $DB->getDepNum($org_key);
echo '<pre>';
print_r($info_list[0]);
echo "<pre>";
//设定创建人 最后修改人 标题 题目 描述 关键字 种类
$objPHPExcel->getProperties()->setCreator("Sky31 Tech")
                             ->setLastModifiedBy("Sky31 Tech")
                             ->setTitle("Excel")
                             ->setSubject("Excel")
                             ->setDescription("Sky31 Tech ")
                             ->setKeywords("Excel")
                             ->setCategory("Excel");
$objPHPExcel->setActiveSheetIndex(0);

//设定第一行标题
$register_list_num = count($register_list);
for($i = 0,$col = 65;$i < $register_list_num;$i++,$col++){
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).'1',$register_list[$i],PHPExcel_Cell_DataType::TYPE_STRING);
}
//设置面试记录
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr((65+$register_list_num)).'1','面试记录',PHPExcel_Cell_DataType::TYPE_STRING);


//设定内容
$info_list_num = count($info_list);
for($i = 1;$i <= $info_list_num;$i++){
    $col = 65;
    for($j = 1;$j<9;$j++,$col++){  //必有项
        $row = $i+1;
        $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).$row,$info_list[$i-1][$j],PHPExcel_Cell_DataType::TYPE_STRING);
    }
    for($j =0;$j<$dep_num;$j++,$col++){   //部门意向数目
        $row = $i+1;
        $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
        $status = $admit_status[($info_list[$i-1][($j+9)][1])];
        if(strlen($info_list[$i-1][($j+9)][0])==1){
            $dep = '未选择';
        }else{
            $dep = $info_list[$i-1][($j+9)][0];
        }
        $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).$row,$dep.'=>'.$status,PHPExcel_Cell_DataType::TYPE_STRING);
    }
    for($j=(9+$dep_num);$j<=$register_list_num;$j++,$col++){  //附加项
        $row = $i+1;
        $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).$row,$info_list[$i-1][$j],PHPExcel_Cell_DataType::TYPE_STRING);
    }
    //设置面试记录
    $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($col).($i+1),$info_list[$i-1][($register_list_num+1)],PHPExcel_Cell_DataType::TYPE_STRING);

}

$objActSheet = $objPHPExcel->getActiveSheet();
$date = date('mdHis');
$filename = $org_key.'_'.$date;
ob_end_clean();//清除缓冲区,避免乱码
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save('php://output');






>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
