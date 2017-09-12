$(document).ready( function() {

    //改变左上角标题内容
    $('body').on("click", ".larg div h3", function(){
        if ($(this).children('span').hasClass('close')) {
            $(this).children('span').removeClass('close');
        }
        else {
            $(this).children('span').addClass('close');
        }
        $(this).parent().children('p').slideToggle(250);
    });

    $('body').on("click", "ul li a", function(){
        var title = $(this).data('title');
        $('.title').children('h2').html(title);
    });

    //admin账户操作栏切换
    $('.tab a').on('click', function (e) {

        e.preventDefault();

        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        target = $(this).attr('href');

        $('.tab-content > ul').not(target).hide();

        $(target).fadeIn(600);

    });

    //默认输出表格
    function printMain(){
        if($('#user_authority').text()== 'root'){
            var url = "getInfo.php?table_type=org_list";
            changeContent(url);
            $('.title').children('h2').html('组织列表');
        }else if($('#user_authority').text()== 'admin'){
            var org_key = $('#org_key').text();
            var dep_name = $('#dep_name').text();
            var url = "getInfo.php?table_type=personal_info_list&org_key="+org_key+"&dep_name="+dep_name;
            changeContent(url);
            $('.title').children('h2').html('全部人员');
        }else {
            var org_key = $('#org_key').text();
            var dep_name = $('#dep_name').text();
            var url = "getInfo.php?table_type=personal_info_list&org_key="+org_key+"&dep_name="+dep_name+"&status=0";
            changeContent(url);
            $('.title').children('h2').html('人员列表');
        }
    }
    printMain();

    //部长级按状态查询
    $('.select_status').on('click',function (e) {
        e.preventDefault();
        var status = $(this).attr("id");
        var org_key = $('#org_key').text();
        var dep_name = $('#dep_name').text();
        var url = "getInfo.php?table_type=personal_info_list&org_key="+org_key+"&dep_name="+dep_name+"&status="+status;
        changeContent(url);
    })

    //状态选项显示
    $('.dep_name').on('click',function () {
        this.next().addClass('dep_status_active');
    })

    //整体介绍
    $('.org_itd').on('click',function (e) {
        e.preventDefault();
        var org_key = $('#org_key').text();
        var url ="getInfo.php?table_type=org_itd&org_key="+org_key;
        changeContent(url);
    })

    //组织介绍
    $('.org_itd_dtl').on('click',function (e) {
        e.preventDefault();
        var org_key = $('#org_key').text();
        var url ="getInfo.php?table_type=org_itd_dtl&org_key="+org_key;
        changeContent(url);
    })


    //部长列表
    $('.ministor_add').on('click',function (e) {
        e.preventDefault();
        var org_key = $('#org_key').text();
        var url ="getInfo.php?table_type=ministor_list&org_key="+org_key;
        changeContent(url);
    })

    //部门列表
    $('.dep_add').on('click',function (e) {
        e.preventDefault();
        var org_key = $('#org_key').text();
        var url ="getInfo.php?table_type=dep_list&org_key="+org_key;
        changeContent(url);
    })

    //报名表列表
    $('.register_form').on('click',function (e) {
        e.preventDefault();
        var org_key = $('#org_key').text();
        var url ="getInfo.php?table_type=register_form&org_key="+org_key;
        changeContent(url);
    })

    //组织添加
    $('.org_add').on('click',function (e) {
        e.preventDefault();
        var url ="getInfo.php?table_type=org_add";
        changeContent(url);
    })

    //组织LOGO
    $('.org_logo').on('click',function (e) {
        e.preventDefault();
        var url ="getInfo.php?table_type=org_logo";
        changeContent(url);
    })


    //导出Excel
    $('.toExcel').on('click',function (e) {
        e.preventDefault();
        var url ="getInfo.php?table_type=toExcel";
        changeContent(url);
    })

    //数据统计
    $('.dataCount').on('click',function (e) {
        e.preventDefault();
        var url ="getInfo.php?table_type=data_count";
        changeContent(url);
    })

    //搜索结果显示
    $('.search_form').submit(function() {
        var search_content = $(this).serialize();
        var url = "getInfo.php?table_type=search";
        $.post(url,search_content,
            function(data){
                $('#content').html(data);
            });
        return false;
    });

    //短信管理
    $('.message_manage').on('click',function (e) {
        e.preventDefault();
        var url ="getInfo.php?table_type=message_manage";
        changeContent(url);
    })

    //短信管理
    $('.message_send').on('click',function (e) {
        e.preventDefault();
        var url ="getInfo.php?table_type=message_send";
        changeContent(url);
    })

    //显示更多信息
    $('.buttonFlat').on('click',function (e) {
        e.preventDefault();
        $('.wrapperOutside_1').css("display","none");
    })

    //interview_record_btn修改面试记录
    $('.interview_record_btn').on('click',function (e) {
        e.preventDefault();
        var record = $('#interview_record').val();
        var personal_id = $('#interview_record').prev().text();
        url = 'changeInfo.php?change_type=interview_record_revise&interview_record='+record+'&personal_id='+personal_id;
        $.get(url,
            function(data) {
                if(data == 1){
                    alert("修改成功");
                    $('.wrapperOutside_1').css("display","none");
                    $('.person_info_id').each(function () {
                        if(this.innerHTML==personal_id){
                            $(this).parent().parent().prev().text(record);
                        }
                    });
                }else{
                    alert("好像什么也没改！");
                }
            });
    })

    //admit_status_change_btn修改录取状态
        $('.admit_status_change_btn').on('click',function (e) {
            e.preventDefault();
            var admit_status = $('#new_admit_status').val();
            var dep_name = $('#new_admit_status').parent().prev().text();
            var personal_id = $('#new_admit_status').parent().prevAll().eq(1).text();
            url = 'changeInfo.php?change_type=admit_status_revise&admit_status='+admit_status+'&dep_name='+dep_name+'&personal_id='+personal_id;
            $.get(url,
                function(data) {
                    if(data == 1){
                        alert("修改成功");
                        $('.wrapperOutside_2').css("display","none");
                    }else{
                        alert("好像什么也没改！");
                    }
                });
        })

    //短信发送
    $('#msg_send_final_btn').on('click',function () {
        // alert(486556);
        $.ajax({
            url:'msg.php',
            type:'POST',
            data:$('#message_send_form').serialize(),
            success:function (res) {
                console.log(res);
                if(res == '1'){
                    alert('发送成功，请进入发送历史查看');
                }else{
                    alert('发送失败,请重试');
                }
            }
        })
        $('.wrapperOutside_3').css("display","none");
    })


    var loading = '<!DOCTYPE html><html><head><meta charset="UTF-8"><link rel="stylesheet" href="css/getInfo.css"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body><div id="demo"><div class="table-responsive-vertical shadow-z-1"><table id="table" class="table table-hover table-bordered table-striped"><thead><tr><th>loading……</th></tr></thead></table></div></div></body></html>';

    function changeContent(url) {
        $('#content').html(loading);
        $.post(url,
            function(data){
                $('#content').html(data);
            });
    }

});









