<?php


function deco()
{
    session_destroy();
    unset($_SESSION);
    header("location:index.php");
}



if (isset($_POST['deco'])) {

    deco();
}



?>



<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light my_nav ">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="home.php">
                        <img src="img/logo FINAL ANNS B PNG.png" alt="" width="50px">
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="home.php">
                        Accueil
                        <span class="icone"> <i class="fa-solid fa-house"></i>
                        </span>
                        <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        Courriers
                        <span class="icone">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu">

                        <a class="dropdown-item" href="nouveau_courrier.php">
                            Nouveau courrier
                            <span class="icone">
                                <i class="fa-solid fa-file-circle-plus"></i>
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="c_envoyes.php">
                            Envoyés
                            <span class="icone">
                                <i class="fa-solid fa-circle-arrow-up"></i>
                            </span>
                        </a>
                        <a class="dropdown-item" href="c_recus.php">
                        Arrivés
                            <span class="icone">
                                <i class="fa-solid fa-circle-down"></i>
                            </span>
                        </a>
                    </div>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="recherche.php">
                        Recherche
                        <span class="icone">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        |
                        <span class="icone">
                            <i class="fa-solid fa-bell"></i>
                        </span> |
                    </a>
                </li>

        </div>
        <form method="POST">
            <button class="btn  btn-deco my-2 my-sm-0" type="submit" name="deco">
                <i class="fas fa-power-off"></i> Se déconnecter
            </button>
        </form>
    </nav>


</header>