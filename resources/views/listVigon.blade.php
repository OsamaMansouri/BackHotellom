<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vigon Systems - SEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
            <img src="https://vigonsystems.com/wp-content/uploads/2019/12/Asset-11blacknotsvg-160x49.png" height="60" /></a>
        </div>
    </nav>

    <div class="container">
        <main>

            <div class="py-5 text-center">
                <h2>LISTE DES UTILISATEURS</h2>
            </div>
            <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <a class="btn" style="background-color: #0d6efd; color:#fff" href="{{ route('addVigon') }}"> Nouveau Client</a>
                    <br/><br/>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Profile</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <th>{{ $client->fullName }}</th>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->vendeur }}</td>
                                <td>
                                    <a href="{{ url('vigon/'. $client->id .'/show') }}"
                                        class="btn btn-success btn-sm" title="afficher"><i class="fa fa-eye"></i></a>
                                    <a href="{{ url('vigon/'. $client->id .'/edit') }}"
                                        class="btn btn-info btn-sm" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <form action="{{ url('vigon/'. $client->id .'/delete') }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                            <a type="submit" href="{{ url('vigon/'. $client->id .'/delete') }}"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')"
                                                class="btn btn-warning btn-sm" title="Supprimer"><i class="fa fa-trash"></i></a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>

                    {{-- <h4 class="mb-3">Billing address</h4> --}}
                </div>

            </div>
    </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2021–2022 Vigon Systems</p>
    </footer>
    </div>

    {{-- <script src="{{ asset('jquery.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script>
        window.onload = function() {


        }
    </script>
</body>

</html>
