// page-index
var pageType = $("meta[name=\"csrf-token\"]").attr('pageType');

if (pageType == 'index') {
    $('#reset-search').click(function () {
        setTimeout(function () {
            showdg();
        }, 200)
    });

    $('#search-form').form({
        onSubmit: function () {
            showdg();
            return false;
        }
    });

    function showdg() {
        if (pageQueryUrl) {
            url = pageQueryUrl;
            var params = JKD.getParams('.ipts');

            $('#dg').datagrid({
                method: 'get',
                queryParams: params,
                url: url,
                loadFilter: function (data, parent) {
                    var myMap = {};
                    myMap['total'] = data.footer;
                    myMap['rows'] = data.data;
                    $('#dgcopy, #dgedit, #dgdel, #dgsave').addClass('disabled');
                    return myMap;
                },
                onSelect: function (index, row) {
                    $('#dgcopy, #dgedit, #dgdel, #dgsave').removeClass('disabled');
                },
                onLoadSuccess: function (data) {
                    rows = $('#dg').datagrid("getRows");
                    dgold = [];
                },
            });
        }
    }


    $('#dgdel').on("click", function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }

        var r = $("#dg").datagrid('getSelected');
        if (!r) {
            JKD.showError('出错了！');
            return false;
        }

        Swal.fire({
            title: '确定删除?',
            text: "一经删除将无法恢复!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: '取消',
            confirmButtonText: '确定'
        }).then((result) => {
            if (result.value) {
                var params = {};
                params['id'] = r.id;
                params['page_type'] = 'delete';
                JKD.loading({msg: '正在处理中...'});
                $.post(destroyUrl, params, function (data, textStatus) {
                    JKD.loading({close: 'true'});
                    JKD.toastr(data.type, data.msg);
                    showdg();
                });
            }
        });

        return false;
    });

}


$(document).ready(function () {
    if (pageType == 'index') {
        dgold = new Array();
        arroid = new Array();
        showdg();
    }
});