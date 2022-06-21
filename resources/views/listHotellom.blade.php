<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotellom - SEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
    <style>
        .form-check-input{
            width: 1.5em !important;
            height: 1.5em !important;
        }
        h4{
            color: #5b1c6e;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('images/HOTELLOM_LOGO_V2.png') }}" height="60" /></a>
        </div>
    </nav>

    <div class="container">
        <main>

            <div class="py-5 text-center">
                <h2>LISTE DES PARTENAIRES</h2>
            </div>
            <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <a class="btn" style="background-color: #7c2156; color:#fff" href="{{ route('addHotellom') }}"> Nouveau partenaire</a>
                    <br/><br/>
                    <table class="table table-bordered table-striped" style="width:100%" id="list_hotellom">
                        <thead class="thead-dark">
                          <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <th>{{ $client->fullName }}</th>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>
                                    <a href="{{ url('hotellom/'. $client->id .'/show') }}"
                                        class="btn btn-success btn-sm" title="afficher"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('hotellom/'. $client->id .'/edit') }}"
                                        class="btn btn-info btn-sm" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <form action="{{ url('hotellom/'. $client->id .'/delete') }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                            <a type="submit" href="{{ url('hotellom/'. $client->id .'/delete') }}"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?')"
                                                class="btn btn-warning btn-sm" title="Supprimer"><i class="fa fa-trash"></i></a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
    </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2021–2022 Hotellom</p>
    </footer>
    </div>

    {{-- <script src="{{ asset('jquery.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#list_hotellom').DataTable();
            $('#example').DataTable();

        } );
    </script>
</body>

</html>
