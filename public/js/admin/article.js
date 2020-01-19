// page-index
var pageType = $("meta[name=\"csrf-token\"]").attr('pageType');

function loaddata() {
    $('#category_id').combobox({
        data: categoryData
    });

    if (pageType == 'add') {
        var tagNum = tagData.length;
        var tagHtml = '';
        if (tagNum) {
            var tag = detail ? detail.tag : '';
            for (var i = 0; i < tagNum; i++) {
                var checked = '';
                if (tagValueData) {
                    if ($.inArray(tagData[i].id, tagValueData) != -1) {
                        checked = 'checked';
                    }
                }
                tagHtml += ' <div class="icheck-success d-inline">\n' +
'                                <input type="checkbox" name="tag_id[]" value="' + tagData[i].id + '" id="tag' + i + '" ' + checked + '>\n' +
'                                <label for="tag' + i + '">' + tagData[i].title + '</label>\n' +
'                            </div>' +
'                            &nbsp;&nbsp;&nbsp;';
            }
        }
        $('#LiTag').html('').html(tagHtml);


        if (thisId) {
            $('#page-form-body').form('load', detail);
            var content = myEditor.setData(detail.content);
        }
        var keywords = detail ? detail.keywords : '';

        var keywordsHtml = '<select multiple class="form-control ipt" id="keywords" name="keywords[]">';
        if (keywords) {
            for (var s = 0; s < keywords.length; s++) {
                keywordsHtml += '<option disabled value="' + keywords[s] + '"></option>';
            }
        }
        keywordsHtml += '</select>';
        $('#keywordsBox').html('').html(keywordsHtml);
        $('#keywords').tagsinput({});

        var pic = detail ? detail.pic : '';
        if(pic) {
            $('#LiPic').attr('href', pic).show();
        }
    }
}


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


    function make_original(val, r) {
        if (r.id) {
            if (val == 1) {
                return '是';
            } else {
                return '否';
            }
        } else {
            return '';
        }
    }

    function make_top(val, r) {
        if (r.id) {
            if (val == 1) {
                return '是';
            } else {
                return '否';
            }
        } else {
            return '';
        }
    }

    function make_status(val, r) {
        if (r.id) {
            if (val == 1) {
                return '已开启';
            } else {
                return '已关闭';
            }
        } else {
            return '';
        }
    }

    function make_category(val, r) {
        if (r.id && val) {
            return val['title'];
        } else {
            return '';
        }
    }

    function make_tag(val, r) {
        var tagLength = val.length;
        if (r.id && tagLength) {
            var tagHtml = '';
            for (var i = 0; i < tagLength; i++) {
                tagHtml += '<span class="badge bg-success">' + val[i].title + '</span>&nbsp;';
            }
            return tagHtml;
        } else {
            return '';
        }
    }

    function make_keywords(val, r) {
        var keywordLength = val.length;
        if (r.id && keywordLength) {
            var keywordHtml = '';
            for (var i = 0; i < keywordLength; i++) {
                keywordHtml += '<span class="badge bg-info">' + val[i] + '</span>&nbsp;';
            }
            return keywordHtml;
        } else {
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

} else if (pageType == 'add') {
    $('#form-back').on("click", function () {
        window.location.href = indexUrl;
    });


    /**
     * 全部提交
     */
    $('#form-submit , .fa-save').on("click", function () {
        if (!$('#page-form-body').form('validate')) {
            return false;
        }
        var params = JKD.getParams('.ipt');
        var content = myEditor.getData();
        var formData = new FormData($("#page-form-body")[0]);
        formData.append('content', content);
        if (params.id == '') {
            url = storeUrl;
            ajaxtype = 'POST';
        } else {
            url = updateUrl;
            ajaxtype = 'POST';
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
                if (data.id) {
                    $('#id').val(data.id);
                }
                if(data.pic) {
                    $('#LiPic').attr('href', data.pic).show();
                }
            },
            error: function (data) {
                if (data.status == 422) {
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


$(document).ready(function () {
    if (pageType == 'index') {
        dgold = new Array();
        arroid = new Array();
        showdg();
    }

    loaddata();
});
