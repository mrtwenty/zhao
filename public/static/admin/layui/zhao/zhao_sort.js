layui.define(['jquery','layer'],function(exports){
    var $     = layui.jquery;
        layer = layui.layer;

    $('#sort').click(function(){

        var url=  $(this).data('href');

        var data={};
        $('.js-sort').each(function(item){
            data[this.name] = parseInt(this.value);
        });

        $.post(url,data,function(res){
            
            layer.msg(res.msg);
            if(res.code==1){
                setTimeout(function(){
                    window.location.href=res.url;
                },1500);
            }

        },'json');
    });

    exports('zhao_sort', {});
});