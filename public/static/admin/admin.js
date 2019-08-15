//全选 全不选
layui.use(['form','jquery'],function(){

    var form = layui.form,
        $    = layui.jquery;

    form.on('checkbox(allChoose)',function(data){
        var status=this.checked;
        $('.checkbox-ids').prop('checked',status);
        form.render('checkbox');
    })

});