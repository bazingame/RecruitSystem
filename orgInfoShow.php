<<<<<<< HEAD
<?php
include_once "db.class.php";
include_once "config.php";
session_start();
$org_key = $_SESSION['org_key'];
header("Content-Type: text/html; charset=UTF-8");
$org_itd = $DB->getOrganInfo($org_key)['introduction_detail'];
echo $org_itd;
echo "<hr>";
echo "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<link href="//apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
<script src='./js/jquery-3.2.1.min.js'></script>
<script src="//apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="./summernote/summernote.css" rel="stylesheet">

<div class="button_div" style="width:100%; text-align: center">
    <td>
        <button class="org_add_btn org_itd_del_revise_save_btn" onclick="location.href='orgInfo.php'" type="button">修改</button>
    </td>
</div>
</body>
</html>
=======
<?php
include_once "db.class.php";
include_once "config.php";
session_start();
$org_key = $_SESSION['org_key'];
header("Content-Type: text/html; charset=UTF-8");
$org_itd = $DB->getOrganInfo($org_key)['introduction_detail'];
echo $org_itd;
echo "<hr>";
echo "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<link href="//apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
<script src='./js/jquery-3.2.1.min.js'></script>
<script src="//apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="./summernote/summernote.css" rel="stylesheet">

<div class="button_div" style="width:100%; text-align: center">
    <td>
        <button class="org_add_btn org_itd_del_revise_save_btn" onclick="location.href='orgInfo.php'" type="button">修改</button>
    </td>
</div>
</body>
</html>
>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
