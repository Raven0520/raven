/**
 * Created by raven on 2016/12/1.
 */
/**
 * 通用表单提交方法
 */
Common = {
    Submit : function () {
        var data = $('#submitForm').serializeArray();
        var formData = {};
        $(data).each(function (i) {
            formData[this.name] = this.value;
        });
        var url  = SCOPE.add_url;
        var jump = SCOPE.jump_url;

        $.post(url,formData,function (res) {
            if (res.status == 1){
                return msg.success(res.message,jump);
            }
            if (res.status == 0){
                return msg.error(res.message);
            }
        },"JSON");
    }
};