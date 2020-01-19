var JKD = JKD || {};
JKD.v = '1.1.2';
JKD.checkBrowser = function () {
    return {
        mozilla: /firefox/.test(navigator.userAgent.toLowerCase()),
        webkit: /webkit/.test(navigator.userAgent.toLowerCase()),
        opera: /opera/.test(navigator.userAgent.toLowerCase()),
        msie: /msie/.test(navigator.userAgent.toLowerCase())
    }
}
JKD.pageHeight = function () {
    if (JKD.checkBrowser().msie) {
        return document.compatMode == "CSS1Compat" ? document.documentElement.clientHeight :
            document.body.clientHeight;
    } else {
        return self.innerHeight;
    }
};
//返回当前页面宽度
JKD.pageWidth = function () {
    if (JKD.checkBrowser().msie) {
        return document.compatMode == "CSS1Compat" ? document.documentElement.clientWidth :
            document.body.clientWidth;
    } else {
        return self.innerWidth;
    }
};


JKD.loading = function () {
    msg = '正在处理中...';
    times = 60000;
    if (arguments.length > 0) {
        if (arguments[0].hasOwnProperty("msg")) {
            msg = arguments[0].msg;
        }
        if (arguments[0].hasOwnProperty("times")) {
            times = arguments[0].times;
        }
        if (arguments[0].hasOwnProperty("close")) {
            $('#JKDloading').remove();
            return;
        }
    }

    var htmlstr = '<div id="JKDloading"><div class="overlay"><i class="fa fa-spinner fa-spin"></i><span class="msg">' + msg + '</span></div></div>';
    $('body').append(htmlstr);

    setTimeout(function () {
        $('#JKDloading').remove()
    }, times);

}


JKD.shareMsg = function (msg, obj) {
    var style_arr = ['danger', 'warning', 'success', 'info'];
    var times = 5000;

    if (obj == '') {
        $('#JKDmsg').remove();
        return false;
    }

    var htmlstr = '';
    for (x in style_arr) {
        if (msg.hasOwnProperty(style_arr[x])) {
            htmlstr = '<div class="flash-message"><p class="alert alert-' + style_arr[x] + '">' + msg[style_arr[x]] + '</p></div>';
        }
    }
    $('#JKDmsg').remove();
    obj.prepend('<div id="JKDmsg">' + htmlstr + '</div>');

    t = setTimeout(function () {
        $('#JKDmsg').fadeOut(2000)
    }, times);
    $('#JKDmsg').on('mouseover', function () {
        $('#JKDmsg').stop().fadeIn();
        if (t) {
            clearTimeout(t);
        }

    })

    $('#JKDmsg').on('mouseleave', function () {
        t = setTimeout(function () {
            $('#JKDmsg').fadeOut(2000)
        }, times);
    })

}

/********************
 * 取窗口滚动条高度
 ******************/
JKD.getScrollTop = function () {
    var scrollTop = 0;
    if (document.documentElement && document.documentElement.scrollTop) {
        scrollTop = document.documentElement.scrollTop;
    } else if (document.body) {
        scrollTop = document.body.scrollTop;
    }
    return scrollTop;
}
/********************
 * 取文档内容实际高度
 *******************/
JKD.getScrollHeight = function () {
    return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
}
//只能輸入數字
JKD.isNumberKey = function (evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
}
//只能輸入數字和小數點
JKD.isNumberdoteKey = function (evt) {
    var e = evt || window.event;
    var srcElement = e.srcElement || e.target;

    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && ((charCode < 48 || charCode > 57) && charCode != 46)) {
        return false;
    } else {
        if (charCode == 46) {
            var s = srcElement.value;
            if (s.length == 0 || s.indexOf(".") != -1) {
                return false;
            }
        }
        return true;
    }
}

//只能輸入數字和字母
JKD.isNumberCharKey = function (evt) {
    var e = evt || window.event;
    var srcElement = e.srcElement || e.target;
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 8) {
        return true;
    } else {
        return false;
    }
}

