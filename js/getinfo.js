(function(removeClass) {

    jQuery.fn.removeClass = function( value ) {
        if ( value && typeof value.test === "function" ) {
            for ( var i = 0, l = this.length; i < l; i++ ) {
                var elem = this[i];
                if ( elem.nodeType === 1 && elem.className ) {
                    var classNames = elem.className.split( /\s+/ );

                    for ( var n = classNames.length; n--; ) {
                        if ( value.test(classNames[n]) ) {
                            classNames.splice(n, 1);
                        }
                    }
                    elem.className = jQuery.trim( classNames.join(" ") );
                }
            }
        } else {
            removeClass.call(this, value);
        }
        return this;
    }

})(jQuery.fn.removeClass);

//删除组织
$('.org_del_btn').on('click',function () {
    var org_key = $(this).parent().prevAll().eq(2).text();
    var url ="changeInfo.php?change_type=org_del&org_key="+org_key;
    $.get(url,
        function(data,status) {
        if(data == 1){
            alert("删除成功");
            history.go(0);
        }else{
            alert("删除失败！");
        }
        });
})

//修改组织
$('.org_revise_btn').on('click',function () {
    var org_key = $(this).parent().prevAll().eq(2).text();
    var url ="getInfo.php?table_type=org_revise&org_key="+org_key;
    changeContent(url);
})

//负责人管理
$('.org_admin_ctl_btn').on('click',function () {
    var org_key = $(this).parent().prevAll().eq(2).text();
    var url ="getInfo.php?table_type=org_admin&org_key="+org_key;
    changeContent(url)
})
//负责人修改
$('.admin_revise_btn').on('click',function () {
    var org_key = $(this).prevAll().eq(1).text();
    var id = $(this).prevAll().eq(0).text();
    var url ="getInfo.php?table_type=admin_revise&org_key="+org_key+"&id="+id;
    // alert(url);
    changeContent(url)
})


//负责人删除
$('.admin_del_btn').on('click',function () {
    var org_key = $(this).prevAll().eq(2).text();
    var id = $(this).prevAll().eq(1).text();
    var url ="changeInfo.php?change_type=admin_del&org_key="+org_key+"&id="+id;
    $.get(url,
        function(data,status) {
            if(data == 1){
                alert("删除成功");
                history.go(0);
            }else{
                alert("删除失败！");
            }
        });
})
//负责人添加
$('.admin_add_btn').on('click',function () {
    var org_key = $(this).prev().text();
    var url ="getInfo.php?table_type=admin_add&org_key="+org_key;
    changeContent(url)
})

//修改组织整体介绍
$('#org_itd_revise_btn').on('click',function () {
    var org_key = $(this).parent().prevAll().eq(4).text();
    var url ="getInfo.php?table_type=org_itd_revise&org_key="+org_key;
    changeContent(url);
})

//取消修改整体介绍
$('#org_itd_revise_cel_btn').on('click',function () {
    var url ="getInfo.php?table_type=org_itd";
    changeContent(url);
})

//取消部门添加
$('#dep_add_cel_btn').on('click',function () {
    var url ="getInfo.php?table_type=dep_list";
    changeContent(url);
})

//取消部长添加
$('#ministor_add_cel_btn').on('click',function () {
    changeContent("getInfo.php?table_type=ministor_list");
})

//取消报名表添加
$('#register_add_cel_btn').on('click',function () {
    changeContent("getInfo.php?table_type=register_form");
})

//取消报名表添加
$('#register_revise_cel_btn').on('click',function () {
    changeContent("getInfo.php?table_type=register_form");
})

//取消apikey修改
$('#api_key_revise_cel_btn').on('click',function () {
    changeContent("getInfo.php?table_type=message_manage");
})
//取消apikey修改
$('#model_add_cel_btn').on('click',function () {
    changeContent("getInfo.php?table_type=message_manage");
})

//部门添加
$('#dep_add_save_btn').on('click',function () {
    $.ajax({
        url:'changeInfo.php?change_type=dep_add',
        type:'POST',
        data:$('#dep_add_form').serialize(),
        success:function (res) {
            if(res == '1'){
                alert('添加成功');
            }else{
                alert('添加失败');
            }
            changeContent('getInfo.php?table_type=dep_list');
        }
    })

})
//部长添加
$('#ministor_add_save_btn').on('click',function () {
    $.ajax({
        url:'changeInfo.php?change_type=ministor_add',
        type:'POST',
        data:$('#ministor_add_form').serialize(),
        success:function (res) {
            if(res == '1'){
                alert('添加成功');
                changeContent('getInfo.php?table_type=ministor_list');
            }else if(res == '0'){
                alert('添加失败');
                changeContent('getInfo.php?table_type=ministor_list');
            }else if(res =='-1'){
                alert('请完善信息');
            }else if(res == '-2'){
                alert('学号好像不对吧……');
            }
        }
    })

})

