<?php
    require_once "model/time.php";

    $t = new Time('ntefsd', '2010');

    $t -> setjogadores('mario', 'lateral', new DateTime('15-07-2005'));
    $t -> getJogadores();
    
?>