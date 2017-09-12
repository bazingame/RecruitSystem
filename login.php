<?php
 include_once "config.php";
session_destroy();
$org_list = $DB->getOrganList_r();
 session_start();
header("Content-Type: text/html; charset=UTF-8");
if(isset($_GET['org_key']) && isset($org_list[$_GET['org_key']])){
     $_SESSION['org_key'] = $org_key = $_GET['org_key'];
 }else{
     echo '<script>location.href="./error.php";</script>';
 }
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>招新管理系统</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
 <div id="sky-logo"></div>
 <div id="logo_2"></div>
  <div class="form">
      <ul class="tab-group">
        <li class="tab"><?php echo $org_list[$org_key]?></li>
      </ul>
      <div class="tab-content">
          <h2>Welcome</h2>
                    <ul class="tab-group2">
                        <li class="tab2 active"><a href="#jwxt">教务系统</a></li>
                        <li class="tab2"><a href="#xxmh">信息门户</a></li>
                    </ul>
          <div id="login">
              <!--教务系统-->
              <div id="jwxt" >
                  <form action="/2017/admin/checkLogin.php?way=jwxt" method="post">
                    <div class="field-wrap" >
                    <label>
        学号<span class="req">*</span>
                    </label>
                    <input type="text" name="sid" required autocomplete="off"/>
                  </div>

                  <div class="field-wrap">
                    <label>教务系统密码<span class="req">*</span>
                    </label>
                    <input type="password" name="password" required autocomplete="off"/>
                  </div>
                  <button class="button button-block"/>登录</button>
                  </form>
              </div>
            <!--信息门户-->
              <div id="xxmh" style="display: none">
                  <form action="/2017/admin/checkLogin.php?way=xxmh" method="post">
                      <div class="field-wrap">
                          <label>
                              学号<span class="req">*</span>
                          </label>
                          <input type="text" name="sid" required autocomplete="off"/>
                      </div>

                      <div class="field-wrap">
                          <label>信息门户密码<span class="req">*</span>
                          </label>
                          <input type="password" name="password" required autocomplete="off"/>
                      </div>
                      <button class="button button-block"/>登录</button>
                  </form>
              </div>
          </div>

          <div id="sky31txz"><a href="https://passport.sky31.com/sso.php?url=https://zx814.sky31.com/2017/admin/checkLogin.php?org_key=<?php echo $_SESSION['org_key']?>" >使用三翼通行证登录</a></div>

      </div><!-- tab-content -->

 </div> <!-- /form -->
 <div style="color:white;font-size: 16px;position: absolute;left: 50%;margin-left:-152px;bottom: 2%;">Copyright&copy;2004-2017湘潭大学三翼工作室</div>
 <script src='./js/jquery-3.2.1.min.js'></script>
 <script src="./js/login.js"></script>

</body>
</html>
