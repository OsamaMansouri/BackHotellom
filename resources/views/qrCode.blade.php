<!DOCTYPE html>
<html>
<head>
    <title>Rooms QrCode</title>
</head>
<body>

<div class="visible-print text-center">

    @foreach($rooms  as $room)
        <div class="text-center">
            <h1>Qrcode of room : {{$room->room_number}}</h1>
            {!! QrCode::size(250)->generate(\App\Models\Room::getRoomByQrCode($room->qrcode)); !!}
            <p>Hotellom rooms.</p>
        </div>
    @endforeach


</div>

</body>
</html>
