<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baridi Health Home</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/index.css">

</head>

<body>



    <?php
    include('courrier.controller.php');
    $cnx->is_connected();
    include('header.php');
    ?>


    <section class="container_tab mt-4  ">

        <h1 class='bg-white titre-page mb-5 text-center'>
            <i class="fa-solid fa-hotel"></i>
            <?php
            if (isset($_SESSION['nom_service'])) {
                echo $_SESSION['nom_service'];
            } else {
                echo "Notre service ";
            }  ?> | Courriers arrivés
            <span class='icone'>
                <i class='fa-solid fa-circle-down'></i>
            </span>
        </h1>

        <div class='content_table'>

            <?php

            $courrier->get_all__service_courriers_recu($_SESSION['id_service']);

            ?>

        </div>


    </section>



    <script src="js/all.js"></script>
    <script src="bootstrap/jquery.js"></script>
    <script src="bootstrap/bootstrap.js"></script>



</body>

</html>