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
            color: #0d6efd !important;
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
                <h2>FICHE DE RENSEIGNEMENTS</h2>
            </div>
            <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <a class="btn" style="background-color: #0d6efd; color:#fff" href="{{ route('listVigon') }}"> List Clients</a>
                    <br/><br/>

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
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder=""
                                value="<?= isset($client) ? $client->phone : '' ?>"
                                    required>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" required class="form-control" name="email" id="email"
                                <?= isset($client) ? $client->email : '' ?>
                                    placeholder="you@example.com">
                            </div>

                            <div class="col-sm-6">
                                <label for="vendeur" class="form-label">Vendeur</label>
                                <input type="text" class="form-control" id="vendeur" name="vendeur" placeholder=""
                                    value="<?= isset($client) ? $client->vendeur : '' ?>" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="profile" class="form-label">Profile</label>
                                <select name="profile" class="form-control">
                                    <option value="">Choisir Profile </option>
                                    <option value="tres chaud">Très chaud</option>
                                    <option value="chaud">Chaud</option>
                                    <option value="interessant">Intéressant</option>
                                    <option value="partenaire">Partenaire</option>
                                </select>
                            </div>

                            <input type="hidden" name="type" id="type" value="vigon" >

                            <input type="hidden" name="demmands" id="aut" value="<?= isset($client) ? $client->demmands : '' ?>" >

                        </div>

                        <div class="py-5 text-center">
                            <h2>Besoin en IT</h2>
                        </div>
                        <hr class="my-4">

                        <div class="row g-3"
                            style="border-style: solid; border-color: #00000091; border-radius: 20px; padding: 30px;">
                            <div class="py-5 text-center">
                                <h4>Hôtel en</h4>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="ouverture" class="form-check-input check"
                                        name="ouverture" id="ouverture"
                                        <?php if(isset($client) && in_array("ouverture", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="ouverture">Ouverture</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="renovation" class="form-check-input check"
                                        name="renovation" id="renovation"
                                        <?php if(isset($client) && in_array("renovation", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="renovation">Renovation</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="exploitation" class="form-check-input check"
                                        name="exploitation" id="exploitation"
                                        <?php if(isset($client) && in_array("exploitation", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="exploitation">Exploitation</label>
                                </div>
                            </div>

                            <div class="py-5 text-center">
                                <h4>Besoin en Technologie</h4>
                            </div>

                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="iptv" class="form-check-input check"
                                        name="iptv" id="iptv"
                                        <?php if(isset($client) && in_array("iptv", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="iptv">IPTV</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="application de gestion" class="form-check-input check"
                                        name="application-de-gestion" id="application-de-gestion"
                                        <?php if(isset($client) && in_array("application-de-gestion", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="application-de-gestion">Application de gestion</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="osto" class="form-check-input check"
                                        name="osto" id="osto"
                                        <?php if(isset($client) && in_array("osto", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="osto">Osto</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="maintenance informatique" class="form-check-input check"
                                        name="maintenance-informatique" id="maintenance-informatique"
                                        <?php if(isset($client) && in_array("maintenance-informatique", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="maintenance-informatique">Maintenance Informatique</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="wifi"
                                        class="form-check-input check" name="wifi"
                                        id="wifi"  <?php if(isset($client) && in_array("wifi", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="wifi">Wifi</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="téléphonie"
                                        class="form-check-input check" name="telephonie"
                                        id="telephonie"  <?php if(isset($client) && in_array("téléphonie", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="telephonie">Téléphonie</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="controle d'acccès"
                                        class="form-check-input check" name="controle-dacces"
                                        id="controle-dacces" <?php if(isset($client) && in_array("controle-dacces", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="controle-dacces">Controle d'accès</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="it management"
                                        class="form-check-input check" name="it-management"
                                        id="it-management" <?php if(isset($client) && in_array("it-management", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="it-management">IT Management (Nouveau)</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="serveur"
                                        class="form-check-input check" name="serveur"
                                        id="serveur" <?php if(isset($client) && in_array("serveur", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="serveur">Serveur</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="cablage"
                                        class="form-check-input check" name="cablage"
                                        id="cablage" <?php if(isset($client) && in_array("cablage", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="cablage">Câblage</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="incendie"
                                        class="form-check-input check" name="incendie"
                                        id="incendie" <?php if(isset($client) && in_array("incendie", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="incendie">Incendie</label>
                                </div>
                                <br />
                                <div class="col-sm-12">
                                    <input type="checkbox" v="audio-visual"
                                        class="form-check-input check" name="audio-visual"
                                        id="audio-visual" <?php if(isset($client) && in_array("audio-visuel", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="audio-visual">Audio-visual</label>
                                </div>
                            </div>

                            <div class="py-5 text-center">
                                <h4>Mode de fonctionnement</h4>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="subvention" class="form-check-input check"
                                        name="subvention" id="subvention" <?php if(isset($client) && in_array("subvention", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="subvention">Subvention</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="mode location OPEX" class="form-check-input check"
                                        name="mode-location-OPEX" id="mode-location-OPEX" <?php if(isset($client) && in_array("mode-location-OPEX", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="mode-location-OPEX">Mode location OPEX</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <input type="checkbox" v="fonds propre" class="form-check-input check"
                                        name="fonds-propre" id="fonds-propre" <?php if(isset($client) && in_array("fonds-propre", explode(',', $client->demmands))){ echo 'checked="true"';} ?>>
                                    <label class="form-check-label" for="fonds-propre">Fonds propre</label>
                                </div>
                            </div>

                            <div class="py-5 text-center">
                                <h4>Date prévue pour le déploiement</h4>
                            </div>

                            <div class="col-sm-12 text-center">
                                <div class="col-sm-6">
                                    <input type="date" required class="form-control" name="datePre" id="datePre" value="<?= isset($client) ? $client->datePre : '' ?>">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

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