//报名表修改
$('#register_revise_save_btn').on('click',function () {
    $.ajax({
        url:'changeInfo.php?change_type=register_form_revise',
        type:'POST',
        data:$('#register_form_revise').serialize(),
        success:function (res) {
            if(res == '1'){
                alert('修改成功');
            }else{
                alert('修改失败');
            }
            changeContent("getInfo.php?table_type=register_form");
        }
    })

})

//整体介绍修改
$('#org_itd_revise_save_btn').on('click',function () {
    $.ajax({
        url:'changeInfo.php?change_type=org_itd_revise',
        type:'POST',
        data:$('#org_itd_revise_form').serialize(),
        success:function (res) {
            if(res == '1'){
                alert('修改成功');
            }else{
                alert('修改失败');
            }
            changeContent("getInfo.php?table_type=org_itd");
        }
    })

})

//报名表添加
$('#register_add_save_btn').on('click',function () {
    $.ajax({
        url:'changeInfo.php?change_type=register_form_add',
        type:'POST',
        data:$('#register_form_add').serialize(),
        success:function (res) {
            if(res == '1'){
                alert('添加成功');
            }else{
                alert('添加失败');
            }
            changeContent("getInfo.php?table_type=register_form");
        }
    })

})




//apikey修改
$('#api_key_revise_save_btn').on('click',function () {
    $.ajax({
        url:'changeInfo.php?change_type=api_key_revise',
        type:'POST',
        data:$('#api_key_revise_form').serialize(),
        success:function (res) {
            if(res == '1'){
                alert('修改成功');
            }else if(res=='0'){
                alert('修改失败');
            }else if(res == '-1'){
                alert('假的！');
            }
        }
    })

})

//修改组织详细介绍编辑器
$('#org_itd_dtl_revise_btn').on('click',function () {
    var org_key = $('#org_key').text();
    var url ="getInfo.php?table_type=org_itd_dtl_revise&org_key="+org_key;
    changeContent(url);
})




//部门添加表格
$('#dep_add_btn').on('click',function () {
    var org_key = $('#org_key').text();
    var url ="getInfo.php?table_type=dep_add&org_key="+org_key;
    changeContent(url);
})

//部长添加表格
$('#ministor_add_btn').on('click',function () {
    var org_key = $('#org_key').text();
    var url ="getInfo.php?table_type=ministor_add&org_key="+org_key;
    changeContent(url);
})

//部门删除
$('.dep_del_btn').on('click',function () {
    var dep_id = $(this).prev().text();
    var url ="changeInfo.php?change_type=dep_del&dep_id="+dep_id;
    $.get(url,
        function(data,status) {
            if(data == 1){
                alert("删除成功");
                changeContent('getInfo.php?table_type=dep_list');
            }else{
                alert("删除失败！");
                changeContent('getInfo.php?table_type=dep_list');
            }
        });
})

//修改意向部门数量
$('.dep_num_revise_btn').on('click',function () {
    var dep_num = $('#dep_num_sel').val();
    var url ="changeInfo.php?change_type=dep_num_revise&dep_num="+dep_num;
    $.get(url,
        function(data,status) {
            if(data == 1){
                alert("修改成功");
                changeContent("getInfo.php?table_type=register_form");
            }else{
                alert("修改失败！");
                changeContent("getInfo.php?table_type=register_form");
            }
        });
})

//报名表添加表格
$('#register_form_add_btn').on('click',function () {
    var url ="getInfo.php?table_type=register_form_add";
    changeContent(url);
})

//报名表删除
$('.register_form_del_btn').on('click',function () {
    var register_id = $(this).prevAll().eq(1).text();
    var url ="changeInfo.php?change_type=register_form_del&org_key="+org_key+"&register_id="+register_id;
    $.get(url,
        function(data,status) {
            if(data == 1){
                alert("删除成功");
                changeContent("getInfo.php?table_type=register_form");
            }else{
                alert("删除失败！");
                changeContent("getInfo.php?table_type=register_form");
            }
        });
})

//报名表修改
$('.register_form_revise_btn').on('click',function () {
    var register_id = $(this).prev().text();
    var url ="getInfo.php?table_type=register_form_revise&org_key="+org_key+"&register_id="+register_id;
    changeContent(url);
})

//部长删除
$('.ministor_del_btn').on('click',function () {
    var ministor_id = $(this).prev().text();
    var url ="changeInfo.php?change_type=ministor_del&ministor_id="+ministor_id;
    $.get(url,
        function(data,status) {
            if(data == 1){
                alert("删除成功");
                changeContent("getInfo.php?table_type=ministor_list");
            }else{
                alert("删除失败！");
                changeContent("getInfo.php?table_type=ministor_list");
            }
        });
})


//模板删除
$('.model_del_btn').on('click',function () {
    var api_key =$('#api_key_span').text();
    var tpl_id = $(this).prev().text();
    var url ="changeInfo.php?change_type=model_del&tpl_id="+tpl_id+"&apikey="+api_key;
    $.get(url,
        function(data,status) {
            if(data == 1){
                alert("删除成功");
                changeContent("getInfo.php?table_type=message_manage");
            }else{
                alert("删除失败！");
            }
        });
})


