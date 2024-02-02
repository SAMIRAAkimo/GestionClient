<?php
include('./include/header.php');

?>
<style>
    table thead{
        max-height: 20px;
        color:black;
    }
</style>

<!--  -->
       
<div class="card card-default">

    <div class="card-header" style="text-align: center;">

    <div class="container">
            <div class="row">
                <div class="col-md-2 form-group">
                    <label for="chambre occupé">Ch occupée</label> <br>
                    <input type="text" value="chambre occupé" class="disabled chambre_occupe "style='width:30px;' disabled>
                </div>

                

                <div class="col-md-2 form-group">
                    <label for="chambre libre">Ch libre</label> <br>
                    <input type="text" value="chambre libre" class="disabled chambre_libre "style='width:30px;' disabled>
                </div>

                <div class="form-group col-2">
                
                <a >
                    <div class="btn btn-sm btn-danger btn_prev" name="btn_prev" id="btn_prev"><i class="fa fa-sharp fa-solid fa-caret-left"></i></div>
                </a>
                <a >
                    <div class="btn btn-sm btn-danger btn_next" name="btn_next" id="btn_next"><i class="fa fa-solid fa-caret-right"></i></div>
                </a>

                </div>

                <div class="form-group col-2">
                <select class="select form-control form-control-sm" name="mois" id="mois">
                    <option selected disabled>choisir mois</option>
                    <option value="1">Jan</option>
                    <option value="2">Fev</option>
                    <option value="3">Mars</option>
                    <option value="4">Avr</option>
                    <option value="5">Mai</option>
                    <option value="6">Juin</option>
                    <option value="7">Juillet</option>
                    <option value="8">Aout</option>
                    <option value="9">Sept</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">dec</option>
                </select>

                </div>
                <div class="form-group col-3">
                

                
                <select class="element select form-control form-control-sm" id="annee" name="annee" value="" required>
                    <option disabled selected value> -- choisir l'année -- </option>
                <?php
                        $year = range((date("Y")+4), 2000);
                        foreach ($year as $anne) {
                    ?>
                    <option value="<?php echo $anne; ?>"><?php echo $anne; ?></option>
                    <?php } ?>
                </select>
                
                </div>
                
                <div class="form-group col-1 ">
                <a >
                    <div class="btn btn-sm btn-danger btn_export disabled" name="btn_export" id="btn_export"><i class="fa fa-sharp fa-solid fa-file-excel"></i></div>
                </a>
                </div>

               
            </div>
        </div>
        
       
     </div>

    <div class="card-body" style="font-size: 11pt;">

        <table id="table_mensuel" class="table table-striped">
            <thead >
                <tr class="bg-grey" style="height:50px; background-color:grey;">
                
                    <th style="width: 10%;">N° Chbr <label for="" ></label></th>
                    <th>Lun <label for="" class="lun"></label></th>
                    <th>Mar <label for="" class="mar"></label></th>
                    <th>Mer <label for="" class="mer"></label></th>
                    <th>Jeu <label for="" class="jeu"></label></th>
                    <th>Vend <label for="" class="ven"></label></th>
                    <th>Sam <label for="" class="sam"></label></th>
                    <th>Dim <label for="" class="dim"></label></th>
                </tr>
            </thead>
            <tbody class="liste_client">

            </tbody>
        </table>


    </div>

</div>



<?php

include('./include/footer.php');
?>
<script src="./model/script/Element.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>
<script src="./model/script/mensuel.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>

<script>

var mois;
var annee

$(document).on('change', '#mois', function () {
      
       mois = $(this).val();

       if(mois && annee){
        $('#btn_export').removeClass('disabled')
        }
    
})
$(document).on('change', '#annee', function () {
      
       annee = $(this).val();
       if(mois && annee){
        $('#btn_export').removeClass('disabled')
}
    
})


$('.btn_export').on('click', function(e) {

    if(!annee || !mois){

    }else{
        
    window.open('./output/mensuel_excel.php?mois='+mois+'&annee='+annee, '_blank');
    
    }
});



</script>