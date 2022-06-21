<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotellom - SEC</title>
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
        {{-- <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('images/HOTELLOM_LOGO_V2.png') }}" height="60" /></a>
        </div> --}}
    </nav>

    <div class="container">
        <main>

            <div class="py-5 text-center">
                <h2>FICHE DE RENSEIGNEMENTS</h2>
            </div>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4><i class="icon fa fa-success"></i> {{ session('status') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <br/>
            @endIf
            <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <a class="btn" style="background-color: #7c2156; color:#fff" href="{{ route('listHotellom') }}"> List des partenaires</a>
                    <br/><br/>

                    {{-- <h4 class="mb-3">Billing address</h4> --}}
                    <form class="needs-validation" action="<?= isset($client) ? '/hotellom/form/update/'.$client->id : '/hotellom/form' ?>" method="POST">
                        @csrf
                        <div class="row g-3"
                            style="border-style: solid; border-color: #ffde7ba1; border-radius: 20px; padding: 30px;">
                            <div class="col-sm-6">
                                <label for="fullName" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" name="fullName" id="fullName" placeholder=""
                                    value="<?= isset($client) ? $client->fullName : '' ?>" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="poste" class="form-label">Poste</label>
                                <input type="text" class="form-control" id="poste" name="poste" placeholder=""
                                    value="<?= isset($client) ? $client->poste : '' ?>" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="etablissement" class="form-label">Etablissement</label>
                                <input type="text" class="form-control" id="etablissement" name="etablissement" placeholder=""
                                    value="<?= isset($client) ? $client->etablissement : '' ?>" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="phone" class="form-label">Numéro de Tél</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="" value="<?= isset($client) ? $client->phone : '' ?>"
                                    required>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" required class="form-control" name="email" id="email" value="<?= isset($client) ? $client->email : '' ?>"
                                    placeholder="you@example.com">
                            </div>

                            <div class="col-sm-6">
                                <label for="ville" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="ville" name="ville" placeholder=""
                                value="<?= isset($client) ? $client->ville : '' ?>">
                            </div>

                            <div class="col-sm-6">
                                <label for="priorite" class="form-label">Priorité</label>
                                <select name="priorite" class="form-control">
                                    <option value="haute" <?php if(isset($client) && $client->priorite === "haute"){ echo "selected";} ?>>Haute</option>
                                    <option value="medium" <?php if(isset($client) && $client->priorite === "medium"){ echo "selected";} ?>>Médium</option>
                                    <option value="normale" <?php if(isset($client) && $client->priorite === "normale"){ echo "selected";} ?>>Normale</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label for="nbrChambre" class="form-label">Nombre de chambres</label>
                                <input type="number" class="form-control" id="nbrChambre" name="nbrChambre" placeholder=""
                                value="<?= isset($client) ? $client->nbrChambre : '' ?>">
                            </div>

                            <input type="hidden" name="id" id="id" value="<?= isset($client) ? $client->id : '' ?>" >

                            <input type="hidden" name="type" id="type" value="hotellom" >

                            <input type="hidden" name="demmands" id="aut" value="<?= isset($client) ? $client->demmands : '' ?>" >

                        </div>

                        <hr class="my-4">

                        <div class="row g-3"
                            style="border-style: solid; border-color: #00000091; border-radius: 20px; padding: 30px;">
                            <div class="py-5 text-center">
                                <h4>Modules</h4>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="room-service" class="form-check-input check"
                                        name="room-service" id="room-service" <?php if(isset($client) && in_array("room-service", explode(',', $client->demmands))){ echo 'checked="true"';} ?> >
                                    <label class="form-check-label" for="room-service">Room Service</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="promotion" class="form-check-input check"
                                        name="promotion" id="promotion" <?php if(isset($client) && in_array("promotion", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="promotion">Promotion</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="messagerie/chat" class="form-check-input check"
                                        name="messagerie" id="messagerie" <?php if(isset($client) && in_array("messagerie/chat", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="messagerie">Messagerie/Chat</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="points de vente" class="form-check-input check"
                                        name="points-de-vente" id="points-de-vente" <?php if(isset($client) && in_array("points de vente", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="points-de-vente">Points de vente</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="gestion des demandes" class="form-check-input check"
                                        name="gestion-des-demandes" id="gestion-des-demandes" <?php if(isset($client) && in_array("gestion des demandes", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="gestion des demandes">Gestion des
                                        demandes</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="appel audio" class="form-check-input check"
                                        name="appel-audio" id="appel-audio" <?php if(isset($client) && in_array("appel audio", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="appel-audio">Appel audio</label>
                                </div>
                            </div>

                            <div class="py-5 text-center">
                                <h4>Hardware</h4>
                            </div>

                            <div class="col-sm-12">
                                <textarea style="width: 100%" name="commentaire" ><?= isset($client) ? $client->commentaire : '' ?></textarea>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="tablette en chambre" class="form-check-input check"
                                        name="tablette-en-chambre" id="tablette-en-chambre" <?php if(isset($client) && in_array("tablette en chambre", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="tablette-en-chambre">Tablette en
                                        chambre</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="imprimante ticket" class="form-check-input check"
                                        name="imprimante-ticket" id="imprimante-ticket" <?php if(isset($client) && in_array("imprimante ticket", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="imprimante-ticket">Imprimente ticket</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="téléphone android en chambre"
                                        class="form-check-input check" name="telephone-android-en-chambre"
                                        id="telephone-android-en-chambre" <?php if(isset($client) && in_array("téléphone android en chambre", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="telephone-android-en-chambre">Téléphone android
                                        en chambre</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="Téléphone fixe tactile en chambre"
                                        class="form-check-input check" name="telephone-fixe-tactile-en-chambre"
                                        id="telephone-fixe-tactile-en-chambre" <?php if(isset($client) && in_array("Téléphone fixe tactile en chambre", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="telephone-fixe-tactile-en-chambre">Téléphone
                                        fixe tactile en chambre</label>
                                </div>
                            </div> --}}

                            <div class="py-5 text-center">
                                <h4>Date prévue pour le déploiement</h4>
                            </div>

                            <div class="col-sm-12 text-center">
                                <div class="col-sm-6">
                                    <input type="date" required class="form-control" name="datePre" id="datePre" value="<?= isset($client) ? $client->datePre : '' ?>" >
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-lg"
                            style="color: #fff; background-color: #7c2156 !important; border-color: #7c2156 important;"
                            type="submit">Enregister</button>
                    </form>
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
    <script>
        window.onload = function() {

            $(document).on('change', '.check', function() {
            var aut = [];
            if($(this).is(":checked")){
                //aut.push($(this).attr('v'));
                $('.check').each(function(){
                    if($(this).is(":checked")){
                        aut.push($(this).attr('v'));
                    }else if ($(this).prop('checked') === false){

                    }
                });
            }else if ($(this).prop('checked') === false){
                //aut.splice(aut.indexOf($(this).attr('v')), 1);
                $('.check').each(function(){
                    if($(this).is(":checked")){
                        aut.push($(this).attr('v'));
                    }else if ($(this).prop('checked') === false){

                    }
                });
            }
            $('#aut').val(aut);
            console.log(aut);
        });

        }
    </script>
</body>

</html>
