<!DOCTYPE html>
<html lang="fr">
<?php
  session_start();
  include('functions/head.php');
  include('functions/connect.php');
  include('functions/aliveordied.php');
  include('functions/getstatus.php');

  $user = $_SESSION['username'];
  if(!isset($user)){
    header ('Location:index.php?logout=1');
    exit;
  }

  if(isset($serverstatus)){
    unset($serverstatus);
  }

  //Get Info
  $serverip=$_GET['serverip'];
  $rconport=$_GET['rconport'];
  $rcon=$_GET['rcon'];
  
  //SendCommand
  if(isset($_POST['submit'])){
    $command = $_POST['command'];
    $command = htmlspecialchars($command);
    $sendcommand = rconConnect($serverip, $rconport, $rcon, $command) or die ('Error sedding command');
  }

  //GetStatus
  $serverstatus = getServerStatus($serverip);
  $connexiontest = aliveordied('tcp://'.$serverip.':'.$rconport);

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

      <div class="container-fluid" style="padding-top: 2%;">
        <div class="row">
          <div class="col-md-9">
            <h2 class="mt-4">Serveur status</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h4><?php echo $serverstatus[motd]->text?></h4>
          </div>        
        </div>
        <div class="row">
          <div class="col-md-12">
          <?php 
            if($serverstatus==false){
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
              echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
              echo '<span aria-hidden="true">&times;</span>';
              echo '</button>';
              echo '<strong>Error during server port query.</strong> Check if enable-query=true in your server.properties.';
              echo '</div>';
            }
          ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <?php 
            if($connexiontest==1){
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
              echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
              echo '<span aria-hidden="true">&times;</span>';
              echo '</button>';
              echo '<strong>Successfully connected to Rcon</strong>';
              echo '</div>';
            }
            else {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
              echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
              echo '<span aria-hidden="true">&times;</span>';
              echo '</button>';
              echo '<strong>Error connecting to Rcon</strong>Check you firewall or your Minecraft configuration.';
              echo '</div>';
            }
          ?>
          </div>
        </div>
        <div class="row" style="padding-top: 2%;">
          <div class="col-md-4">
            <h4>Ping</h4>
            <h5><?php echo $serverstatus[ping];?></h5>
          </div>
          <div class="col-md-4">
            <h4>Version</h4>
            <h5><?php echo $serverstatus[version];?></h5>
          </div>
          <div class="col-md-4 align-self-cente">
            <h4>Joueurs</h4>
            <h5><?php echo $serverstatus[players].'/'.$serverstatus[maxplayers]?></h5>
          </div>                    
        </div>
        <div class="row">
          <div class="col-md-12">
          <div class="app">
            <textarea class="textarea">
            <?php
              if(isset($sendcommand)){
                echo $sendcommand;
              }
            ?>
            </textarea>
          </div> 
          </div>
        </div>
        <div class="row" style="margin-top:2%">
          <div class="col-md-12">
            <form action="" name="LoginForm" autocomplete="off" method="post">
              <div class="form-row">
                <div class="col-md-10">
                  <input type="text" class="form-control" name="command" placeholder="Commande" required>
                </div>
                <div class="col-md-2">
                  <input class="btn btn-success" type="submit" name="submit" value="Envoyer">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <h4 class="mt-4" style="padding-left:2%">/help</h4>
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Commande</th>
                <th scope="col">Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">/ban [Joueur]</th>
                <td>Bannit un joueur du serveur, avec une raison optionelle. Un joueur banni ne peut plus se connecter au serveur.</td>
              </tr>
              <tr>
                <th scope="row">/pardon [Joueur]</th>
                <td>Enlève le bannissement du joueur.</td>
              </tr>
              <tr>
                <th scope="row">/banlist [(ips|players)]</th>
                <td>Affiche la liste des joueurs ou des adresses IP bannies du serveur.</td>
              </tr>
              <tr>
                <th scope="row">/op [Joueur]</th>
                <td>Donne les permissions d'opérateur à un joueur.</td>
              </tr>
              <tr>
                <th scope="row">/deop [Joueur]</th>
                <td>Retire les permissions d'opérateur à un joueur.</td>
              </tr>
              <tr>
                <th scope="row">/time <(add|query|set)></th>
                <td>Change l'heure dans le monde (ainsi que la position du soleil et de la lune).</td>
              </tr>
              <tr>
                <th scope="row">/gamemode <(survival|creative|adventure|spectator)> [Joueur]</th>
                <td>Change le mode de jeu d'un joueur.</td>
              </tr>
              <tr>
                <th scope="row">/weather <(clear|rain|thunder)></th>
                <td>Change la météo pour celle choisie. Notez que dans certains biomes tels que le désert, les particules de pluie n'apparaîtront pas, et seul le ciel s'assombrira.</td>
              </tr>
              <tr>
                <th scope="row">/difficulty <(peaceful|easy|normal|hard)></th>
                <td>Définit la difficulté de jeu sur la map en cours. Ce niveau de difficulté n'est pas enregistré, et sera réinitialisé à chaque lancement.</td>
              </tr>
              <tr>
                <th scope="row">/clear [Joueur] [Objet] [Quantité]</th>
                <td>Vide l'inventaire d'un joueur (ou le vide des objets choisis)</td>
              </tr>
            </tbody>
        </div>        
      </div>
    </div>

  </div>

</body>
</html>
