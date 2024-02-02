var tableClient;
var id_image;
var tableChambre;
var tableFontion;
var tableSalaire;
var url_client = "./model/php/employerDAO.php";
var liste_chamb_tarif;


var statut_user = $('.statut_user').val()

function dateDiff(date1, date2) {
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;

    tmp = Math.floor(tmp / 1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes

    tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes

    tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures

    tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
    diff.day = tmp;

    return diff;
}

var langue = {
    "sProcessing": "Traitement en cours ...",
    "sLengthMenu": "Afficher _MENU_",
    "sZeroRecords": "Aucun résultat trouvé",
    "sEmptyTable": "Aucune donnée disponible",
    "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
    "sInfoEmpty": "Aucune ligne affichée",
    "sInfoFiltered": "(Filtrer un maximum _MAX_)",
    "sInfoPostFix": "",
    "sSearch": "Chercher:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Chargement...",
    "oPaginate": {
        "sFirst": "Premier",
        "sLast": "Dernier",
        "sNext": "Suivant",
        "sPrevious": "Précédent"
    },
    "oAria": {
        "sSortAscending": ":Trier par ordre croissant",
        "sSortDescending": ":Trier par ordre décroissant"
    }
};

var client_cours = function () {
    if (tableClient) {
        $("#table_client").DataTable().clear().destroy();
    }
    tableClient = $("#table_client").DataTable({
        lengthMenu: [5, 20, 50, 100, 200],
        fixedHeader: true,
        language: langue
    });

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_client,
                dataType: "JSON",
                method: "POST",
                data: { FILTRE_CLIENT: "FILTRE_CLIENT", filtre: 1 },
            })
                .done(function (response) {
                    self.close();

                    $.each(response, function (index, rowS) {
                        index++;

                        var action;
                        if (statut_user.indexOf('1') > -1) {
                            //alert(statut_user)
                            action =
                                '<div class="btn-group">' +
                                '<button type="button" class="btn btn-danger">Options</button>' +
                                '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="sr-only">Toggle Dropdown</span>' +
                                '</button>' +
                                '<div class="dropdown-menu" role="menu">' +
                                '<a class="dropdown-item btn_look_employer" data-idclient="' + rowS.idClient + '" href="#">Afficher</a>' +
                                '<a class="dropdown-item btn_modif_employer" data-idclient="' + rowS.idClient + '" href="#">Modifier</a>' +
                                '<a class="dropdown-item btn_supp_employer" data-idclient="' + rowS.idClient + '" href="#">Supprimer</a>' +
                                '<div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href="./output/PDF/info_client.php?id_info=' + rowS.idClient + '" target="_blank">Imprimer</a>' +
                                '</div>' +
                                '</div>';
                        } else {
                            action =
                                '<div class="btn-group">' +
                                '<button type="button" class="btn btn-danger">Options</button>' +
                                '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="sr-only">Toggle Dropdown</span>' +
                                '</button>' +
                                '<div class="dropdown-menu" role="menu">' +
                                '<a class="dropdown-item btn_look_employer" data-idclient="' + rowS.idClient + '" href="#">Afficher</a>' +
                                '<a class="dropdown-item btn_modif_employer" data-idclient="' + rowS.idClient + '" href="#">Modifier</a>' +

                                '<div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href="./output/PDF/info_client.php?id_info=' + rowS.idClient + '" target="_blank">Imprimer</a>' +
                                '</div>' +
                                '</div>';
                        }
                        var statut;
                        if (rowS.statut == 1) {
                            statut = '<input type="checkbox" name="statut" id="statut" data-id="' + rowS.idClient + '" value="0" checked>'

                        } else {
                            //statut='<input type="checkbox" name="statut" id="statut" data-id="' + rowS.idClient + '" value="1">'
                        }
                        var date_arrive = (rowS.dateArrivee.toString().indexOf('-') > -1) ? rowS.dateArrivee.split('-') : rowS.dateArrivee.split('/')
                        var date_depart = (rowS.dateDepart.toString().indexOf('-') > -1) ? rowS.dateDepart.split('-') : rowS.dateDepart.split('/')
                        tableClient.row.add([
                            rowS.num_chambre,
                            rowS.nomClient + ' ' + rowS.prenom,
                            date_arrive[2] + '-' + date_arrive[1] + '-' + date_arrive[0],
                            date_depart[2] + '-' + date_depart[1] + '-' + date_depart[0],
                            statut,
                            // index,
                            action,
                        ]);
                    });

                    tableClient.draw();
                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};

var select_chb = function () {
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_client,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_CHAMBRE: "SELECT_ALL_CHAMBRE" },
            })
                .done(function (response) {
                    self.close();
                    
                    var liste_chamb = "";
                    liste_chamb_tarif = response;
                    $.each(response, function (index, rowS) {
                        index++;
                        liste_chamb +=
                            '<option class="val_chbr" value="' + rowS.num_chambre + '" data-tarif="' + rowS.tarifNuite + '">' + rowS.num_chambre + '</option>';

                    });
                    $("#numchambre").html(liste_chamb);


                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
}

var select_chb_filtre = function (params) {


    $.ajax({
        url: url_client,
        dataType: "JSON",
        method: "POST",
        data: { SELECT_ALL_CHAMBRE: "SELECT_ALL_CHAMBRE" },
        success: function (reponse1) {
            var reponse_chambre = reponse1;
            var liste_chamb = '';
            $.ajax({
                url: url_client,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_EMPLOYER_FILTRE: "SELECT_ALL_EMPLOYER_FILTRE" },
                success: function (reponse) {

                    var reponse_client = reponse;

                    $.each(reponse_chambre, function (index, rowS_chambre) {
                        var boll = true;
                        $.each(reponse_client, function (index, rowS_client) {

                            if (rowS_client.num_chambre.indexOf(rowS_chambre.num_chambre) > -1) {

                                if (rowS_client.jour.indexOf(params) > -1) {
                                    boll = false;
                                }
                            }

                        });
                        if (boll) {
                            liste_chamb +=
                                '<option class="val_chbr" value="' + rowS_chambre.num_chambre + '" data-tarif="' + rowS_chambre.tarifNuite + '">' + rowS_chambre.num_chambre + '</option>';

                        }

                    });

                    $("#numchambre").html(liste_chamb);

                }
            })

        }
    })


}

