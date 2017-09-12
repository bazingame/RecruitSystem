<<<<<<< HEAD
<?php
require_once "db.class.php";
require_once "config.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
$type = $_GET['type'];
// 允许上传的图片后缀
$allowedExts = array("jpeg", "jpg", "png","PNG");
$temp = explode(".", $_FILES["file"]["name"]);//将文件名以“.”打散
$temp_2 = end($temp);     // 获取文件后缀名
$extension=strtolower($temp_2);

if($type=='logo'){
    if ((($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 1024000)   // 小于 1M
        && in_array($extension, $allowedExts))
    {
        $_FILES["file"]["name"]=$_SESSION["org_key"].".".$extension;
        if ($_FILES["file"]["error"] > 0){
            echo "错误：: " . $_FILES["file"]["error"] . "<br>";
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"],"images/org_logo/".$_FILES["file"]["name"]);
            $_SESSION["logo_address"]=$_FILES["file"]["name"];
            $logo_address=$_FILES["file"]["name"];
            $res = $DB->changeLogoPath($_SESSION['org_key'],$logo_address);
            if($res == 1){
                echo "<script>alert ('上传LOGO成功！');history.go(-1);</script>";
            }else{
                echo "<script>alert ('上传LOGO失败！');history.go(-1);</script>";
            }
        }
    }else{
        echo "<script>alert ('非法文件格式！');history.go(-1);</script>";
    }
}else if($type == 'img'){
    $org_key = $_SESSION['org_key'];
    if ((($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 2097152)   // 小于 2M
        && in_array($extension, $allowedExts))
    {
        $timestamp = date('dHis');
        $_FILES["file"]["name"]=$org_key.'_'.$timestamp.".".$extension;
        if ($_FILES["file"]["error"] > 0){
            echo "错误：: " . $_FILES["file"]["error"] . "<br>";
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"],"images/org_info_img/".$_FILES["file"]["name"]);
            $img_address = 'https://zx814.sky31.com/2017/admin/images/org_info_img/'.$_FILES["file"]["name"];
            echo $img_address;
        }
    }

}

=======
<?php
require_once "db.class.php";
require_once "config.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
$type = $_GET['type'];
// 允许上传的图片后缀
$allowedExts = array("jpeg", "jpg", "png","PNG");
$temp = explode(".", $_FILES["file"]["name"]);//将文件名以“.”打散
$temp_2 = end($temp);     // 获取文件后缀名
$extension=strtolower($temp_2);

if($type=='logo'){
    if ((($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 1024000)   // 小于 1M
        && in_array($extension, $allowedExts))
    {
        $_FILES["file"]["name"]=$_SESSION["org_key"].".".$extension;
        if ($_FILES["file"]["error"] > 0){
            echo "错误：: " . $_FILES["file"]["error"] . "<br>";
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"],"images/org_logo/".$_FILES["file"]["name"]);
            $_SESSION["logo_address"]=$_FILES["file"]["name"];
            $logo_address=$_FILES["file"]["name"];
            $res = $DB->changeLogoPath($_SESSION['org_key'],$logo_address);
            if($res == 1){
                echo "<script>alert ('上传LOGO成功！');history.go(-1);</script>";
            }else{
                echo "<script>alert ('上传LOGO失败！');history.go(-1);</script>";
            }
        }
    }else{
        echo "<script>alert ('非法文件格式！');history.go(-1);</script>";
    }
}else if($type == 'img'){
    $org_key = $_SESSION['org_key'];
    if ((($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 2097152)   // 小于 2M
        && in_array($extension, $allowedExts))
    {
        $timestamp = date('dHis');
        $_FILES["file"]["name"]=$org_key.'_'.$timestamp.".".$extension;
        if ($_FILES["file"]["error"] > 0){
            echo "错误：: " . $_FILES["file"]["error"] . "<br>";
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"],"images/org_info_img/".$_FILES["file"]["name"]);
            $img_address = 'https://zx814.sky31.com/2017/admin/images/org_info_img/'.$_FILES["file"]["name"];
            echo $img_address;
        }
    }

}

>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
?>