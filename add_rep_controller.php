<?php

session_start();
include('courrier.controller.php');

$_SESSION['erreur'] = '' ;
$_SESSION['added'] = '' ;

if (isset($_POST['add_rep'])  && $_SERVER["REQUEST_METHOD"] == "POST") 
{

    if (isset($_POST['add_rep'])) 
    {

        if (
            isset($_POST['add_rep'], $_FILES['fichier'] , $_POST['id_cour']  )
            && ! empty(  $_POST['id_cour']  )
            &&  (!empty(trim($_POST['msg']))  ||   (!empty($_FILES['fichier']['name'])  &&    $_FILES['fichier']['size']  != 0))

        ) {

            if (!empty(trim($_POST['id_cour']))) {
                $id_cour = $_POST['id_cour'];
                 
            } else {
                $id_cour =  NULL;
            }

            if (!empty(trim($_POST['msg']))) {
                $msg = $_POST['msg'];

            } else {
                $msg =  NULL;
            }

            if ((!empty($_FILES['fichier']['name'])  &&    $_FILES['fichier']['size']  != 0)) 
            {
                $fichier = $_FILES['fichier']['name'];

            } else {
                $fichier =  NULL;
            }


            if ($courrier->add_rep($id_cour, $msg)) 
            {
                $_SESSION['added']  = "<div class='alert alert-success text-center ' > 
                                            <b>   Répense   envoyée !  </b>
                                        </div>  ";
            } else {
                "<div class='alert alert-warning text-center ' > 
                <b> Erreur !  La répense n'est pas envoyée ! </b>
             </div>  ";
            }


            header("location:courrier.php?id=$id_cour");
        } else {

            $_SESSION['erreur']  .=
                "<div class='alert alert-warning text-center ' > 
               <b> Erreur !  Remplissez au moins un seul champ pour répondre! </b>
            </div>  ";
            if (!empty(trim($_POST['id_cour']))) {
                $id_cour = $_POST['id_cour'];
                header("location:courrier.php?id=$id_cour");
            } else {
                header("location:home.php");
            }
             
        }
    } else {
        header("location:home.php");
    }
} else {
    header("location:home.php");
}
