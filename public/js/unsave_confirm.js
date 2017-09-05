// 离开页面提示
// 引入本文件，作用于页面中的所有表单
var f = "";
var submit = false;
$(window).load(function(){
    f=$('form').serialize();
})
window.onbeforeunload=function(){
    if ( ! submit ) {
        if( hasChanged($('form'), f) )
            return '是否离开当前页面'
    }
}
function hasChanged(elem, arr){
    if(elem.serialize()==arr){
        return false;
    }
    return true;
}
$(document).on("submit", "form", function(event){
    submit = true;
});
