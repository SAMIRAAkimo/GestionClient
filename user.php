<?php include './include/header.php'; ?>
<div class="card card-default">

    <div class="card-header" style="text-align: center;">

    <div class="container">
        <div class="row">
    
        <a>
            <div class="btn btn-sm btn-default float-left btn_add_user" name="btn_add_user" id="btn_add_user"><i class="fa fa-plus"> </i> Ajouter un utilisateur</div>
        </a>
        
        </div>  
    </div>    
    </div>

    <div class="card-body" style="font-size: 11pt;">

        <table id="table_user" class="table table-striped">
            <thead>
                <tr>
                <!-- <th style="width: 5%;">N°</th> -->
                    <th>Username</th>
                    <th>Statut</th>
                    <th style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody class="liste_user">

            </tbody>
        </table>


    </div>

</div>


<?php include './include/footer.php'; ?> 
<script src="./model/script/Element.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>
<script src="./model/script/user.js?v=<?php echo date('l jS of F Y h:i:s A'); ?>"></script>