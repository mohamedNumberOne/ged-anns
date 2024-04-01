<?php

class cnx
{

    private $ps;
    private $server;
    private $db_name;
    private $user;


    public function cnxt_to_db()
    {


        $this->ps = '';
        $this->server = 'localhost';
        $this->db_name = 'baridi_health';
        $this->user = 'root';


        // $this->ps = 'n51HosfniLxfEjPV';
        // $this->server = 'mysql.at.dz';
        // $this->db_name = 'db0547_anns-3';
        // $this->user = 'u0547';

        try {

            $cnx = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->db_name,  $this->user, $this->ps, array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $cnx;
        } catch (PDOException $e) {

            echo   $e->getMessage();
        }
    }


    public function secure_input($input)
    {
        $input = trim($input);
        if (!empty($input)) {

            $input = htmlspecialchars($input);
            $input = stripslashes($input);
            return $input;
        } else {
            return 0;
        }
    }


    public function deco_user()
    {
        session_destroy();
        unset($_SESSION);
        header("location:index.php");
    }
    
    

    public function if_user_existes($id)
    {

        $this->secure_input($id);

        $sql = "SELECT id_user FROM users  WHERE  id_user = ?  ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$id]);

        $row = $exec->rowCount();
        if( ! $row  ) {
            $this -> deco_user() ;
        }
        // return $row; 
    }


    public function is_connected()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->if_user_existes($_SESSION['id_user']); 

        if (!isset($_SESSION['is_connected'])  || ($_SESSION['is_connected'] != true)) {
            header('location:index.php');
            // echo "<script> location.href ='index.php' ; </script> " ;
        }
    }

    public function go_home_if_connected()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['is_connected'])  &&  ($_SESSION['is_connected'] == true)) {
            header('location:home.php');
        }
    }


    public function connect($email, $ps)
    {

        $email = $this->secure_input($email);
        $ps =  htmlspecialchars($ps);
        $ps =  stripslashes($ps);

        $sql = "SELECT * FROM users 
                inner join services_internes on 
                services_internes.id_service = users.id_service 
                WHERE email_user = ?  ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$email]);

        $row = $exec->rowCount();

        if ($row  === 1) {

            foreach ($exec as $key => $value) {

                $bdd_hashed_ps = $value['ps_user'];

                if (password_verify($ps, $bdd_hashed_ps)) {

                    session_start();
                    $_SESSION['id_user'] = $value['id_user'];
                    $_SESSION['nom_user'] = $value['nom_user'];
                    $_SESSION['pnom_user'] = $value['pnom_user'];
                    $_SESSION['poste_user'] = $value['poste_user'];
                    $_SESSION['role'] = $value['user'];
                    $_SESSION['id_service'] = $value['id_service'];
                    $_SESSION['nom_service'] = $value['nom_service'];
                    $_SESSION['is_connected'] = true;
                    header('location:home.php');
                } else {
                    echo " <div class='alert alert-warning text-center mt-2 container ' > Vérifiez votre mot de passe ! </div> ";
                }
            }
        } else {
            echo   " <div class='alert alert-warning text-center mt-2 container ' > Vérifiez votre Email ! </div> ";
        }
    }


    public function add_user($email, $ps)
    {

        $email = $this->secure_input($email);
        $ps =  htmlspecialchars($ps);
        $ps =  stripslashes($ps);
        $ps =  password_hash($ps, PASSWORD_DEFAULT);

        // id_user
        // nom_user
        // pnom_user
        // email_user
        // ps_user
        // poste_user
        // super_admin
        // grade_user
        // id_service

        // id_user	nom_user	pnom_user	email_user	ps_user	poste_user	grade_user	id_service	

        $sql = "INSERT INTO users VALUES (  NULL , 'nassim  ' , '  name' , 
            ? , ? , 'post' , '1'  , '8'   )  ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$email, $ps]);

        $row = $exec->rowCount();

        if ($row  === 1) {

            echo "gg";
        } else {
            echo "no";
        }
    }

    
}



$cnx = new cnx();