//apikey修改
$('.apikey_revise_btn').on('click',function () {
    var url ="getInfo.php?table_type=api_key_revise";
    changeContent(url)
})

//添加模板
$('.model_add_btn').on('click',function () {
    var api_key =$('#api_key_span').text();
    var org_key = $('#org_key').text();
    var url ="getInfo.php?table_type=msg_model_add&apikey="+api_key;
    changeContent(url);
})

//查看短信发送历史
$('#msg_history_btn').on('click',function () {
    // alert(1234567);
    var org_key = $('#org_key').text();
    var url ="getInfo.php?table_type=msg_history&org_key="+org_key;
    changeContent(url);
})

//查看短信发送历史失败详情
$('.fail_detail').on('click',function () {
   var fail_detail = $(this).prev().text();
    var url ="getInfo.php?table_type=msg_history_fail_detail";
    $.post(url,{"fail_detail":fail_detail},
        function(data){
            $('#content').html(data);
        });
})

//获取模板信息
$('#msg_tpl_id_select').change(function () {
    var id = $(this).children('option:selected').val();
    $.ajax({
        url:'infoDetail.php?table_type=msg_tpl_content',
        type:'GET',
        data:{'id':id},
        success:function (data) {
            $('#msg_model_content').html(data);
        },
        error:function () {
            $('#msg_model_content').html('获取失败');
        }
    })

});

//总人数修改
$('#status_select').change(function () {
    var department = $('#dep_name_select').children('option:selected').val();
    var status = $('#status_select').children('option:selected').val();
    var url ="changeInfo.php?change_type=selected_num&dep_name="+department+"&status="+status;
    $.get(url,function (data) {
            $('#selected_num').text(data);
        })
})

$('#dep_name_select').change(function () {
    var department = $('#dep_name_select').children('option:selected').val();
    var status = $('#status_select').children('option:selected').val();
    var url ="changeInfo.php?change_type=selected_num&dep_name="+department+"&status="+status;
    $.get(url,function (data) {
        $('#selected_num').text(data);
    })
})

//显示更多信息
$('.more_info').on('click',function (e) {
    e.preventDefault();
    var Id = $(this).prev().text();
    var url ="infoDetail.php?table_type=info_name&personal_id="+Id;
    $.get(url,
        function(data){
            $('.dialogContentTitle').html(data);
        });
    var url ="infoDetail.php?table_type=info_more&personal_id="+Id;
    $.get(url,
        function(data){
            $('.dialogContentBody').html(data);
        });
    $('.wrapperOutside_1').css("display","table");
    // $('.wrapperOutside').css("display","table");
})


//状态修改遮罩层
$('.status_change').on('click',function (e) {
    e.preventDefault();
    var Id = $(this).prev().text();
    var url ="infoDetail.php?table_type=info_name&personal_id="+Id;
    $.get(url,
        function(data){
            $('.dialogContentTitle').html(data);
        });
    var url ="infoDetail.php?table_type=status_change&personal_id="+Id;
    $.get(url,
        function(data){
            $('.dialogContentBody_2').html(data);
        });
    $('.wrapperOutside_2').css("display","table");
    // $('.wrapperOutside').css("display","table");
})

//短信确认遮罩层
$('#msg_confirm').on('click',function (e) {
    e.preventDefault();
    var department = $('#dep_name_select').children('option:selected').text();
    var status = $('#status_select').children('option:selected').text();
    var no_start = Number($('#no_start').val());
    var no_end = Number($('#no_end').val());
    var max = $('#selected_num').text();
    var tpl_contnet = $('#msg_model_content').html();
    if(tpl_contnet==''){
        alert('请选择模板！');
    }else if((no_start > no_end) || (no_start == '' && no_end != '') ||( no_end == '' && no_start != '') || (no_end < 0) || (no_start < 0) || (no_end > max)){
        alert('请输入正确的区间！');
    }else{
        if(no_start=='' && no_end==''){
            var range = '全体';
        }else{
           var range = no_start +'--'+ no_end;
        }
        var content = '部门：<span style="color: black">'+department+'</span><br>状态：<span style="color:black ">'+status+'</span><br>序号：<span style="color:black ">'+range+'</span><br>短信模板:<br><span style="color: black">'+tpl_contnet+'</span>';
        $('.dialogContentBody_3').html(content);
        $('.wrapperOutside_3').css("display","table");
    }

})

//短信确认遮罩层关闭
$('#msg_confirm_cel').on('click',function (e) {
    e.preventDefault();
    $('.wrapperOutside_3').css("display","none");
})

//更多信息改遮罩关闭
$('.more_btn').on('click',function (e) {
    e.preventDefault();
    $('.wrapperOutside_1').css("display","none");
})

//状态修改遮罩关闭
$('.admit_status_revise_cel').on('click',function (e) {
    e.preventDefault();
    $('.wrapperOutside_2').css("display","none");
})



function changeContent(url) {
    $.get(url,
        function(data){
            $('#content').html(data);
        });
}
