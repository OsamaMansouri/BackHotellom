<!DOCTYPE html>
<html>
<head>
    <title>Qrcode</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap">
</head>
<style>
     body{
        background: #35143B;
        text-align: center;
        font-family: 'Montserrat', sans-serif;
    }
    .content{
        margin-top: 150px;
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
    h3{
        font-size: 22px;
    }
    .logo{
        width: 400px;
    }
    .qrcode{
        width: 300px;
    }
    .hotel_code{
        font-size: 32px;
    }
      @page { margin: 0px; }
</style>
<body>
    <div class="content">
        <img class="logo" src="https://apptest.hotellom.com/static/media/logohotellom.png" alt="">
        <h3>HOTEL IN YOUR POCKET</h3>
        <h3 class="hotel_code">HOTEL CODE : {{$hotel_code}}</h3>
        <img class="qrcode" src="https://api.hotellom.com/img/rooms/room-{{$room_number}}{{$qrcode}}.png">
        <h3>APP.HOTELLOM.COM</h3>
        <h1>SAVE UP TP 25%</h1>
        <h3>SCAN THE QR CODE OR USE THE LINK <br> TO ACCESS THE APP</h3>
    </div>
</body>
</html>