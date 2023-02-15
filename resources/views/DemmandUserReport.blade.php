<!DOCTYPE html>
<html>
<head>
    <title>Client Request Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</head>
<style>
     body{
        text-align: center;
        font-family: 'Montserrat';
        margin: 0 auto; 
    }
    .content{
        margin-left: auto;
        margin-right: auto;
    }
    .title h2{
        background: #F2F2F2;
        font-weight: 100;
        color: #424244;
    }
    table{
        font-size: 18px;
        display: table;
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0px;
        margin-bottom: 1.5rem;
    }
    table tbody tr{
      color: inherit;
      display: table-row;
      vertical-align: middle;
      outline: 0px;
    }
</style>
<body>

   
    <div class="container">
        <div class="row">
            <div class="col-md-6 content table-responsive">
                <div class="title">
                    <h2 class="mb-5 mt-5">Demmand Request Report</h2>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                      <tr>
                        <td>Request From</td>
                        <td>{{$user_name}}</td>
                      </tr>
                      <tr>
                        <td>Request Name</td>
                        <td>{{$demmand_name}}</td>
                      </tr>
                      <tr>
                        <td>Demmand Option</td>
                        <td>{{$demmand_option}}</td>
                      </tr>
                      <tr>
                        <td>Request Message</td>
                        <td>{{$message}}</td>
                      </tr>
                      <tr>
                        <td>Room Number</td>
                        <td>{{$room_number}}</td>
                      </tr>
                      <tr>
                        <td>Request Status</td>
                        <td>{{$status}}</td>
                      </tr>
                      <tr>
                        <td>Request Created at</td>
                        <td>{{$created_at_time}}</td>
                      </tr>
                      <tr>
                        <td>Request Done by</td>
                        <td>{{ $done_by }}</td>
                      </tr>
                      <tr>
                        <td>Request Done at</td>
                        <td>{{ $updated_at_time  }}</td>
                      </tr>

                      <tr>
                        <td>Request done after</td>
                        <td>{{ $difftime  }}</td>
                      </tr>

                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</body>
</html>