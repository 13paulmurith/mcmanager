
<?php
    session_start();
    include('functions/head.php');
    include('configs/mc_config.php');

    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location:'.$_SERVER['PHP_SELF']);
    }

    if(isset($_POST['submit'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        if($user==$AdminInfo['user'] && $pass==$AdminInfo['password']){
            $_SESSION['username'] = $user;
            header('Location:home.php');
            exit;
        }
        else {
            echo '<p class="alert alert-danger" style="text-align: center">Identifiant ou mot de passe incorrect</p>';
        }
    }

?>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh">
            <img src="src/img/minecraft_logo.png" alt="#" />
            <div class="col-4">
                <div class="card">
                    <h4 style="text-align:center; padding-top:5%">Minecraft Web Console</h4>
                    <div class="card-body">
                        <form action="" name="LoginForm" autocomplete="off" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Identifiant">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-success" type="submit" name="submit" value="Connexion">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>