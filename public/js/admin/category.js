// page-index
var pageType = $("meta[name=\"csrf-token\"]").attr('pageType');

if(pageType == 'index'){
    $('#reset-search').click(function () {
        setTimeout(function(){
            showdg();
        },200)
    });


    $('#search-form').form({
        onSubmit: function(){
            showdg();
            return false;
        }
    });


    function showdg(){
        if(pageQueryUrl){
            url = pageQueryUrl;
            var params = JKD.getParams('.ipts');

            $('#dg').datagrid({
                method : 'get',
                queryParams : params,
                url : url,
                loadFilter: function(data,parent){
                    var myMap = {};
                    myMap['total'] = data.footer;
                    myMap['rows'] = data.data;
                    $('#dgcopy, #dgedit, #dgdel, #dgsave').addClass('disabled');
                    return myMap;
                },
                onSelect: function(index,row){
                    $('#dgcopy, #dgedit, #dgdel, #dgsave').removeClass('disabled');
                },
                onLoadSuccess:function(data){
                    rows= $('#dg').datagrid("getRows");
                    dgold = [];
                    for (var i = 0; i < rows.length; i++) {
                        dgold.push({id: rows[i].id, sort: rows[i].sort});
                    }
                },
            });
        }
    }


    function make_status(val, r){
        if(r.id){
            if(val==1){
                return '已开启';
            }else{
                return '已关闭';
            }
        }else{
            return '';
        }
    }


    $('#dgadd').on("click", function () {
        window.location.href = editUrl;
        return false;
    });

    $('#dgedit').on("click", function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        var r = $("#dg").datagrid('getSelected');
        if (!r) {
            JKD.showError('出错了！');
            return false;
        }

        url = editUrl + '?id=' + r.id;
        window.location.href = url;
        return false;
    });


    $('#dgdel').on("click", function(){
        if($(this).hasClass('disabled')){
            return false;
        }

        var r = $("#dg").datagrid('getSelected');
        if(!r){
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


    $('#dgsave').on("click", function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        $('#dg').datagrid("acceptChanges");

        var datastr = '';
        var rows = $('#dg').datagrid("getRows");

        for (var i = 0, j = 0; i < rows.length; i++) {
            if (rows[i].sort != dgold[i].sort) {
                if (j == 0) {
                    j = 1;
                    datastr += rows[i].id + ':' + rows[i].sort;
                } else {
                    datastr += ',' + rows[i].id + ':' + rows[i].sort;
                }
            }
        }

        if (datastr != '') {
            JKD.loading({msg: '正在处理中...'});
            $.post(batchUpdateUrl, {params: datastr}, function (data, textStatus) {
                JKD.loading({close: 'true'});
                JKD.toastr(data.type, data.msg);
                showdg();
            });

        }
        return false;
    });

} else if(pageType == 'add') {
    function loaddata(){
        if(thisId){
            $('#page-form-body').form('load', detail);
        }
        var keywords = detail ? detail.keywords : '';

        var keywordsHtml = '<select multiple data-role="tagsinput" class="form-control ipt" id="keywords" name="keywords[]">';
        if(keywords){
            for (var s = 0; s < keywords.length; s++) {
                keywordsHtml += '<option selected value="' + keywords[s] + '"></option>';
            }
        }
        keywordsHtml += '</select>';
        $('#keywordsBox').html('').html(keywordsHtml);
        $('#keywords').tagsinput({});
    }


    $('#form-back').on("click", function(){
        window.location.href = indexUrl;
    });


    /**
     * 全部提交
     */
    $('#form-submit , .fa-save').on("click", function()
    {
        if(!$('#page-form-body').form('validate')) {
            return false;
        }
        var params = JKD.getParams('.ipt');

        var formData = new FormData($("#page-form-body")[0]);

        if(params.id==''){
            url=storeUrl;
            ajaxtype='POST';
        }else{
            url=updateUrl;
            ajaxtype='POST';
        }

        JKD.loading({msg: '正在加载中...'});
        $.ajax({
            url: url,
            type: ajaxtype,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                JKD.loading({close: 'true'});
                JKD.toastr(data.type, data.msg);
                if(data.id){
                    $('#id').val(data.id);
                }
            },
            error: function (data) {
                if(data.status == 422) {
                    var errMsg = {};
                    var errorsData = data.responseJSON.errors;
                    if (errorsData.warning) {
                        JKD.toastr('warning', errorsData.warning);
                    }
                }

                JKD.loading({close: 'true'});
            }
        });

        return false;
    });

}


$(document).ready(function(){
    if (pageType == 'index') {
        dgold = new Array();
        arroid = new Array();
        showdg();
        $('#dg').datagrid('enableCellEditing');
    } else if (pageType == 'add') {
        loaddata();
    }
});