JKD.isChinese = function (obj, isReplace) {
    var pattern = /[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/i
    if (pattern.test(obj.value)) {
        if (isReplace) obj.value = obj.value.replace(/[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/ig, "");
        return true;
    }
    return false;
}
//用户名判断 （可输入"_",".","@", 数字，字母）
JKD.isUserName = function (evt) {
    var evt = evt || window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode == 95 || charCode == 46 || charCode == 64) || (charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 8) {
        return true;
    } else {
        return false;
    }
}

JKD.isEmail = function (v) {
    var tel = new RegExp("^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$");
    return (tel.test(v));
}

JKD.isHasImg = function (pathImg) {
    var ImgObj = new Image();
    ImgObj.src = pathImg;
    if (ImgObj.fileSize > 0 || (ImgObj.width > 0 && ImgObj.height > 0)) {
        return true;
    } else {
        return false;
    }
}
//判断url
JKD.isUrl = function (str) {
    if (str == null || str == "") return false;
    var result = str.match(/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\’:+!]*([^<>\"])*$/);
    if (result == null) return false;
    return true;
}
//比较时间差
JKD.getTimeDiff = function (startTime, endTime, diffType) {
    //将xxxx-xx-xx的时间格式，转换为 xxxx/xx/xx的格式
    startTime = startTime.replace(/-/g, "/");
    endTime = endTime.replace(/-/g, "/");
    //将计算间隔类性字符转换为小写
    diffType = diffType.toLowerCase();
    var sTime = new Date(startTime); //开始时间
    var eTime = new Date(endTime); //结束时间
    //作为除数的数字
    var divNum = 1;
    switch (diffType) {
        case "second":
            divNum = 1000;
            break;
        case "minute":
            divNum = 1000 * 60;
            break;
        case "hour":
            divNum = 1000 * 3600;
            break;
        case "day":
            divNum = 1000 * 3600 * 24;
            break;
        default:
            break;
    }
    return parseInt((eTime.getTime() - sTime.getTime()) / parseInt(divNum));
}
/**
 * 截取字符串
 */
JKD.cutStr = function (str, len) {
    if (!str || str == '') return '';
    var strlen = 0;
    var s = "";
    for (var i = 0; i < str.length; i++) {
        if (strlen >= len) {
            return s + "...";
        }
        if (str.charCodeAt(i) > 128)
            strlen += 2;
        else
            strlen++;
        s += str.charAt(i);
    }
    return s;
}

JKD.checkChks = function (obj, cobj) {
    $(cobj).each(function () {
        $(this)[0].checked = obj.checked;
    })
}

JKD.getChks = function (obj) {
    var ids = [];
    $(obj).each(function () {
        if ($(this)[0].checked) ids.push($(this).val());
    });
    return ids;
}

JKD.showHide = function (t, str) {
    var s = str.split(',');
    if (t) {
        for (var i = 0; i < s.length; i++) {
            $(s[i]).show();
        }
    } else {
        for (var i = 0; i < s.length; i++) {
            $(s[i]).hide();
        }
    }
    s = null;
}

JKD.limitDecimal = function (obj, len) {
    var s = obj.value;
    if (s.indexOf(".") > -1) {
        if ((s.length - s.indexOf(".") - 1) > len) {
            obj.value = s.substring(0, s.indexOf(".") + len + 1);
        }
    }
    s = null;
}

JKD.getParams = function (obj) {
    var params = {};
    var chk = {}, s;
    $(obj).each(function () {
        if ($(this)[0].type == 'hidden' || $(this)[0].type == 'number' || $(this)[0].type == 'tel' || $(this)[0].type == 'password' || $(this)[0].type == 'select-one' || $(this)[0].type == 'textarea' || $(this)[0].type == 'text') {

            params[(typeof ($(this).attr('id')) == "undefined") ? $(this).attr('name') : $(this).attr('id')] = $.trim($(this).val());

        } else if ($(this)[0].type == 'radio') {
            if ($(this).attr('name')) {
                params[$(this).attr('name')] = $('input[name=' + $(this).attr('name') + ']:checked').val();
            }
        } else if ($(this)[0].type == 'checkbox') {
            if ($(this).attr('name') && !chk[$(this).attr('name')]) {
                s = [];
                chk[$(this).attr('name')] = 1;
                $('input[name=' + $(this).attr('name') + ']:checked').each(function () {
                    s.push($(this).val());
                });
                params[$(this).attr('name')] = s.join(',');
            }
        }
    });
    chk = null, s = null;
    return params;
}

JKD.setValue = function (name, value) {
    var first = name.substr(0, 1), input, i = 0, val;
    if ("#" === first || "." === first) {
        input = $(name);
    } else {
        input = $("[name='" + name + "']");
    }

    if (input.eq(0).is(":radio")) { //单选按钮
        input.filter("[value='" + value + "']").each(function () {
            this.checked = true
        });
    } else if (input.eq(0).is(":checkbox")) { //复选框
        if (!$.isArray(value)) {
            val = new Array();
            val[0] = value;
        } else {
            val = value;
        }
        for (i = 0, len = val.length; i < len; i++) {
            input.filter("[value='" + val[i] + "']").each(function () {
                this.checked = true
            });
        }
    } else {  //其他表单选项直接设置值
        input.val(value);
    }
}

JKD.setValues = function (obj) {
    var input, value, val;
    for (var key in obj) {
        if ($('#' + key)[0]) {
            JKD.setValue('#' + key, obj[key]);
        } else if ($("[name='" + key + "']")[0]) {
            JKD.setValue(key, obj[key]);
        }
    }
}

JKD.html_encode = function (str) {
    var s = "";
    if (str.length == 0) return "";
    s = str.replace(/&/g, "&gt;");
    s = s.replace(/</g, "&lt;");
    s = s.replace(/>/g, "&gt;");
    s = s.replace(/ /g, "&nbsp;");
    s = s.replace(/\'/g, "&#39;");
    s = s.replace(/\"/g, "&quot;");
    s = s.replace(/\n/g, "<br>");
    return s;
}

JKD.html_decode = function (str) {
    var s = "";
    if (str.length == 0) return "";
    s = str.replace(/&gt;/g, "&");
    s = s.replace(/&lt;/g, "<");
    s = s.replace(/&gt;/g, ">");
    s = s.replace(/&nbsp;/g, " ");
    s = s.replace(/&#39;/g, "\'");
    s = s.replace(/&quot;/g, "\"");
    s = s.replace(/<br>/g, "\n");
    return s;
}

JKD.toJson = function (str) {
    var json = {};
    try {
        if (typeof (str) == "object") {
            json = str;
        } else {
            json = eval("(" + str + ")");
        }

    } catch (e) {
        alert("系统发生错误:" + e.getMessage);
        json = {};
    }
    return json;
}


JKD.toastr = function (type, msg) {
    switch (type) {
        case 'danger':
            toastr.danger(msg);
            break;
        case 'warning':
            toastr.warning(msg);
            break;
        case 'success':
            toastr.success(msg);
            break;
        case 'info':
            toastr.info(msg);
            break;
        case 'error':
            toastr.error(msg);
            break;
    }
}


JKD.showError = function (msg) {
    Swal.fire({
        title: msg,
        icon: 'error',
        confirmButtonText: '确定'
    })
}


function getDay(num, str) {
    var today = new Date();
    var nowTime = today.getTime();
    var ms = 24 * 3600 * 1000 * num;
    today.setTime(parseInt(nowTime + ms));
    var oYear = today.getFullYear();
    var oMoth = (today.getMonth() + 1).toString();
    if (oMoth.length <= 1) oMoth = '0' + oMoth;
    var oDay = today.getDate().toString();
    if (oDay.length <= 1) oDay = '0' + oDay;
    return oYear + str + oMoth + str + oDay;
}


function formatCurrency(num) {

    if (num == 0) {
        return 0;
    }

    if (!num) {
        return;
    }

    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}


function formatCurrencyTenThou(num) {
    if (!num) {
        return;
    }
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 10 + 0.50000000001);
    //cents = num%10;
    num = Math.floor(num / 10).toString();
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num);
}


function TGSN(str) {
    return str.slice(0, 6) + ' - ' + str.slice(6);
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
