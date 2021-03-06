/**
 * Created by raven on 2016/12/1.
 */
/**
 * 通用表单提交方法
 */
Common = {
    /**
     * 提交表单
     * @constructor
     */
    Submit: function () {
        var data = $('#submitForm').serialize();
        var url = SCOPE.add_url;
        var jump = SCOPE.jump_url;
        $.post(url, data, function (res) {
            if (res.status == 1) {
                return msg.success(res.info, jump);
            }
            if (res.status == 0) {
                return msg.error(res.info);
            }
        }, "JSON");
    },

    /**
     * 排序方法
     */
    setListOrder: function (id, order) {
        if (!order) {
            return msg.error('排序不能为空');
        }
        if (order < 0) {
            return msg.error('排序不能小于0');
        }

        $.ajax({
            type: "POST",
            url: SCOPE.order_url,
            data: {id: id, order: order},
            success: function (res) {
                if (res.status == 1) {
                    return msg.success(res.info, SCOPE.jump_url);
                }
                if (res.status == 0) {
                    return msg.error(res.info);
                }
            }
        })
    },

    /**
     * 修改状态
     */
    setStatus: function (id, status) {
        $.ajax({
            type: "POST",
            url: SCOPE.status_url,
            data: {id: id, status: status},
            success: function (res) {
                if (res.status == 1) {
                    return msg.success(res.info, SCOPE.jump_url);
                }
                if (res.status == 0) {
                    return msg.error(res.info);
                }
            }
        })
    }
};

function GetRequest() {

    var url = location.search; //获取url中"?"符后的字串
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
        }
    }
    return theRequest;
}