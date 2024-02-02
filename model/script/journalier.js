var tableJournalier;
var url_journalier = "./model/php/journalierDAO.php";
var url_client = "./model/php/employerDAO.php";

var jour = 0

var all_chambre = 0;
    var count_chbr=0;

    $.ajax({
        url: url_client,
        dataType: "JSON",
        method: "POST",
        data: { SELECT_ALL_CHAMBRE: "SELECT_ALL_CHAMBRE" },
        success:function (data) {
            all_chambre = data
            count_chbr = data.length
        }
    })

var affiche_journalier = function (jour) {
    console.log(jour);
    var date_now=$('.date_excel').val()

    if (tableJournalier) {
        $("#table_journalier").DataTable().clear().destroy();
    }
    tableJournalier = $("#table_journalier").DataTable({
        lengthMenu: [8, 20, 50, 100, 200],
        fixedHeader: true,
        language: {
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
        }
    });

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_journalier,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_JOUR: "SELECT_ALL_JOUR", jour: jour,date_now },
            })
                .done(function (response) {
                    self.close();
                    var chambre_occupe = 0;
                    var total_nb_nuit = 0;
                    var nb_arrive = 0;
                    var nb_depart = 0;
                    var chambre_libre = 0;
                    var date_now = response[0]
                    var dat=response[2];
                    $('#date_excel').val(dat)

                    var day = '';

                    if (date_now.indexOf('Mon') > -1) { day = 'Lundi' }
                    if (date_now.indexOf('Tue') > -1) { day = 'Mardi' }
                    if (date_now.indexOf('Wed') > -1) { day = 'Mercredi' }
                    if (date_now.indexOf('Thu') > -1) { day = 'Jeudi' }
                    if (date_now.indexOf('Fri') > -1) { day = 'Vendredi' }
                    if (date_now.indexOf('Sat') > -1) { day = 'Samedi' }
                    if (date_now.indexOf('Sun') > -1) { day = 'Dimanche' }

                    $('#date_jour').html(day + ' le ' + date_now.substr(4, 100))

                    var Type='', Client='', Categorie='', Arrive='', Nb_Nuites='', Forf='', Desc='';

                    for (var compteur = 0; all_chambre.length > compteur; compteur++) {

                        $.each(response[1], function (index, rowS) {

                            if (rowS.num_chambre.indexOf(all_chambre[compteur].num_chambre )>-1 ) {
                              
                                Type = rowS.type
                                Client = rowS.nom_client + ' ' +  rowS.prenom;
                                Categorie = rowS.categorie
                                Arrive = rowS.arrive
                                Nb_Nuites = rowS.nuite
                                Forf = rowS.forfait
                                Desc = rowS.desc
                              
                                chambre_occupe = chambre_occupe + 1

                                if(rowS.depart!=rowS.date_now){
                                    total_nb_nuit=total_nb_nuit+1
                                }

                                if(rowS.arrive == rowS.date_now){
                                    nb_arrive=nb_arrive+1
                                }

                                if(rowS.depart == rowS.date_now){
                                    nb_depart=nb_depart+1
                                }
                                
                            }
                                
                        });

                       
                            tableJournalier.row.add([
                                all_chambre[compteur].num_chambre,
                                Type,
                                Client,
                                Categorie,
                                Arrive,
                                Nb_Nuites,
                                Forf,
                                Desc

                            ]);
                       
                          Type = '', Client = '', Categorie = '', Arrive = '', Nb_Nuites = '', Forf = '', Desc = '';
                    }

                    tableJournalier.draw();

                    $('.chambre_occupe').val(chambre_occupe)
                    $('.total_nb_nuit').val(total_nb_nuit)
                    $('.nb_arrive').val(nb_arrive)
                    $('.nb_depart').val(nb_depart)
                    $('.chambre_libre').val(count_chbr - chambre_occupe)
                    
                    jour = 0

                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};

var journalierManuel = function (date) {
 
    if (tableJournalier) {
        $("#table_journalier").DataTable().clear().destroy();
    }
    tableJournalier = $("#table_journalier").DataTable({
        lengthMenu: [8, 20, 50, 100, 200],
        fixedHeader: true,
        language: {
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
        }
    });

    

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_journalier,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_JOUR: "SELECT_ALL_JOUR", jour: 0, date_now:date },
            })
                .done(function (response) {
                    self.close();

                   
                    var chambre_occupe = 0;
                    var total_nb_nuit = 0;
                    var nb_arrive = 0;
                    var nb_depart = 0;
                    var chambre_libre = 0;
                    var date_now = response[0]

                    var day = '';

                    if (date_now.indexOf('Mon') > -1) { day = 'Lundi' }
                    if (date_now.indexOf('Tue') > -1) { day = 'Mardi' }
                    if (date_now.indexOf('Wed') > -1) { day = 'Mercredi' }
                    if (date_now.indexOf('Thu') > -1) { day = 'Jeudi' }
                    if (date_now.indexOf('Fri') > -1) { day = 'Vendredi' }
                    if (date_now.indexOf('Sat') > -1) { day = 'Samedi' }
                    if (date_now.indexOf('Sun') > -1) { day = 'Dimanche' }

                    $('#date_jour').html(day + ' le ' + date_now.substr(4, 100))

                    var Type='', Client='', Categorie='', Arrive='', Nb_Nuites='', Forf='', Desc='';
                    for (var compteur = 0; all_chambre.length > compteur; compteur++) {

                        $.each(response[1], function (index, rowS) {

                            if (rowS.num_chambre.indexOf(all_chambre[compteur].num_chambre)>-1 ) {
                             
                                Type = rowS.type;
                                Client = rowS.nom_client + ' ' +  rowS.prenom;
                                Categorie = rowS.categorie;
                                Arrive = rowS.arrive;
                                Nb_Nuites = rowS.nuite;
                                Forf = rowS.forfait;
                                Desc = rowS.desc;

                                chambre_occupe = chambre_occupe + 1

                                if(rowS.depart!=rowS.date_now){
                                    total_nb_nuit=total_nb_nuit+1
                                }

                                if(rowS.arrive == rowS.date_now){
                                    nb_arrive=nb_arrive+1
                                }

                                if(rowS.depart == rowS.date_now){
                                    nb_depart=nb_depart+1
                                }
                                
                            }
                                
                        });

                        // if (compteur != 11) {
                            tableJournalier.row.add([
                                all_chambre[compteur].num_chambre,
                                Type,
                                Client,
                                Categorie,
                                Arrive,
                                Nb_Nuites,
                                Forf,
                                Desc

                            ]);
                        // }
                          Type = '', Client = '', Categorie = '', Arrive = '', Nb_Nuites = '', Forf = '', Desc = '';
                    }

                    tableJournalier.draw();

                    $('.chambre_occupe').val(chambre_occupe)
                    $('.total_nb_nuit').val(total_nb_nuit)
                    $('.nb_arrive').val(nb_arrive)
                    $('.nb_depart').val(nb_depart)
                    $('.chambre_libre').val(count_chbr - chambre_occupe)
                    
                    jour = 0


                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};
$(function () {

    affiche_journalier(jour)

    $(document).on("click", ".btn_next", function () {
        jour = 0
        jour = jour + 1

        affiche_journalier(jour);

    });

    $(document).on("click", '.btn_prev', function () {
        jour = 0
        jour = jour - 1

        affiche_journalier(jour);
    });

})