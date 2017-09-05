$(document).ready(function() {
    var img_width; // 图片实际宽度
    var img_height; // 图片实际高度
    var avatar_s_width = 50; // 小头像宽度
    var avatar_m_width = 70; // 中头像宽度
    var avatar_l_width = 100; // 大头像宽度
    var margin = 10; // 预览图片的 margin-left

    // 初始化 jcrop
    function initJcrop() {
        $('#jcrop').Jcrop({
            aspectRatio: 1, // 长宽比
            boxWidth: 420, // 最大宽度
            setSelect: [ 0, 0, 225, 225 ], // 初始化选中区域
            // setSelect: [ 15, 15, 210, 210 ], // 初始化选中区域
            onChange: updatePreview,
            onSelect: updatePreview,
        }, function() {
            jcropApi = this;
            img_width = this.getBounds()[0];
            img_height = this.getBounds()[1];

            $('#jcrop').css('width', img_width); // 设置上传图片的宽度，受限于 boxWidth
            $('#jcrop').css('height', img_height); // 设置上传图片的高度

            // this.tellScaled(); // 选择框的像素尺寸
            // select = this.tellSelect(); // 选中区域图片的实际尺寸
            setAvatar(this.tellSelect(), img_width, img_height); // 初始化时设置头像
        });
    }
    initJcrop(); // 页面载入时运行，使用默认图片


    // 拖动选框 or 更新图片 时更新头像
    function updatePreview(c) {
        console.log('c', c); // 选中区域图片的实际尺寸，相当于 tellSelect()
        setAvatar(c, img_width, img_height);
    }
    // 设置头像的 css 参数
    function setAvatar(size, img_width, img_height) {
        ratio = size.w / avatar_s_width; // 选中区域图片的实际尺寸的宽度 ÷ 需要缩放至的头像宽度
        $('.avatar-s').css('clip', 'rect('+size.y/ratio+'px, '+size.x2/ratio+'px, '+size.y2/ratio+'px, '+size.x/ratio+'px)');
        $('.avatar-s').css('width', img_width / ratio);
        $('.avatar-s').css('height', img_height / ratio);
        $('.avatar-s').css('top', -size.y/ratio + margin);
        $('.avatar-s').css('left', -size.x2/ratio + avatar_s_width + avatar_m_width + avatar_l_width + margin * 3);
        ratio = size.w / avatar_m_width;
        $('.avatar-m').css('clip', 'rect('+size.y/ratio+'px, '+size.x2/ratio+'px, '+size.y2/ratio+'px, '+size.x/ratio+'px)');
        $('.avatar-m').css('width', img_width / ratio);
        $('.avatar-m').css('height', img_height / ratio);
        $('.avatar-m').css('top', -size.y/ratio + margin);
        $('.avatar-m').css('left', -size.x2/ratio + avatar_m_width + avatar_l_width + margin * 2 );
        ratio = size.w / avatar_l_width;
        $('.avatar-l').css('clip', 'rect('+size.y/ratio+'px, '+size.x2/ratio+'px, '+size.y2/ratio+'px, '+size.x/ratio+'px)');
        $('.avatar-l').css('width', img_width / ratio);
        $('.avatar-l').css('height', img_height / ratio);
        $('.avatar-l').css('top', -size.y/ratio + margin);
        $('.avatar-l').css('left', -size.x2/ratio + avatar_l_width + margin );

        // 设置提交数据
        $('#avatar_size').val(JSON.stringify(size));
    }

    // 修改上传的图片，获取并设置一些属性
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                jcropApi.destroy(); // 删除上一个 jcrop
                // $('#jcrop').attr('src', e.target.result); // 只能修改图片地址，对样式不起作用
                $('#jcrop').replaceWith('<img id="jcrop" src="'+e.target.result+'"/>'); // 修改图片，并清除所有样式
                $('.avatar-s').attr('src', e.target.result); // 修改头像图片
                $('.avatar-m').attr('src', e.target.result); // 修改头像图片
                $('.avatar-l').attr('src', e.target.result); // 修改头像图片
                initJcrop();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    // 上传新文件后触发
    $("#upload_avatar").change(function(){
        readURL(this);
    });
});