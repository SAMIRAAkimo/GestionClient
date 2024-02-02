<?php

    require_once ('./config/db_config.php');
    include('./include/header.php');

    session_start();
    if(array_key_exists('id', $_SESSION)){
            header('location:index.php');
    
     }
    if (isset($_POST['login'])) {
        $essai='Connexion échoué';
        $username = $_POST['username'];
        $motdepasse=$_POST['motdepasse'];
        $req="SELECT * FROM personnel WHERE username='".$username."' AND motdepasse='".$motdepasse."'";

        $rst = $mysqli->query($req);
        $result_obt = array();

        if ($rst->num_rows > 0) {
            $_SESSION['username']=$username;
           while ($row = $rst->fetch_assoc()) {
                $result_obt[] = $row;

                $_SESSION["statut"]=$row['statut'];
                $_SESSION['username']=$row["username"];
                $_SESSION['id']=$row["id"];
                $_SESSION['motdepasse']=$row["motdepasse"];

           }
           header("location:index.php");
        }
        
    }
   
    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="./Asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./asset/fontawesome/css/all.min.css">
</head>
<body>
    <div class="wraper">

    <div class="container">
        <div class="row">
            <div class="col-md-3 m-auto">
                <img src="./assets/image/logo.jpg" alt=""class="logo mb-4 ml-5">
                <div class="line-1 mb-4" ></div>
                
                <form action="" method="post" class="form-group">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" id="username" class="username form-control mb-4 ">
                    <span class="icon"><i class="fa fa-solid fa-lock"></i></span>
                    <input type="password" name="motdepasse" id="motdepasse" class="motdepasse form-control mb-4">
                    
                    <input type="submit" name="login" id="login"value="Connexion" class="login m-2" style="width: 100px;">
                </form>
                <div class="line-2 mb-4" ></div>
            </div>
        </div>
    </div>
    </div>
   
</body>
<?php

include('./include/footer.php');
?>
</html>