var client_quitte = function () {
    if (tableClient) {
        $("#table_client").DataTable().clear().destroy();
    }
    tableClient = $("#table_client").DataTable({
        lengthMenu: [5, 20, 50, 100, 200],
        fixedHeader: true,
        language: langue
    });

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_client,
                dataType: "JSON",
                method: "POST",
                data: { FILTRE_CLIENT: "FILTRE_CLIENT", filtre: 2 },
            })
                .done(function (response) {
                    self.close();

                    $.each(response, function (index, rowS) {
                        index++;

                        var action;
                        if (statut_user.indexOf('1') > -1) {
                            //alert(statut_user)
                            action =
                                '<div class="btn-group">' +
                                '<button type="button" class="btn btn-danger">Option</button>' +
                                '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="sr-only">Toggle Dropdown</span>' +
                                '</button>' +
                                '<div class="dropdown-menu" role="menu">' +
                                '<a class="dropdown-item btn_look_employer" data-idclient="' + rowS.idClient + '" href="#">Afficher</a>' +
                                '<a class="dropdown-item btn_modif_employer" data-idclient="' + rowS.idClient + '" href="#">Modifier</a>' +
                                '<a class="dropdown-item btn_supp_employer" data-idclient="' + rowS.idClient + '" href="#">Supprimer</a>' +
                                '<div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href="./output/PDF/info_client.php?id_info=' + rowS.idClient + '" target="_blank">Imprimer</a>' +
                                '</div>' +
                                '</div>';
                        } else {
                            action =
                                '<div class="btn-group">' +
                                '<button type="button" class="btn btn-danger">Option</button>' +
                                '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="sr-only">Toggle Dropdown</span>' +
                                '</button>' +
                                '<div class="dropdown-menu" role="menu">' +
                                '<a class="dropdown-item btn_look_employer" data-idclient="' + rowS.idClient + '" href="#">Afficher</a>' +
                                '<a class="dropdown-item btn_modif_employer" data-idclient="' + rowS.idClient + '" href="#">Modifier</a>' +

                                '<div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href="./output/PDF/info_client.php?id_info=' + rowS.idClient + '" target="_blank">Imprimer</a>' +
                                '</div>' +
                                '</div>';
                        }
                        var statut;
                        if (rowS.statut == 0) {
                            statut = '<input type="checkbox" name="statut" id="statut" data-id="' + rowS.idClient + '" value="1">'

                        }
                        var date_arrive = (rowS.dateArrivee.toString().indexOf('-') > -1) ? rowS.dateArrivee.split('-') : rowS.dateArrivee.split('/')
                        var date_depart = (rowS.dateDepart.toString().indexOf('-') > -1) ? rowS.dateDepart.split('-') : rowS.dateDepart.split('/')
                        tableClient.row.add([
                            rowS.num_chambre,
                            rowS.nomClient + ' ' + rowS.prenom,
                            date_arrive[2] + '-' + date_arrive[1] + '-' + date_arrive[0],
                            date_depart[2] + '-' + date_depart[1] + '-' + date_depart[0],
                            statut,
                            // index,
                            action,
                        ]);
                    });

                    tableClient.draw();
                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};

var affiche_chambre = function () {
    if (tableChambre) {
        $("#table_chambre").DataTable().clear().destroy();
    }
    tableChambre = $("#table_chambre").DataTable({
        lengthMenu: [8, 20, 50, 100, 200],
        fixedHeader: true,
        language: langue
    });

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_client,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_CHAMBRE: "SELECT_ALL_CHAMBRE" },
            })
                .done(function (response) {
                    self.close();
                   
                    $.each(response, function (index, rowS) {
                        index++;
                        var action =
                            '<div class="btn-group' + rowS.id_chambre + '">' +
                            '       <button type="button" data-id_chambre="' + rowS.id_chambre + '" class="btn btn-warning btn-sm fa fa-edit btn_modif_chambre"></button>' +
                            '       <button type="button" data-id_chambre="' + rowS.id_chambre + '" class="btn btn-danger btn-sm btn_supp_chambre"><i class="fa fa-trash"></i></button>' +
                            '</div>';

                        tableChambre.row.add([
                            index,
                            rowS.num_chambre,
                            rowS.description,
                            rowS.type,
                            rowS.tarifNuite,
                            action,
                        ]);
                    });

                    tableChambre.draw();
                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};

var affiche_client = function () {
    if (tableClient) {
        $("#table_client").DataTable().clear().destroy();
    }
    tableClient = $("#table_client").DataTable({
        lengthMenu: [8, 20, 50, 100, 200],
        fixedHeader: true,
        language: langue
    });

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_client,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_EMPLOYER: "SELECT_ALL_EMPLOYER" },
            })
                .done(function (response) {
                    self.close();

                    $.each(response, function (index, rowS) {
                        index++;

                        var action;
                        if (statut_user.indexOf('1') > -1) {
                            //alert(statut_user)
                            action =
                                '<div class="btn-group">' +
                                '<button type="button" class="btn btn-danger">Options</button>' +
                                '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="sr-only">Toggle Dropdown</span>' +
                                '</button>' +
                                '<div class="dropdown-menu" role="menu">' +
                                '<a class="dropdown-item btn_look_employer" data-idclient="' + rowS.idClient + '" href="#">Afficher</a>' +
                                '<a class="dropdown-item btn_modif_employer" data-idclient="' + rowS.idClient + '" href="#">Modifier</a>' +
                                '<a class="dropdown-item btn_supp_employer" data-idclient="' + rowS.idClient + '" href="#">Supprimer</a>' +
                                '<div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href="./output/PDF/info_client.php?id_info=' + rowS.idClient + '" target="_blank">Imprimer</a>' +
                                '</div>' +
                                '</div>';
                        } else {
                            action =
                                '<div class="btn-group">' +
                                '<button type="button" class="btn btn-success">Option</button>' +
                                '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="sr-only">Toggle Dropdown</span>' +
                                '</button>' +
                                '<div class="dropdown-menu" role="menu">' +
                                '<a class="dropdown-item btn_look_employer" data-idclient="' + rowS.idClient + '" href="#">Afficher</a>' +
                                '<a class="dropdown-item btn_modif_employer" data-idclient="' + rowS.idClient + '" href="#">Modifier</a>' +

                                '<div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href="./output/PDF/info_client.php?id_info=' + rowS.idClient + '" target="_blank">Imprimer</a>' +
                                '</div>' +
                                '</div>';
                        }
                        var statut;
                        if (rowS.statut == 1) {
                            statut = '<input type="checkbox" name="statut" id="statut" data-id="' + rowS.idClient + '" value="0" checked>'

                        } else {
                            statut = '<input type="checkbox" name="statut" id="statut" data-id="' + rowS.idClient + '" value="1">'
                        }
                        var date_arrive = (rowS.dateArrivee.toString().indexOf('-') > -1) ? rowS.dateArrivee.split('-') : rowS.dateArrivee.split('/')
                        var date_depart = (rowS.dateDepart.toString().indexOf('-') > -1) ? rowS.dateDepart.split('-') : rowS.dateDepart.split('/')
                        tableClient.row.add([
                            rowS.num_chambre,
                            rowS.nomClient + ' ' + rowS.prenom,
                            date_arrive[2] + '-' + date_arrive[1] + '-' + date_arrive[0],
                            date_depart[2] + '-' + date_depart[1] + '-' + date_depart[0],
                            statut,
                            // index,
                            action,
                        ]);
                    });

                    tableClient.draw();
                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};

var add_client = function (idClient) {
    var chbr;

    $.confirm({
        columnClass: "xlarge",
        title: !idClient ? 'Ajouter un nouveau client' : 'Modifier un  client',
        content: "" +
            '<form action="" class="formulaire_client" id="formulaire_client" enctype="multipart/form-data">' +


            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-12 mb-3 text-center bg-danger" style="min-height:40px;">' +

            '	<label class="mt-2" style="font-size:20px;">Informations du client</label>' +

            '		</div>' +

            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="nom">Nom*</label>' +
            '	<input type="text" class="form-control form-control-sm design nom" name="nom" id="nom" required>' +
            '		</div>' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="prenom">Prénom</label>' +
            '	<input type="text" class="form-control form-control-sm prenom" name="prenom" id="prenom" required>' +
            '	    </div>' +

            '<div class="col-md-6" mb-3>' +
            '<!-- select -->' +
            '<div class="form-group">' +
            '<label>Type*</label>' +
            '<select class="form-control type" name="type" id="type">' +
            '<option>Adulte</option>' +
            '<option>Enfant</option>' +
            '</select>' +
            '</div>' +
            '</div>' +

            '<div class="col-md-6 mb-3">' +

            '	<label for="societe">Société</label>' +
            '	<input class="form-control form-control-sm societe" name="societe" id="societe" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +


            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="datenais">Date de naissance</label>' +
            '	<input type="date" class="form-control form-control-sm datenais" name="datenais" id="datenais" required>' +
            '		</div>' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="lieunais">Lieu de naissance</label>' +
            '	<input type="text" class="form-control form-control-sm lieunais " name="lieunais" id="lieunais" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +


            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="pere">Père</label>' +
            '	<input type="text" class="form-control form-control-sm pere" name="pere" id="pere" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="mere">Mère</label>' +
            '	<input type="text" class="form-control form-control-sm mere" name="mere" id="mere" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="telephone">Téléphone</label>' +
            '	<input type="tel" class="form-control form-control-sm telephone" name="telephone" id="telephone" required>' +
            '		</div>' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="nationalite">Nationalité*</label>' +
            '	<input type="text" class="form-control form-control-sm nationalite" name="nationalite" id="nationalite" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="domicile">Domicile exacte</label>' +
            '	<input type="text" class="form-control form-control-sm domicile" name="domicile" id="domicile" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="profession">Profession</label>' +
            '	<input type="text" class="form-control form-control-sm profession" name="profession" id="profession" required>' +
            '		</div>' +

            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="cin">CIN*</label>' +
            '	<input  type="file" class="form-control form-control-sm cin" name="cin" id="cin" onchange="show_image(\'cin_image\')">' +
            '   <img id="cin_image" style="max-width:100px;">' +
            '		</div>' +


            '  <div class="col-md-6 mb-3">' +

            '	<label for="passeport">Passeport*</label>' +
            '	<input  type="file" class="form-control form-control-sm passeport" name="passeport" id="passeport"onchange="show_image(\'passeport_image\')">' +
            '   <img id="passeport_image" style="max-width:100px;">' +
            '	    </div>' +

            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-12 mb-3 text-center bg-danger" style="min-height:40px;">' +

            '	<label class="mt-2" style="font-size:20px;">Fiche de chambre</label>' +

            '		</div>' +

            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="arrive">Date d\'arrivée*</label>' +
            '	<input type="date" class="form-control form-control-sm design arrive" name="arrive" id="arrive" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +
            '	<label for="depart">Date de départ*</label>' +
            '	<input type="date" class="form-control form-control-sm design depart " disabled name="depart" id="depart" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="numchambre">Numéro de chambre*</label>' +
            '	<select class="form-control form-control-sm select2 numchambre" name="numchambre[]" id="numchambre" multiple="multiple" disabled></select>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="totaljour">Total jour*</label>' +
            '	<input type="text" class="form-control form-control-sm design calcul val_numerique totaljour" name="totaljour" id="totaljour" disabled value="0" required>' +
            '		</div>' +

            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +

            '<div class="col-md-6" mb-3>' +
            '<!-- select -->' +
            '<div class="form-group">' +
            '<label>Forfait*</label>' +
            '<select class="form-control forfait" name="forfait" id="forfait">' +
            '<option>Démi-pention</option>' +
            '<option>GSec</option>' +
            '<option>Pention complet</option>' +
            '</select>' +
            '</div>' +
            '</div>' +



            '<div class="col-md-6 mb-3">' +

            '	<label for="tarifnuite">Tarif nuité(€)*</label>' +
            '	<input type="text" class="form-control form-control-sm  calcul val_numerique tarifnuite" name="tarifnuite" id="tarifnuite" required value="0">' +
            '	    </div>' +

            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="refbar">Reférence bar</label>' +
            '	<input type="text" class="form-control form-control-sm refbar" name="refbar" id="refbar" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="refrest">Reférence restaurant</label>' +
            '	<input type="text" class="form-control form-control-sm refrest" name="refrest" id="refrest" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="reffrigo">Reférence frigo</label>' +
            '	<input type="text" class="form-control form-control-sm reffrigo" name="reffrigo" id="reffrigo" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="reflinge">Reférence lingerie</label>' +
            '	<input type="text" class="form-control form-control-sm reflinge" name="reflinge" id="reflinge" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="refloca">Reférence location</label>' +
            '	<input type="text" class="form-control form-control-sm refloca" name="refloca" id="refloca" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="refnuite">Reférence nuité*</label>' +
            '	<input type="text" class="form-control form-control-sm design refnuite" name="refnuite" id="refnuite" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-12 mb-3 text-center bg-danger" style="min-height:40px;">' +

            '	<label class="mt-2" style="font-size:20px;">Montant</label>' +

            '		</div>' +

            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="montantbar">Montant bar(€)</label>' +
            '	<input type="text" class="form-control form-control-sm  calcul val_numerique montantbar" name="montantbar" id="montantbar" value="0" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="montantrest">Montant restaurant(€)</label>' +
            '	<input type="text" class="form-control form-control-sm calcul val_numerique montantrest" name="montantrest" id="montantrest" value="0" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +



            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="montantfrigo">Montant frigo(€)</label>' +
            '	<input type="text" class="form-control form-control-sm calcul val_numerique montantfrigo" name="montantfrigo" id="montantfrigo" value="0" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="montantlinge">Montant lingerie(€)</label>' +
            '	<input type="text" type="file" class="form-control form-control-sm calcul val_numerique montantlinge" name="montantlinge" id="montantlinge" value="0" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="montantloca">Montant location(€)</label>' +
            '	<input type="text" class="form-control form-control-sm calcul val_numerique montantloca" name="montantloca" id="montantloca" value="0" required>' +
            '		</div>' +


            '	    <div class="col-md-6 mb-3">' +

            '	<label for="montantnuite">Montant nuité(€)*</label>' +
            '	<input type="text" class="form-control form-control-sm calcul val_numerique montantnuite" name="montantnuite" id="montantnuite" value="0">' +
            '	    </div>' +



            '   </div>' +
            '</div>' +

            

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +

            '	<label for="totalfac">Total facture(€)*</label>' +
            '	<input type="text" class="form-control form-control-sm calcul totalfac" name="totalfac" id="totalfac" required>' +
            '		</div>' +
            '   </div>' +
            '</div>' +

            "</form>",
        buttons: {
            formSubmit: {
                text: "Enregistrer",
                btnClass: "btn-red",
                action: function () {
                    $('#totaljour').removeAttr('disabled');
                    var check = $('.numchambre').val().toString().trim()
                    if(check){

                        $.confirm({
                            content: function () {
                                var self = this;
    
                                var formulaire = $(".formulaire_client")[0];
                                var formData = new FormData(formulaire);
                                formData.append("INSERTION_EMPLOYER", "INSERTION_EMPLOYER");
                                if (idClient != "") {
                                    formData.append("idClient", idClient);
                                }
    
                                return $.ajax({
                                    url: url_client,
                                    method: "POST",
                                    data: formData,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
    
                                })
                                    .done(function (response) {
                                        self.close();
                                        if (response.indexOf('success') > -1) {
    
                                            showSuccedWal('Enregistrement reussi');
                                            affiche_client();
                                        } else {
                                            showWarningWal("Aucune modification effectuer");
                                            affiche_client();
                                        }
                                    })
                                    .fail(function () {
                                        self.setContent("Une erreur est survenu, veuiller ressayer SVP!");
                                    });
                            },
                        });
                    }else{
                        showWarningWal("Chambre invalid");
                        return false
                    }

                    
                },
            },
            Retour: function () {

            },
        },
        onOpenBefore: function () {
            
            var self2 = this;

            if (idClient != "") {
                select_chb()
                $.ajax({
                    url: url_client,
                    method: "POST",
                    dataType: 'JSON',
                    data: { SELECT_ALL_EMPLOYER: "SELECT_ALL_EMPLOYER", idClient: idClient },
                    success: function (response) {

                        rowS = response[0];
                        
                        $('#depart').removeAttr('disabled');
                        $('#numchambre').removeAttr('disabled');

                        $('.nom').val(rowS.nomClient);
                        $('.prenom').val(rowS.prenom);
                        $('.datenais').val(rowS.dateNais);
                        $('.lieunais').val(rowS.lieuNais);
                        $('.type').val(rowS.type);
                        $('.pere').val(rowS.pere);
                        $('.mere').val(rowS.mere);
                        $('.telephone').val(rowS.telephone);
                        $('.nationalite').val(rowS.nationalite);
                        $('.domicile').val(rowS.domicileExacte);
                        $('.profession').val(rowS.profession);

                        $('#passeport_image').attr('src', './assets/image/Photos/' + rowS.photocopiePasseport);
                        $('#cin_image').attr('src', './assets/image/Photos/' + rowS.photocopieCIN);

                        $('.societe').val(rowS.societe);
                        $('.forfait').val(rowS.forfait);
                        $('.arrive').val(rowS.dateArrivee);
                        $('.depart').val(rowS.dateDepart);
                        $(".tarifnuite").val(rowS.tarifNuite);
                        $('.refbar').val(rowS.refBar);
                        $('.refrest').val(rowS.refRestaurant);
                        $('.reffrigo').val(rowS.refFrigo);
                        $('.reflinge').val(rowS.refLingerie);
                        $('.refloca').val(rowS.refLocation);
                        $('.refnuite').val(rowS.refNuite);
                        $('.totaljour').val(rowS.totalJour);
                        $('.montantbar').val(rowS.montantBar);
                        $('.montantrest').val(rowS.montantRestaurant);
                        $('.montantfrigo').val(rowS.montantFrigo);
                        $('.montantlinge').val(rowS.montantLingerie);
                        $('.montantloca').val(rowS.montantLocation);
                        $('.montantnuite').val(rowS.montantNuite);
                        $('.totalfac').val(rowS.totalFacture);

                        $('.select2').select2();

                        chbr = (rowS.num_chambre.indexOf(',') > -1) ? rowS.num_chambre.split(',').trim() : rowS.num_chambre.trim()



                    }

                });

            } else {

                // select_chb()
                $('#passeport_image').attr('src', './image.png');
                $('#cin_image').attr('src', './image.png');

            }


        },
        onContentReady: function () {

            var jc = this;
            if (idClient) {
                $('.numchambre').val(chbr);

            }


            $('.numchambre').trigger("change");
            $('.select2').select2();
            if (idClient != "") {

            } else {
                jc.buttons.formSubmit.disable();
            }

            this.$content.find(".val_numerique").keypress(function (event) {
                return onlyNumberAcceptField(event, this);
            });
            this.$content.find("form").on("submit", function (e) {
                e.preventDefault();
                jc.$$formSubmit.trigger("click");
            });
            $(document).on('keyup', ".design", function () {
                var empty = false;
                $(".design ").each(function () {
                    if ($(this).val().trim() == "") {
                        empty = true;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                if (empty) {
                    jc.buttons.formSubmit.disable();
                } else {
                    jc.buttons.formSubmit.enable();
                }
            });

            this.$content.find(".design").on("change", function () {
                var empty = false;
                $(".design").each(function () {
                    if ($(this).val().trim() == "") {
                        empty = true;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                if (empty) {
                    jc.buttons.formSubmit.disable();
                } else {
                    jc.buttons.formSubmit.enable();
                }
            });


            // dept //
            $(document).on('click', '.btn_add_chambre', function () {
                var input =
                    '                      <input type="text" class="form-control value_add_chambre" id="value_add_chambre"/>' +
                    '                      <div class="input-group-append" ">' +
                    '                          <div class="input-group-text text-info" id="cancel_save_chambre"><i class="fas fa-times"></i></div>' +
                    '                          <div class="input-group-text text-info save_chambre" id="save_chambre"><i class="fas fa-save"></i></div>' +
                    '                      </div>';

                $('.dept_group').html(input);


            })
            $(document).on('click', '#cancel_save_dept', function () {
                var input =
                    '            <div class="input-group-prepend">' +
                    '                <span class="input-group-text btn_add_dept text-info"><i class="fa fa-plus"></i></span>' +
                    '            </div>' +
                    '	        <select name="id_dept" class="form-control select2 dept liste_dept" multiple="multiple" id="liste_dept">' +

                    '	        </select>';
                $('.dept_group').html(input);
                liste_dept();
                $('.select2').select2();

            })
            $(document).on('click', '.save_chambre', function () {
                var new_chambre = $('.value_add_chambre').val();


                $.ajax({
                    url: url_client,
                    method: 'POST',
                    data: { INSERTION_CHAMBRE: "INSERTION_CHAMBRE", num_chambre: new_chambre },
                    success: function (response) {
                        var input =
                            '            <div class="input-group-prepend">' +
                            '                <span class="input-group-text btn_add_chambre text-info"><i class="fa fa-plus"></i></span>' +
                            '            </div>' +
                            '	        <select name="id_chambre" class="form-control select2 chambre liste_chambre" multiple="multiple" id="liste_chambre">' +

                            '	        </select>';
                        $('.dept_group').html(input);
                        liste_dept();
                        $('.select2').select2();

                    }

                })
            })
            $(document).on("keypress", '.value_add_chambre', function (event) {

                if (event.keyCode === 13) {
                    event.preventDefault();

                    var new_chambre = $('.value_add_chambre').val();


                    $.ajax({
                        url: url_client,
                        method: 'POST',
                        data: { INSERTION_DEPT: "INSERTION_CHAMBRE", num_chambre: new_chambre },
                        success: function (response) {
                            var input =
                                '            <div class="input-group-prepend">' +
                                '                <span class="input-group-text btn_add_chambre text-info"><i class="fa fa-plus"></i></span>' +
                                '            </div>' +
                                '	        <select name="id_chambre" class="form-control select2 dept liste_chambre" multiple="multiple" id="liste_chambre">' +

                                '	        </select>';
                            $('.dept_group').html(input);
                            liste_dept();
                            $('.select2').select2();

                        }

                    })

                }
            });


            $(document).on('change', '.liste_fonction', function () {
                var salaire = $('.fonction option:selected').data('salaire');
                $('.salaire').val(salaire);


            })

        },
    });
};

// client

$(function () {

    affiche_client();
    select_chb()

    $(document).on("click", ".btn_add_client", function () {
        add_client("");
    });

    $(document).on("click", '.btn_modif_employer', function () {
        var idClient = $(this).data('idclient');
        add_client(idClient);
    });

    $(document).on("click", ".btn_supp_employer", function () {
        var idClient = $(this).data("idclient");
        // alert(idClient)

        $.confirm({
            title: 'Confirme!',
            content: 'Voulez vous supprimer ce client?',
            buttons: {
                supprimer: function () {

                    $.confirm({
                        content: function () {
                            var self = this;
                            return $.ajax({
                                url: url_client,
                                method: "POST",
                                data: { SUPPR_EMPLOYER: "SUPPR_EMPLOYER", idClient: idClient },
                            })
                                .done(function (response) {
                                    self.close();
                                    $.alert(response);
                                    affiche_client();
                                })
                                .fail(function () {
                                    self.setContent("Une erreur est survenu");
                                });
                        },
                    });


                },
                annuler: function () {

                }
            }
        });


    });

    $(document).on('click', ".btn_look_employer", function () {
        var idClient = $(this).data('idclient');

        $.confirm({
            columnClass: "large",
            title: " ",
            content: "" +
                '<div class="card">' +
                '<div class="card-header bg-secondary">' +
                ' <h3 class="card-title">' +
                ' <i class="fas fa-text-width"></i>' +
                ' Informations du client' +
                ' </h3>' +
                '</div>' +

                '<div class="card-body clearfix">' +
                ' <blockquote class="quote-secondary">' +
                ' <p>' +

                'Nom : <label for="nom" id="nom"></label><br>' +
                'Prénom: <label for="nom" id="prenom"></label><br>' +
                'Date de naissance: <label for="datenais" id="datenais"></label> <br>' +
                'Lieu de naissance: <label for="lieunais" id="lieunais"></label><br>' +
                'Père: <label for="pere" id="pere"></label><br>' +
                'Type: <label for="type" id="type"></label><br>' +
                'Mère: <label for="mere" id="mere"></label><br>' +
                'Téléphone: <label for="telephone" id="telephone"></label><br>' +
                'Nationalité: <label for="nationalite" id="nationalite"></label><br>' +
                'Domicile exacte: <label for="domicile" id="domicile"></label><br>' +
                'Profession: <label for="profession" id="profession"></label><br>' +

                ' </p>' +

                ' </blockquote>' +
                ' </div>' +

                '</div>' +

                '<div class="card">' +
                '<div class="card-header bg-secondary">' +
                ' <h3 class="card-title">' +
                ' <i class="fas fa-text-width"></i>' +
                ' Informations du chambre' +
                ' </h3>' +
                '</div>' +

                '<div class="card-body clearfix">' +
                ' <blockquote class="quote-secondary">' +
                ' <p>' +

                'Numero de chambre: <label for="numchambre" id="numchambre"></label><br>' +
                'Société: <label for="societe" id="societe"></label><br>' +
                'Forfait: <label for="forfait" id="forfait"></label><br>' +
                'Date d\'arrivée: <label for="arrive" id="arrive"></label><br>' +
                'Date de départ: <label for="depart" id="depart"></label><br>' +
                'Tarif nuité: <label for="tarifnuite" id="tarifnuite"></label><br>' +
                'Reférence Bar: <label for="refbar" id="refbar"></label><br>' +
                'Reférence Restaurant: <label for="refrest" id="refrest"></label><br>' +
                'Reférence Frigo: <label for="reffrigo" id="reffrigo"></label><br>' +
                'Reférence Lingerie: <label for="reflinge" id="reflinge"></label><br>' +
                'Reférence Location: <label for="refloca" id="refloca"></label><br>' +
                'Reférence Nuité: <label for="refnuite" id="refnuite"></label><br>' +
                'Montant Bar: <label for="montantbar" id="montantbar"></label><br>' +
                'Montant Restaurant: <label for="montantrest" id="montantrest"></label><br>' +
                'Montant Frigo: <label for="montantfrigo" id="montantfrigo"></label><br>' +
                'Montant Lingerie: <label for="montantlinge" id="montantlinge"></label><br>' +
                'Montant Location: <label for="montantloca" id="montantloca"></label><br>' +
                'Montant Nuité: <label for="montantnuite" id="montantnuite"></label><br>' +
                'Total jour: <label for="totaljour" id="totaljour"></label><br>' +
                'Total Facture: <label for="totalfac" id="totalfac"></label><br>' +

                ' </p>' +

                ' </blockquote>' +
                ' </div>' +

                '</div>' +

                '<div class="row">' +
                '<div class="col-5 card ml-4 mr-2">' +
                '    <div class="card-header text-center">' +
                '   CIN' +
                '   </div>' +
                '<div class="card-body">' +
                '	<img  id="cin_vue" ><br>' +
                '</div>' +
                '</div>' +
                '<div class="col-5 card ml-4 ">' +
                '    <div class="card-header text-center">' +
                '   Passeport' +
                '   </div>' +
                '<div class="card-body">' +
                '	<img  id="passeport_vue"><br>' +
                '</div>' +
                '</div>' +

                '</div>' +

                '</div>' +
                '</div>',
            buttons: {
                formSubmit: {
                    text: 'Imprimer',
                    btnClass: 'btn-blue',
                    action: function () {

                        window.location.href = './output/PDF/info_client.php?id_info=' + idClient + '';

                        $.ajax({
                            url: './output/PDF/info_client.php',
                            method: "GET",
                            dataType: "JSON",
                            data: { idClient: idClient },
                            success: function (reponse) {
                                if (response.indexOf('succes') > -1) {

                                } else {
                                }


                            },
                        });

                        return false;
                    }
                },
                Retour: function () {
                    //close
                },
            },
            onOpenBefore: function () {

                var self2 = this;
                $.confirm({
                    columnClass: "xlarge",
                    content: function () {
                        var self = this;
                        return $.ajax({
                            url: url_client,
                            dataType: "JSON",
                            method: "POST",
                            data: { SELECT_ALL_EMPLOYER: "SELECT_ALL_EMPLOYER", idClient: idClient },
                        })
                            .done(function (response) {
                                self.close();
                                var rowS = response[0];

                                $('#nom').html(rowS.nomClient);
                                $('#prenom').html(rowS.prenom);
                                $('#datenais').html(rowS.dateNais);
                                $('#lieunais').html(rowS.lieuNais);
                                $('#type').html(rowS.type);
                                $('#pere').html(rowS.pere);
                                $('#mere').html(rowS.mere);

                                $('#telephone').html(rowS.telephone);
                                $('#nationalite').html(rowS.nationalite);
                                $('#domicile').html(rowS.domicileExacte);
                                $('#profession').html(rowS.profession);
                                $('#cin_vue').attr('src', './assets/image/Photos/' + rowS.photocopieCIN);
                                $('#passeport_vue').attr('src', './assets/image/Photos/' + rowS.photocopiePasseport);

                                $('#numchambre').html(rowS.num_chambre);
                                $('#societe').html(rowS.societe);
                                $('#forfait').html(rowS.forfait);
                                $('#arrive').html(rowS.dateArrivee);
                                $('#depart').html(rowS.dateDepart);
                                $('#tarifnuite').html(rowS.tarifNuite);
                                $('#refbar').html(rowS.refBar);
                                $('#refrest').html(rowS.refRestaurant);
                                $('#reffrigo').html(rowS.refFrigo);
                                $('#reflinge').html(rowS.refLingerie);
                                $('#refnuite').html(rowS.refNuite);
                                $('#refloca').html(rowS.refLocation);
                                $('#totaljour').html(rowS.totalJour);
                                $('#montantbar').html(rowS.montantBar);
                                $('#montantrest').html(rowS.montantRestaurant);
                                $('#montantfrigo').html(rowS.montantFrigo);
                                $('#montantlinge').html(rowS.montantLingerie);
                                $('#montantloca').html(rowS.montantLocation);
                                $('#montantnuite').html(rowS.montantNuite);
                                $('#totalfac').html(rowS.totalFacture);


                            })
                            .fail(function (response) {
                                self.setContent("Error");
                            });
                    },
                });

            },
            onContentReady: function () {

            }
        });

    })

    $(document).on("change", "#statut", function () {
        var id = $(this).data('id');
        var statut = $(this).val();
        $.confirm({
            content: function () {
                var self = this;
                return $.ajax({
                    url: url_client,
                    method: "POST",
                    data: { STATUT_CLIENT: "STATUT_CLIENT", id: id, statut: statut },
                })
                    .done(function (response) {
                        self.close();
                        if (response.indexOf("success") > -1) {
                            showSuccedWal("success");
                            affiche_client();
                        } else {
                            showWarningWal(response);
                        }

                    })
                    .fail(function () {
                        self.setContent("Une eurrer est survenu");
                    });
            },
        });
    });

    $(document).on("change", "#filtre", function () {
        var filtre = $(this).val();
        if (filtre == 1) {
            client_cours();
        }
        if (filtre == 2) {
            client_quitte();
        }
        if (filtre == 3) {
            affiche_client();
        }
    });

    //Agrandir passeport en cliquant

    $(document).on("click", "#passeport_vue", function () {
        var img = $(this).attr('src');
        var img_display = `<img style="min-heigth:800px;" src="${img}" >`;

        $.dialog({
            columnClass: 'xlarge',
            title: ' ',
            content: img_display,
        });

    });

    //Agrnadir CIN en cliquant

    $(document).on("click", "#cin_vue", function () {
        var img = $(this).attr('src');
        var img_display = `<img style="min-heigth:800px;" src="${img}" >`;

        $.dialog({
            columnClass: 'xlarge',
            title: ' ',
            content: img_display,
        });

    });
    // chambre //

    $(document).on('click', '#btn_chambre', function () {

        $.confirm({
            title: 'Chambres',
            columnClass: "xlarge",
            content: '' +
                '<form action="" id="formulaire_chambre" class="formName">' +
                '<div id="form_add_chambre" class="form-group class_essai d-none">' +
                '<!-- columns -->' +
                '<div class="form-group">' +
                '<div class="form-row align-items-center">' +

                '<div class="col-md-3 mb-3">' +
                '	<label for="chambre">Numero du chambre</label><br>' +
                '<input type="text" name="num_chambre" id="num_chambre" class="form-control form-control-sm fonction clearable num_chambre" required />' +
                '</div>' +

                '<div class="col-md-3 mb-3">' +
                '	<label for="chambre">Description</label><br>' +
                '<input type="text" name="description" id="description" class="form-control form-control-sm fonction clearable description" required />' +
                '</div>' +

                '<div class="col-md-2 mb-3">' +
                '	<label for="chambre">Type</label><br>' +
                '   <select class="form-control-sm type fonction clearable form-control form-control-sm type" required name="type" id="type">' +
                        '<option>Single</option>' +
                        '<option>Double</option>' +
                        '<option>Twin</option>' +
                '   </select>' +
                '</div>' +
                '<div class="col-md-2 mb-3">' +
                '	<label for="chambre">Tarif nuité(€)</label><br>' +
                '  <input type="text" name="tarif" id="tarif" class="form-control form-control-sm fonction clearable tarif" required />'+
                '</div>' +
                '<div class="col-md-1 mb-3 display_btn_save  d-none text-center">' +
                '	<label for="chambre">Enregister</label><br>' +
                '   <a data-id_chambre="null" id="btn_save_chambre" class="form-control form-control-sm btn btn-light btn_save_chambre text-warning"><i class="fas fa-save"></i></a>' +
                '</div>' +
                '<div class="col-md-1 mb-3  text-center">' +
                '	<label for="chambre">Fermer</label><br>' +
                '   <a data-id_chambre="null" id="btn_fermer" class="form-control form-control-sm btn btn-light btn_fermer text-danger"><i class="fas fa-times"></i></a>' +
                '</div>' +

                '</div>' +
                '<hr>' +
                '<hr>' +

                '</div>' +
                '</div>' +



                '<div class="">' +
                '<div>' +

                '  <table id="table_chambre" class="table_chambre col-md-12">' +
                '    <thead>' +
                '     <tr>' +
                '      <th>N°</th>' +
                '      <th>Numero</th>' +
                '      <th>Description</th>' +
                '      <th>Type</th>' +
                '      <th>Tarif nuité(€)</th>' +
                '      <th style="width: 60px">Action</th>' +
                '     </tr>' +
                '    </thead>' +
                '  <tbody >' +

                '  </tbody>' +
                '  </table>' +
                '</div>' +

                '</div>' +
                '</form>',
            buttons: {
                Enregistrer: {
                    text: 'Enregistrer',
                    btnClass: 'btn-danger',
                    keys: ['enter'],
                    action: function () {
                        var id_chambre = $('#btn_save_chambre').data('id_chambre');
                        if (id_chambre == null) {
                            id_chambre = null;
                        }

                        $.confirm({
                            content: function () {
                                var self = this;
                                var formulaire = $("#formulaire_chambre")[0];
                                var formData = new FormData(formulaire);
                                formData.append("INSERTION_CHAMBRE", "INSERTION_CHAMBRE");
                                formData.append("id_chambre", id_chambre);
                                return $.ajax({
                                    url: url_client,
                                    method: "POST",
                                    data: formData,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                })
                                    .done(function (response) {

                                        if (response.indexOf("success") > -1) {
                                            showSuccedWal("Enregistrement reussi");
                                            affiche_chambre();
                                        } else {
                                            showWarningWal(response);
                                        }

                                        self.close();

                                        $("#num_chambre").val("");
                                        $("#description").val("");
                                        $('.display_btn_save').addClass('d-none');
                                        $('#btn_save_chambre').data('id_chambre', null);

                                        ;


                                    })
                                    .fail(function () {
                                        self.setContent("Une eurrer est survenu , veuillez ressayée SVP!");
                                    });

                            },
                        });

                        return false;
                    }
                },
                Ajouter: {
                    btnClass: 'btn-blue any-other-class',
                    action: function () {

                        $('.class_essai').removeClass('d-none');
                        return false;

                    }
                },
                Fermer: function () {
                    //close
                },
            },
            onOpenBefore: function () {
                var jc = this;
                affiche_chambre();

            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                jc.buttons.Enregistrer.disable();


                this.$content.find('form').on('submit', function (e) {

                    e.preventDefault();
                    jc.$$Enregistrer.trigger('click');
                });

                this.$content.find(".num_chambre, .description").on("keyup", function () {
                    var empty = false;
                    $(".num_chambre").each(function () {
                        if ($(this).val().trim() == "") {
                            empty = true;
                            $(this).addClass("is-invalid");
                        } else {
                            $(this).removeClass("is-invalid");
                        }
                    });

                    if (empty) {
                        jc.buttons.Enregistrer.disable();
                        $('.display_btn_save').addClass('d-none');
                    } else {

                        jc.buttons.Enregistrer.enable();
                        $('.display_btn_save').removeClass('d-none');

                    }
                });
                this.$content.find(".type, .tarif").on("change", function () {
                    var empty = false;
                    $(".num_chambre").each(function () {
                        if ($(this).val().trim() == "") {
                            empty = true;
                            $(this).addClass("is-invalid");
                        } else {
                            $(this).removeClass("is-invalid");
                        }
                    });

                    if (empty) {
                        jc.buttons.Enregistrer.disable();
                        $('.display_btn_save').addClass('d-none');
                    } else {

                        jc.buttons.Enregistrer.enable();
                        $('.display_btn_save').removeClass('d-none');

                    }
                });

                this.$content.find(".btn_save_chambre").on('click', function () {
                    var id_chambre = $('#btn_save_chambre').data("id_chambre");

                   

                    $.confirm({
                        content: function () {
                            var self = this;
                            var formulaire = $("#formulaire_chambre")[0];
                            var formData = new FormData(formulaire);
                            formData.append("INSERTION_CHAMBRE", "INSERTION_CHAMBRE");
                            formData.append("id_chambre", id_chambre);
                            return $.ajax({
                                url: url_client,
                                method: "POST",
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                            })
                                .done(function (response) {

                                    if (response.indexOf("success") > -1) {
                                        showSuccedWal("Enregistrement reussi");
                                        affiche_chambre();
                                    } else {
                                        showWarningWal(response);
                                    }

                                    self.close();

                                    $("#num_chambre").val("");
                                    $("#description").val("");
                                    
                                    $('.display_btn_save').addClass('d-none');
                                    $('#btn_save_chambre').data("id_chambre", null);
                                    jc.buttons.Enregistrer.disable();

                                    if(id_chambre){
                                        $('.class_essai').addClass("d-none");
                                    }

                                })
                                .fail(function () {
                                    self.setContent("Une eurrer est survenu , veuillez ressayée SVP!");
                                });

                        },
                    })

                });


                $(document).on('click', ".btn_modif_chambre", function () {
                    var id_chambre = $(this).data('id_chambre');

                    $.ajax({
                        url: url_client,
                        method: "POST",
                        dataType: "JSON",
                        data: { SELECT_ALL_CHAMBRE: "SELECT_ALL_CHAMBRE", id_chambre: id_chambre },
                        success: function (reponse) {
                            var rowS = reponse[0];

                            $('.class_essai').removeClass('d-none');
                            $('.num_chambre').val(rowS.num_chambre);
                            $('.description').val(rowS.description);
                            $('.type').val(rowS.type);
                            $('.tarif').val(rowS.tarifNuite);
                            $('#btn_save_chambre').data("id_chambre", id_chambre);


                        },
                    });
                })
                this.$content.find(".btn_fermer").on('click', function () {
                    $("#num_chambre").val("");
                    $("#description").val("");
                  $('.class_essai').addClass("d-none");
             
                });

            }
        });

    })

    $(document).on("click", ".btn_supp_chambre", function () {
        var id_chambre = $(this).data('id_chambre');

        $.confirm({
            title: 'Confirme!',
            content: 'Voulez vous supprimer cette chambre?',
            buttons: {
                supprimer: function () {

                    $.confirm({
                        content: function () {
                            var self = this;
                            return $.ajax({
                                url: url_client,
                                method: "POST",
                                data: { DELETE_CHAMBRE: "DELETE_CHAMBRE", id_chambre: id_chambre },
                            })
                                .done(function (response) {
                                    self.close();
                                    $.alert(response);
                                    affiche_chambre();
                                })
                                .fail(function () {
                                    self.setContent("Une erreur est survenu");
                                });
                        },
                    });


                },
                annuler: function () {

                }
            }
        });
    });

    $(document).on('keyup', '.calcul', function () {

        var a = $('.montantbar').val()
        var b = $('.montantrest').val()
        var c = $('.montantfrigo').val()
        var d = $('.montantlinge').val()
        var f = $('.montantloca').val()
        var g = $('.montantnuite').val()

        //var j =$('.montantnuite').val()


        // var e = $('.tarifnuite').val()
        // var g = $('.totaljour').val()
        // var mnt =(parseInt(e)*parseInt(g)) 
        //  $('.montantnuite').val(mnt)

        var rst = (parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(f) + parseInt(g))
        $('.totalfac').val(rst)
        // parseInt(a) +  parseInt(b) + parseInt(c) + parseInt(d) + parseInt(e) +

    });

    $(document).on('change', '.arrive', function () {

        $('.depart').removeAttr('disabled')

        $('.numchambre').val('');
        $('.numchambre').trigger("change");
       
        $('.select2').select2();

        var g = $('.depart').val()

        if (g) {
            $('.numchambre').removeAttr('disabled')
            var e = $('.arrive').val()


            date1 = new Date(e);
            date2 = new Date(g);
            diff = dateDiff(date1, date2);

            $('.totaljour').val(diff.day)


            var rst_nuite = 0
            var tar = $('.numchambre').val().toString()
            if (tar.trim() != '') {

                var tarif = tar.split(',')


                $.each(liste_chamb_tarif, function (index, rowS) {
                    for (var i = 0; tarif.length > i; i++) {
                        if (tarif[i] == rowS.num_chambre) {

                            rst_nuite = parseInt(rowS.tarifNuite) + parseInt(rst_nuite)

                        }

                    }

                });
                $('.tarifnuite').val(rst_nuite)
                $('.montantnuite').val(rst_nuite * diff.day)
                var a = $('.montantbar').val()
                var b = $('.montantrest').val()
                var c = $('.montantfrigo').val()
                var d = $('.montantlinge').val()
                var f = $('.montantloca').val()
                // var g = $('.montantnuite').val()

                var rst = (parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(f) + parseInt(rst_nuite * diff.day))
                $('.totalfac').val(rst)

            }


        }


        var arrive_filtre = $('.arrive').val()
        select_chb_filtre(arrive_filtre);


    });

    $(document).on('change', '.depart', function () {

        $('.depart').removeAttr('disabled')
        $('.numchambre').removeAttr('disabled')
        var e = $('.arrive').val()
        var g = $('.depart').val()

        date1 = new Date(e);
        date2 = new Date(g);
        diff = dateDiff(date1, date2);
        //alert("Entre le "+date1.toString()+" et "+date2.toString()+" il y a "+diff.day+" jours");
        $('.totaljour').val(diff.day)

        if (g) {


            var rst_nuite = 0
            var tar = $('.numchambre').val().toString()
            if (tar.trim() != '') {

                var tarif = tar.split(',')


                $.each(liste_chamb_tarif, function (index, rowS) {
                    for (var i = 0; tarif.length > i; i++) {
                        if (tarif[i] == rowS.num_chambre) {

                            rst_nuite = parseInt(rowS.tarifNuite) + parseInt(rst_nuite)

                        }

                    }

                });
                $('.tarifnuite').val(rst_nuite)
                $('.montantnuite').val(rst_nuite * diff.day)
                var a = $('.montantbar').val()
                var b = $('.montantrest').val()
                var c = $('.montantfrigo').val()
                var d = $('.montantlinge').val()
                var f = $('.montantloca').val()
                // var g = $('.montantnuite').val()

                var rst = (parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(f) + parseInt(rst_nuite * diff.day))
                $('.totalfac').val(rst)

            }


        }
    });

    $(document).on('change', '.numchambre', function () {
       
        var rst_nuite = 0
        var tar = $(this).val().toString()
       
        if (tar.trim() != '') {

            var tarif = tar.split(',')

            $.each(liste_chamb_tarif, function (index, rowS) {
                for (var i = 0; tarif.length > i; i++) {

                    if (tarif[i] == rowS.num_chambre) {
                       
                        rst_nuite = parseInt(rowS.tarifNuite) + parseInt(rst_nuite)

                    }

                }

            });

            $('.tarifnuite').val(rst_nuite)
            
            var g = $('.totaljour').val()
            var mnt = (parseInt(rst_nuite) * parseInt(g))
            $('.montantnuite').val(mnt)

            var a = $('.montantbar').val()
            var b = $('.montantrest').val()
            var c = $('.montantfrigo').val()
            var d = $('.montantlinge').val()
            var f = $('.montantloca').val()

            //var j =$('.montantnuite').val()


            // var e = $('.tarifnuite').val()
            // var g = $('.totaljour').val()
            // var mnt =(parseInt(e)*parseInt(g)) 
            //  $('.montantnuite').val(mnt)

            var rst = (parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(f) + parseInt(mnt))
            $('.totalfac').val(rst)
        }


    })

})