<?php
include('./include/header.php');

?>

<!-- <input type="date" class="d-none date_excel_now" value="<?php echo date('Y-m-d')?>"> -->

<div class="">
    <div class="row">
        <div class="card col-9">

            <div class="card-body" style="font-size: 11pt;">
                <table id="table_journalier" class="table table-striped">
                    <thead>
                        <tr style="background-color:grey ;">
                            <!-- <th style="width: 5%;">N°</th> -->

                            <th>Ch<label for="" class="num_chambre"></label></th>
                            <th>Type<label for="" class="type"></label></th>
                            <th>Client<label for="" class="client"></label></th>
                            <th>Catégorie<label for="" class="categorie"></label></th>
                            <th>Arrivée<label for="" class="arrive"></label></th>
                            <th>Nb Nuitées<label for="" class="nuite"></label></th>
                            <th>Forf<label for="" class="forfait"></label></th>
                            <th>Desc<label for="" class="desc"></label></th>
                        </tr>
                    </thead>
                    <tbody class="fiche_jour">

                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>

                        </tr>
                        <tr>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>


            </div>

        </div>
        <div class="card col-3">

            <div class="card-header" style="text-align: center;">
                <label for="" class="text-center" id='date_jour'></label>
            </div>

            <div class="card-body">
                <div class="container">
                    <div class="row">

                        <div class="col-md-12 mb-4">
                            <a style="margin-left:30%;">
                                <div class="btn btn-sm btn-danger btn_prev" name="btn_prev" id="btn_prev"><i class="fa fa-sharp fa-solid fa-caret-left"></i></div>
                            </a>
                            <a style="margin-left:30px;">
                                <div class="btn btn-sm btn-danger btn_next" name="btn_next" id="btn_next"><i class="fa fa-solid fa-caret-right"></i></div>
                            </a>
                        </div>

                        
                        <div class="col-md-8 mt-4" id="date_exp">

                            <input type="date" id="date_excel"  class=" form-control form-control-sm date_excel"  value="<?php echo date('Y-m-d')?>">

                        </div>
                        <div class="col-md-4 mt-4 mb-4">

                            <a style="margin-left:10px;">
                                <div class="btn btn-sm btn-danger btn_export" name="btn_export" id="btn_export"><i class="fa fa-sharp fa-solid fa-file-excel"></i></div>
                            </a>

                        </div>

                        <div class="col-md-12 mt-4">
                            <label for="chambre occupé">Ch occupées</label>
                            <input type="text" value="chambre occupé" class="disabled chambre_occupe float-right" style='width:50px;' disabled>
                        </div>
                        <div class="col-md-12">
                            <label for="chambre libre">Ch libres</label>
                            <input type="text" value="chambre libre" class="disabled chambre_libre float-right" style='width:50px;' disabled>
                        </div>

                        <div class="col-md-12">
                            <label for="total_nb_nuit">Nb arrivées</label>
                            <input type="text" value="nb_arrive" class="disabled nb_arrive float-right" style='width:50px;' disabled>
                        </div>

                        <div class="col-md-12">
                            <label for="total_nb_nuit">Nb depart</label>
                            <input type="text" value="nb_depart" class="disabled nb_depart float-right" style='width:50px;' disabled>
                        </div>

                        <div class="col-md-12">
                            <label for="total_nb_nuit">Nb nuitées</label>
                            <input type="text" value="total_nb_nuit" class="disabled total_nb_nuit float-right" style='width:50px;' disabled>
                        </div>


                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<?php

include('./include/footer.php');
?>
<script src="./model/script/Element.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>
<script src="./model/script/journalier.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>
<script>

    var date;
    $('.date_excel').on('change', function(e) {
        date=$('.date_excel').val()

        journalierManuel(date)

        
    });
    $('.btn_export').on('click', function(e) {
        date=$('.date_excel').val()
        if(date){
           
            window.open('./output/journalier_excel.php?jour='+date, '_blank');
        }
       
    });
</script>