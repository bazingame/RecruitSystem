<<<<<<< HEAD
<?php
define("ROOT_PASSWORD","sky31root");
define("JWXTAPI_URL","http://api.sky31.com/lib-new/edu_student_info.php?role=2016501308&hash=92a973960e0732fd426399954e578911&");
define("XXMHAPI_URL","http://api.sky31.com/PortalCode/edu-new/student_info.php?role=2016501308&hash=92a973960e0732fd426399954e578911&");

include_once "db.class.php";
$DB = new DB_operate(); //获取组织列表
error_reporting(0);
=======
<?php
define("ROOT_PASSWORD","root");
define("JWXTAPI_URL","http://api.sky31.com/lib-new/edu_student_info.php?role=2016501308&hash=92a973960e0732fd426399954e578911&");


include_once "db.class.php";
$DB = new DB_operate(); //获取组织列表
error_reporting(0);
>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
?>