<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Baridi Health C.info</title>

    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel='stylesheet' href='css/all.css'>
    <link rel='stylesheet' href='css/home.css'>
    <link rel='stylesheet' href='css/index.css'>
    <link rel='stylesheet' href='css/courrier.css'>

</head>

<body>


    <?php
    include('courrier.controller.php');
    $cnx->is_connected();
    include('header.php');

    ?>




    <section class=''  >


        <div class='container  discussion'>

            <?php

            if (isset($_SESSION['added'])) {
                echo  $_SESSION['added'];
                unset($_SESSION['added']);
            }

            if (isset($_SESSION['erreur'])) {
                echo  $_SESSION['erreur'];
                unset($_SESSION['erreur']);
            }


            if ( isset( $_POST['transfer_c'] ) ) {
                 
            }

            if (isset($_GET['id']) && !empty(trim($_GET['id']))) 
            {

                $id = $courrier->secure_input($_GET['id']);
                if ($courrier->verify_id('courriers', 'id_cour', $id)) {

                    if ($courrier->has_access_courrier($id)) 
                    {
                        if (!$courrier->is_courrier_vu($id)) 
                        {
                            $courrier->add_courrier_vu($id);
                        }

                        $courrier->get_courrier_info($id);
                    } else {
                        header('location:home.php'); 
                    }
                } else {
                    header('location:home.php');
                }
            }

            


            ?>

        </div>



    </section>



    <script src='js/all.js'></script>
    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>
    <script>
        var spans = document.querySelectorAll('#suggestions span ');

        for (var i = 0; i < spans.length; i++) {


            spans[i].addEventListener('click', function() {

                var msg = document.getElementById('msg');
                msg.value = this.innerHTML;

            });

        }
    </script>

</body>

</html>