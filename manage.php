<?php
include "config.php";
session_start();
if(isset($_SESSION['login_status']) && $_SESSION['login_status']==1){

}else{
    echo '<script>location.href="./error.php";</script>';
}
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>招新管理系统</title>
    <link rel="stylesheet" href="css/manage.css">
</head>

<body>
    <span class="bckg"></span>
    <header>
        <?php
            if($_SESSION['user_authority'] == 'root'){
                echo "<h1>组织管理</h1>";
            }else if($_SESSION['user_authority'] == 'admin'){
                echo  '<ul class="tab-group">
                          <li class="tab active"><a class="nav_top" href="#info_look">信息查看</a></li>
                          <li class="tab"><a class="nav_top" href="#org_revise">组织修改</a></li>
                       </ul>';
            }else{
                echo "<h1>报名人员管理</h1>";
            }
            ?>
                <?php
                    if($_SESSION['user_authority'] == 'root'){
                        echo '<ul><li class="org_add left_bot "><a href="javascript:void(0);" data-title="组织添加">  组织添加</a></li></ul>';
                    }else if($_SESSION['user_authority'] == 'ministor'){
                        echo '<ul>
                                  <li class="all left_bot select_status" id="0"><a href="javascript:void(0);" data-title="全部人员">  全部人员</a></li>
                                  <li class="pass_1 left_bot select_status" id="1"><a href="javascript:void(0);" data-title="通过初试">   通过初试</a></li>
                                  <li class="out_1 left_bot select_status" id="2"><a href="javascript:void(0);" data-title="初试淘汰">   初试淘汰</a></li>
                                  <li class="pass_2 left_bot select_status" id="3"><a href="javascript:void(0);" data-title="通过复试">   通过复试</a></li>
                                  <li class="out_2 left_bot select_status" id="4"><a href="javascript:void(0);" data-title="复试淘汰">   复试淘汰</a></li>
                                  <li class="pass_3 left_bot select_status" id="5"><a href="javascript:void(0);" data-title="正式受聘">   正式受聘</a></li>
                              </ul>';
                    }else{
                        echo '                              
                              <div class="tab-content">
                                <ul id="info_look"> 
                                  <li class="all left_bot select_status" id="0"><a href="javascript:void(0);" data-title="全部人员">  全部人员</a></li>
                                  <li class="pass_1 left_bot select_status" id="1"><a href="javascript:void(0);" data-title="通过初试">   通过初试</a></li>
                                  <li class="out_1 left_bot select_status" id="2"><a href="javascript:void(0);" data-title="初试淘汰">   初试淘汰</a></li>
                                  <li class="pass_2 left_bot select_status" id="3"><a href="javascript:void(0);" data-title="通过复试">   通过复试</a></li>
                                  <li class="out_2 left_bot select_status" id="4"><a href="javascript:void(0);" data-title="复试淘汰">   复试淘汰</a></li>
                                  <li class="pass_3 left_bot select_status" id="5"><a href="javascript:void(0);" data-title="正式受聘">   正式受聘</a></li>
                                </ul>       
                                <ul id="org_revise" style="display:none">   
                                  <li class="org_itd left_bot"><a href="javascript:void(0);" data-title="整体介绍">  整体介绍</a></li>
                                  <li class="org_itd_dtl left_bot"><a href="javascript:void(0);" data-title="组织介绍">   组织介绍</a></li>
                                  <li class="dep_add left_bot"><a href="javascript:void(0);" data-title="部门管理">   部门管理</a></li>
                                  <li class="ministor_add left_bot"><a href="javascript:void(0);" data-title="部长管理">   部长管理</a></li>
                                  <li class="register_form left_bot"><a href="javascript:void(0);" data-title="报名表单">   报名表单</a></li>                                  
                                  <li class="org_logo left_bot"><a href="javascript:void(0);" data-title="组织LOGO">   组织LOGO</a></li>

                                </ul>
                                
                              </div>'
                                ;
                    }
                ?>
    </header>
    <main>
        <div class="title">
            <h2></h2>
            <ul class="title_nav">
                <?php
                    if($_SESSION['user_authority'] == 'root'){
                        echo "<li class='nav_item'><a href='logout.php'>退出</a><a href='javascript:void(0);'>Hello <span id='user_authority'>".$_SESSION['user_authority']."</span></a></li>";
                    }else{
                        echo '<span id ="org_key" style="display:none">'.$_SESSION['org_key'].'</span>
                              <span id ="dep_name" style="display:none" >';
                        if($_SESSION['user_authority'] == 'admin'){
                            echo 0;
                        }else{
                            echo $_SESSION['dep_name'];
                        }
                        echo '</span>';
                        echo '<li class="nav_item search" ><form class="search_form" ><input type="search" name ="search_content" placeholder="Search"></form></li>
                              <li class="nav_item dataCount" ><a href="javascript:void(0);">数据统计</a></li>
                              <li class="nav_item toExcel"><a href="javascript:void(0);">导出到Excel</a></li>
                              <li class="nav_item"><a href="javascript:void(0);">短信平台</a>
                                <ul>
                                    <li class="message_manage"><a>短信管理</a></li>
                                    <li class="message_send"><a>短信发送</a></li>
                                </ul>
                              </li>
                              <li class="nav_item"><a href="logout.php">退出</a><a href="javascript:void(0);">Hello <span id="user_authority">'.$_SESSION['user_authority'].'</span> '.$_SESSION['user_name'].'</a></li>';
                    }
                ?>
            </ul>

        </div>
        <div class="content" id="content">
        </div>
    </main>
    <!--cover-->
    <!-- Content wrapper -->
    <div class="wrapperOutside_1">
        <div class="wrapperInside">
            <!-- Dialog -->
            <div class="dialogContainer_1">
                <!-- Dialog title and body -->
                <div class="dialogContent">
                    <div class="dialogContentTitle" style="font-size: 2em">Name</div>
                    <div class="dialogContentBody">换个人点一下试试~</div>
                </div>
                <!-- Dialog action bar -->
                <div class="dialogActionBar">
                    <!-- Buttons -->
                    <a class="buttonTouchTarget" id="buttonOneTouchTarget" href="#">
                        <button class="org_opt_btn org_add_btn interview_record_btn" type="button">修改</button>
                    </a><!-- This comment removes 4px gap between buttons
          --><a class="buttonTouchTarget" id="buttonTwoTouchTarget" href="#">
                        <button class="more_btn org_add_btn org_opt_btn opt_btn_r" type="button" >返回</button>

                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapperOutside_2">
        <div class="wrapperInside">
            <!-- Dialog -->
            <div class="dialogContainer_2">
                <!-- Dialog title and body -->
                <div class="dialogContent">
                    <div class="dialogContentTitle" style="font-size: 2em">Name</div>
                    <div class="dialogContentBody_2">换个人点一下试试~</div>
                </div>
                <!-- Dialog action bar -->
                <div class="dialogActionBar">
                    <!-- Buttons -->
                    <a class="buttonTouchTarget" id="buttonOneTouchTarget" href="#">
                        <?php
                            if($_SESSION['user_authority'] == 'ministor'){
                                echo '<button class="org_opt_btn org_add_btn admit_status_change_btn" type="button">修改</button>';
                            }else{
                                echo '<span>负责人账户无法修改</span>';
                            }
                        ?>
                    </a><!-- This comment removes 4px gap between buttons
          --><a class="buttonTouchTarget" id="buttonTwoTouchTarget" href="#">

                        <button class="admit_status_revise_cel org_add_btn org_opt_btn opt_btn_r" type="button" >取消</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapperOutside_3">
        <div class="wrapperInside">
            <!-- Dialog -->
            <div class="dialogContainer_3">
                <!-- Dialog title and body -->
                <div class="dialogContent">
                    <div class="dialogContentTitle" style="font-size: 2em">请再次确认！</div>
                    <div class="dialogContentBody_3"></div>
                </div>
                <!-- Dialog action bar -->
                <div class="dialogActionBar">
                    <!-- Buttons -->
                    </a><!-- This comment removes 4px gap between buttons
          --><a class="buttonTouchTarget" id="buttonTwoTouchTarget" href="#">

                        <button class="org_add_btn org_opt_btn opt_btn_r" id="msg_send_final_btn" type="button" >确认发送</button>
                    </a>
                    <a class="buttonTouchTarget" id="buttonOneTouchTarget" href="#">
                    </a><!-- This comment removes 4px gap between buttons
          --><a class="buttonTouchTarget" id="buttonTwoTouchTarget" href="#">
                        <button class="org_add_btn org_opt_btn opt_btn_r" id="msg_confirm_cel" type="button" >取消</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--cover-->

    <script src='./js/jquery-3.2.1.min.js'></script>
    <script src="./js/manage.js"></script>
</body>
</html>
