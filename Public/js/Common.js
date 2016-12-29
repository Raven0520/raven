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
        console.log(url);
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