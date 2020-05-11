<?php
function aliveOrDied($socket){
    $sock = @fsockopen($socket);
    if(is_resource($sock)){
        return 1;
        fclose($sock);
    }
    else {
        return 0;
    }
}
?>