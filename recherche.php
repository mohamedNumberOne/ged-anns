<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Baridi Health Home</title>

    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel='stylesheet' href='css/all.css'>
    <link rel='stylesheet' href='css/index.css'>

</head>

<body>


    <?php
    // include('connect.class.php'); 
    include('courrier.controller.php');
    $cnx->is_connected();
   
    include('header.php');
    ?>


    <section class='container mt-4  '>

        <h1 class='bg-white titre-page '>
            Recherche
            <span class='icone'>
                <i class='fa-solid fa-magnifying-glass'></i>
            </span>
        </h1>

        <div class='box-shadow mt-3 '>

            <form method='post' class=''>
    <?php

    if(  isset( $_POST['rech_ref'] ) ){
        if( isset( $_POST['ref'] )  ){
            $ref = trim($_POST['ref']  );
        $courrier -> recherche_ref ( $ref ) ;

        }
    }

    ?>
                <div class='row mt-3'>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <label for='ref' class='text-white'> Par rérérence </label>
                        <input type='text' class='form-control' id='ref' placeholder='#Ref' name='ref'>
                    </div>

                </div>

                <input type='submit' class='btn  btn-recherche ' value='Recherche'  name="rech_ref" >
            </form>
            <hr>
            <!-- <form method='post'>
                <div class='row mt-3'>
                    <div class='col-md-6 mb-sm-3 col-sm-12'>
                        <label for='exampleFormControlSelect1' class=''> Par direction </label>
                        <select class='form-control' id='exampleFormControlSelect1'>
                            <option>direction 1</option>
                            <option>direction 2</option>
                            <option>direction 3</option>
                            <option>direction 4</option>
                            <option>direction 5</option>
                        </select>
                    </div>

                </div>

            </form> -->

            <hr>
            <!-- 
            <form method='post'>
                <div class='col-md-6 mb-sm-3 col-sm-12 p-0'>
                    <label for='exampleFormControlSelect2'> Par Date </label>
                    <input type='date' class='form-control' id='date' name='date_courrier'>
                </div>
                <input type="submit" value="Rechercher" class="btn-recherche btn ">
            </form> -->

        </div>


    </section>



    <script src='js/all.js'></script>
    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>



</body>

</html>