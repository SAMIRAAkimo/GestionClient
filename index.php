<?php
session_start();

if (array_key_exists('statut', $_SESSION)) {
    
    $statut=$_SESSION["statut"];
    $username=$_SESSION['username'];
    $motdepasse=$_SESSION['motdepasse'];
    if($statut!=1 && $statut!=0){
        header("location:login.php");
    }
}else {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel de la poste</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/vendor/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="./assets/vendor/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="./assets/vendor/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="./assets/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="./assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="./assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="./assets/vendor/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <!--<link rel="stylesheet" href="./assets/vendor/dropzone/min/dropzone.min.css">-->
    <!-- DataTables -->
    <link rel="stylesheet" href="./assets/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!--checkbox Datatable-->
    <link href="./assets/vendor/checkboxDataTable/css/dataTables.checkboxes.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="./assets/css/adminlte.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="./assets/vendor/summernote/summernote-bs4.min.css">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="./assets/vendor/codemirror/codemirror.css">
    <link rel="stylesheet" href="./assets/vendor/codemirror/theme/monokai.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="./assets/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="./assets/vendor/Confirme/jquery-confirm.min.css?v=<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet" type="text/css" />
    <!--sweetAlert-->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="./assets/vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!--toastr-->
    <link href="./assets/vendor/toastr/toastr.min.css?v=<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet" type="text/css" />
    <!--custom css-->
    <link href="./assets/css/custom.css?v=<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet" type="text/css" />
    <!--select with checkbox-->
    <link href="./assets/vendor/SelectCheckbox/css/bootstrap-multiselect.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
    <div class="wrapper">

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar bg-white elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <!-- <img src="./assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <span class="brand-text font-weight-light"></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="./assets/img/avatar2.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Utilisateur</a>
                    </div>
                </div> -->

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Chercher" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                       
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class=" nav-icon fas fa-th-large"></i>
                                <p class="">
                                    Tableau de bord
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                    <a href="index2.php" class="nav-link">
                                        <i class="fas fa-user-circle nav-icon"></i>
                                        <p> Client</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="journalier.php" class="nav-link">
                                        <i class="fas fa-th-list nav-icon"></i>
                                        <p> Fiche journalier</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="mensuel.php" class="nav-link">
                                        <i class="fas fa-th-list nav-icon"></i>
                                        <p> Fiche mensuel</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php
                            if($statut==1) echo '
                            
                            <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class=" nav-icon fas fa-cogs"></i>
                                <p class="">
                                    Parametre
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="user.php" class="nav-link">
                                        <i class="fas fa-user-plus nav-icon"></i> <p>Utilisateur</p> 
                                       
                                    </a>
                                </li>
                            </ul>
                        </li>
                            
                            ';
                        ?>

                      

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!--include body-->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750" style="background-image: url(accueil.jpg); background-size:cover;">
            <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"></a> -->
                <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
                <!-- <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"></a> -->
                <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <div class="nav-item dropdown">
                    <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Fermer</a>
                    <div class="dropdown-menu mt-0">
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Fermer tout</a>
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Fermer les
                            autres</a>
                            
           <a class='btn btn-danger form-control' href="logout.php" >Déconnexion</a>
        
                    </div>
                </div>
            </div>
            <div class="tab-content" >
                <div class="tab-empty">
                     <!--<h2 class="display-4">Aucun onglet sélectionné!</h2>-->
                </div>
                <div class="tab-loading">
                    <div>
                       <h2 class="display-4">Chargement en cours <i class="fa fa-sync fa-spin"></i></h2> 
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->




        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="./assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="./assets/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Select2 -->
    <script src="./assets/vendor/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="./assets/vendor/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="./assets/vendor/moment/moment.min.js"></script>
    <script src="./assets/vendor/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="./assets/vendor/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="./assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="./assets/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="./assets/vendor/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="./assets/vendor/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <!--<script src="./assets/vendor/dropzone/min/dropzone.min.js"></script>-->
    <!-- DataTables  & Plugins -->
    <script src="./assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="./assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="./assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="./assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="./assets/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="./assets/vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="./assets/vendor/jszip/jszip.min.js"></script>
    <script src="./assets/vendor/pdfmake/pdfmake.min.js"></script>
    <script src="./assets/vendor/pdfmake/vfs_fonts.js"></script>
    <script src="./assets/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="./assets/vendor/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="./assets/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!--inline table editor-->
    <script src="./assets/vendor/jquery-tabledit-1.2.3/jquery.tabledit.js?v=<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/javascript"></script>
    <!--<script src="./assets/vendor/jquery-tabledit-1.2.3/jquery.tabledit.min.js?v=<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/javascript"></script>-->
    <script src="./assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js" type="text/javascript"></script>

    <!--checkbox Datatable-->
    <script src="./assets/vendor/checkboxDataTable/js/dataTables.checkboxes.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="./assets/js/adminlte.min.js?v=<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    <!-- Summernote -->
    <script src="./assets/vendor/summernote/summernote-bs4.min.js"></script>
    <!-- CodeMirror -->
    <script src="./assets/vendor/codemirror/codemirror.js"></script>
    <script src="./assets/vendor/codemirror/mode/css/css.js"></script>
    <script src="./assets/vendor/codemirror/mode/xml/xml.js"></script>
    <script src="./assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./assets/js/demo.js"></script>
    <!--confirme-->
    <script src="./assets/vendor/Confirme/jquery-confirm.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="./assets/vendor/sweetalert2/sweetalert2.min.js"></script>
    <!--toastr-->
    <script src="./assets/vendor/toastr/toastr.min.js?v=<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/javascript"></script>
    <!--select checkbox-->
    <script src="./assets/vendor/SelectCheckbox/js/bootstrap-multiselect.min.js" type="text/javascript"></script>

</body>

</html>