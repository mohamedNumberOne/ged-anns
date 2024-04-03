<?php

include('connect.class.php');

class courrier extends cnx
{

    //
    public function add_courrier($ref, $sujet_courrier, $date_arrive, $txt_cour)
    // public function add_courrier($ref, $sujet_courrier, $date_arrive, $txt_cour, $id_groupe)
    {

        // id_cour	ref	sujet	date_enr	date_arrive	id_user	txt_cour	

        //  ref	sujet	date_arrive		txt_cour	

        $ref = $this->secure_input($ref);
        $sujet_courrier = $this->secure_input($sujet_courrier);
        $date_arrive = $this->secure_input($date_arrive);
        $txt_cour = $this->secure_input($txt_cour);

        // Verify   id_groupe :
        // $sql = "SELECT id_service from services_internes where id_service = ? ";
        // $exec = $this->cnxt_to_db()->prepare($sql);

        // $exec->execute([$id_groupe]);
        // $row = $exec->rowCount();

        // if ( count($id_groupe) > 0 ) {  

        // Verify   ref :
        $sql = "SELECT ref from courriers where ref = ? ";
        $exec = $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$ref]);
        $row_ref = $exec->rowCount();

        if ($row_ref === 0) {

            // Verify   sujet :
            $sql = "SELECT sujet from courriers where sujet = ? ";
            $exec = $this->cnxt_to_db()->prepare($sql);

            $exec->execute([$sujet_courrier]);
            $row_sujet_courrier = $exec->rowCount();

            if ($row_sujet_courrier == 0) {



                try {

                    $cnx = new PDO('mysql:host=' . 'localhost' . ';dbname=' . 'baridi_health', 'root', '', array(1002 => 'SET NAMES utf8'));
                    // $cnx = new PDO('mysql:host=' . 'mysql.at.dz' . ';dbname=' .  'db0547_anns-3', 'u0547',  'n51HosfniLxfEjPV', array(1002 => 'SET NAMES utf8'));
                    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                    $id_user = $_SESSION['id_user'];
                    date_default_timezone_set('Africa/Algiers');
                    $now = date("Y-m-d H-i-s");

                    $sql = "INSERT INTO courriers VALUES 
                        ( NULL , ? , ? ,  '$now'  , ? ,  '$id_user'  , ? ) ";

                    // id_cour	ref	sujet	date_enr	date_arrive	id_user	txt_cour	)

                    // $ref, $sujet_courrier ,   $date_arrive,   $txt_cour

                    $exec = $cnx->prepare($sql);
                    $exec->execute([$ref, $sujet_courrier, $date_arrive, $txt_cour]);

                    $row_insert = $exec->rowCount();

                    if ($row_insert === 1) {
                        $last_id_cour = $cnx->lastInsertId();
                    } else {
                        $last_id_cour = 0;
                    }

                    return $last_id_cour;
                } catch (PDOException $e) {

                    echo $e->getMessage();
                }
            } else {
                $_SESSION['added'] = "<div class='alert alert-warning text-center ' > 
                                            <b> Cet Objet existe déja ! </b> 
                                      </div>";
                header('location:nouveau_courrier.php');
                return 0;
            }
        } else {

            $_SESSION['added'] = "<div class='alert alert-warning text-center ' > 
                                            <b> Cette référence existe déja ! </b> 
                                      </div>";
            header('location:nouveau_courrier.php');
            return 0;
        }
        // } else {

        //     $_SESSION['added'] = "<div class='alert alert-warning text-center ' > <b> Erreur dans la destination! </b> </div>";
        //     header('location:nouveau_courrier.php');
        // }
    }


    public function add_envoyer($last_id_cour, $id_service, $urgent, $confidentiel, $important)
    {



        try {

            $cnx = new PDO('mysql:host=' . 'localhost' . ';dbname=' . 'baridi_health', 'root', '', array(1002 => 'SET NAMES utf8'));
            // $cnx = new PDO('mysql:host=' . 'mysql.at.dz' . ';dbname=' .  'db0547_anns-3', 'u0547',  'n51HosfniLxfEjPV', array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $last_id_cour = $this->secure_input($last_id_cour);
            // $id_service = $this->secure_input($id_service); 
            $id_user = $_SESSION['id_user'];

            foreach ($id_service as $value_service) {

                $sql = "INSERT INTO envoyer VALUES 
                ( NULL , ? , ?  , NULL , /* => id_org */   '$id_user'  , 0 , 0 , ? /*=> urgnt */ , ?  , ? ,  0  , 0 , NULL , now() ) ";

                //    	type	, traite	, urgent	, confidentiel	, important, 	secret, 	date_env	
                // id_env, id_cour,id_service, id_org	, id_user,type, traite	, urgent	, confidentiel	, important, 	secret, vu , date_vu, date_env	

                $exec = $cnx->prepare($sql);
                $exec->execute([$last_id_cour, $value_service, $urgent, $confidentiel, $important]);


                $row_insert = $exec->rowCount();

                if ($row_insert === 1) {
                    $last_id = $cnx->lastInsertId();
                } else {
                    $last_id = 0;
                }
            }



            return $last_id;
        } catch (PDOException $e) {

            echo $e->getMessage();
        }
    }

    public function add_fichier_courrier($last_id_cour, $src_file_cour)
    {

        try {

            $cnx = new PDO('mysql:host=' . 'localhost' . ';dbname=' . 'baridi_health', 'root', '', array(1002 => 'SET NAMES utf8'));
            // $cnx = new PDO('mysql:host=' . 'mysql.at.dz' . ';dbname=' .  'db0547_anns-3', 'u0547',  'n51HosfniLxfEjPV', array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "INSERT INTO fichiers_cour  VALUES   (  NULL , ? , ?  )   ";

            //  id_fichier_cour	,  id_cour	,  src_fichier_cour	

            $exec = $cnx->prepare($sql);

            $exec->execute([$last_id_cour, $src_file_cour]);

            $row_insert = $exec->rowCount();

            if ($row_insert === 1) {
                $last_id = $cnx->lastInsertId();
            } else {
                $last_id = 0;
            }

            return $last_id;
        } catch (PDOException $e) {

            echo $e->getMessage();
        }
    }

    // type : 0 => interne | 1 => externe 
    public function get_form_add_courrier($id)
    {

        $id = $this->secure_input($id);

        // Verify  type organisation  :
        if (($id == 0 || $id == 1) && !empty($id)) {
            // $sql = "SELECT id_service from services_internes where id_service = ? ";
            // $exec  =  $this->cnxt_to_db()->prepare($sql);

            if ($id == 0) {

                $this->select_all_services_internes();
            } elseif ($id == 1) {
            } else {
            }

            // if ($row === 1) {
            // }
        } else {
        }
    }

    public function select_all_services_internes()
    {

        $sql = "SELECT * from services_internes ORDER by nom_service ";
        $exec = $this->cnxt_to_db()->prepare($sql);

        $exec->execute();

        $row = $exec->rowCount();

        if ($row > 0) {
            // echo "
            // <label class='rounded p-1 badg badge-light'> <b> Envoyer à </b> </label>
            // <select class='form-control' name='groupe' required multiple >
            // <option value='' > </option> 
            // ";
            // foreach ($exec as $key => $value) {
            //     $id_service = $value['id_service'];
            //     $nom_service = ucfirst($value['nom_service']);

            //     echo "<option value='$id_service' > $nom_service </option>";
            // }
            // echo " </select> ";

            foreach ($exec as $key => $value) {
                $id_service = $value['id_service'];
                $nom_service = ucfirst($value['nom_service']);

                echo "  <div class='d-inline-block m-2 w-25 badge-dore badge' > 
                            <label for='$nom_service' > $nom_service    </label>
                            <input name='groupe[]' type='checkbox'  value='$id_service'  id='$nom_service' >  
                            
                        </div> ";
            }
        } else {
            echo "pas de services !";
        }
    }


    public function select_all_services_externe()
    {

        $sql = "SELECT * from org_exterieurs ORDER by nom_org ";
        $exec = $this->cnxt_to_db()->prepare($sql);

        $exec->execute();

        $row = $exec->rowCount();

        if ($row > 0) {
            echo "
                <label class='rounded p-1 badg badge-light'> Envoyer en Externe à </label>
                <select class='form-control' name='groupe' required >
                            <option value='' > </option>  ";
            foreach ($exec as $key => $value) {
                $id_org = $value['id_org'];
                $nom_org = ucfirst($value['nom_org']);

                echo "<option value='$id_org' > $nom_org </option>";
            }
            echo " </select> ";
        } else {
            echo "pas de services !";
        }
    }


    public function get_all__service_courriers_envoyes($id_service)
    {

        $sql = "SELECT   * ,  
        date(date_env) as date_env , time(date_env) as time_env ,  date(date_vu) as date_vu ,   time(date_vu) as time_vu
        from envoyer  
                INNER JOIN services_internes on  services_internes.id_service = envoyer.id_service
                INNER JOIN courriers on  courriers.id_cour = envoyer.id_cour
                INNER JOIN users on  users.id_user = envoyer.id_user
                INNER JOIN fichiers_cour on  fichiers_cour.id_cour = envoyer.id_cour
                WHERE users.id_service = ? ORDER BY  envoyer.date_env DESC  ";

        $exec = $this->cnxt_to_db()->prepare($sql);
        $exec->execute([$id_service]);

        $row = $exec->rowCount();

        if ($row > 0) {
            // 
            echo "
                <table class='table table-bordered mt-4 text-center ' style='  ' >
                <thead>
                    <tr>
                        <th scope='col'  > #Référence</th>
                        <th scope='col'  > Objet <i class='fa-solid fa-file'></i> </th>
                        <th scope='col'  > Vu <i class='fa-solid fa-eye'></i> </th>
                        <th scope='col'  > Date env. <i class='fa-solid fa-calendar-days'></i> </th>
                        <th scope='col'  > Expéditeur    <i class='fa-solid fa-location-arrow'></i> </th>
                        <th scope='col'  > Destinsation <i class='fa-solid fa-location-pin'></i> </th>
                        <th scope='col'  > Statut  <i class='fa-solid fa-circle-exclamation'></i>  </th>
                        <th scope='col'  > Etat <i class='fa-solid fa-down-left-and-up-right-to-center'></i> </th>
                        <th scope='col'  > Important  <i class='fa-solid fa-star'></i>  </th>
                        
                        <th scope='col'  > Confidentiel     </th>
                        <th scope='col'  >  Actions  </th>
                    </tr>
                </thead>
                <tbody> ";

            foreach ($exec as $key => $value) {
                $id_cour = $value['id_cour'];
                $src_fichier = $value['src_fichier_cour'];
                $ref = $value['ref'];
                $date_env = $value['date_env'];

                // $date_eng =  $value['date_eng'];
                // $time_eng =  $value['time_eng']; 
                $id_service = $value['id_service'];
                $nom_service = $value['nom_service'];
                $time_env = $value['time_env'];
                $nom_user = $value['nom_user'];
                $pnom_user = $value['pnom_user'];
                $traite = $value['traite'];
                $confidentiel = $value['confidentiel'];
                // $secret = $value['secret']; 
                $urgent = $value['urgent'];
                $important = $value['important'];
                $vu = $value['vu'];
                $date_vu = $value['date_vu'];
                $time_vu = $value['time_vu'];
                $sujet = $value['sujet'];
                // $txt_cour =  $value['txt_cour'];

                if (empty($date_vu) || $date_vu == NULL) {
                    $date_vu = "";
                }


                switch ($traite) {
                    case '0':
                        $traite = "<span  class=' not_yet traite ' > <b> Non traité </b> <i class='fa-solid fa-circle-xmark'></i> </span>";
                        break;
                    case '1':
                        $traite = "<span  class='traite_done  traite' >  Traité  <i class='fa-solid fa-circle-check'></i>  </span>";
                        break;
                    default:
                        $traite = "<span  class='  not_yet traite ' > <b> Non traité </b> <i class='fa-solid fa-circle-xmark'></i> </span>";
                        break;
                }


                switch ($vu) {
                    case '0':
                        $vu = "<span  class=' not_yet traite ' > <b> Pas encore </b>   <i class='fa-solid fa-eye-slash'></i>  </span>";
                        break;
                    case '1':
                        $vu = "<span  style='color:var(--bleu);' >  <i class='fa-solid fa-eye'></i>  <br> $date_vu <br> $time_vu    </span> ";
                        break;
                    default:
                        $vu = "<span  style='color:var(--bleu);'  >  <i class='fa-solid fa-eye'></i>  <br> $date_vu <br> $time_vu    </span> ";
                        break;
                }



                switch ($urgent) {
                    case '0':
                        $urgent = "<span  class=' traite ' >   Normal   </span>";
                        break;
                    case '1':
                        $urgent = "<span  class='   traite anim_red' >  <b> Urgent</b>  <i class='fa-solid fa-circle-exclamation'></i>   </span>";
                        break;
                    default:
                        $urgent = "<span  class='  traite  anim_red' > <b> Urgent </b>   <i class='fa-solid fa-circle-exclamation'></i>  </span>";
                        break;
                }



                switch ($confidentiel) {
                    case '0':
                        $confidentiel = "<span  class='p-1 confidentiel' >   Non   </span>";
                        break;
                    case '1':
                        $confidentiel = "<span  class='p-1 confidentiel' >  <b> confidentiel </b>    </span>";
                        break;
                    default:
                        $confidentiel = "<span  class='p-1 confidentiel' >   <b> confidentiel  </b>    </span>";
                        break;
                }


                // switch ($secret) {
                //     case '0':
                //         $secret = "<span  class='secret p-1 ' >   Non   </span>";
                //         break;
                //     case '1':
                //         $secret = "<span   class='secret p-1 ' >  <b> secret </b>    </span>";
                //         break;
                //     default:
                //         $secret = "<span   class='secret p-1 ' >   <b> secret  </b>    </span>";
                //         break;
                // }

                switch ($important) {
                    case '0':
                        $important = "<span class='p-1 important' style=''  >   Non   </span>";
                        break;
                    case '1':
                        $important = "<span class='p-1 important'   >  <b> important </b>    </span>";
                        break;
                    default:
                        $important = "<span class='p-1 important'    >   <b> important  </b>    </span>";
                        break;
                }


                $sujet = ucfirst($value['sujet']);
                // <th scope='row'> <a href='$src_fichier' target='_blank' > courrier </a> </th> style='width:200px;' 
                echo "

                    <tr>
                    
                    <th scope='row'   >
                        <a href='courrier.php?id=$id_cour' class='  text-white ' target='_blank'   >
                            $ref
                        </a>
                    </th>
                    
                    <td scope='row'  style=' min-width:200px ; '   >    $sujet    </th>
                    <td class='text-center'   >  $vu   </td>
                    <td class='text-center'   > <span class='badge badge-light' > $date_env <br> <br> $time_env </span> </td>
                    <td  >  $nom_user <br> $pnom_user  </td>
                    <td  >  $nom_service   </td>
                    <td  >  $urgent       </td>
                    <td  >  $traite      </td>
                    <td  >  $important    </td>
                     
                    <td  >  $confidentiel </td>

                    <td   style=' padding: 15px ;'  >
                        <a href='courrier.php?id=$id_cour' class='link mt-2 link_modifier ' target='_blank'   >
                            Ouvrir
                            <i class='fa-solid fa-pen-to-square'></i>
                        </a> <br>
                         
                    </td>
                </tr>";
            }


            echo "</tbody>
                    </table>";
        } else {
            echo " <div  class='alert alert-warning text-center'  > Pas de courriers pour l'instant </div> ";
        }
    }


    public function get_all__service_courriers_recu($id_service)
    {

        $sql = "SELECT * ,  
        date(date_env) as date_env , time(date_env) as time_env ,  date(date_vu) as date_vu ,   time(date_vu) as time_vu
        from envoyer  
                INNER JOIN services_internes on  services_internes.id_service = envoyer.id_service
                INNER JOIN courriers on  courriers.id_cour = envoyer.id_cour
                INNER JOIN users on  users.id_user = envoyer.id_user
                INNER JOIN fichiers_cour on  fichiers_cour.id_cour = envoyer.id_cour
                WHERE envoyer.id_service = ? ORDER BY  envoyer.date_env DESC  ";

        $exec = $this->cnxt_to_db()->prepare($sql);
        $exec->execute([$id_service]);

        $row = $exec->rowCount();

        if ($row > 0) {
            // 
            echo "
                <table class='table table-bordered mt-4 text-center ' style='  ' >
                <thead>
                    <tr>
                        <th scope='col'  > #Référence</th>
                        <th scope='col'  > Objet <i class='fa-solid fa-file'></i> </th>
                        <th scope='col'  > Vu <i class='fa-solid fa-eye'></i> </th>
                        <th scope='col'  > Date env. <i class='fa-solid fa-calendar-days'></i> </th>
                        <th scope='col'  > Expéditeur  <i class='fa-solid fa-location-arrow'></i> </th>
                        
                        <th scope='col'  > Statut  <i class='fa-solid fa-circle-exclamation'></i>  </th>
                        <th scope='col'  > Etat <i class='fa-solid fa-down-left-and-up-right-to-center'></i> </th>
                        <th scope='col'  > Important  <i class='fa-solid fa-star'></i>  </th>
                         
                        <th scope='col'  > Confidentiel     </th>
                        <th scope='col'  >  Actions  </th>
                    </tr>
                </thead>
                <tbody> ";

            foreach ($exec as $key => $value) {
                $id_cour = $value['id_cour'];
                $src_fichier = $value['src_fichier_cour'];
                $ref = $value['ref'];
                $date_env = $value['date_env'];

                // $date_eng =  $value['date_eng'];
                // $time_eng =  $value['time_eng']; 
                $id_service = $value['id_service'];
                $nom_service = $value['nom_service'];
                $time_env = $value['time_env'];
                $nom_user = $value['nom_user'];
                $pnom_user = $value['pnom_user'];
                $traite = $value['traite'];
                $confidentiel = $value['confidentiel'];
                // $secret = $value['secret']; 
                $urgent = $value['urgent'];
                $important = $value['important'];
                $vu = $value['vu'];
                $date_vu = $value['date_vu'];
                $time_vu = $value['time_vu'];
                $sujet = $value['sujet'];
                // $txt_cour =  $value['txt_cour'];

                if (empty($date_vu) || $date_vu == NULL) {
                    $date_vu = "";
                }


                switch ($traite) {
                    case '0':
                        $traite = "<span  class=' not_yet traite ' > <b> Non traité </b> <i class='fa-solid fa-circle-xmark'></i> </span>";
                        break;
                    case '1':
                        $traite = "<span  class='traite_done traite ' >  Traité  <i class='fa-solid fa-circle-check'></i>  </span>";
                        break;
                    default:
                        $traite = "<span  class='  not_yet traite ' > <b> Non traité </b> <i class='fa-solid fa-circle-xmark'></i> </span>";
                        break;
                }


                switch ($vu) {
                    case '0':
                        $vu = "<span  class=' not_yet traite ' > <b> Pas encore </b>   <i class='fa-solid fa-eye-slash'></i>  </span>";
                        break;
                    case '1':
                        $vu = "<span  style='color:var(--bleu);'  >  <i class='fa-solid fa-eye'></i>  <br> $date_vu <br> $time_vu    </span> ";
                        break;
                    default:
                        $vu = "<span  style='color:var(--bleu);'  >  <i class='fa-solid fa-eye'></i>  <br> $date_vu <br> $time_vu    </span> ";
                        break;
                }



                switch ($urgent) {
                    case '0':
                        $urgent = "<span  class=' traite ' >   Normal   </span>";
                        break;
                    case '1':
                        $urgent = "<span  class='   traite anim_red' >  <b> Urgent</b>  <i class='fa-solid fa-circle-exclamation'></i>   </span>";
                        break;
                    default:
                        $urgent = "<span  class='  traite  anim_red' > <b> Urgent </b>   <i class='fa-solid fa-circle-exclamation'></i>  </span>";
                        break;
                }



                switch ($confidentiel) {
                    case '0':
                        $confidentiel = "<span class='p-1 confidentiel' >   Non   </span>";
                        break;
                    case '1':
                        $confidentiel = "<span class='p-1 confidentiel' >  <b> confidentiel </b>    </span>";
                        break;
                    default:
                        $confidentiel = "<span class='p-1 confidentiel' >   <b> confidentiel  </b>    </span>";
                        break;
                }


                // switch ($secret) {
                //     case '0':
                //         $secret = "<span class='secret p-1 ' >   Non   </span>";
                //         break;
                //     case '1':
                //         $secret = "<span class='secret p-1 ' >  <b> secret </b>    </span>";
                //         break;
                //     default:
                //         $secret = "<span class='secret p-1 ' >   <b> secret  </b>    </span>";
                //         break;
                // }

                switch ($important) {
                    case '0':
                        $important = "<span class='p-1 important'  >   Non   </span>";
                        break;
                    case '1':
                        $important = "<span  class='p-1 important'  >  <b>   important </b>  </span>";
                        break;
                    default:
                        $important = "<span  class='p-1 important'  >   <b> important  </b>    </span>";
                        break;
                }


                $sujet = ucfirst($value['sujet']);
                // <th scope='row'> <a href='$src_fichier' target='_blank' > courrier </a> </th> style='width:200px;' 
                echo "

                    <tr>
                    <th scope='row'   >
                        <a href='courrier.php?id=$id_cour' class='  ' target='_blank'   >
                            $ref
                        </a>
                    </th>
                    <td scope='row'  style=' min-width:200px ; '   >    $sujet    </th>
                    <td class='text-center'   >  $vu   </td>
                    <td class='text-center'   > <span class='badge badge-light' > $date_env <br> <br> $time_env </span> </td>
                    <td  >  $nom_user <br> $pnom_user  </td>
                    
                    <td  >  $urgent       </td>
                    <td  >  $traite      </td>
                    <td  >  $important    </td>
                 
                    <td  >  $confidentiel </td>

                    <td   style=' padding: 15px ;'  >
                        <a href='courrier.php?id=$id_cour' class='link mt-2 link_modifier'  target='_blank'  >
                            Ouvrir
                            <i class='fa-solid fa-pen-to-square'></i>
                        </a> <br>
                        
                    </td>
                </tr>";
            }


            echo "</tbody>
                    </table>";
        } else {
            echo " <div  class='alert alert-warning text-center'  > Pas de courriers pour l'instant </div> ";
        }
    }


    public function get_courrier_info($id_cour)
    {

        $id_cour = $this->secure_input($id_cour);

        if ($this->verify_id("courriers", 'id_cour', $id_cour)) {

            // $id_service = $_SESSION['id_service'] ;
            // echo $id_service ;
            $sql = "SELECT  * ,  
                date(date_env) as date_env , time(date_env) as time_env ,  date(date_vu) as date_vu , time(date_vu) as time_vu

                from envoyer  
                    INNER JOIN services_internes on  services_internes.id_service = envoyer.id_service
                    INNER JOIN courriers on  courriers.id_cour = envoyer.id_cour
                    INNER JOIN users on  users.id_user = envoyer.id_user
                    INNER JOIN fichiers_cour on  fichiers_cour.id_cour = envoyer.id_cour
                    WHERE  courriers.id_cour = ?   ";


            $exec = $this->cnxt_to_db()->prepare($sql);
            $exec->execute([$id_cour]);

            $row = $exec->rowCount();
            if ($row >= 1) {

                foreach ($exec as $key => $value) {

                    $id_envoyeur = $value['id_user'];

                    $id_cour = $value['id_cour'];

                    if (!empty($value['src_fichier_cour'])) {
                        $src_fichier =  $value['src_fichier_cour'];
                        $src_fichier =  "fichiers :
                        <a href='$src_fichier'>
                            <img src='img/img_file.png' alt='file' width='30px'>
                        </a>";
                    } else {
                        $src_fichier = '';
                    }

                    $ref = $value['ref'];
                    $date_env = $value['date_env'];

                    // $date_eng =  $value['date_eng'];
                    // $time_eng =  $value['time_eng']; 
                    $id_service = $value['id_service'];
                    $nom_service = $value['nom_service'];
                    $time_env = $value['time_env'];
                    $nom_user = $value['nom_user'];
                    $pnom_user = $value['pnom_user'];
                    $traite = $value['traite'];
                    $confidentiel = $value['confidentiel'];
                    // $secret = $value['secret'];
                    $urgent = $value['urgent'];
                    $important = $value['important'];
                    $vu = $value['vu'];
                    $date_vu = $value['date_vu'];
                    $time_vu = $value['time_vu'];
                    $sujet = $value['sujet'];
                    $txt_cour =  $value['txt_cour'];

                    if (empty($date_vu) || $date_vu == NULL) {
                        $date_vu = "";
                    }


                    switch ($traite) {
                        case '0':
                            $traite = "<span  class=' not_yet traite ' > <b> Non traité </b> <i class='fa-solid fa-circle-xmark'></i> 
                            </span>";
                            break;
                        case '1':
                            $traite = "<span  class='done traite ' >  Traité  <i class='fa-solid fa-circle-check'></i>  </span>";
                            break;
                        default:
                            $traite = "<span  class='  not_yet traite ' > <b> Non traité </b> <i class='fa-solid fa-circle-xmark'></i> 
                            </span>";
                            break;
                    }


                    switch ($vu) {
                        case '0':
                            $vu = "<span  class=' not_yet traite ' > <b> Pas encore </b>   <i class='fa-solid fa-eye-slash'></i>
                            </span>";
                            break;
                        case '1':
                            $vu = "<span  style='color:var(--bleu);'  >  <i class='fa-solid fa-eye'></i>  <br> $date_vu <br> $time_vu    </span> ";
                            break;
                        default:
                            $vu = "<span  style='color:var(--bleu);'  >  <i class='fa-solid fa-eye'></i>  <br> $date_vu <br> $time_vu    </span> ";
                            break;
                    }



                    switch ($urgent) {
                        case '0':
                            $urgent = "<span  class='' >   Normal   </span>";
                            break;
                        case '1':
                            $urgent = "<span  class='text-danger ' >  <b> Urgent</b>  <i class='fa-solid fa-circle-exclamation'></i>   
                            </span>";
                            break;
                        default:
                            $urgent = "
                            <span  class=' text-danger ' > 

                                <b> Urgent </b> 
                                <i class='fa-solid  fa-circle-exclamation'></i>  
                            
                            </span>";
                            break;
                    }



                    switch ($confidentiel) {
                        case '0':
                            $confidentiel = "<span>   Non   </span>";
                            break;
                        case '1':
                            $confidentiel = "<span>  <b> Oui </b>    </span>";
                            break;
                        default:
                            $confidentiel = "<span>   <b> Oui  </b>    </span>";
                            break;
                    }


                    // switch ($secret) {
                    //     case '0':
                    //         $secret = "<span>   Non   </span>";
                    //         break;
                    //     case '1':
                    //         $secret = "<span>  <b> Oui </b>    </span>";
                    //         break;
                    //     default:
                    //         $secret = "<span>   <b> Oui  </b>    </span>";
                    //         break;
                    // }

                    switch ($important) {
                        case '0':
                            $important = "<span>   Non   </span>";
                            break;
                        case '1':
                            $important = "<span>  <b> Oui </b>    </span>";
                            break;
                        default:
                            $important = "<span>   <b> Oui  </b>    </span>";
                            break;
                    }


                    $sql_get_nom_serv = "SELECT  nom_service   as  nom_service_envoyeur from services_internes
                        inner JOIN users  on users.id_service =  services_internes.id_service 
                        WHERE users.id_user = '$id_envoyeur' ";

                    $exec_service = $this->cnxt_to_db()->prepare($sql_get_nom_serv);
                    $exec_service->execute();

                    $row_s = $exec_service->rowCount();

                    if ($row_s == 1) {

                        foreach ($exec_service as $key => $value) {
                            $nom_service_envoyeur = $value['nom_service_envoyeur'];
                        }
                    } else {
                        $nom_service_envoyeur = '';
                    }

                    echo " 
                        <div class='  mb-3 bg_cour '>
                                    <h1 class='bg-white titre-page text-dark '>
                                        Courrier | $ref <span class='icone'>
                                            <i class='fa-solid fa-pen-to-square'></i>
                                        </span>
                                    </h1>

                            <div  class='info_cour ' >
                                <h4 class='text-center' >Informations du courrier</h4>
                                <hr>
                                <div>  


                                    <div> <span class='badge badge-dark badge-dore ' > Expéditeur  
                                            <i class='fa-solid fa-location-arrow'></i> </span>
                                            : <b> <i class='fa-solid fa-hotel'></i> 
                                        $nom_service_envoyeur </b> | $nom_user $pnom_user 
                                     </div> 

                                     <hr>

                                    <div> <span class='badge badge-dark badge-dore ' > Destinsation 	  
                                     <i class='fa-solid fa-location-pin'></i> </span>
                                     : <b> <i class='fa-solid fa-hotel'></i> 
                                        $nom_service </b>  
                                    </div> 

                                        <hr>

                                     <div> <span class='badge badge-dark badge-dore ' >  Date  
                                            <i class='fa-solid fa-calendar-days'></i> </span>
                                            : <b> $date_env  | $time_env  </b>
                                        </div>
                                        <hr>

                                        <div> 
                                            <table class='table-bordered text-center' >
                                                <tr>
                                                    <td  class='p-1' >  urgent  </td>
                                                    <td  class=' p-1' >  important  </td>
                                                    <td  class=' p-1' >  confidentiel </td>
                                                </tr>
                                                <tr>
                                                    <td   class='p-1' > $urgent  </td>
                                                    <td   class='p-1' >  $important  </td>
                                                    <td   class='p-1' >  $confidentiel </td>
                                                  
                                                </tr>
                                            </table>
                                        </div>
                                </div>
                            </div>

                        </div>



                        <div class='row div_details ' >

                        <div class='col-6' style='border-right: 1px solid white;'>
                        <p class='mt-1'>
                            <span class='badge badge-light '>
                            Objet <i class='fa-solid fa-file'></i> :
                            </span>                   
                                <b> $sujet </b>
                            </p>

                            <hr  style='background-color:white' > ";
                    if (!empty(trim($txt_cour))) {
                        echo "<p class='mt-1 mb-1'>
                            <span style='font-size:30px' > <i class='fa-regular fa-comment-dots'></i> </span>
                            $txt_cour  
                                </p>
                                <hr  style='background-color:white' >";
                    }


                    echo "</div>
        
                        <div class='col-4'>
                            $src_fichier
                        </div>
        
                    </div>";


                    echo "<form method='post' >";
                    $this->select_all_services_internes();
                    echo "<button class='btn badge-dore mb-2 mt-2' name='transfer_c' > Envoyer </button> 
                        </form>";
                    // groupe


                    echo " <div class='repenses'> ";

                    $this->get_all_reps($id_cour);


                    echo " </div>
                    
        
                    <hr style=background:white;' >
                     <h2> Répondre: </h2>
                    <div class='box-shadow mt-3 mb-3 bg-light ' id='repondre_form'>
        
                        <form method='POST' action='add_rep_controller.php' enctype='multipart/form-data'>
        
                            <input type='hidden' name='id_cour' value=" . $_GET['id'] . " >  
                            <div class='row mt-3'>
                                <div class='col-md-6 mb-sm-3 col-sm-12'>
                                    <label for='fichier' class='badg badge-light  rounded p-1'> <b> Fichier : pdf / image </b> </label>
                                    <input type='file' class='form-control' id='fichier' name='fichier' accept='.pdf, .png, .jpg, .jpeg, .PNG,'>
                                </div>
                            </div>
        
                            <div class='row mt-3'>
        
                                <div class='col-md-9 mb-sm-3 col-sm-12 '>
                                    <label class='rounded p-1 badg badge-light '> <b> Message </b> </label>
                                    <textarea name='msg' maxlength='255' cols='30' rows='10' class='form-control' id='msg' placeholder='Message facultatif'></textarea>
                                </div>
        
                                <div class='col-md-3 mb-sm-3 col-sm-12 mt-4 ' id='suggestions'>
                                    <h4 class='  text-dark'>Suggestions: </h4>
                                    <span class='badge badge-dore m-1'>Bien reçu!</span>
                                    <span class='badge badge-dore m-1'>Je suis d'accord!</span>
                                    <span class='badge badge-dore m-1'>Non ce n'est pas possible!</span>
                                    <span class='badge badge-dore m-1'>Merci je vais voir!</span>
                                    <span class='badge badge-dore m-1'>Merci!</span>
                                    <span class='badge badge-dore m-1'>Laissez nous un peu de temps!</span>
                                </div>
        
        
                            </div>
        
        
                            <input type='submit' value='Répondre' class='btn btn-primary  ' name='add_rep'>
        
                        </form>
        
                    </div>



                    ";
                }
            } else {
                echo " <div class='alert alert-warning' >  Pas de courrier avec cet identifiant !  </div>";
            }
        } else {
            echo "verifier courrier 2";
        }
    }

    // public function add_rep($id_cour, $txt_rep, $fichier_rep) 
    public function add_rep($id_cour, $txt_rep)
    {


        $id_cour = $this->secure_input($id_cour);
        $txt_rep = $this->secure_input($txt_rep);
        // $fichier_rep = $this->secure_input($fichier_rep); 

        if ($this->verify_id("courriers", 'id_cour', $id_cour)) {


            try {

                $cnx = new PDO('mysql:host=' . 'localhost' . ';dbname=' . 'baridi_health', 'root', '', array(1002 => 'SET NAMES utf8'));

                // $cnx = new PDO('mysql:host=' . 'mysql.at.dz' . ';dbname=' .  'db0547_anns-3', 'u0547',  'n51HosfniLxfEjPV', array(1002 => 'SET NAMES utf8'));

                $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                // date_default_timezone_set('Africa/Algiers');
                // $now = date("Y-m-d H-i-s");

                $id_user = $_SESSION['id_user'];
                $sql = "INSERT INTO repenses VALUES ( NULL , ? , $id_user , ? , now() ) ";

                $exec = $cnx->prepare($sql);
                $exec->execute([$id_cour, $txt_rep]);

                $row_insert = $exec->rowCount();

                if ($row_insert === 1) {
                    $last_id_cour = $cnx->lastInsertId();
                } else {
                    $last_id_cour = 0;
                }

                return $last_id_cour;
            } catch (PDOException $e) {

                echo $e->getMessage();
            }
        }
    }


    public function get_all_reps($id_cour)
    {

        $id_cour = $this->secure_input($id_cour);

        if ($this->verify_id("courriers", 'id_cour', $id_cour)) {

            $sql = "SELECT *  from repenses  
                    INNER JOIN courriers on  courriers.id_cour = repenses.id_cour
                    LEFT JOIN fichiers_rep on  fichiers_rep.id_rep = repenses.id_rep
                    WHERE courriers.id_cour =  ?  and (txt_rep  is not NULL or src_fichier_rep is not null )  ";


            $exec = $this->cnxt_to_db()->prepare($sql);
            $exec->execute([$id_cour]);

            $row = $exec->rowCount();

            if ($row >  0) {
                echo  "<h4> Répenses: </h4>";
                foreach ($exec as $key => $value) {
                    $txt_rep = $value['txt_rep'];
                    $fichier_rep = $value['src_fichier_rep'];
                    $nom_user = $_SESSION['nom_user'];

                    if (!empty($value['date_rep'])) {
                        $date_rep = $value['date_rep'];
                        // $nom_user <br> 
                        $date_rep =  "<center> <span class='badge badge-dore ' >  $date_rep   </span> </center>";
                    } else {
                        $date_rep = "";
                    }

                    if (!empty($value['src_fichier_rep'])) {
                        $fichier_rep = $value['src_fichier_rep'];
                        $fichier_rep  =  "<a href='$fichier_rep'>  <img src='img/img_file.png' alt='fichier' width='30px' > </a> ";
                    } else {
                        $fichier_rep = "";
                    }
                    echo "<p  class='mt-1' >  
                        $date_rep  
                        <br>
                        $txt_rep  $fichier_rep 
                    </p> <center> <hr style='width:70%;' > </center> ";
                }
            } else {
                echo " <div class='alert alert-info text-center ' > Pas de répenses pour ce courrier </div> ";
            }
        } else {
            header('location:home.php');
        }
    }


    public function  is_courrier_vu($id_cour)
    {

        $sql = "SELECT vu , date_vu FROM envoyer WHERE id_cour = ?  ";

        $exec = $this->cnxt_to_db()->prepare($sql);
        $exec->execute([$id_cour]);

        foreach ($exec as $key => $value) {
            $vu = $value['vu'];
            $date_vu = $value['vu'];
        }

        if ($vu == 0 && $date_vu == NULL) {
            return  0;
        } else {
            return 1;
        }
    }


    public function has_access_courrier($id_cour)
    {

        $id_user = $_SESSION['id_user'];
        $id_service_user_connected = $_SESSION['id_service'];


        // SG aussi a le droit d'y acceder

        $id_cour =  $this->secure_input($id_cour);

        $sql = "SELECT envoyer.id_service as id_service_recepteur  ,   envoyer.id_user as id_user_envoyeur
               FROM envoyer  WHERE id_cour =  ?  ";


        $exec = $this->cnxt_to_db()->prepare($sql);
        $exec->execute([$id_cour]);

        $row = $exec->rowCount();
        if ($row >= 1) {
            foreach ($exec as $key) {

                $id_user_envoyeur = $key['id_user_envoyeur'];
                $id_service_recepteur = $key['id_service_recepteur'];

                $sql_get_id_service_envoyeur = "  SELECT services_internes.id_service  as id_service_envoyeur
                from services_internes 
                inner join users  on users.id_service = services_internes.id_service
                where id_user = ?  ";

                $exec = $this->cnxt_to_db()->prepare($sql_get_id_service_envoyeur);
                $exec->execute([$id_user_envoyeur]);
                $row = $exec->rowCount();
                if ($row === 1) {
                    foreach ($exec as $key) {
                        $id_service_envoyeur = $key['id_service_envoyeur'];

                        // $_SESSION['info'] =  "id_service_user_connected : $id_service_user_connected  ____ id_service_recepteur : 
                        // $id_service_recepteur ______ id_service_user_connected : $id_service_user_connected ______ id_service_envoyeur :  $id_service_envoyeur";
                        if (
                            ($id_service_user_connected ==  $id_service_recepteur) ||
                            ($id_service_user_connected  == $id_service_envoyeur)
                            ||  1
                            // or or id_sg has access to 
                        ) {
                            return 1;
                        } else {
                            return 0;
                        }
                    }
                }
            }
        } else {
            header('location:recherche.php');
        }
    }


    public function add_courrier_vu($id_cour)
    {

        $id_user = $_SESSION['id_user'];
        $nom_service_user = $_SESSION['nom_service'];

        $sql = "SELECT *  from envoyer  
                    INNER JOIN courriers on  courriers.id_cour = envoyer.id_cour
                    INNER JOIN services_internes on  services_internes.id_service = envoyer.id_service
                    WHERE courriers.id_cour =  ?   ";

        $exec = $this->cnxt_to_db()->prepare($sql);
        $exec->execute([$id_cour]);

        $row = $exec->rowCount();

        foreach ($exec as $key) {

            $nom_service_recu = $key['nom_service'];
            $id_expediteur = $key['id_user'];

            // if (  ($nom_service_recu  ==   $nom_service_user ) &&  ($id_user != $id_expediteur)  ) 
            if (($id_user != $id_expediteur)) {

                $id_cour = $this->secure_input($id_cour);
                date_default_timezone_set('Africa/Algiers');
                $now = date("Y-m-d H-i-s");

                $sql = "UPDATE envoyer set vu = 1  , date_vu =  '$now'   WHERE id_cour = ? ";

                $exec = $this->cnxt_to_db()->prepare($sql);
                $exec->execute([$id_cour]);

                $row = $exec->rowCount();

                if ($row > 0) {
                    return $row;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }


    public function verify_id($table, $id_name, $id)
    {

        $id = $this->secure_input($id);

        if (filter_var($id, FILTER_VALIDATE_INT) && $id > 0) {
            $sql = "SELECT * FROM " . $table . " WHERE  " . " $id_name " . " = ? ";

            $exec = $this->cnxt_to_db()->prepare($sql);
            $exec->execute([$id]);

            $row = $exec->rowCount();

            if ($row > 0) {
                return $row;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }


    public function recherche_ref($ref)
    {

        $ref = $this->secure_input($ref);


        $sql = "SELECT * FROM courriers WHERE ref  = ? ";

        $exec = $this->cnxt_to_db()->prepare($sql);
        $exec->execute([$ref]);

        $row = $exec->rowCount();


        if ($row > 0) {

            foreach ($exec as $key) {

                $id_cour = $key['id_cour'];
            }
            echo "  <a href='courrier.php?id=$id_cour' target='_blank' class='text-white' > voir le courrier  </a> ";
            return $row;
        } else {

            echo " <div class='alert alert-warning text-center ' > Pas de courriers ! </div> ";
        }
    }
}

$courrier = new courrier();
