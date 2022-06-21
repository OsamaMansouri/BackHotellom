<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hotellom - SEC</title>
        <style type="text/css">
            html, body {
                padding: 0;
                margin: 0;
                width: 100vw;
                height: 100vh;
                overflow: hidden;
            }
            .webView{
                width: 100%;
                height: 100vh;
                padding: 0;
                margin: 0;
                overflow: hidden;
                border: 0;
            }
        </style>
    </head>
    <body class="antialiased">

        <div>

            <form method="post" action="http://172.16.255.254:8002/index.php?zone=vgc" style="display: none;" id="js-cpForm">
				<input name="auth_user" type="text">
				<input name="auth_voucher" type="text">
				<input name="redirurl" id="redirurl" type="hidden" value="https://www.youtube.com/">
				<input name="zone" type="hidden" value="vgc">
				<input name="accept" type="submit" value="Continue" id="js-cpForm-submit">
			</form>

        </div>

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
        <script src="{{asset('jquery.min.js')}}"></script>
        <script>

            window.onload = function() {
                /* $("#js-cpForm").submit(function(e) {
                    e.preventDefault();
                    console.log('Form Submiit Event')
                    var data = $("#js-cpForm").serialize();
                    console.log(data)
                    var url = $("#js-cpForm").attr('action');
                    $.post(
                    `http://172.16.255.254:8002/index.php?zone=vgc`,
                    { data : data },
                    function(data) {
                        console.log("User Connected Successfully")
                    });
                }); */
                console.log("Button Clicked");
                $("#js-cpForm-submit").click();
                /* var data = $("#js-cpForm").serialize();
                console.log(data)
                var url = $("#js-cpForm").attr('action');
                $.post(
                `http://172.16.255.254:8002/index.php?zone=vgc`,
                { data : data },
                function(data) {
                    console.log("User Connected Successfully")
                }); */
                //setTimeout(() => {
               /*  $("#js-from-data").submit(function(e) {
                    var clName = $("#js-name").length ? $("#js-name").val() : "";
                    var clFname = $("#js-fname").length ? $("#js-fname").val() : "";
                    var clTel = $("#js-tel").val();
                    var clEmail = $("#js-email").val();
                    var clPwd = $("#js-pwd").val();
                    var userpwd = $("userpwd").val();
                    var userlogin = $("userlogin").val();

                    var request = "newClient";
                    var data = {
                        request: request,
                        name: clName,
                        fname: clFname,
                        tel: clTel,
                        email: clEmail,
                        pwd: clPwd,
                        userpwd : 'jrisalam123',
                        userlogin: 'jrisalam'
                    };

                    $.post(
                    `http://vigonprod.com/jrisalam/controller_user.php`, {
                        data: data
                    },
                    function(data, status) {
                        var resault = JSON.parse(data);
                        console.log(resault.status);
                        console.log(resault.message);
                        console.log(resault.data);
                        var message = JSON.stringify({
                            type: "login",
                            source: "form"
                        });
                        if (resault.status) {
                            //window.parent.postMessage(message, "*");
                        } else {
                            $("#js-userpwd").siblings(".help-block").removeClass("hidden");
                        }
                    });
                }); */
                //}, 1500);


                /* var iframe = document.getElementById('frame_name')
                iframe.contentWindow.postMessage('aha', '*');
                var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document
                var login = innerDoc.getElementById("js-userlogin")
                console.log("login " + login) */
                /* setTimeout(() => {
                    var email = document.getElementById("js-userlogin");
                    var pwr = document.getElementById("js-userpwd");
                    var email = window.frames['frame_name'].document.getElementById("js-userlogin")
                    email.value('jrisalam');
                    pwr.value('jrisalam123');
                }, 1000); */
            }

        </script>
    </body>
</html>
