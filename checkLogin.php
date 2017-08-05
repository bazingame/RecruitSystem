<?php
include_once "config.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
$sid = $_POST['sid'];
$password = $_POST['password'];
    //判断是否为root账户
    if($sid == 'root'){
        if($password == ROOT_PASSWORD){
            $_SESSION['user_name'] = 'root';
            $_SESSION['user_authority'] = 'root';
            $_SESSION['login_status']=1;
            echo "<script>window.location.href='manage.php'</script>";
        }else{
            echo "<script>alert('密码错误,请重新输入！');history.go(-1);</script>";
        }
    }else{
        //验证学号密码
        $url = JWXTAPI_URL.'sid='.$sid.'&password='.$password;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true);

        //若学号正确查询权限
//        if($data['code'] == 0){
        if(1){
            $sid_info = $DB->checkAuthority($sid);
            $authority = $sid_info[0];
            if($authority == 'none'){
                echo "<script>alert('无权限访问！');history.go(-1);</script>";
            }else if($authority == 'ministor'){
                if($_SESSION['org_key'] == $sid_info[1][1]){     //判断是否为本组织部长级
                    $_SESSION['user_authority'] = 'ministor';
                    $_SESSION['user_name'] = $sid_info[1][4];
                    $_SESSION['dep_name'] = $sid_info[1][2];
                    $_SESSION['login_status']=1;
                    echo "<script>window.location.href='manage.php'</script>";
                }else{
                    echo "<script>alert('走错地方了!请去其他组织~');history.go(-1);</script>";
                }
            }else if($authority == 'admin'){
                if($_SESSION['org_key'] == $sid_info[1][2]){    //判断是否为本组织管理员
                    $_SESSION['user_authority'] = 'admin';
                    $_SESSION['user_name'] = $sid_info[1][3];
                    $_SESSION['login_status']=1;
                    echo "<script>window.location.href='manage.php'</script>";
                }else{
                    echo "<script>alert('走错地方了!请去其他组织~');</script>";
                }
            }
        }else{
            echo "<script>alert('用户名或密码错误!');history.go(-1);</script>";
        }
    }

?>