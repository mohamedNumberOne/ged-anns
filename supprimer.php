<?php

include('');

if( isset( $_GET['id'] ) && count($_GET) === 1 ) {

    $sql = " DELETE FROM courriers WHERE id = ?  " ;
    $_SESSION['supprimer'] = "" ;

}

?>