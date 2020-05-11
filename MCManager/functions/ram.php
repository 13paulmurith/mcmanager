<?php
  error_reporting(E_ERROR | E_PARSE);
  function GetRam(){
    $fh = fopen('/proc/meminfo','r');
    $mem = 0;
    while ($line = fgets($fh)) {
      $pieces = array();
      if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
        $mem = $pieces[1];
        break;
      }
    }
    fclose($fh);
    return $mem;
  }?>