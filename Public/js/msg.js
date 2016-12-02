/**
 * Created by raven on 2016/6/20.
 */
var msg ={
    //错误弹出层
    error : function (message) {
        layer.msg(message,{
            time: 1200
        });
    },
    //正确弹出层
    success : function (message,url) {
        layer.msg(message,{
            time:1200
        },function () {
            if (url){
                window.location.href = url;
            }
        });
    },
    //确认弹出层
    confirm : function (message,url) {
        layer.msg(message,{
            time  : 0,
            btn   : ['Yes','No'],
            yes   : function () {
                location.href = url;
            }
        });
    }
};