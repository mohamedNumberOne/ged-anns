<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Baridi Health Home</title>

    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel='stylesheet' href='css/all.css'>
    <link rel='stylesheet' href='css/home.css'>
    <link rel='stylesheet' href='css/index.css'>

</head>

<body>


    <?php

    include('connect.class.php');
    $cnx->is_connected();
    include('header.php');
    ?>


    <section class='container  row  m-auto mt-4 pt-5 '>

        <div class='col-md-3 col-sm-12 mb-sm-5 '>
            <div class='card '>
                <img src='img/profile.png' class='card-img-top' alt='profile'>
                <div class='card-body'>
                    <h5 class='card-title'>

                        <?php
                        if (isset($_SESSION['nom_user'], $_SESSION['pnom_user'])) {
                            echo $_SESSION['nom_user'] . ' - ' . $_SESSION['pnom_user'];
                        }
                        ?>
                        <hr>
                    </h5>
                    <p class='card-text'> <?php echo  "  <i class='fa-solid fa-hotel'></i> " .  $_SESSION['nom_service'];  ?> </p>

                </div>
            </div>
        </div>



        <div class='  col-md-9  col-sm-12   '>
            <h1 class='text-center text-light   ' style="font-style:italic;">Tableau de bord </h1>
            <div class="statistiques mt-5">
                <div>
                    <div class='one_stat'>
                        <div class='pourcentage   ' style="height: 25%; background-color: #ffe120  ;"></div>
                    </div>
                    <div class='div_num badge badge-dore'> 10 Envoyés <br> 25% </div>
                </div>
                <!--  -->
                <div>
                    <div class='one_stat'>
                        <div class='pourcentage' style="height: 75%; background-color:  var(--bciel) ;"></div>
                    </div>
                    <div class='div_num badge badge-dore'> Reçus 40 <br> 75% </div>
                </div>
                <!--  -->
                <div>
                    <div class='one_stat'>
                        <div class='pourcentage bg-success ' style="height: 50%; "></div>
                    </div>
                    <div class='div_num badge badge-dore'> 25 Traités <br> 50% </div>
                </div>


                <!--  -->
                <div>
                    <div class='one_stat'>
                        <div class='pourcentage   ' style="height: 30%; background-color:  var(--rouge) ;"></div>
                    </div>
                    <div class='div_num badge badge-dore'> 15 urgents <br> 30% </div>
                </div>
                <!--  -->

                <div>
                    <div class='one_stat'>
                        <div class='pourcentage' style="height: 70%; background-color:  var(--bleu) ;"></div>
                    </div>
                    <div class='div_num badge badge-dore'> 30 vus <br> 70% </div>
                </div>
                <!--  -->

                <div>
                    <div class='one_stat'>
                        <div class='pourcentage' style="height: 70%; background-color:  var(--violet) ;"></div>
                    </div>
                    <div class='div_num badge badge-dore'> 30 importants <br> 70% </div>
                </div>

                <!--  -->

                <div>
                    <div class='one_stat'>
                        <div class='pourcentage' style="height: 30%; background-color: #646060 ;"></div>
                    </div>
                    <div class='div_num badge badge-dore'> 15 Confidentiel <br>30% </div>
                </div>

            </div>
        </div>




    </section>



    <script src='js/all.js'></script>
    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>


</body>

</html>