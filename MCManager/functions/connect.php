<?php
    require_once('rcon.php');
    use Thedudeguy\Rcon;
    
    function rconConnect($host, $rconport, $password, $command){


        $rcon = new Rcon($host, $rconport, $password, '3');
        if ($rcon->connect())
        {
            $commandvalue = $rcon->sendCommand($command);
            return $commandvalue;
            $rcon->$disconnect;
        }
    }
?>
