window.onload = function(){
    //微信浏览器中，aler弹框不显示域名
    (function () {
        //先判断是否为微信浏览器
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            //重写alert方法，alert()方法重写，不能传多余参数
            window.alert = function (name) {
                var iframe = document.createElement("IFRAME");
                iframe.style.display = "none";
                iframe.setAttribute("src", 'data:text/plain');
                document.documentElement.appendChild(iframe);
                window.frames[0].window.alert(name);
                iframe.parentNode.removeChild(iframe);
            }
        }
    })();
    $('.custom-form').submit(function () {
        $('.custom-btn').prop('disabled', true);
    });
}

