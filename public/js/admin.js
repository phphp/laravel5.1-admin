// 操作确认
$(document).ready(function() {
    $('.confirm_button').click(function() {
        if (confirm('确定要执行该操作吗？')) return true;
        else return false;
    });
});


// 排序表格
$(function() {
    $( "#sortable" ).sortable({
        cursor: "move",
        items :".moveable",
        opacity: 0.6,
        revert: true,
        delay: 200,
        update : function(event, ui) {
                // 当排序动作结束时且元素坐标已经发生改变时触发此事件
                var data = $(this).sortable("toArray");
                send(data);
            }
    });
});
function send (send_data)
{
    // host = document.domain;
    var url = $("#sortable").attr('ajax-url');
    $.ajax({
        type: 'POST',
        url: url,
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {new_sort: send_data}, 
        success: function(data){
            if ( data == 'error' )
            {
                console.log(data);
                $("#sortable_danger").css("display","block");
                $("#sortable_success").css("display","none");
            }
            else
            {
                $("#sortable_danger").css("display","none");
                $("#sortable_success").css("display","block");
            }
        },
    });
}

