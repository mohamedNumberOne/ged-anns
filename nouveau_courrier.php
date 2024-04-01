<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Baridi Health </title>
    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel='stylesheet' href='css/all.css'>
    <link rel='stylesheet' href='css/index.css'>

    <style>
        body {
            background-image: url('img/bg1.png');
            background-size: contain;
            background-position: center;

        }

        .container .box-shadow {
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid #eee;
        }
    </style>

</head>

<body>


    <?php
    // include('connect.class.php'); 
    include('courrier.controller.php');
    $cnx->is_connected();
    include('header.php');

    if (isset($_SESSION['added'])) {
        echo  $_SESSION['added'];
        unset($_SESSION['added']);
    }

    if (isset($_SESSION['erreur'])) {
        echo  $_SESSION['erreur'];
        unset($_SESSION['erreur']);
    }



    ?>


    <section class='container mt-4  '>

        <h1 class='bg-white titre-page '>
            Nouveau courrier
            <span class='icone'>
                <i class='fa-solid fa-file-circle-plus'></i>
            </span>
        </h1>

        <div class='box-shadow mt-3 mb-3 '>

            <form method='POST' action='add_courrier_controller.php' enctype='multipart/form-data'>
                <div class='row'>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <input type='text' class='form-control' placeholder='#Réf' name='ref' required>
                    </div>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <input type='text' class='form-control' placeholder='Objet' name='sujet' required maxlength="255">
                    </div>
                </div>

                <div class='row mt-3'>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <label for='fichier' class='badg badge-light  rounded p-1'> <b> Fichier : pdf / image </b> </label>
                        <input type='file' class='form-control' id='fichier' name='fichier' accept='.pdf, .png, .jpg, .jpeg, .PNG,'>
                    </div>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <label for='date' class='rounded p-1 badg badge-light'> <b> Date arrivé </b> </label>
                        <input type='date' class='form-control' id='date' name='date_courrier' required value="2023-10-03">
                    </div>
                </div>

                <div class='row mt-3'>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <?php $courrier->select_all_services_internes(); ?>
                    </div>


                    <div class='col-md-6 mb-sm-3 col-sm-12'>

                        <label for='date' class='rounded p-1 badg badge-light'> <b> Source </b> </label>

                        <select class='form-control' name='source' required>
                            <option value=''> </option>
                            <option value='1'>ministére des finances</option>
                            <option value='2'> ANNS </option>
                            <option value='3'> ANS </option>
                            <option value='4'> Ministére de la justice </option>
                            <option value='5'> PCH </option>
                            <option value='6'> CHU mustapha </option>

                        </select>

                    </div>


                </div>

                <div class='row mt-3'>

                    <div class='col-md-3 mb-sm-3 col-sm-12'>
                        <label class='rounded p-1 badg badge-light text-danger '> <b> Confidentiel ? </b> </label>
                        <select class='form-control' name='confidentiel' required>
                            <option value=''> </option>
                            <option value='1' selected>oui</option>
                            <option value='0'>non</option>
                        </select>
                    </div>


                    <div class='col-md-3 mb-sm-3 col-sm-12'>
                        <label class='rounded p-1 badg badge-light text-danger '> <b> Urgent ? </b> </label>
                        <select class='form-control' name='urgent' required>
                            <option value=''> </option>
                            <option value='1' selected>oui</option>
                            <option value='0'>non</option>
                        </select>
                    </div>

                    <div class='col-md-3 mb-sm-3 col-sm-12'>
                        <label class='rounded p-1 badg badge-light text-danger '> <b> Important ? </b> </label>
                        <select class='form-control' name='important' required>
                            <option value=''> </option>
                            <option value='1' selected>oui</option>
                            <option value='0'>non</option>
                        </select>
                    </div>

                </div>

                <div class='row mt-3'>

                    <div class='col-md-12 mb-sm-3  '>
                        <label class='rounded p-1 badg badge-light '> <b> Message </b> </label>
                        <textarea name="msg" maxlength="255" cols="30" rows="10" class='form-control' placeholder="Message facultatif"></textarea>

                    </div>

                </div>

                <input type='submit' value='Ajouter +' class='btn btn-recherche  ' name='add_courrier'>

            </form>

        </div>


    </section>



    <script src='js/all.js'></script>
    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>



</body>

</html>