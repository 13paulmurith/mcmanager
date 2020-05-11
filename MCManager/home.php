<!DOCTYPE html>
<html lang="fr">
<?php
  session_start();
  include('functions/head.php');
  include('configs/mc_config.php');
  include('functions/aliveordied.php');

  //Check connexion
  $user = $_SESSION['username'];
  if(!isset($user)){
    header ('Location:index.php?logout=1');
    exit;
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
          <div class="col-md-9">
            <h2 class="mt-4">Liste des serveurs</h2>
          </div>
          <div class="col-md-3" style="padding-top:2%; padding-bottom: 2%">
            <button type="button" onclick="window.location.href = 'add.php';" class="btn btn-success">Ajouter un serveur</button>
          </div>
        </div>
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">ServerName</th>
                <th scope="col">ServerPort</th>
                <th scope="col">RconPort</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $serversfile = fopen('configs/servers.csv', 'r') or die("Error openning file");
              $count = 1;
              while(($serverdata = fgetcsv($serversfile, 1000, ';')) != FALSE){
                $connexiontest = aliveordied('tcp://'.$serverdata[0].':'.$serverdata[1]);
                echo '<tr>';
                echo '<th scope="row">'.$count.'</th>';
                echo '<td><a href="view.php?serverip='.$serverdata[0].'&serverport='.$serverdata[1].'&rconport='.$serverdata[2].'&rcon='.$serverdata[3].'" style="text-decoration:none;">'.$serverdata[0].'</a></td>';
                echo '<td>'.$serverdata[1].'</td>';
                echo '<td>'.$serverdata[2].'</td>';
                if ($connexiontest == TRUE){
                  echo '<td class="alert alert-success">OK</td>';
                }
                else {
                  echo '<td class="alert alert-danger">Down</td>';
                }
                echo '</tr>';
                $count++;
              }
              fclose($serversfile);
            //echo '<td class="alert alert-success">OK</td>';
            //echo '<td class="alert alert-danger">OK</td>';
            ?>
            </tbody>
          </table>
      </div>
    </div>

  </div>

</body>

</html>
