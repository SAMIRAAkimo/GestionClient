
var tableMensuel;
var url_mensuel = "./model/php/mensuelDAO.php";
var url_client = "./model/php/employerDAO.php";

let clientList = []
let color = ["AliceBlue", "Chartreuse", "Beige", "Chocolate", "CadetBlue", "DarkGrey", "DarkKhaki", "AliceBlue", "DarkOrange", "DarkOrchid", "DarkRed", "DarkSalmon", "DarkSeaGreen", "DarkSlateBlue", "DarkSlateGray", "DarkSlateGrey", "DarkTurquoise", "DarkViolet", "DeepPink", "DeepSkyBlue", "DimGray", "DimGrey", "DodgerBlue", "FireBrick", "FloralWhite", "ForestGreen", "Fuchsia", "Gainsboro", "GhostWhite", "Gold", "GoldenRod", "Gray", "Grey", "Green", "GreenYellow", "HoneyDew", "HotPink", "IndianRed", "Indigo", "Ivory", "Khaki", "Lavender", "DarkMagenta", "DarkOliveGreen"]


let getClient = () => {
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_mensuel,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_CLIENT: "SELECT_CLIENT", lundi: -1, dimanche: 1 },
            })
                .done(function (response) {
                    
                    self.close();

                    var clientInfo = response;
                    for (let i = 0; i < clientInfo.length; i++) {
                        nomComplet = clientInfo[i].nomClient + ' ' + clientInfo[i].prenom
                        clientList.push(nomComplet);

                    }
                 
                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
}

var x = -1
var y = 1

var affiche_mensuel = function (lun, dim) {
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
    if (tableMensuel) {
        $("#table_mensuel").DataTable().clear().destroy();
    }
    tableMensuel = $("#table_mensuel").DataTable({
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
        },
        createdRow: function (row, data, dataIndex) {
           
            var fsc = function (k1,k) {
                for(var k=k  , x=2  ; k <8 ;k++,x++){
        
                    if(data[k1]==data[k] && data[k].trim()!=''){
                       
                        $('td', row).eq(k).addClass('d-none');
                        $('td', row).eq(k1).attr("colspan", x);
                        $('td', row).eq(k1).addClass("text-center");
                       
                    }
                }
            }
            for (let i = 1; i < data.length; i++) {
               
                for (let j = 0; j < clientList.length; j++) {
                   
                    if (data[i] == clientList[j]) {
                     
                        $('td', row).eq(i).css("background-color", color[j]);
                      
                    }
                }
               
            }

            fsc(1,2) 
            fsc(2,3) 
            fsc(3,4) 
            fsc(4,5) 
            fsc(5,6) 
            fsc(6,7) 
           
        },

    });

    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: url_mensuel,
                dataType: "JSON",
                method: "POST",
                data: { SELECT_ALL_MENSUEL: "SELECT_ALL_MENSUEL", lundi: lun, dimanche: dim },
            })
                .done(function (response) {
                    self.close();

                    var liste_date = response[0];

                    $('.lun').html(liste_date[0])
                    $('.mar').html(liste_date[1])
                    $('.mer').html(liste_date[2])
                    $('.jeu').html(liste_date[3])
                    $('.ven').html(liste_date[4])
                    $('.sam').html(liste_date[5])
                    $('.dim').html(liste_date[6])

                    var chambre_occupe = 0;
                    var chambre_libre = 0;
                    var lundi='', mardi='', mercredi='', jeudi='', vendredi='', samedi='', dimanche='';

                    for (var compteur = 0; all_chambre.length > compteur; compteur++) {

                        $.each(response[1], function (index, rowS) {
                            if (rowS.num_chambre.indexOf(all_chambre[compteur].num_chambre)>-1) {

                                if ((rowS.jour.indexOf('0')) > -1) {
                                    lundi = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }
                                if ((rowS.jour.indexOf('1')) > -1) {
                                    mardi = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }
                                if ((rowS.jour.indexOf('2')) > -1) {
                                    mercredi = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }
                                if ((rowS.jour.indexOf('3')) > -1) {
                                    jeudi = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }
                                if ((rowS.jour.indexOf('4')) > -1) {
                                    vendredi = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }
                                if ((rowS.jour.indexOf('5')) > -1) {
                                    samedi = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }
                                if ((rowS.jour.indexOf('6')) > -1) {
                                    dimanche = rowS.nom_client
                                    chambre_occupe = chambre_occupe + 1;
                                }

                            }

                        });
 
                            tableMensuel.row.add([
                                all_chambre[compteur].num_chambre,
                                lundi,
                                mardi,
                                mercredi,
                                jeudi,
                                vendredi,
                                samedi,
                                dimanche

                            ]);
                        
                        lundi = '', mardi = '', mercredi = '', jeudi = '', vendredi = '', samedi = '', dimanche = '';
                    }

                    tableMensuel.draw();
                    $('.chambre_occupe').val(chambre_occupe)
                    $('.chambre_libre').val(count_chbr - chambre_occupe)

                })
                .fail(function () {
                    self.setContent("Une erreur est survenu, veuiller réessayer SVP!");
                });
        },
    });
};


$(function () {

    getClient()
    console.log(clientList);
    affiche_mensuel(x, y)

    $(document).on("click", ".btn_next", function () {
        x = x + 1
        y = y + 1
        affiche_mensuel(x, y);

    });

    $(document).on("click", '.btn_prev', function () {
        x = x - 1
        y = y - 1
        affiche_mensuel(x, y);
    });

})