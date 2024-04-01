<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baridi Health</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/all.css">
     
</head>

<body>


    <?php


    include('connect.class.php');
    $cnx->go_home_if_connected();

    if (isset($_POST['connect'])) {
        $cnx->connect($_POST['email'], $_POST['ps']);
    }

    // $cnx ->   add_user( 'm@gmail.com' ,  "" ) ; 


    ?>

    <header class="mt-4">
        <h1 class="text-center text-white">Connexion</h1>
    </header>

    <section class="container mt-4 section_form">


        <div class="div_form">
            <form method="post" class="form">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label text-light "  >
                        Email
                        <span class="icone"> <i class="fa-solid fa-envelope"></i> </span>
                    </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label text-light">
                        Mot de passe
                        <span class="icone"> <i class="fa-solid fa-key"></i> </span>
                    </label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="ps" value="">
                </div>
                <button type="submit" class="btn btn-primary" name="connect">Se connecter</button>
            </form>
        </div>


        <div class="div_img">
            <!-- <img src="img/bg1.png" alt="image"  > -->
            <!-- <img src="img/logo-b.png" alt="logo">  -->

            <h1 class="text-center "  style="font-style: italic; font-size: 80px;  
                text-shadow: 1px 1px 2px red, 0 0 1em blue, 0 0 0.2em blue; "   >
                <span style="color: var(--bleu) ; "> GED </span> <span style="color: var(--violet) ; "> ANNS </span>
            </h1>

        </div>

    </section>

    <script src="js/all.js"></script>

</body>

</html>