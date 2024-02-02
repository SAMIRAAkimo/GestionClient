var url_user = "./model/php/userDAO.php";
var tableUser;

$(function () {

    var affichageUser = function () {

        if (tableUser) {
            $('#table_user').DataTable().clear().destroy();
        }

        tableUser = $('#table_user').DataTable({
            'lengthMenu': [10, 20, 50, 100, 200],
            'fixedHeader': true,
        });

        $.confirm({
            content: function () {
                var self = this;
                return $.ajax({
                    url: url_user,
                    dataType: 'JSON',
                    method: 'POST',
                    data: {USER_AFFICHAGE: 'USER_AFFICHAGE'}
                }).done(function (response) {
                    self.close();

                    //boucle pour la lecture de donnée retour de la BD
                    $.each(response, function (index, rowS) {
                        
                        var action =  '<div class="btn-group' + rowS.id + '">' +
                        '       <button type="button" data-id="' + rowS.id + '" class="btn btn-warning btn-sm fa fa-edit btn_modif_user"></button>' +
                        '       <button type="button" data-id="' + rowS.id + '" class="btn btn-danger btn-sm btn_supp_user"><i class="fa fa-trash"></i></button>' +
                        '</div>';
                        tableUser.row.add([
                            //rowS.id,
                            rowS.username,
                            rowS.statut,
                            action
                        ]);
                    });

                    tableUser.draw();

                }).fail(function () {
                    self.setContent('Something went wrong.');
                });
            }
        });

    };


    var add_user = function(id) {
        $.confirm({
            title: 'Ajouter un utilisateur',
            columnClass: 'large',
            content: '' +
            '<form action="" class="formulaire_user" id="formulaire_user" enctype="multipart/form-data">' +
            

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +
           
                    '	<label for="username">Username</label>' +
                    '	<input type="text" class="form-control form-control-sm design username" name="username" id="username" required>' +
            '		</div>' +
            '	    <div class="col-md-6 mb-3">' +
           
                    '	<label for="mdp">Mot de passe</label>' +
                    '	<input type="password" class="form-control form-control-sm mdp" name="mdp" id="mdp" required>' +
            '	    </div>' +
            '   </div>' +
            '</div>' +

            '<div class="form-group">' +
            '   <div class="form-row align-items-center">' +
            '	    <div class="col-md-6 mb-3">' +
           
                    '	<label for="statut">Statut</label>' +
                    '	<input type="number" class="form-control form-control-sm design statut" name="statut" id="statut" required>' +
            '		</div>' +
            // '<div class="col-md-1 mb-3 display_btn_save  d-none text-center">' +
            //     '	<label for="user">Enregister</label><br>' +
            //     '<a data-id="null" id="btn_save_user" class="form-control form-control-sm btn btn-light btn_save_user text-warning"><i class="fas fa-save"></i></a>' +
            //     '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: "Enregistrer",
                            btnClass: "btn-danger",
                            action: function() {
                                $.confirm({
                                    content: function() {
                                        var self = this;
            
                                        var formulaire = $(".formulaire_user")[0];
                                        var formData = new FormData(formulaire);
                                        formData.append("INSERTION_USER", "INSERTION_USER");
                                        if (id != "") {
                                        formData.append("id", id);
                                        }
            
                                        return $.ajax({
                                                url: url_user,
                                                method: "POST",
                                                data: formData,
                                                cache: false,
                                                processData: false,
                                                contentType: false,
            
                                            })
                                            .done(function(response) {
                                                self.close();
                                                if (response.indexOf('success') > -1) {
            
                                                    showSuccedWal('Enregistrement reussi');
                                                    affichageUser();
                                                } else {
                                                    showWarningWal("Aucune modification effectuer");
                                                }
                                            })
                                            .fail(function() {
                                                self.setContent("Une erreur est survenu, veuiller ressayer SVP!");
                                            });
                                    },
                                });
                            },
                        },
                        Retour: function() {
            
                        },
                    },
                    onOpenBefore: function() {
                        var self2 = this;
            
                     
            
                        if (id != "") {
                
                            $.ajax({
                                url: url_user,
                                method: "POST",
                                dataType: 'JSON',
                                data: { USER_AFFICHAGE: "USER_AFFICHAGE", id: id },
                                success: function(response) {
            
                                    rowS = response[0];
            
                                    $('.username').val(rowS.username);
                                    $('.mdp').val(rowS.motdepasse);
                                    $('.statut').val(rowS.statut);

                             
                                   
                                }
            
                            });
            
                        } else {
            
                        }
            
                        
                    },
            
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                    //affichageUser();
                });
                
                
            }
            
        });
    }
    affichageUser();


         $(document).on("click", ".btn_add_user", function() {
            add_user("");
        });
        
        $(document).on("click", '.btn_modif_user', function() {
            var id = $(this).data('id');
            add_user(id);
        });
    
    $(document).on('click', '.btn_supp_user', function(){
        var id = $(this).data('id');
        //var libelle = $(this).data('libelle');
        $.confirm({
            title: 'Confirmation',
            content: 'Voulez-vous vraiment la supprimer ?',
            buttons: {
                Supprimée: function () {
                    
                    $.confirm({
                        content: function () {
                            var self = this;
                            return $.ajax({
                                url: url_user,
                                method: 'POST',
                                data: {USER_DELETTE: 'USER_DELETTE' , id:id}
                            }).done(function (response) {
                                self.close();

                                if (response.indexOf('success') > -1) {
                                    showSuccedWal("Utilisateur Suprimée");
                                    affichageUser();
                                } else
                                    showWarningWal(response);
                            }).fail(function () {
                                self.setContent('echec de la suppression');
                            });
                        }
                    });
                },
                Annulée: function () {
                    $.alert('Suppressin annulée');
                },
              
            }
        });
                                    
        
    });


})
