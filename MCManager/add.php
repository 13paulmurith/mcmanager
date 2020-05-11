<!DOCTYPE html>
<html lang="fr">
<?php
  session_start();
  include('functions/head.php');
  
  //Check connexion
  $user = $_SESSION['username'];
  if(!isset($user)){
    header ('Location:index.php?logout=1');
    exit;
  }

  if(isset($_POST['submit'])){
    $serverip = $_POST['serverip'];
    $serverip = htmlspecialchars($serverip);
    $serverport = $_POST['serverport'];
    $serverport = htmlspecialchars($serverport);
    $rconport = $_POST['rconport'];
    $rconport = htmlspecialchars($rconport);
    $rcon = $_POST['rcon'];
    $rcon = htmlspecialchars($rcon);

    $validip = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $serverip);
    $validserverport = preg_match('/^\d{1,5}\z/', $serverport);
    $validrconport = preg_match('/^\d{1,5}\z/', $rconport);

    if($validip == 1 && $validserverport == 1 && $validrconport == 1){
      echo '<p class="alert alert-success" style="text-align: center">Serveur ajouté</p>';
      $fp = fopen('configs/servers.csv', 'a') or die("Error openning file");
      fwrite($fp, $serverip.';'.$serverport.';'.$rconport.';'.$rcon."\n");
      fclose($fp);
    }
    else {
      echo '<p class="alert alert-danger" style="text-align: center">Formulaire incorrect</p>';
    }

  }

?>
<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <a href="home.php" style="text-decoration: none;"><div class="sidebar-heading">Minecraft Manager </div></a>
      <div class="list-group list-group-flush">
        <a href="home.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="index.php?logout=1" class="list-group-item list-group-item-action bg-light">Déconnexion</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link"><i class="far fa-user"></i><?php echo ' '.$_SESSION['username'];?></a>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h2 class="mt-4" style="margin-bottom:2%;">Ajouter un serveur</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <form action="" name="AddServerForm" autocomplete="off" method="post">
              <div class="form-group">
                <label for="servername">IP du serveur</label>
                <input type="text" class="form-control" name="serverip" id="serverip" placeholder="127.0.0.1" required>
              </div>
              <div class="form-group">
                <label for="serverport">Port du serveur</label>
                <input type="text" class="form-control" name="serverport" id="serverport" placeholder="25565" required>
              </div>
              <div class="form-group">
                <label for="rconport">Port RCON du serveur</label>
                <input type="text" class="form-control" name="rconport" id="rconport" placeholder="25575" required>
              </div>
              <div class="form-group">
                <label for="rconport">RCON du serveur</label>
                <input type="password" class="form-control" name="rcon" id="rcon" placeholder="P@ssword" required>
              </div>                                    
              <div class="form-group">
                <input class="btn btn-success" type="submit" name="submit" value="Ajouter">
              </div>
            </form> 
          </div>
          <div class="col-md-6">
            <img src="src/img/characters.png" alt="characters">
          </div>
        </div>
      </div>
    </div>

  </div>

</body>

</html>
