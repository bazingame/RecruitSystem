<<<<<<< HEAD
<?php
require_once "config.php";
require_once "db.class.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
$table_type = $_GET['table_type'];
//$org_key = isset($_SESSION['org_key'])?$_SESSION['org_key']:'';
$org_key = isset($_GET['org_key'])?htmlspecialchars($_GET['org_key'],ENT_QUOTES):'';
$dep_name = isset($_GET['dep_name'])?htmlspecialchars($_GET['dep_name'],ENT_QUOTES):'';
$status = isset($_GET['status'])?htmlspecialchars($_GET['status'],ENT_QUOTES):'';
echo'
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/getInfo.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div id="demo">
        <div class="table-responsive-vertical shadow-z-1">';
            //获取组织列表
            if($table_type =='org_list'){
                 $org_list = $DB->getOrganListDetail_r();
                 echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>组织名称</th>
                               <th>key</th>
                               <th>总负责人</th>
                               <th>总负责人学号</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                for($i = 0;$i<count($org_list);$i++){
                    echo '<tr id="id_7">
                        <td data-title="组织名称" id="id_1">'.$org_list[$i]['org_name'].'</td>
                        <td data-title="key" id="id_2">'.$org_list[$i]['org_key'].'</td>
                        <td data-title="负责人" id="id_3">'.$org_list[$i]['admin_name'].'</td>
                        <td data-title="负责人学号" id="id_4">'.$org_list[$i]['admin_sid'].'</td>
                        <td><button class="org_opt_btn org_add_btn org_admin_ctl_btn" type="button" style="width: 100px;margin-right: 20px;">负责人管理</button>
                            <button class="org_opt_btn org_add_btn org_revise_btn" type="button">修改</button>
                          
                    </tr>';
                }
                    echo '</tbody>
                        </table>';
            //获取部门列表
            }else if($table_type =='dep_list'){
                $org_key = $_SESSION['org_key'];
                $dep_list = $DB->getDepList($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th colspan="3"><span style="color: red;float: left">*招新工作正式开始后，请勿随意改动以下内容</span></th>
                            </tr>
                            <tr>
                               <th>部门名称</th>
                               <th>创建时间</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                for($i = 0;$i<count($dep_list);$i++){
                    echo '<tr>
                        <td data-title="部门名称">'.$dep_list[$i]['dep_name'].'</td>
                        <td data-title="创建时间">'.$dep_list[$i]['creat_time'].'</td>
                        <td><span id ="dep_id" style="display:none">'.$dep_list[$i]['Id'].'</span><button class="dep_del_btn org_add_btn org_opt_btn opt_btn_r"  type="button" >删除</button></td>
                    </tr>';
                }
                echo '<thead>
                            <th colspan="5">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="dep_add_btn" type="button">添加</button>
                                </div>
                            </th>
                         </thead></tbody></table>';
            //获取部长列表
            }else if($table_type =='ministor_list'){
                $org_key = $_SESSION['org_key'];
                $ministor_list = $DB->getMinistorList($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>部门名称</th>
                               <th>部长级姓名</th>
                               <th>部长级学号</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                for($i = 0;$i<count($ministor_list);$i++){
                    echo '<tr>
                        <td data-title="部门名称">'.$ministor_list[$i]['dep_name'].'</td>
                        <td data-title="部长名称">'.$ministor_list[$i]['ministor_name'].'</td>
                        <td data-title="部长学号">'.$ministor_list[$i]['ministor_sid'].'</td>
                        <td><span id ="dep_id" style="display:none">'.$ministor_list[$i]['Id'].'</span><button class="ministor_del_btn org_add_btn org_opt_btn opt_btn_r" type="button" >删除</button></td>
                    </tr>';
                }
                echo '<thead>
                            <th colspan="5">
                                <div class="sub-main">
                                <button class="ministor_add_btn org_add_btn" id="ministor_add_btn" type="button">添加</button>
                                </div>
                            </th>
                         </thead></tbody></table>';
            //获取报名人员信息
            }else if($table_type =='personal_info_list'){
                $string = $_GET['string'];
                $dep_num = substr($string,0,1);
                $status = substr($string,1,1);
                $dep_list = $DB->getDepListArr($_SESSION['org_key']);
                if($_SESSION['user_authority']=='admin'){
                    $dep_name = $dep_list[$dep_num];
                }else{
                    $dep_name = $_SESSION['dep_name'];
                }
                $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
                $personal_info_list = $DB->getPersonalInfo($org_key,$dep_name,$status);
                $dep_num = $DB->getDepNum($org_key);
                $org_reg_list = $DB->getOrgRegList($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>No</th>
                               <th width="8%">姓名</th>
                               <th width="6%">性别</th>
                               <th width="10%">院系</th>
                               <th width="10%">专业</th>
                               <th>电话</th>';
                for($i = 8;$i < ($dep_num+8);$i++){
                    echo '<th>'.$org_reg_list[$i].'</th>';
                }
                echo '         <th width="10%">面试记录</th>
                               <th width="10%">操作</th>
                            </tr>
                       </thead>
                       <tbody>';
                if(count($personal_info_list)>0){
                    $info_num = count($personal_info_list[0])-1;
                }
                for($i = 0;$i<count($personal_info_list);$i++){
                    echo '<tr>';
                    echo '<td>'.($i+1).'</td>
                          <td data-title="">'.$personal_info_list[$i][1].'</td>
                          <td data-title="">'.$personal_info_list[$i][2].'</td>
                          <td data-title="">'.$personal_info_list[$i][4].'</td>
                          <td data-title="">'.$personal_info_list[$i][5].'</td>
                          <td data-title="">'.$personal_info_list[$i][6].'</td>';
                    for($j = 9;$j < $dep_num + 9;$j++){
                        echo '<td data-title="">';
                        if(strlen($personal_info_list[$i][$j][0]) != 1){
                          echo $personal_info_list[$i][$j][0];
                        }else{
                          echo '未选择';
                        }
                        echo '</br>'.$admit_status[$personal_info_list[$i][$j][1]].'</td>';
                    }
                    echo '<td data-title="" width="50px">'.$personal_info_list[$i][$info_num].'</td>';
                    echo '<td width="10%">
                            <ul>
                            <span class ="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>
                            <li class="more_info"><a href="javascript:void(0);" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">更多</a></li></br>
                            ';

//                    if($_SESSION['user_authority']=='ministor'){
                        echo '<span id ="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>                                    
                            <li class="status_change"><a href="#" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">状态修改</a></li>';
//                    }
                    echo '</td></tr></ul>';
                }
                echo '</tbody></table>';
            //获取报名表
            }else if($table_type =='register_form'){
                $org_key = $_SESSION['org_key'];
                $register_form = $DB->getOrgRegList($org_key);
                $dep_num = $DB->getDepNum($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th colspan="2"><span style="float: left"><span style="color: red">*招新工作正式开始后，请勿随意改动以下内容</span><span style="color: black">(使用前请详细阅读<a href="help.html" style="display: inline"target="_blank">帮助文档</a>)</span></span></th>
                           </tr>
                           <tr>
                               <th>表单项目</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                echo  '<tr><td data-title="姓名">姓名</td><td>必有项</td></tr>
                       <tr><td data-title="性别">性别</td><td>必有项</td></tr>
                       <tr><td data-title="生日">生日</td><td>必有项</td></tr>
                       <tr><td data-title="学院">学院</td><td>必有项</td></tr>
                       <tr><td data-title="专业">专业</td><td>必有项</td></tr>
                       <tr><td data-title="手机">手机</td><td>必有项</td></tr>
                       <tr><td data-title="qq">qq</td><td>必有项</td></tr>
                       <tr><td data-title="个人简介">个人简介</td><td>必有项</td></tr>';
                echo '<tr><td>意向数目：<select id="dep_num_sel">';
                for($i=1;$i<=4;$i++){
                    if($i == $dep_num){
                        echo '<option value="'.$i.'" selected = "selected">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;选择后点击修改以保存</td>';
                echo '<td><button class="org_opt_btn org_add_btn dep_num_revise_btn" type="button">修改</button></td></tr>';
                for($i = $dep_num + 8;$i<count($register_form);$i++){
                    $register_no = $i-$dep_num-8;
                    echo '<tr><td>'.$register_form[$i].'</td><td><span id ="register_no" style="display:none">'.$register_no.'</span><button class="org_opt_btn org_add_btn register_form_revise_btn" type="button">修改</button><button class="register_form_del_btn org_add_btn org_opt_btn opt_btn_r" type="button" >删除</button></td></tr>';
                }
                echo '<thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn register_form_add_btn" id="register_form_add_btn" type="button">添加</button>
                                </div>
                            </th>
                         </thead></tbody></table>';
            //获取整体介绍
            }else if($table_type =='org_itd'){
                $org_key = $_SESSION['org_key'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>整体介绍</th>
                           </tr>
                       </thead>
                       <tbody>';
                echo  '<tr><td>'.$org_itd['introduction'].'</td></tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_itd_revise_btn" type="button">修改</button>
                                </div>
                            </th>
                         </thead>';
                echo '</tbody></table>';
            //组织添加
            }else if($table_type =='org_add'){
                echo '<form id="org_add_form" action="changeInfo.php?change_type=org_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>组织名称</td><td><input type="text" name="org_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>组织Key</td><td><input type="text" name="org_key" value="" ></td>
                        </tr>
                        <tr>
                           <td>总负责人姓名</td><td><input type="text" name="admin_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>总负责人学号</td><td><input type="text" name="admin_sid" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn org_add_cel_btn" type="button" id="org_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
             //组织负责人管理
            }else if($table_type =='org_admin'){
                $org_key = htmlspecialchars($_GET['org_key'],ENT_QUOTES);
                $admin_list = $DB->getOrgAdmin($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>姓名</th><th>学号</th><th>操作</th>
                      </thead>
                      <tbody>';
                    for($i = 0;$i<count($admin_list);$i++){
                        if($i == 0){
                            echo '<tr><td>'.$admin_list[$i][0].'</td><td>'.$admin_list[$i][1].'</td><td></td></tr>';
                        }else{
                            echo '<tr>
                                  <td>'.$admin_list[$i][0].'</td>
                                  <td>'.$admin_list[$i][1].'</td>
                                  <td><span style="display:none;">'.$admin_list[$i][3].'</span>
                                      <span style="display:none;">'.$admin_list[$i][2].'</span>
                                      <button class="org_add_btn org_opt_btn admin_revise_btn" id="" type="button">修改</button>
                                      <button class=" org_add_btn admin_del_btn org_opt_btn opt_btn_r" type="button" id=""  >删除</button>
                                  </td></tr>';
                        }
                    }
                    echo '<thead>
                            <th colspan="3">
                                <div class="sub-main">
                                <span style="display: none">'.$org_key.'</span>
                                <button class="org_add_btn admin_add_btn" id="" type="button">添加负责人</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn " id="" type="button" onclick="history.go(0);">返回</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>';
             //组织负责人修改
            }else if($table_type =='admin_revise'){
                $id = $_GET['id'];
                $org_key = $_GET['org_key'];
                $admin_info = $DB->getAdmin($id);
                echo '<form id="admin_revise" action="changeInfo.php?change_type=admin_revise&id='.$id.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>';
                        echo '<tr><td>姓名</td>
                                  <td><input type="text" value="'.$admin_info['admin_name'].'" name="admin_name"></td>
                              </tr>
                              <tr><td>学号</td>
                                  <td><input type="text" value="'.$admin_info['admin_sid'].'" name ="admin_sid"></td>
                              </tr>';
                    echo '<thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn admin_add_btn" id="" type="submit">保存</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn admin_add_btn" id="" type="button" onclick="history.go(0)">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table></form>';
             //负责人添加
            }else if($table_type =='admin_add'){
                $org_key = $_GET['org_key'];
                echo '<form id="admin_add" action="changeInfo.php?change_type=admin_add&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>负责人姓名</td><td><input type="text" name="admin_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>负责人学号</td><td><input type="text" name="admin_sid" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="admin_add_btn org_add_btn" id="org_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn admin_add_cel_btn" type="button" id="org_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
             //组织修改
            }else if($table_type == 'org_revise'){
                $org_info = $DB->getOrganInfo($org_key);
                echo '<form id="org_revise_form" action="changeInfo.php?change_type=org_revise&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>组织名称</td><td><input type="text" name="org_name" value='.$org_info['org_name'].' ></td>
                        </tr>
                        <tr>
                           <td>组织Key</td><td><input type="text" name="org_new_key" value='.$org_info['org_key'].' ></td>
                        </tr>
                        <tr>
                           <td>总负责人姓名</td><td><input type="text" name="admin_name" value='.$org_info['admin_name'].' ></td>
                        </tr>
                        <tr>
                           <td>总负责人学号</td><td><input type="text" name="admin_sid" value='.$org_info['admin_sid'].' ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn org_add_cel_btn" type="button" id="org_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
            //修改组织整体介绍
            }else if($table_type == 'org_itd_revise'){
                $org_key = $_SESSION['org_key'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<form id="org_itd_revise_form" action="changeInfo.php?change_type=org_itd_revise&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>整体介绍</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><textarea name="org_introduction"  cols="50" rows="5">'.$org_itd['introduction'].'</textarea></td>
                        </tr>
                        <thead>
                            <th colspan="2" >
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_itd_revise_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn org_itd" type="button" id="org_itd_revise_cel_btn">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //修改详细信息
            }else if($table_type == 'org_itd_dtl'){
                $org_key = $_SESSION['org_key'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<iframe src="orgInfoShow.php" width="1100px" height="850px" frameborder="0"></iframe>';
//                echo '<iframe src="orgInfo.php" width="1100px" height="2000px" frameborder="0"></iframe>';
                //部门删除
            }else if($table_type == 'dep_del'){
                $dep_id = $_GET['dep_id'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<form id="org_itd_revise_form" action="changeInfo.php?change_type=org_itd_revise&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>整体介绍</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="org_introduction" value='.$org_itd['introduction'].'></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_itd_revise_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="org_itd_revise_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //部门添加
            }else if($table_type == 'dep_add'){
                echo '<form id="dep_add_form" >
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>部门名称</td><td><input type="text" name="dep_name" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="dep_add_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn dep_add_cel_btn" type="button" id="dep_add_cel_btn"  >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //部长添加
            }else if($table_type == 'ministor_add'){
                $dep_list = $DB->getDepList($org_key);
                echo '<form id="ministor_add_form" action="changeInfo.php?change_type=ministor_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                        <td>所属部门</td>
                        <td><div class="selectdiv" style="margin: 0 38%;"><select name="dep_id">';
                        for($i = 0;$i < count($dep_list);$i++){
                            echo '<option value="'.$dep_list[$i]['Id'].'">'.$dep_list[$i]['dep_name'].'</option>';
                        }
                echo  '</select></div></td>
                        </tr>
                        <tr>
                           <td>部长姓名</td><td><input type="text" name="ministor_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>部长学号</td><td><input type="text" name="ministor_sid" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="ministor_add_save_btn org_add_btn" id="ministor_add_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn ministor_add_cel_btn" type="button" id="ministor_add_cel_btn"  >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //组织logo
            }else if($table_type == 'org_logo'){
                $logo_address = $DB->getOrganInfo($_SESSION['org_key']);
                $logo_address = $logo_address['logo_path'];
                echo '<form id="org_logo_form" action="uploadImg.php?type=logo" method="post" enctype="multipart/form-data">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>当前LOGO</th><th>修改LOGO</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td align="center" width="151" style="margin:0;padding:0;width:auto;text-align:center;"><div class="org_logo_div" style="background:url(./images/org_logo/' .$logo_address.') no-repeat center center;background-size: cover"></div></td><td align="center" style="margin:0;padding:0;width:auto;text-align:center;"><input class="choose_pic" type="file" name="file" value="" ><p>请上传小于1M的图片(支持png,jpg,jpeg)</p></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_logo_btn org_add_btn" id="org_logo_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn org_logo_cel_btn" type="button" id="org_logo_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //报名表添加
            }else if($table_type == 'register_form_add'){
                echo '<form id="register_form_add">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>表单项目名称</td><td><input type="text" name="register_form_name" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="register_add_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="register_add_cel_btn"  >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //报名表修改
            }else if($table_type == 'register_form_revise'){
                $register_id = $_GET['register_id'];
                $val = $DB->getOrgRegListDef($_SESSION['org_key'],$register_id);
                echo '<form id="register_form_revise" >
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>
                           <input type="hidden" name="register_id" value="'.$register_id.'">
                           <input type="text" name="register_form_name" value="'.$val.'" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="register_revise_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="register_revise_cel_btn">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //导出excel
            }else if($table_type =='toExcel'){
                $dep_list = $DB->getDepList($_SESSION['org_key']);
                if($_SESSION['user_authority'] == 'admin'){
                    echo '<form id="toExcel" action="toexcel.php" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>导出范围</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><div class="selectdiv" style="margin: 0 43%;"><select name="dep_name">';
                            echo '<option value="0">所有部门</option>';
                        for($i = 0;$i < count($dep_list);$i++){
                            echo '<option value="'.$dep_list[$i]['dep_name'].'">'.$dep_list[$i]['dep_name'].'</option>';
                        }
                    echo'</select></div></td>
                        </tr>
                        <tr>
                           <td><div class="selectdiv" style="margin: 0 43%;"><select name = "status">
                               <option value ="0">全部人员</option>
                               <option value ="1">初试通过</option>
                               <option value ="2">初试淘汰</option>
                               <option value ="3">复试通过</option>
                               <option value ="4">复试淘汰</option>
                               <option value ="5">正式受聘</option>
                         </select></div></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn toExce_btn" id="" type="submit">导出</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }else if($_SESSION['user_authority'] == 'ministor'){
                    echo '<form id="toExcel" action="toexcel.php" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>导出范围</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><div class="selectdiv"><select name="dep_name"><option value="'.$_SESSION['dep_name'].'">'.$_SESSION['dep_name'].'</option></select></div></td>
                        </tr>
                        <tr>
                           <td><div class="selectdiv"><select name = "status">
                               <option value ="0">全部人员</option>
                               <option value ="1">初试通过</option>
                               <option value ="2">初试淘汰</option>
                               <option value ="3">复试通过</option>
                               <option value ="4">复试淘汰</option>
                               <option value ="5">正式受聘</option>
                         </select></div></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn toExce_btn" id="" type="submit">导出</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //数据统计表单
            }else if($table_type =='data_count'){
                $dep_list = $DB->getDepList($_SESSION['org_key']);
                $register_way_count = $DB->countRegisterWay($_SESSION['org_key']);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>部门名称</th>
                               <th>全部人员</th>
                               <th>无状态</th>
                               <th>通过初试</th>
                               <th>初试淘汰</th>
                               <th>通过复试</th>
                               <th>复试淘汰</th>
                               <th>正式受聘</th>
                           </tr>     
                       </thead>
                       <tbody>';
                if($_SESSION['user_authority'] == 'admin'){
                    for($i = 0;$i < count($dep_list);$i++){
                        $register_count = $DB->countRegister($_SESSION['org_key'],$dep_list[$i]['dep_name']);
                        echo '<tr><td>'.$dep_list[$i]['dep_name'].'</td>
                                  <td>'.$register_count[0].'</td>
                                  <td>'.$register_count[1].'</td>
                                  <td>'.$register_count[2].'</td>
                                  <td>'.$register_count[3].'</td>
                                  <td>'.$register_count[4].'</td>
                                  <td>'.$register_count[5].'</td>
                                  <td>'.$register_count[6].'</td>
                                  </tr>';
                    }
                    echo '<tr><td>报名表来源</td><td colspan="2">PC端:'.$register_way_count['PC'].'</td><td colspan="2">移动端：'.$register_way_count['PHONE'].'</td><td colspan="3">总人数：'.($register_way_count['PC']+$register_way_count['PHONE']).'</td></tr></tbody></table>';
                }else if($_SESSION['user_authority'] == 'ministor'){
                        $register_count = $DB->countRegister($_SESSION['org_key'],$_SESSION['dep_name']);
                        echo '<tr><td>'.$_SESSION['dep_name'].'</td>
                                <td>'.$register_count[0].'</td>
                                <td>'.$register_count[1].'</td>
                                <td>'.$register_count[2].'</td>
                                <td>'.$register_count[3].'</td>
                                <td>'.$register_count[4].'</td>
                                <td>'.$register_count[5].'</td>
                                <td>'.$register_count[6].'</td>
                              </tr></tbody></table>';
                }
                //搜索结果表单
            }else if($table_type == 'search'){
                $like = $_POST['search_content'];
                $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
                if($_SESSION['user_authority']=='admin'){
                    $personal_info_list = $DB->search($_SESSION['org_key'],0,$like);
                }else{
                    $personal_info_list = $DB->search($_SESSION['org_key'],$_SESSION['dep_name'],$like);
                }
                $dep_num = $DB->getDepNum($_SESSION['org_key']);
                $org_reg_list = $DB->getOrgRegList($_SESSION['org_key']);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr><th>No</th>
                               <th>姓名</th>
                               <th>性别</th>
                               <th>院系</th>
                               <th>专业</th>
                               <th>电话</th>';
                for($i = 8;$i < ($dep_num+8);$i++){
                    echo '<th>'.$org_reg_list[$i].'</th>';
                }
                echo '         <th width="12%">面试记录</th>
                               <th width="10%">操作</th>
                            </tr>
                       </thead>
                       <tbody>';
                if(count($personal_info_list)>0){
                    $info_num = count($personal_info_list[0])-1;
                }
                for($i = 0;$i<count($personal_info_list);$i++){
                    echo '<tr>';
                    echo '<td>'.($i+1).'</td>
                          <td data-title="">'.$personal_info_list[$i][1].'</td>
                          <td data-title="">'.$personal_info_list[$i][2].'</td>
                          <td data-title="">'.$personal_info_list[$i][4].'</td>
                          <td data-title="">'.$personal_info_list[$i][5].'</td>
                          <td data-title="">'.$personal_info_list[$i][6].'</td>';
                    for($j = 9;$j < $dep_num + 9;$j++){
                         echo '<td data-title="">';
                        if(strlen($personal_info_list[$i][$j][0]) != 1){
                          echo $personal_info_list[$i][$j][0];
                        }else{
                          echo '未选择';
                        }
                        echo '</br>'.$admit_status[$personal_info_list[$i][$j][1]].'</td>';
                    }
                    echo '<td data-title="">'.$personal_info_list[$i][$info_num].'</td>';
                    echo '<td><ul>
                             <span class="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>
                             <li class="more_info"><a href="#" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">更多</a></li></br>';
                    echo '<span id ="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>                                    
                            <li class="status_change"><a href="#" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">状态修改</a></li>';
                     echo '</td></tr></ul>';
                }
                echo '</tbody></table>';
                //短信管理
            }else if($table_type == 'message_manage'){
                include_once "MSGoperate.php";
                $MSG = new MSGoperate();
                $api_key = $DB->getApikey($_SESSION['org_key'])[0];
                if($api_key != ''){
                    $tpl = $MSG->getMsgModel($api_key,'');
                    echo '<table id="table" class="table table-hover table-bordered table-striped">
                        <thead>
                                 <tr><th colspan="4"><span style="float: left"><span style="color: red;"></span><span style="color: black">(使用前请详细阅读<a href="help.html" style="display: inline"target="_blank">帮助文档</a>)</span></span></th>
                                </tr>
                            </thead>
                        <thead>
                        <th colspan="2">APIKEY:<span id = "api_key_span">'.$api_key.'</span></th><th colspan="2"><div class="sub-main">
                                <button class="apikey_revise_btn org_add_btn org_opt_btn" id="apikey_revise_btn" type="button" style="margin-left: -40px">修改KEY</button>
                                </div>
                                <div class="sub-main">
                                <button class="model_add_btn org_add_btn org_opt_btn " id="model_add_btn" type="button" style="width: 100px">添加短信模板</button>
                                </div>
                                </th>
                        </thead>
                        <tbody>
                        <tr><td colspan ="1">已有模板ID</td><td>模板内容</td><td colspan ="1">审核状态</td><td>操作</td></tr>';
                        for($i = 0;$i < count($tpl);$i++){
                            echo '<tr><td>'.$tpl[$i]['tpl_id'].'</td><td>'.$tpl[$i]['tpl_content'].'</td><td>';
                                if($tpl[$i]['check_status']=='SUCCESS'){
                                    echo 'SUCCESS';
                                }else{
                                    echo $tpl[$i]['reason'];
                                }
                                echo '</td><td><span style="display: none">'.$tpl[$i]['tpl_id'].'</span><button class="model_del_btn org_add_btn org_opt_btn" id="model_del_btn" type="button">删除</button></td></tr>';
                        }
                       echo '
                      </tbody>
                        </table>';
                }else{
                    echo '<form id="apikey_add_form" action="changeInfo.php?change_type=api_key_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>请先添加APIKEY</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="apikey" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="apikey_add_btn org_add_btn" id="apikey_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn apikey_add_cel_btn" type="button" id="apikey_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //回复列表
            }else if($table_type == 'reply_list'){
                include_once "MSGoperate.php";
                $MSG = new MSGoperate();
                $api_key = $DB->getApikey($_SESSION['org_key'])[0];
                if($api_key != ''){
                    $tpl = $MSG->getMsgModel($api_key,'');
                    $reply_list = $DB->getReplyList($_SESSION['org_key']);
                    echo '<table id="table" class="table table-hover table-bordered table-striped">
                        <thead>
                        <th width="10%">No.</th><th>姓名</th><th>电话</th><th>回复内容</th><th>时间</th>
                        </thead>
                        <tbody>';
                    for ($i = 0;$i < count($reply_list);$i++){
                        echo '<tr><td>'.($i+1).'</td>
                              <td>'.$reply_list[$i]['name'].'</td>
                              <td>'.$reply_list[$i]['mobile'].'</td>
                              <td>'.$reply_list[$i]['text'].'</td>
                              <td>'.$reply_list[$i]['reply_time'].'</td></tr>';
                    }
                    echo '
                      </tbody>
                        </table>';
                }else{
                    echo '<form id="apikey_add_form" action="changeInfo.php?change_type=api_key_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>请先添加APIKEY</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="apikey" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="apikey_add_btn org_add_btn" id="apikey_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn apikey_add_cel_btn" type="button" id="apikey_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //短信发送
            }else if($table_type == 'message_send'){
                include_once "MSGoperate.php";
                $MSG = new MSGoperate();
                $org_key = $_SESSION['org_key'];
                $api_key = $DB->getApikey($org_key)[0];
                if($api_key != ''){
                    $dep_list = $DB->getDepList($org_key);
                    $tpl = $MSG->getMsgModel($api_key,'');
                    echo '<form id="message_send_form" action="msg.php" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped">
                            <thead>
                                 <tr><th colspan="4"><span style="float: left"><span style="color: red;">*谨慎操作，请确认信息无误后发送</span><span style="color: black">(使用前请详细阅读<a href="help.html" style="display: inline"target="_blank">帮助文档</a>)</span></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td width="32%" style="text-align: left">选择部门：</td><td colspan ="1" style="text-align: left">
                                <div class="selectdiv">
                                <select name="dep_name" id="dep_name_select">';
                    //判断权限及部门类别
                    if($_SESSION['user_authority']=='admin'){
                        echo '<option value="0">所有部门</option>';
                        for($i = 0;$i < count($dep_list);$i++){
                            echo '<option value="'.$dep_list[$i]['dep_name'].'">'.$dep_list[$i]['dep_name'].'</option>';
                        }
                    }else if($_SESSION['user_authority']=='ministor'){
                        echo '<option value="'.$_SESSION['dep_name'].'">'.$_SESSION['dep_name'].'</option>';
                    }
                    $default_num = $DB->getNum($_SESSION['org_key'],0,0);
                    echo  '</select></div></td>
                            <td width="32%" style="text-align: left">选择状态:</td>
                            <td style="text-align: left">
                            <div class="selectdiv">
                               <select name="status" id="status_select">
                                    <option value = "0" selected="selected">全部人员</option>
                                    <option value = "1">通过初试</option>
                                    <option value = "2">初试淘汰</option>
                                    <option value = "3">通过复试</option>
                                    <option value = "4">复试淘汰</option>
                                    <option value = "5">正式受聘</option>
                                </select> </div>
                            </td></tr>
                            <td style="text-align: left">选择人员序号(共<span style="color:red;" id="selected_num">'.$default_num.'</span>人):<br><span style="font-size: 12px">(不输入默认为全体)</span></td>
                            <td><input style="width: 65px;height:25px" type="text" id="no_start" name="no_start"> -- <input style="width: 65px;height:25px" type="text" id="no_end" name="no_end"></td>
                            <td colspan="1" style="text-align: left">选择模板 (请在短信管理界面查看相关模板的编号)</td><td colspan="1" style="text-align: left"><div class="selectdiv"><select name ="msg_tpl_id" id="msg_tpl_id_select">';
                    echo '<option value="">请选择模板</option>';
                    for($i = 0;$i < count($tpl);$i++) {
                        if ($tpl[$i]['check_status'] == 'SUCCESS') {
                            echo '<option value="' . $tpl[$i]['tpl_id'] . '">' . $tpl[$i]['tpl_id'] . '</option>';
                        }
                    }
                    echo '</select></div></td></tr>';
                    echo '<tr>
                            <td colspan="4" style="text-align: left"><span>模板内容:</span><span id="msg_model_content"></span></td>
                          </tr>';
                    echo '<thead>
                                <th colspan="4"> 
                                    <div class="sub-main">
                                    <button class="org_add_btn" id="msg_confirm" type="button">发送短信</button>
                                    </div>
                                    <div class="sub-main">
                                    <button class="msg_history_btn org_add_btn" id="msg_history_btn" type="button">短信发送历史</button>
                                    </div>
                                </th>
                             </thead>
                          </tbody>
                        </table>
                        </form>';
                }else{
                    echo '<form id="apikey_add_form" action="changeInfo.php?change_type=api_key_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>请先添加APIKEY</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="apikey" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="apikey_add_btn org_add_btn" id="apikey_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn apikey_add_cel_btn" type="button" id="apikey_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //apikey修改
            }else if($table_type == 'api_key_revise'){
                $org_key = $_SESSION['org_key'];
                $api_key = $DB->getApikey($org_key)[0];
                echo '<form id="api_key_revise_form" xmlns="http://www.w3.org/1999/html">
                        <table id="api_key_revise_table" class="table table-hover table-bordered table-striped"><thead>
                        <th>APIKEY修改</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="new_apikey" value=' .$api_key.'></td>
                        </tr>
                        <tr>
                           <td style="text-align: 
                           left"><p>请在<a target="_blank" href="https://www.yunpian.com/dashboard/config/system#!/config/system/statusInboundSmsConf" style="display:inline;">云片后台——设置——系统设置——数据推送与获取</a>，将数据获取开关开启，并在 数据推送中更改如下内容，否则无法查看短信回复及状态短信状态</br>报告推送地址：http://zx.sky31.com/msgstatus/sky31</br>上行短信推送地址：https://zx.sky31.com/2017/admin/msgreply.php?org_key='.$_SESSION['org_key'].'</p></br>详情请见<a href="help.html" target="_blank"><b>帮助文档-短信平台说明</b></a></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn " id="api_key_revise_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="api_key_revise_cel_btn">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //短信模板添加
            }else if($table_type == 'msg_model_add'){
                $api_key = $_GET['apikey'];
                echo '<form id="msg_model_add_form" action="changeInfo.php?change_type=msg_model_add&api_key='.$api_key.'" method="post">
                        <table id="msg_model_add_table" class="table table-hover table-bordered table-striped"><thead>
                        <th>短信模板添加</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><textarea name="new_model" cols="50" rows="5"></textarea></td>
                        </tr>
                        <tr>
                           <td style="text-align: 
                           left"><p>1.模板头部必须为已审核通过的短信签名</br>2.短信模板中的变量目前支持部门（#department#）和姓名(#name#)两个，在发送短信时，系统会自动替换为报名的部门及收信人的姓名</br>3.模板请勿重复，否则会添加不成功</br>如使用以下模板：</br>【三翼工作室】亲爱的#name#你好，欢迎报名三翼工作室的#department#，请于9月10日在兴湘B栋101初试[收到请回复姓名]</br>若收信人的姓名为张三，部门为技术开发部，那么，其收到短信时内容为：<br>
【三翼工作室】亲爱的张三你好，欢迎报名三翼工作室的技术开发部，请于9月10日在兴湘B栋101初试[收到请回复姓名]</br></br><b>敬告：短信模板是由云片网人工审核，审核时间为9:00 ~ 23:00 ，另外，一条短信存在字数限制，一条以70个字计算，多条以67个字计算，均包含签名字数，具体由最终发送内容决定，添加模板时请把握好字数</b></p></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="model_add_btn org_add_btn" id="" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn " type="button" id="model_add_cel_btn" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
             </tbody>       </table>
                    </form>';
            //短信历史
            }else if($table_type =='msg_history'){
                $admit_status = array('全部人员','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
                $history = $DB->getMsgHitory($_SESSION['org_key']);
                echo '<table id="msg_history_table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>No.</th>
                               <th>发送时间</th>
                               <th>模板Id</th>
                               <th>部门</th>
                               <th>状态</th>
                               <th>人员序号</th>
                               <th>发送人数</th>
                               <th>成功人数</th>
                               <th>失败人数</th>
                               <th>失败详情</th>
                           </tr>     
                       </thead>
                       <tbody>';
                    for($i = 0;$i < count($history);$i++){
                        $j = $i+1;
                        if(!$history[$i]['dep_name']){
                            $history[$i]['dep_name'] = '所有部门';
                        }
                        echo '<tr><td>'.$j.'</td>
                                  <td>'.$history[$i]['send_time'].'</td>
                                  <td>'.$history[$i]['msg_tpl_id'].'</td>
                                  <td>'.$history[$i]['dep_name'].'</td>
                                  <td>'.$admit_status[$history[$i]['status']].'</td>
                                  <td>'.$history[$i]['no_start'].'--'.$history[$i]['no_end'].'</td>
                                  <td>'.$history[$i]['sum'].'</td>
                                  <td>'.$history[$i]['success'].'</td>
                                  <td>'.$history[$i]['fail'].'</td>
                                  <td><span id ="fail_detail" style="display:none">'.json_encode($history[$i]['fail_detail'],JSON_UNESCAPED_UNICODE).'</span>';
                        if($history[$i]['fail']>0){
                            echo '<button class="org_add_btn fail_detail" type="button">查看</button>';
                        }else{
                            echo '<button class="org_add_btn " type="button">无</button>';
                        }
                        echo '</td></tr>';
                    }
                    echo '</tbody></table>';
                //短信发送失败历史记录
            }else if($table_type =='msg_history_fail_detail'){
                $fail_detail = json_decode($_POST['fail_detail'],true);
                echo '<table id="msg_history_table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>姓名</th>
                               <th>使用模板Id</th>
                               <th>手机</th>
                               <th>详情</th>
                           </tr>     
                       </thead>
                       <tbody>';
                for($i = 0;$i < count($fail_detail);$i++){
                    echo '<tr><td>'.$fail_detail[$i][0].'</td>
                              <td>'.$fail_detail[$i][1].'</td>
                              <td>'.$fail_detail[$i][2].'</td>
                              <td>'.$fail_detail[$i][3].'</td>
                          </tr>';
                }
                echo '</tbody></table>';
            }
echo '</div>
    </div>';

             if($table_type != 'org_itd_dtl_revise' ){
                   echo '<script src="./js/jquery-3.2.1.min.js"></script><script src="js/getinfo.js"></script>';
               }else{
                   echo '<script src="js/getinfo.js"></script>';
             }
echo'</body></html>';
=======
<?php
require_once "config.php";
require_once "db.class.php";
session_start();
header("Content-Type: text/html; charset=UTF-8");
$table_type = $_GET['table_type'];
//$org_key = isset($_SESSION['org_key'])?$_SESSION['org_key']:'';
$org_key = isset($_GET['org_key'])?htmlspecialchars($_GET['org_key'],ENT_QUOTES):'';
$dep_name = isset($_GET['dep_name'])?htmlspecialchars($_GET['dep_name'],ENT_QUOTES):'';
$status = isset($_GET['status'])?htmlspecialchars($_GET['status'],ENT_QUOTES):'';
echo'
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/getInfo.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div id="demo">
        <div class="table-responsive-vertical shadow-z-1">';
            //获取组织列表
            if($table_type =='org_list'){
                 $org_list = $DB->getOrganListDetail_r();
                 echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>组织名称</th>
                               <th>key</th>
                               <th>总负责人</th>
                               <th>总负责人学号</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                for($i = 0;$i<count($org_list);$i++){
                    echo '<tr id="id_7">
                        <td data-title="组织名称" id="id_1">'.$org_list[$i]['org_name'].'</td>
                        <td data-title="key" id="id_2">'.$org_list[$i]['org_key'].'</td>
                        <td data-title="负责人" id="id_3">'.$org_list[$i]['admin_name'].'</td>
                        <td data-title="负责人学号" id="id_4">'.$org_list[$i]['admin_sid'].'</td>
                        <td><button class="org_opt_btn org_add_btn org_admin_ctl_btn" type="button" style="width: 100px;margin-right: 20px;">负责人管理</button>
                            <button class="org_opt_btn org_add_btn org_revise_btn" type="button">修改</button>
                            <button class="opt_btn_r org_add_btn org_opt_btn org_del_btn" type="button" >删除</button></td>
                    </tr>';
                }
                    echo '</tbody>
                        </table>';
            //获取部门列表
            }else if($table_type =='dep_list'){
                $org_key = $_SESSION['org_key'];
                $dep_list = $DB->getDepList($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th colspan="3"><span style="color: red;float: left">*招新工作正式开始后，请勿随意改动以下内容</span></th>
                            </tr>
                            <tr>
                               <th>部门名称</th>
                               <th>创建时间</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                for($i = 0;$i<count($dep_list);$i++){
                    echo '<tr>
                        <td data-title="部门名称">'.$dep_list[$i]['dep_name'].'</td>
                        <td data-title="创建时间">'.$dep_list[$i]['creat_time'].'</td>
                        <td><span id ="dep_id" style="display:none">'.$dep_list[$i]['Id'].'</span><button class="dep_del_btn org_add_btn org_opt_btn opt_btn_r"  type="button" >删除</button></td>
                    </tr>';
                }
                echo '<thead>
                            <th colspan="5">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="dep_add_btn" type="button">添加</button>
                                </div>
                            </th>
                         </thead></tbody></table>';
            //获取部长列表
            }else if($table_type =='ministor_list'){
                $org_key = $_SESSION['org_key'];
                $ministor_list = $DB->getMinistorList($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>部门名称</th>
                               <th>部长级姓名</th>
                               <th>部长级学号</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                for($i = 0;$i<count($ministor_list);$i++){
                    echo '<tr>
                        <td data-title="部门名称">'.$ministor_list[$i]['dep_name'].'</td>
                        <td data-title="部长名称">'.$ministor_list[$i]['ministor_name'].'</td>
                        <td data-title="部长学号">'.$ministor_list[$i]['ministor_sid'].'</td>
                        <td><span id ="dep_id" style="display:none">'.$ministor_list[$i]['Id'].'</span><button class="ministor_del_btn org_add_btn org_opt_btn opt_btn_r" type="button" >删除</button></td>
                    </tr>';
                }
                echo '<thead>
                            <th colspan="5">
                                <div class="sub-main">
                                <button class="ministor_add_btn org_add_btn" id="ministor_add_btn" type="button">添加</button>
                                </div>
                            </th>
                         </thead></tbody></table>';
            //获取报名人员信息
            }else if($table_type =='personal_info_list'){
                $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
                $personal_info_list = $DB->getPersonalInfo($org_key,$dep_name,$status);
                $dep_num = $DB->getDepNum($org_key);
                $org_reg_list = $DB->getOrgRegList($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th width="8%">姓名</th>
                               <th width="6%">性别</th>
                               <th width="10%">院系</th>
                               <th width="10%">专业</th>
                               <th>电话</th>';
                for($i = 8;$i < ($dep_num+8);$i++){
                    echo '<th>'.$org_reg_list[$i].'</th>';
                }
                echo '         <th width="10%">面试记录</th>
                               <th width="10%">操作</th>
                            </tr>
                       </thead>
                       <tbody>';
                if(count($personal_info_list)>0){
                    $info_num = count($personal_info_list[0])-1;
                }
                for($i = 0;$i<count($personal_info_list);$i++){
                    echo '<tr>';
                    echo '<td data-title="">'.$personal_info_list[$i][1].'</td>
                          <td data-title="">'.$personal_info_list[$i][2].'</td>
                          <td data-title="">'.$personal_info_list[$i][4].'</td>
                          <td data-title="">'.$personal_info_list[$i][5].'</td>
                          <td data-title="">'.$personal_info_list[$i][6].'</td>';
                    for($j = 9;$j < $dep_num + 9;$j++){
                        echo '<td data-title="">';
                        if(strlen($personal_info_list[$i][$j][0]) != 1){
                          echo $personal_info_list[$i][$j][0];
                        }else{
                          echo '未选择';
                        }
                        echo '</br>'.$admit_status[$personal_info_list[$i][$j][1]].'</td>';
                    }
                    echo '<td data-title="" width="50px">'.$personal_info_list[$i][$info_num].'</td>';
                    echo '<td width="10%">
                            <ul>
                            <span id ="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>
                            <li class="more_info"><a href="javascript:void(0);" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">更多</a></li></br>
                            <span id ="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>                                    <li class="status_change"><a  style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">状态修改</a></li>
                          </td></tr></ul>';
                }
                echo '</tbody></table>';
            //获取报名表
            }else if($table_type =='register_form'){
                $org_key = $_SESSION['org_key'];
                $register_form = $DB->getOrgRegList($org_key);
                $dep_num = $DB->getDepNum($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th colspan="2"><span style="color: red;float: left">*招新工作正式开始后，请勿随意改动以下内容</span></th>
                           </tr>
                           <tr>
                               <th>表单项目</th>
                               <th>操作</th>
                           </tr>
                       </thead>
                       <tbody>';
                echo  '<tr><td data-title="姓名">姓名</td><td>必有项</td></tr>
                       <tr><td data-title="性别">性别</td><td>必有项</td></tr>
                       <tr><td data-title="生日">生日</td><td>必有项</td></tr>
                       <tr><td data-title="学院">学院</td><td>必有项</td></tr>
                       <tr><td data-title="专业">专业</td><td>必有项</td></tr>
                       <tr><td data-title="手机">手机</td><td>必有项</td></tr>
                       <tr><td data-title="qq">qq</td><td>必有项</td></tr>
                       <tr><td data-title="个人简介">个人简介</td><td>必有项</td></tr>';
                echo '<tr><td>意向数目：<select id="dep_num_sel">';
                for($i=1;$i<=4;$i++){
                    if($i == $dep_num){
                        echo '<option value="'.$i.'" selected = "selected">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;选择后点击修改以保存</td>';
                echo '<td><button class="org_opt_btn org_add_btn dep_num_revise_btn" type="button">修改</button></td></tr>';
                for($i = $dep_num + 8;$i<count($register_form);$i++){
                    $register_no = $i-$dep_num-8;
                    echo '<tr><td>'.$register_form[$i].'</td><td><span id ="register_no" style="display:none">'.$register_no.'</span><button class="org_opt_btn org_add_btn register_form_revise_btn" type="button">修改</button><button class="register_form_del_btn org_add_btn org_opt_btn opt_btn_r" type="button" >删除</button></td></tr>';
                }
                echo '<thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn register_form_add_btn" id="register_form_add_btn" type="button">添加</button>
                                </div>
                            </th>
                         </thead></tbody></table>';
            //获取整体介绍
            }else if($table_type =='org_itd'){
                $org_key = $_SESSION['org_key'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>整体介绍</th>
                           </tr>
                       </thead>
                       <tbody>';
                echo  '<tr><td>'.$org_itd['introduction'].'</td></tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_itd_revise_btn" type="button">修改</button>
                                </div>
                            </th>
                         </thead>';
                echo '</tbody></table>';
            //组织添加
            }else if($table_type =='org_add'){
                echo '<form id="org_add_form" action="changeInfo.php?change_type=org_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>组织名称</td><td><input type="text" name="org_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>组织Key</td><td><input type="text" name="org_key" value="" ></td>
                        </tr>
                        <tr>
                           <td>总负责人姓名</td><td><input type="text" name="admin_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>总负责人学号</td><td><input type="text" name="admin_sid" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn org_add_cel_btn" type="button" id="org_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
             //组织负责人管理
            }else if($table_type =='org_admin'){
                $org_key = htmlspecialchars($_GET['org_key'],ENT_QUOTES);
                $admin_list = $DB->getOrgAdmin($org_key);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>姓名</th><th>学号</th><th>操作</th>
                      </thead>
                      <tbody>';
                    for($i = 0;$i<count($admin_list);$i++){
                        if($i == 0){
                            echo '<tr><td>'.$admin_list[$i][0].'</td><td>'.$admin_list[$i][1].'</td><td></td></tr>';
                        }else{
                            echo '<tr>
                                  <td>'.$admin_list[$i][0].'</td>
                                  <td>'.$admin_list[$i][1].'</td>
                                  <td><span style="display:none;">'.$admin_list[$i][3].'</span>
                                      <span style="display:none;">'.$admin_list[$i][2].'</span>
                                      <button class="org_add_btn org_opt_btn admin_revise_btn" id="" type="button">修改</button>
                                      <button class=" org_add_btn admin_del_btn org_opt_btn opt_btn_r" type="button" id=""  >删除</button>
                                  </td></tr>';
                        }
                    }
                    echo '<thead>
                            <th colspan="3">
                                <div class="sub-main">
                                <span style="display: none">'.$org_key.'</span>
                                <button class="org_add_btn admin_add_btn" id="" type="button">添加负责人</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn " id="" type="button" onclick="history.go(0);">返回</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>';
             //组织负责人修改
            }else if($table_type =='admin_revise'){
                $id = $_GET['id'];
                $org_key = $_GET['org_key'];
                $admin_info = $DB->getAdmin($id);
                echo '<form id="admin_revise" action="changeInfo.php?change_type=admin_revise&id='.$id.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>';
                        echo '<tr><td>姓名</td>
                                  <td><input type="text" value="'.$admin_info['admin_name'].'" name="admin_name"></td>
                              </tr>
                              <tr><td>学号</td>
                                  <td><input type="text" value="'.$admin_info['admin_sid'].'" name ="admin_sid"></td>
                              </tr>';
                    echo '<thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn admin_add_btn" id="" type="submit">保存</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn admin_add_btn" id="" type="button" onclick="history.go(0)">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table></form>';
             //负责人添加
            }else if($table_type =='admin_add'){
                $org_key = $_GET['org_key'];
                echo '<form id="admin_add" action="changeInfo.php?change_type=admin_add&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>负责人姓名</td><td><input type="text" name="admin_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>负责人学号</td><td><input type="text" name="admin_sid" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="admin_add_btn org_add_btn" id="org_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn admin_add_cel_btn" type="button" id="org_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
             //组织修改
            }else if($table_type == 'org_revise'){
                $org_info = $DB->getOrganInfo($org_key);
                echo '<form id="org_revise_form" action="changeInfo.php?change_type=org_revise&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>组织名称</td><td><input type="text" name="org_name" value='.$org_info['org_name'].' ></td>
                        </tr>
                        <tr>
                           <td>组织Key</td><td><input type="text" name="org_new_key" value='.$org_info['org_key'].' ></td>
                        </tr>
                        <tr>
                           <td>总负责人姓名</td><td><input type="text" name="admin_name" value='.$org_info['admin_name'].' ></td>
                        </tr>
                        <tr>
                           <td>总负责人学号</td><td><input type="text" name="admin_sid" value='.$org_info['admin_sid'].' ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn org_add_cel_btn" type="button" id="org_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
            //修改组织整体介绍
            }else if($table_type == 'org_itd_revise'){
                $org_key = $_SESSION['org_key'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<form id="org_itd_revise_form" action="changeInfo.php?change_type=org_itd_revise&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>整体介绍</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><textarea name="org_introduction"  cols="50" rows="5">'.$org_itd['introduction'].'</textarea></td>
                        </tr>
                        <thead>
                            <th colspan="2" >
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_itd_revise_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn org_itd" type="button" id="org_itd_revise_cel_btn">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //修改详细信息
            }else if($table_type == 'org_itd_dtl'){
                $org_key = $_SESSION['org_key'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<iframe src="orgInfoShow.php" width="1100px" height="850px" frameborder="0"></iframe>';
//                echo '<iframe src="orgInfo.php" width="1100px" height="2000px" frameborder="0"></iframe>';
                //部门删除
            }else if($table_type == 'dep_del'){
                $dep_id = $_GET['dep_id'];
                $org_itd = $DB->getOrganInfo($org_key);
                echo '<form id="org_itd_revise_form" action="changeInfo.php?change_type=org_itd_revise&org_key='.$org_key.'" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>整体介绍</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="org_introduction" value='.$org_itd['introduction'].'></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn" id="org_itd_revise_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="org_itd_revise_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //部门添加
            }else if($table_type == 'dep_add'){
                echo '<form id="dep_add_form" action="changeInfo.php?change_type=dep_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>部门名称</td><td><input type="text" name="dep_name" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="dep_add_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn dep_add_cel_btn" type="button" id="dep_add_cel_btn"  >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //部长添加
            }else if($table_type == 'ministor_add'){
                $dep_list = $DB->getDepList($org_key);
                echo '<form id="ministor_add_form" action="changeInfo.php?change_type=ministor_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                        <td>所属部门</td>
                        <td><div class="selectdiv" style="margin: 0 38%;"><select name="dep_id">';
                        for($i = 0;$i < count($dep_list);$i++){
                            echo '<option value="'.$dep_list[$i]['Id'].'">'.$dep_list[$i]['dep_name'].'</option>';
                        }
                echo  '</select></div></td>
                        </tr>
                        <tr>
                           <td>部长姓名</td><td><input type="text" name="ministor_name" value="" ></td>
                        </tr>
                        <tr>
                           <td>部长学号</td><td><input type="text" name="ministor_sid" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="ministor_add_save_btn org_add_btn" id="ministor_add_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn ministor_add_cel_btn" type="button" id="ministor_add_cel_btn"  >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //组织logo
            }else if($table_type == 'org_logo'){
                $logo_address = $DB->getOrganInfo($_SESSION['org_key']);
                $logo_address = $logo_address['logo_path'];
                echo '<form id="org_logo_form" action="uploadImg.php?type=logo" method="post" enctype="multipart/form-data">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>当前LOGO</th><th>修改LOGO</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td align="center" width="151" style="margin:0;padding:0;width:auto;text-align:center;"><div class="org_logo_div" style="background:url(./images/org_logo/' .$logo_address.') no-repeat center center;background-size: cover"></div></td><td align="center" style="margin:0;padding:0;width:auto;text-align:center;"><input class="choose_pic" type="file" name="file" value="" ><p>请上传小于1M的图片(支持png,jpg,jpeg)</p></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_logo_btn org_add_btn" id="org_logo_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn org_logo_cel_btn" type="button" id="org_logo_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //报名表添加
            }else if($table_type == 'register_form_add'){
                echo '<form id="register_form_add" action="changeInfo.php?change_type=register_form_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th><th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>表单项目名称</td><td><input type="text" name="register_form_name" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="register_add_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="register_add_cel_btn"  >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //报名表修改
            }else if($table_type == 'register_form_revise'){
                $register_id = $_GET['register_id'];
                $val = $DB->getOrgRegListDef($_SESSION['org_key'],$register_id);
                echo '<form id="register_form_revise" action="changeInfo.php?change_type=register_form_revise" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>项目</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td>
                           <input type="hidden" name="register_id" value="'.$register_id.'">
                           <input type="text" name="register_form_name" value="'.$val.'" ></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn" id="register_revise_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="register_revise_cel_btn">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //导出excel
            }else if($table_type =='toExcel'){
                $dep_list = $DB->getDepList($_SESSION['org_key']);
                if($_SESSION['user_authority'] == 'admin'){
                    echo '<form id="toExcel" action="toexcel.php" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>导出范围</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><div class="selectdiv" style="margin: 0 43%;"><select name="dep_name">';
                        for($i = 0;$i < count($dep_list);$i++){
                            echo '<option value="'.$dep_list[$i]['dep_name'].'">'.$dep_list[$i]['dep_name'].'</option>';
                        }
                    echo'</select></div></td>
                        </tr>
                        <tr>
                           <td><div class="selectdiv" style="margin: 0 43%;"><select name = "status">
                               <option value ="0">全部人员</option>
                               <option value ="1">初试通过</option>
                               <option value ="2">初试淘汰</option>
                               <option value ="3">复试通过</option>
                               <option value ="4">复试淘汰</option>
                               <option value ="5">正式受聘</option>
                         </select></div></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn toExce_btn" id="" type="submit">导出</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }else if($_SESSION['user_authority'] == 'ministor'){
                    echo '<form id="toExcel" action="toexcel.php" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>导出范围</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><div class="selectdiv"><select name="dep_name"><option value="'.$_SESSION['dep_name'].'">'.$_SESSION['dep_name'].'</option></select></div></td>
                        </tr>
                        <tr>
                           <td><div class="selectdiv"><select name = "status">
                               <option value ="0">全部人员</option>
                               <option value ="1">初试通过</option>
                               <option value ="2">初试淘汰</option>
                               <option value ="3">复试通过</option>
                               <option value ="4">复试淘汰</option>
                               <option value ="5">正式受聘</option>
                         </select></div></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="dep_add_btn org_add_btn toExce_btn" id="" type="submit">导出</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //数据统计表单
            }else if($table_type =='data_count'){
                $dep_list = $DB->getDepList($_SESSION['org_key']);
                $register_way_count = $DB->countRegisterWay($_SESSION['org_key']);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>部门名称</th>
                               <th>全部人员</th>
                               <th>无状态</th>
                               <th>通过初试</th>
                               <th>初试淘汰</th>
                               <th>通过复试</th>
                               <th>复试淘汰</th>
                               <th>正式受聘</th>
                           </tr>     
                       </thead>
                       <tbody>';
                if($_SESSION['user_authority'] == 'admin'){
                    for($i = 0;$i < count($dep_list);$i++){
                        $register_count = $DB->countRegister($_SESSION['org_key'],$dep_list[$i]['dep_name']);
                        echo '<tr><td>'.$dep_list[$i]['dep_name'].'</td>
                                  <td>'.$register_count[0].'</td>
                                  <td>'.$register_count[1].'</td>
                                  <td>'.$register_count[2].'</td>
                                  <td>'.$register_count[3].'</td>
                                  <td>'.$register_count[4].'</td>
                                  <td>'.$register_count[5].'</td>
                                  <td>'.$register_count[6].'</td>
                                  </tr>';
                    }
                    echo '<tr><td>报名表来源</td><td colspan="3">PC端:'.$register_way_count['PC'].'</td><td colspan="3">移动端：'.$register_way_count['PHONE'].'</td></tr></tbody></table>';
                }else if($_SESSION['user_authority'] == 'ministor'){
                        $register_count = $DB->countRegister($_SESSION['org_key'],$_SESSION['dep_name']);
                        echo '<tr><td>'.$_SESSION['dep_name'].'</td>
                                <td>'.$register_count[0].'</td>
                                <td>'.$register_count[1].'</td>
                                <td>'.$register_count[2].'</td>
                                <td>'.$register_count[3].'</td>
                                <td>'.$register_count[4].'</td>
                                <td>'.$register_count[5].'</td>
                                <td>'.$register_count[6].'</td>
                              </tr></tbody></table>';
                }
                //搜索结果表单
            }else if($table_type == 'search'){
                $like = $_POST['search_content'];
                $admit_status = array('无状态','通过初试','初试淘汰','通过复试','复试淘汰','正式受聘');
                if($_SESSION['user_authority']=='admin'){
                    $personal_info_list = $DB->search($_SESSION['org_key'],0,$like);
                }else{
                    $personal_info_list = $DB->search($_SESSION['org_key'],$_SESSION['dep_name'],$like);
                }
                $dep_num = $DB->getDepNum($_SESSION['org_key']);
                $org_reg_list = $DB->getOrgRegList($_SESSION['org_key']);
                echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>姓名</th>
                               <th>性别</th>
                               <th>院系</th>
                               <th>专业</th>
                               <th>电话</th>';
                for($i = 8;$i < ($dep_num+8);$i++){
                    echo '<th>'.$org_reg_list[$i].'</th>';
                }
                echo '         <th width="12%">面试记录</th>
                               <th width="10%">操作</th>
                            </tr>
                       </thead>
                       <tbody>';
                if(count($personal_info_list)>0){
                    $info_num = count($personal_info_list[0])-1;
                }
                for($i = 0;$i<count($personal_info_list);$i++){
                    echo '<tr>';
                    echo '<td data-title="">'.$personal_info_list[$i][1].'</td>
                          <td data-title="">'.$personal_info_list[$i][2].'</td>
                          <td data-title="">'.$personal_info_list[$i][4].'</td>
                          <td data-title="">'.$personal_info_list[$i][5].'</td>
                          <td data-title="">'.$personal_info_list[$i][6].'</td>';
                    for($j = 9;$j < $dep_num + 9;$j++){
                         echo '<td data-title="">';
                        if(strlen($personal_info_list[$i][$j][0]) != 1){
                          echo $personal_info_list[$i][$j][0];
                        }else{
                          echo '未选择';
                        }
                        echo '</br>'.$admit_status[$personal_info_list[$i][$j][1]].'</td>';
                    }
                    echo '<td data-title="">'.$personal_info_list[$i][$info_num].'</td>';
                    echo '<td><ul>
                             <span id ="person_info_id" style="display:none">'.$personal_info_list[$i][0].'</span>
                             <li class="more_info"><a href="javascript:void(0);" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">更多</a></li></br>
                            <li><a class="status_change" style="color:#B1ACAC;border:solid #B1ACAC 1px;border-radius: 5px;">状态修改</a></li>
                          </td></tr></ul>';
                }
                echo '</tbody></table>';
                //短信管理
            }else if($table_type == 'message_manage'){
                include_once "MSGoperate.php";
                $MSG = new MSGoperate();
                $api_key = $DB->getApikey($_SESSION['org_key'])[0];
                if($api_key != ''){
                    $tpl = $MSG->getMsgModel($api_key,'');
                    echo '<table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th colspan="2">APIKEY:<span id = "api_key_span">'.$api_key.'</span></th><th colspan="2"><div class="sub-main">
                                <button class="apikey_revise_btn org_add_btn org_opt_btn" id="apikey_revise_btn" type="button" style="margin-left: -40px">修改KEY</button>
                                </div>
                                <div class="sub-main">
                                <button class="model_add_btn org_add_btn org_opt_btn " id="model_add_btn" type="button" style="width: 100px">添加短信模板</button>
                                </div>
                                </th>
                        </thead>
                        <tbody>
                        <tr><td colspan ="1">已有模板ID</td><td>模板内容</td><td colspan ="1">审核状态</td><td>操作</td></tr>';
                        for($i = 0;$i < count($tpl);$i++){
                            echo '<tr><td>'.$tpl[$i]['tpl_id'].'</td><td>'.$tpl[$i]['tpl_content'].'</td><td>';
                                if($tpl[$i]['check_status']=='SUCCESS'){
                                    echo 'SUCCESS';
                                }else{
                                    echo $tpl[$i]['reason'];
                                }
                                echo '</td><td><span style="display: none">'.$tpl[$i]['tpl_id'].'</span><button class="model_del_btn org_add_btn org_opt_btn" id="model_del_btn" type="button">删除</button></td></tr>';
                        }
                       echo '
                      </tbody>
                        </table>';
                }else{
                    echo '<form id="apikey_add_form" action="changeInfo.php?change_type=api_key_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>请先添加APIKEY</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="apikey" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="apikey_add_btn org_add_btn" id="apikey_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn apikey_add_cel_btn" type="button" id="apikey_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //短信发送
            }else if($table_type == 'message_send'){
                include_once "MSGoperate.php";
                $MSG = new MSGoperate();
                $org_key = $_SESSION['org_key'];
                $api_key = $DB->getApikey($org_key)[0];
                if($api_key != ''){
                    $dep_list = $DB->getDepList($org_key);
                    $tpl = $MSG->getMsgModel($api_key,'');
                    echo '<form id="message_send_form" action="msg.php" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped">
                            <thead>
                                 <tr><th colspan="4"><span style="color: red;float: left">*谨慎操作，请确认信息无误后发送</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td width="32%" style="text-align: left">选择部门：</td><td colspan ="1" style="text-align: left">
                                <div class="selectdiv">
                                <select name="dep_name" id="dep_name_select">';
                    //判断权限及部门类别
                    if($_SESSION['user_authority']=='admin'){
                        echo '<option value="0">所有部门</option>';
                        for($i = 0;$i < count($dep_list);$i++){
                            echo '<option value="'.$dep_list[$i]['dep_name'].'">'.$dep_list[$i]['dep_name'].'</option>';
                        }
                    }else if($_SESSION['user_authority']=='ministor'){
                        echo '<option value="'.$_SESSION['dep_name'].'">'.$_SESSION['dep_name'].'</option>';
                    }
                    echo  '</select></div></td>
                            <td width="32%" style="text-align: left">选择状态:</td>
                            <td style="text-align: left">
                            <div class="selectdiv">
                               <select name="status" id="status_select">
                                    <option value = "0" selected="selected">全部人员</option>
                                    <option value = "1">通过初试</option>
                                    <option value = "2">初试淘汰</option>
                                    <option value = "3">通过复试</option>
                                    <option value = "4">复试淘汰</option>
                                    <option value = "5">正式受聘</option>
                                </select> </div>
                            </td></tr><td colspan="1" style="text-align: left">选择模板 (请在短信管理界面查看相关模板的编号)</td><td colspan="1" style="text-align: left"><div class="selectdiv"><select name ="msg_tpl_id" id="msg_tpl_id_select">';
                    echo '<option value="">请选择模板</option>';
                    for($i = 0;$i < count($tpl);$i++) {
                        if ($tpl[$i]['check_status'] == 'SUCCESS') {
                            echo '<option value="' . $tpl[$i]['tpl_id'] . '">' . $tpl[$i]['tpl_id'] . '</option>';
                        }
                    }
                    echo '</select></div></td><td></td><td></td></tr>';
                    echo '<tr>
                            <td colspan="4" style="text-align: left"><span>模板内容:</span><span id="msg_model_content"></span></td>
                          </tr>';
                    echo '<thead>
                                <th colspan="4"> 
                                    <div class="sub-main">
                                    <button class="org_add_btn" id="msg_confirm" type="button">发送短信</button>
                                    </div>
                                    <div class="sub-main">
                                    <button class="msg_history_btn org_add_btn" id="msg_history_btn" type="button">短信发送历史</button>
                                    </div>
                                </th>
                             </thead>
                          </tbody>
                        </table>
                        </form>';
                }else{
                    echo '<form id="apikey_add_form" action="changeInfo.php?change_type=api_key_add" method="post">
                        <table id="table" class="table table-hover table-bordered table-striped"><thead>
                        <th>请先添加APIKEY</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="apikey" value="" ></td>
                        </tr>
                        <thead>
                            <th colspan="1">
                                <div class="sub-main">
                                <button class="apikey_add_btn org_add_btn" id="apikey_add_btn" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn apikey_add_cel_btn" type="button" id="apikey_add_cel_btn" onclick="history.go(0)" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                }
                //apikey修改
            }else if($table_type == 'api_key_revise'){
                $org_key = $_SESSION['org_key'];
                $api_key = $DB->getApikey($org_key)[0];
                echo '<form id="api_key_revise_form" action="changeInfo.php?change_type=api_key_revise" method="post">
                        <table id="api_key_revise_table" class="table table-hover table-bordered table-striped"><thead>
                        <th>APIKEY修改</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><input type="text" name="new_apikey" value='.$api_key.'></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="org_add_btn " id="api_key_revise_save_btn" type="button">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class=" org_add_btn " type="button" id="api_key_revise_cel_btn">取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
                    </table>
                    </form>';
                //短信模板添加
            }else if($table_type == 'msg_model_add'){
                $api_key = $_GET['apikey'];
                echo '<form id="msg_model_add_form" action="changeInfo.php?change_type=msg_model_add&api_key='.$api_key.'" method="post">
                        <table id="msg_model_add_table" class="table table-hover table-bordered table-striped"><thead>
                        <th>短信模板添加</th>
                      </thead>
                      <tbody>
                        <tr>
                           <td><textarea name="new_model" cols="50" rows="5"></textarea></td>
                        </tr>
                        <tr>
                           <td style="text-align: 
                           left"><p>1.模板头部必须为已审核通过的短信签名</br>2.短信模板中的变量目前支持部门（#department#）和姓名(#name#)两个，在发送短信时，系统会自动替换为报名的部门及收信人的姓名</br>3.模板请勿重复，否则会添加不成功</br>如使用以下模板：</br>【三翼工作室】亲爱的#name#你好，欢迎报名三翼工作室的#department#，请于9月10日在兴湘B栋101初试[收到请回复姓名]</br>若收信人的姓名为张三，部门为技术开发部，那么，其收到短信时内容为：<br>
【三翼工作室】亲爱的张三你好，欢迎报名三翼工作室的技术开发部，请于9月10日在兴湘B栋101初试[收到请回复姓名]</p></td>
                        </tr>
                        <thead>
                            <th colspan="2">
                                <div class="sub-main">
                                <button class="model_add_btn org_add_btn" id="" type="submit">提交</button>
                                </div>
                                <div class="sub-main">
                                <button class="org_add_btn " type="button" id="model_add_cel_btn" >取消</button>
                                </div>
                            </th>
                         </thead>
                      </tbody>
             </tbody>       </table>
                    </form>';
            //短信历史
            }else if($table_type =='msg_history'){
                $history = $DB->getMsgHitory($_SESSION['org_key']);
                echo '<table id="msg_history_table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>序号</th>
                               <th>发送时间</th>
                               <th>发送人数</th>
                               <th>成功人数</th>
                               <th>失败人数</th>
                               <th>失败详情</th>
                           </tr>     
                       </thead>
                       <tbody>';
                    for($i = 0;$i < count($history);$i++){
                        $j = $i+1;
                        echo '<tr><td>'.$j.'</td>
                                  <td>'.$history[$i]['send_time'].'</td>
                                  <td>'.$history[$i]['sum'].'</td>
                                  <td>'.$history[$i]['success'].'</td>
                                  <td>'.$history[$i]['fail'].'</td>
                                  <td><span id ="fail_detail" style="display:none">'.json_encode($history[$i]['fail_detail'],JSON_UNESCAPED_UNICODE).'</span>';
                        if($history[$i]['fail']>0){
                            echo '<button class="org_add_btn fail_detail" type="button">查看</button>';
                        }else{
                            echo '<button class="org_add_btn " type="button">无</button>';
                        }
                        echo '</td>
                                  </tr>';
                    }
                    echo '</tbody></table>';
                //短信发送失败历史记录
            }else if($table_type =='msg_history_fail_detail'){
                $fail_detail = json_decode($_POST['fail_detail'],true);
                echo '<table id="msg_history_table" class="table table-hover table-bordered table-striped"><thead>
                            <tr>
                               <th>姓名</th>
                               <th>使用模板Id</th>
                               <th>手机</th>
                               <th>详情</th>
                           </tr>     
                       </thead>
                       <tbody>';
                for($i = 0;$i < count($fail_detail);$i++){
                    echo '<tr><td>'.$fail_detail[$i][0].'</td>
                              <td>'.$fail_detail[$i][1].'</td>
                              <td>'.$fail_detail[$i][2].'</td>
                              <td>'.$fail_detail[$i][3].'</td>
                          </tr>';
                }
                echo '</tbody></table>';
            }
echo '</div>
    </div>';

             if($table_type != 'org_itd_dtl_revise' ){
                   echo '<script src="./js/jquery-3.2.1.min.js"></script><script src="js/getinfo.js"></script>';
               }else{
                   echo '<script src="js/getinfo.js"></script>';
             }
echo'</body></html>';
>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
?>