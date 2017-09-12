<<<<<<< HEAD
<?php
require_once "config.php";
require_once "db.class.php";
session_start();?>
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
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<script src="./summernote/summernote.js"></script>
<script type="text/javascript" src="./summernote/lang/summernote-zh-CN.js"></script>

<div id="summernote" class="summernote" placeholder="asdas" name=""></div>

<div class="button_div" style="width:100%; text-align: center"><td><button class="org_add_btn org_itd_del_revise_save_btn" onclick="saveOrgItdDet()" type="button">保存</button><button class="opt_btn_r org_add_btn org_itd_del_revise_cel_btn" type="button"  onclick="location.href='orgInfoShow.php'">取消</button></td></div>
<script src="js/getinfo.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 700,
            minHeight: 700,
            maxHeight: 700,
            lang:'zh-CN',
            callbacks: {
                onImageUpload: function(files){
                    sendFile(files);
                }
            }
        });
        var url ="infoDetail.php?table_type=org_itd_dtl_content&org_key=<?php echo $_SESSION['org_key']?>";
        $.post(url,function (data) {
            var content = data;
            $('#summernote').summernote('code', content);
        });

    //重写图片上传
        function sendFile(files) {
            var data = new FormData();
            data.append("file", files[0]);
            $.ajax({
                data : data,
                type : "POST",
                url : "uploadImg.php?type=img", //图片上传出来的url，返回的是图片上传后的路径，http格式
                cache : false,
                contentType : false,
                processData : false,
                success: function(data) {//data是返回的hash,key之类的值，key是定义的文件名
                    $('#summernote').summernote('insertImage', data,'image name');
                },
                error:function(){
                    alert("上传失败");
                }
            });
        }

    });

    function saveOrgItdDet() {
        var str = $('#summernote').summernote('code');
        var url ="changeInfo.php?change_type=org_itd_dtl_revise&org_key=<?php echo $_SESSION['org_key']?>";
        $.post(url,str,
            function(data){
                if(data != 0 ){
                    alert("修改成功");

                    var url ="getInfo.php?table_type=org_itd_dtl&org_key=<?php echo $_SESSION['org_key'] ?>";
                    $.get(url,
                        function(data){
                            $('#content').html(data);
                        });

                }else {
                    alert("修改失败");
                }
            });
        location.href='orgInfoShow.php';
    }

</script>
</body>
</html>

=======
<?php
require_once "config.php";
require_once "db.class.php";
session_start();?>
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
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<script src="./summernote/summernote.js"></script>
<script type="text/javascript" src="./summernote/lang/summernote-zh-CN.js"></script>

<div id="summernote" class="summernote" placeholder="asdas" name=""></div>

<div class="button_div" style="width:100%; text-align: center"><td><button class="org_add_btn org_itd_del_revise_save_btn" onclick="saveOrgItdDet()" type="button">保存</button><button class="opt_btn_r org_add_btn org_itd_del_revise_cel_btn" type="button"  onclick="location.href='orgInfoShow.php'">取消</button></td></div>
<script src="js/getinfo.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 700,
            minHeight: 700,
            maxHeight: 700,
            lang:'zh-CN',
            callbacks: {
                onImageUpload: function(files){
                    sendFile(files);
                }
            }
        });
        var url ="infoDetail.php?table_type=org_itd_dtl_content&org_key=<?php echo $_SESSION['org_key']?>";
        $.post(url,function (data) {
            var content = data;
            $('#summernote').summernote('code', content);
        });

    //重写图片上传
        function sendFile(files) {
            var data = new FormData();
            data.append("file", files[0]);
            $.ajax({
                data : data,
                type : "POST",
                url : "uploadImg.php?type=img", //图片上传出来的url，返回的是图片上传后的路径，http格式
                cache : false,
                contentType : false,
                processData : false,
                success: function(data) {//data是返回的hash,key之类的值，key是定义的文件名
                    $('#summernote').summernote('insertImage', data,'image name');
                },
                error:function(){
                    alert("上传失败");
                }
            });
        }

    });

    function saveOrgItdDet() {
        var str = $('#summernote').summernote('code');
        var url ="changeInfo.php?change_type=org_itd_dtl_revise&org_key=<?php echo $_SESSION['org_key']?>";
        $.post(url,str,
            function(data){
                if(data != 0 ){
                    alert("修改成功");

                    var url ="getInfo.php?table_type=org_itd_dtl&org_key=<?php echo $_SESSION['org_key'] ?>";
                    $.get(url,
                        function(data){
                            $('#content').html(data);
                        });

                }else {
                    alert("修改失败");
                }
            });
        location.href='orgInfoShow.php';
    }

</script>
</body>
</html>

>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
