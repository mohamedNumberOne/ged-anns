<?php

include('courrier.controller.php');

session_start();

if (isset($_POST['add_courrier'])  && $_SERVER["REQUEST_METHOD"] == "POST") {


    if (
        isset(
            $_POST['ref'],
            $_POST['sujet'],
            $_POST['groupe'],
            $_POST['date_courrier'],
            $_POST['urgent'],
            $_POST['confidentiel'],
            
            $_POST['important'],

        )
        && !empty(trim($_POST['ref']))
        && !empty(trim($_POST['sujet']))
        && !empty(trim($_POST['groupe']))
        && !empty(trim($_POST['date_courrier']))


    ) {


        $date_courrier = $courrier->secure_input($_POST['date_courrier']);

        if (strtotime($date_courrier)) {

            $ref = $courrier->secure_input($_POST['ref']);
            $sujet = $courrier->secure_input($_POST['sujet']);
            $groupe = $courrier->secure_input($_POST['groupe']);
            $confidentiel = $courrier->secure_input($_POST['confidentiel']);
            // $secret = $courrier->secure_input($_POST['secret']); 
            $urgent = $courrier->secure_input($_POST['urgent']);
            $important = $courrier->secure_input($_POST['important']);


            switch ($confidentiel) {
                case '0':
                    $confidentiel = 0;
                    break;
                case '1':
                    $confidentiel = 1;
                    break;
                default:
                    $confidentiel = 1;
                    break;
            }


            // switch ($secret) {
            //     case '0':
            //         $secret = 0;
            //         break;
            //     case '1':
            //         $secret = 1;
            //         break;
            //     default:
            //         $secret = 1;
            //         break;
            // }

            switch ($urgent) {
                case '0':
                    $urgent = 0;
                    break;
                case '1':
                    $urgent = 1;
                    break;
                default:
                    $urgent = 1;
                    break;
            }

            switch ($important) {
                case '0':
                    $important = 0;
                    break;
                case '1':
                    $important = 1;
                    break;
                default:
                    $important = 1;
                    break;
            }


            // code urgent + confidentiel 

            if (
                //&& ($secret == 1 || $secret == 0) 
                ($urgent == 1 || $urgent == 0)  && ($confidentiel == 1 || $confidentiel == 0)  && ($important == 1 || $important == 0)

            ) {

                // verify msg
                if (isset($_POST['msg']) && !empty(trim($_POST['msg']))) {
                    $msg = $courrier->secure_input($_POST['msg']);
                } else {
                    $msg = NULL;
                }

                // code file 
                if (!empty($_FILES['fichier']['name'])  &&    $_FILES['fichier']['size']  != 0) {


                    if ($_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                        // get details of the uploaded file
                        $fileTmpPath = $_FILES['fichier']['tmp_name'];
                        $fileName = $_FILES['fichier']['name'];
                        $fileSize = $_FILES['fichier']['size'];
                        $fileType = $_FILES['fichier']['type'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));

                        // sanitize file-name
                        date_default_timezone_set('Africa/Algiers');
                        $newFileName =   date("Y-m-d H-i-s") . '.' . $fileExtension;

                        // check if file has one of the following extensions
                        $allowedfileExtensions = array('pdf', 'PDF', 'png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG');
                        if ($fileSize <= 9097152) {
                            if (in_array($fileExtension, $allowedfileExtensions)) {
                                // directory in which the uploaded file will be moved
                                $uploadFileDir = 'courriers/';
                                $dest_path = $uploadFileDir . $newFileName;

                                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                    $last_id_cour = $courrier->add_courrier($ref, $sujet, $date_courrier, $msg, $groupe);
                                    $last_id =  $last_id_cour;
                                    // $ref, $sujet_courrier,   $date_arrive,   $txt_cour 
                                    if ($last_id) {

                                        if ($courrier->add_envoyer(
                                            $last_id,
                                            $groupe,
                                            $urgent,
                                            $confidentiel,
                                            $important
                                        )) {
                                            if ($courrier->add_fichier_courrier($last_id, $dest_path)) {
                                                $_SESSION['added']  .=
                                                    "<div class='alert alert-success text-center ' > 
                                                        <b> Courrier envoyé </b>
                                                        </div>  ";
                                                header('location:nouveau_courrier.php');
                                            }
                                        }
                                    } else {
                                        $file_path = $dest_path;
                                        // Vérifier si le fichier existe avant de tenter de le supprimer
                                        if (file_exists($file_path)) {
                                            unlink($file_path);
                                        }
                                        header('location:nouveau_courrier.php');
                                    }
                                } else {

                                    $_SESSION['erreur']  .=
                                        "<div class='alert alert-warning text-center ' > 
                                               <b> Erreur ! Le fichier n'est  pas importé ! </b>
                                            </div>  ";
                                    header('location:nouveau_courrier.php');
                                }
                            } else {
                                $_SESSION['erreur']  .=  " <div class='alert alert-warning text-center ' > 
                                        <b> Les extensions acceptées sont : pdf , png , jpg , jpeg. </b>
                                        </div>   ";
                                header('location:nouveau_courrier.php');
                            }
                        } else {
                            $_SESSION['erreur']  .=
                                "<div class='alert alert-warning text-center ' > 
                                        <b> la taille maximale du fichier est : 9 Mo. </b>
                                        </div> ";
                            header('location:nouveau_courrier.php');
                        }
                    } else {

                        $_SESSION['erreur']  .=
                            "<div class='alert alert-warning text-center ' > 
                                    <b> Erreur dans le fichier </b>  
                                </div>  ";
                        header('location:nouveau_courrier.php');
                    }
                } else {

                    // fichier vide
                    $dest_path  = NULL;


                    $last_id_cour = $courrier->add_courrier($ref, $sujet, $date_courrier, $msg, $groupe);
                    $last_id =  $last_id_cour;
                    // $ref, $sujet_courrier,   $date_arrive,   $txt_cour 
                    if ($last_id) {

                        // $last_id_cour , $id_service , $urgent, $confidentiel, $important 

                        if ($courrier->add_envoyer(
                            $last_id,
                            $groupe,
                            $urgent,
                            $confidentiel,
                            $important 
                        )) {
                            if ($courrier->add_fichier_courrier($last_id, $dest_path)) {
                                $_SESSION['added']  .=
                                    "<div class='alert alert-success text-center ' > 
                                        <b> Courrier envoyé ! </b>
                                        </div>  ";
                                header('location:nouveau_courrier.php');
                            } else {

                                try {


                                    $cnx = new PDO('mysql:host=' . 'localhost' . ';dbname=' .  'baridi_health', 'root',  '', array(1002 => 'SET NAMES utf8'));
                                    // $cnx = new PDO('mysql:host=' . 'mysql.at.dz' . ';dbname=' .  'db0547_anns-3', 'u0547',  'n51HosfniLxfEjPV', array(1002 => 'SET NAMES utf8'));

                                    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $sql  = " DELETE FROM envoyer where id_cour  = ? ";

                                    //  id_fichier_cour	,  id_cour	,  src_fichier_cour	

                                    $exec =  $cnx->prepare($sql);

                                    $exec->execute([$last_id]);

                                    $_SESSION['erreur']  .=
                                        "<div class='alert alert-warning text-center ' > 
                                       <b> Erreur ! courrier non envoyé 1  </b>
                                    </div>  ";

                                    header('location:nouveau_courrier.php');
                                } catch (PDOException $e) {

                                    echo   $e->getMessage();
                                }
                            }
                        } else {


                            try {

                                $cnx = new PDO('mysql:host=' . 'localhost' . ';dbname=' .  'baridi_health', 'root',  '', array(1002 => 'SET NAMES utf8'));

                                // $cnx = new PDO('mysql:host=' . 'mysql.at.dz' . ';dbname=' .  'db0547_anns-3', 'u0547',  'n51HosfniLxfEjPV', array(1002 => 'SET NAMES utf8'));

                                $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                                $sql  = " DELETE FROM courriers where id_cour  = ? ";

                                //  id_fichier_cour	,  id_cour	,  src_fichier_cour	

                                $exec =  $cnx->prepare($sql);

                                $exec->execute([$last_id]);

                                $_SESSION['erreur']  .=
                                    "<div class='alert alert-warning text-center ' > 
                                   <b> Erreur ! courrier non envoyé  2  </b>
                                </div>  ";

                                header('location:nouveau_courrier.php');
                            } catch (PDOException $e) {

                                echo   $e->getMessage();
                            }
                        }



                        //

                    } else {

                        $_SESSION['erreur']  .=
                            "<div class='alert alert-warning text-center ' > 
                               <b> Erreur !  le courrier n'est pas envoyé </b>
                            </div>  ";
                        header('location:nouveau_courrier.php');
                    }
                }
            } else {

                $_SESSION['erreur'] =  "<div  class='alert-warning text-center alert' > 
                Vérifiez les champs : urgent, confidentiel, important    !  
            </div>";
                header('location:nouveau_courrier.php');
            }
        } else {
            $_SESSION['erreur'] =  "<div  class='alert-warning text-center alert' > 
                                        Vérifiez la Date !  
                                    </div>";
            header('location:nouveau_courrier.php');
        }
    } else {

        $_SESSION['erreur'] =  "<div  class='alert-warning text-center alert' > 
                                    <b>  Remplissez touts les champs !   </b>
                                </div>";
        header('location:nouveau_courrier.php');
    }
} else {
    header('location:nouveau_courrier.php');
}
