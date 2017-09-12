<?php
require_once "config.php";
require_once "db.class.php";
include_once "MSGoperate.php";
session_start();
$table_type = $_GET['table_type'];
//$org_key = isset($_SESSION['org_key'])?$_SESSION['org_key']:'';
$org_key = isset($_GET['org_key'])?$_GET['org_key']:'';
$dep_name = isset($_GET['dep_name'])?$_GET['dep_name']:'';
$status = isset($_GET['status'])?$_GET['status']:'';


if($table_type == 'info_more'){
    $personal_id = $_GET['personal_id'];
    $personal_info_list = $DB->getPersonalById($_SESSION['org_key'],$personal_id)[0];
    $record_num = count($personal_info_list)-1;
    $org_reg_list = $DB->getOrgRegList($_SESSION['org_key']);
    $dep_num = $DB->getDepNum($_SESSION['org_key']);
    echo '<body>
            <div id="demo">
                <div class="table-responsive-vertical shadow-z-1">
                      <table><tr><td  style="color: black" width="3%">性别:</td><td>'.$personal_info_list[2].'</td>
                                 <td  style="color: black">生日:</td><td>'.$personal_info_list[3].'</td></tr>
                             <tr><td  style="color: black">院系:</td><td>'.$personal_info_list[4].'</td>
                                 <td  style="color: black">专业:</td><td>'.$personal_info_list[5].'</td>
                             <tr><td  style="color: black">电话:</td><td>'.$personal_info_list[6].'</td>
                                 <td  style="color: black">qq:</td><td>'.$personal_info_list[7].'</td></tr>
                             <tr><td  style="color: black" colspan="4">个人简介:</td></tr>
                             <tr><td colspan="4">'.$personal_info_list[8].'</td></tr>';
                    for($i = (8+$dep_num);$i < count($org_reg_list);$i++){
                        echo '<tr><td  style="color: black" colspan="4">'.$org_reg_list[$i].':</td></tr>
                             <tr><td colspan="4">'.$personal_info_list[($i+1)].'</td></tr>';
                    }
                    echo '<tr><td style="color: black;" colspan="4">面试记录：</td></tr>
                             <tr><td colspan="4"><span style="display: none">'.$personal_info_list[0].'</span><textarea id="interview_record" rows="5" cols="60">'.$personal_info_list[$record_num].'</textarea></td></tr>
                            </table></div></div>';
}else if($table_type =='info_name'){
    $personal_id = $_GET['personal_id'];
    $personal_info_list = $DB->getPersonalById($_SESSION['org_key'],$personal_id)[0];
    echo $personal_info_list[1];
    //修改录取状态
}else if($table_type == 'status_change'){
    $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
    $personal_id = $_GET['personal_id'];
    $personal_info_list = $DB->getPersonalById($_SESSION['org_key'],$personal_id)[0];
    $org_reg_list = $DB->getOrgRegList($_SESSION['org_key']);
    $dep_num = $DB->getDepNum($_SESSION['org_key']);
    if($_SESSION['user_authority']=='admin') {

        //账户级别为负责人时显示所有状态修改
        echo '<body>
            <div id="demo">
                <div class="table-responsive-vertical shadow-z-1">
                      <table style="text-align: center"><tr>';
        for ($i = 8; $i < ($dep_num + 8); $i++) {
            echo '<th width="10%" >' . $org_reg_list[$i] . '</th>';
        }
        echo '</tr><tr>';
        for($j = 9;$j < $dep_num + 9;$j++){
            // echo '<td data-title="">'.$personal_info_list[$j][0].'</td>';
            echo '<td data-title="">';
                if(strlen($personal_info_list[$j][0]) != 1){
                  echo $personal_info_list[$j][0];
                }else{
                  echo '未选择';
                }
            echo '</td>';
        }
        echo '</tr><tr style="height:22px">';

        //负责人可修改所有意向
        for($j = 9;$j < $dep_num + 9;$j++){
            if(strlen($personal_info_list[$j][0]) != 1){
                echo '<td><span style="display: none">'.$personal_info_list[0].'</span>
                        <span style="display: none">'.$personal_info_list[$j][0].'</span><div class="selectdiv select_2" style="min-width: 0px ;float: none;"><select id="new_admit_status'.($j-8).'" style="height: 23px;line-height:20px;">';
                for($n=0;$n<6;$n++){
                    if($n != $personal_info_list[$j][1]) {    //判断默认选择项
                        echo '<option value="'.$n.'">'.$admit_status[$n].'</option>';
                    }else {
                        echo '<option selected="selected" value="'.$personal_info_list[$j][1].'">'.$admit_status[$personal_info_list[$j][1]].'</option>';
                    }
                }
                echo '</select></div></td>';
            }else{
                echo '<td>无状态</td>';
            }
                   }
        echo '</tr></table></div></div>';
    }else if($_SESSION['user_authority']=='ministor'){
        echo '<body>
            <div id="demo">
                <div class="table-responsive-vertical shadow-z-1">
                      <table style="text-align: center"><tr>';
        for ($i = 8; $i < ($dep_num + 8); $i++) {
            echo '<th width="10%" >' . $org_reg_list[$i] . '</th>';
        }
        echo '</tr><tr>';
        $check_dep = array();
        for($j = 9;$j < $dep_num + 9;$j++){
            //检查是否是本部门部长级
            if($personal_info_list[$j][0] == $_SESSION['dep_name']){
                $check_dep[($j-9)] = 1;
            }else{
                $check_dep[($j-9)] = 0;
            }
            // echo '<td data-title="">'.$personal_info_list[$j][0].'</td>';
            echo '<td data-title="">';
                if(strlen($personal_info_list[$j][0]) != 1){
                  echo $personal_info_list[$j][0];
                }else{
                  echo '未选择';
                }
            echo '</td>';
        }
        echo '</tr><tr>';
        for($j = 9;$j < $dep_num + 9;$j++){
            if($check_dep[($j-9)]==1){                       //判断是否为本部门意向,若是,则有权限修改
                echo '<td><span style="display: none">'.$personal_info_list[0].'</span>
                        <span style="display: none">'.$personal_info_list[$j][0].'</span><div class="selectdiv select_2" style="min-width: 0px ;float: none;"><select id="new_admit_status" style="height: 23px;line-height:20px;">';
                for($n=0;$n<6;$n++){
                    if($n != $personal_info_list[$j][1]) {    //判断默认选择项
                        echo '<option value="'.$n.'">'.$admit_status[$n].'</option>';
                    }else {
                        echo '<option selected="selected" value="'.$personal_info_list[$j][1].'">'.$admit_status[$personal_info_list[$j][1]].'</option>';
                    }
                }
                echo '</select></div></td>';
            }else{
                echo '<td>'.$admit_status[$personal_info_list[$j][1]].'</td>';
            }
        }
        echo '</tr></table></div></div>';
    }
}else if($table_type == 'org_itd_dtl_content'){
    $org_itd = $DB->getOrganInfo($org_key)['introduction_detail'];
    echo $org_itd;
}else if($table_type == 'msg_tpl_content'){
    $MSG = new MSGoperate();
    $msg_tpl_id = $_GET['id'];
    $apikey = $DB->getApikey($_SESSION['org_key'])[0];
    $text = $MSG->getMsgModel($apikey,$msg_tpl_id)['tpl_content'];
    echo $text;
}


