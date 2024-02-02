<?php
include('./include/header.php');
session_start();
$statut = '';
if ($_SESSION['username']) {
    $statut = $_SESSION["statut"];
    $username = $_SESSION['username'];
    $motdepasse = $_SESSION['motdepasse'];
} else {
    header("location:login.php");
}
?>
<input class="d-none statut_user" type="text" value="<?php echo $statut; ?>">
<style>
    a {
        color: black;
    }


    .clearable {
        background: #fff url(http://i.stack.imgur.com/mJotv.gif) no-repeat right -10px center;
        border: 1px solid #999;
        padding: 3px 18px 3px 4px;
        border-radius: 3px;
        transition: background 0.4s;
    }

    .clearable.x {
        background-position: right 5px center;
    }

    /* (jQ) Show icon */
    .clearable.onX {
        cursor: pointer;
    }

    /* (jQ) hover cursor style */
    .clearable::-ms-clear {
        display: none;
        width: 0;
        height: 0;
    }

    .text-info:hover {
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0.2);
    }

    /* Remove IE default X */
</style>

<script>

    var id_image;

    function show_image(params) {
        console.log(params);
        id_image = params;
        preview_image(event)

    }

    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(id_image);
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

</script>

<div class="card card-default">

    <div class="card-header" style="text-align: center;">
        <div class="card-header" style="text-align: center;">

            <div class="row">
                <div class="col-2">
                    <a>
                        <div class="btn btn-sm btn-default float-left btn_add_client" name="btn_add_client" id="btn_add_client"><i class="fa fa-plus text-grey"> </i> Client</div>
                    </a>
                </div>
                <div class="col-2">
                    <a>
                        <div class="btn btn-sm btn-default float-left btn_chambre" name="btn_chambre" id="btn_chambre"><i class="fa fa-plus text-grey"> </i> Chambre</div>
                    </a>
                </div>
                <div class="col-2">
                    <select class="filtre form-control form-control-sm" name="filtre" id="filtre">

                        <option disabled selected>Filtre client</option>
                        <option value="3">tout clients</option>
                        <option value="1">clients en cours</option>
                        <option value="2">clients quités</option>

                    </select>

                </div>
            </div>

            <!-- <a>
            <?php
            if ($statut == 1) echo '<div class="btn btn-sm btn-default float-left btn_user " name="btn_user" id="btn_user"><i class="fa fa-plus"> </i> user</div>';
            ?>
            
        </a> -->
        </div>




    </div>

    <div class="card-body" style="font-size: 11pt;">

        <table id="table_client" class="table table-striped">
            <thead>
                <tr style="background-color:grey ;">
                    <!-- <th style="width: 5%;">N°</th> -->
                    <th style="width: 8%;">NumCh</th>
                    <th>Nom et Prenom</th>
                    <th>date d'arivée</th>
                    <th>date de départ</th>
                    <th>Statut</th>
                    <th style="width: 15%;">Action</th>
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
<script src="./model/script/employerScript.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>