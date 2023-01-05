<!DOCTYPE html>
<html>
<head>
    <title>Qrcode</title>
</head>
<style>
    body{
        background: #35143B;
        text-align: center;
        font-family: "Times New Roman", Times, serif;
    }
    h2,h4,h3{
        color: #fff;
    }
    h1{
        color: #D1AB67;
        font-size:50px;
    }
    h2{
        font-size: 45px;
    }
    h4{
        margin-top: -25px;
        font-weight: 300;
        font-size: 25px;
    }
    h3{
        font-size: 22px;
    }
    .logo{
        width: 400px;
    }
    .qrcode{
        width: 300px;
    }
</style>
<body>
    <img class="logo" src="/logohotellom.png"  alt="">
    <h3>HOTEL IN YOUR POCKET</h3>
    <h3>HOTEL CODE : {{$hotel_code}} </h3>
    <img class="qrcode" src="https://api.hotellom.com/img/hotels/hotel-{{$reference}}.png">
    <h3>APP.HOTELLOM.COM</h3>
    <h1>SAVE UP TP 25%</h1>
    <h4>SCAN THE QR CODE OR USE THE LINK <br> TO ACCESS THE APP</h4>
</body>
</html>