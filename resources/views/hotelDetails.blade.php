<!DOCTYPE html>
<html>
<head>
    <title>Hotel Details QrCode</title>
</head>
<body>

<div class="visible-print text-center">

    @foreach($rooms  as $room)
        <div class="text-center">
            <h1>Hotel's QrCode</h1>
            {!! QrCode::size(250)->generate(\App\Models\Hotel::getHotelDetails($room->qrcode)); !!}
            <p>Hotellom Hotel details.</p>
        </div>
    @endforeach


</div>

</body>
</html>
