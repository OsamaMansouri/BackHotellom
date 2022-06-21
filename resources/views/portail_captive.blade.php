<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hotellom - SEC</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style type="text/css">
            html, body {
                padding: 0;
                margin: 0;
                width: 100vw;
                /* height: 100vh; */
                overflow: hidden;
                background-color: rgba(59,24,77,1)
            }
            .container {
                text-align: center;
                padding-top: 40px
            }
            .title{
                color: aliceblue;
                /* padding-top: 30px */
            }
            .logo{
                padding-top: 0px;
            }
            .logo img{
                width: 500px;
                height: 150px;
                object-fit: contain;
            }
            .short_descr{
                color: aliceblue;
                padding-top: 30px
            }
            .btn-connect{
                border-radius: 15px;
                border-color: rgba(112,56,122,1);
                text-transform: uppercase;
                white-space: nowrap;
                text-align: left;
                font-family: Montserrat;
                font-style: normal;
                font-weight: bold;
                font-size: 28px;
                color: rgba(112,56,122,1);
                padding: 15px 60px;
                margin-top: 30px;
            }
            .discount, .short_mobile_descr{
                color: aliceblue;
                font-size: 20px;
            }
            .discount span, .short_mobile_descr span{
                font-weight: bold;
            }
            .row-bottom{
                display: grid;
                color: aliceblue;
                font-size: 20px;
                grid-template-columns: auto auto;
            }
            .row-bottom a{
                color: aliceblue;
            }
            .grid-item-1 {
                padding: 20px;
                text-align: start;
            }
            .grid-item-2 {
                padding: 20px;
                text-align: end;
            }
            @media only screen and (max-width: 600px) {
                .container {
                    padding-top: 20px
                }
                .logo img{
                    width: 200px;
                }
                .row-bottom{
                    font-size: 12px;
                    grid-template-columns: auto auto;
                }
                .grid-container{
                    position: absolute;
                    bottom: 0;
                    width: 100%;
                }
                .short_mobile_descr{
                    padding-top: 12%;
                }
                .btn-android{
                    background-image: linear-gradient(to right, #40e47a 23%, #75edf2 100%);
                    font-size: 20px;
                    font-weight: bold;
                    padding: 13px 20px;
                    color: rgba(59,24,77,1);
                    border-radius: 15px;
                    border-color: rgba(59,24,77,1);
                }
                .btn-apple{
                    background-image: linear-gradient(to right, #dadcdb 40%, #ffffff 100%);
                    font-size: 20px;
                    font-weight: bold;
                    padding: 13px 20px;
                    color: rgb(112 56 122);
                    border-radius: 15px;
                    border-color: rgba(59,24,77,1);
                }
            }
        </style>
    </head>
    <body>

        <div class="web-format" id="web-format">
            <div class="container">
                <div class="row">
                    <div class="logo">
                        <img src="https://api.hotellom.com/img/logohotellom.png" alt="">
                    </div>
                    <div class="title_section">
                        <h1 class="title">Welcome to Royal Mirage Deluxe,</h1>
                    </div>
                    <div class="short_descr_section">
                        <p class="short_descr">Tape to connect</p>
                    </div>
                    <div class="">
                        <p class="short_mobile_descr">Download our app<br><span>TO CONNECT TO THE WIFI</span></p>
                    </div>
                    <div class="short_descr_section">
                        <button class="btn-connect">Connect</button>
                    </div>
                    <div class="btn-area">
                        <a href=""><button class="btn-android"><i class="fa-brands fa-android"></i> Play Store</button></a>
                        <a href=""><button class="btn-apple"><i class="fa-brands fa-apple"></i> App Store</button></a>
                    </div>
                    <div>
                        <p class="discount">
                            <span>GET 25% DISCOUNT</span> <br>On all our services
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid-container">
                <div class="row-bottom">
                    <div class="grid-item-1">
                        <p class="">
                            HOTEL RESERVATION <br>
                            <a href="mailto:support@hotellom.com">RESA@HOTEL.COM</a><br>
                            <a href="tel:0524153625">0524 44 44 44</a></p>
                    </div>
                    <div class="grid-item-2">
                        <p class="">
                            HOTELLOM SUPPORT<br>
                            <a href="tel:0524153625">088 800 808</a><br>
                            <a href="mailto:support@hotellom.com">SUPPORT@HOTELLOM.COM</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('jquery.min.js')}}"></script>
        <script>

            window.onload = function() {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
                    $('.btn-connect').hide();
                    $('.short_descr_section').hide();
                    $('.short_mobile_descr').show();
                    $('.btn-area').show();
                } else {
                    $('.btn-connect').show();
                    $('.short_descr_section').show();
                    $('.short_mobile_descr').hide();
                    $('.btn-area').hide();
                }
                /* const isMobile = navigator.userAgentData.mobile;
                console.log(isMobile) */
            }

        </script>
    </body>
</html>
