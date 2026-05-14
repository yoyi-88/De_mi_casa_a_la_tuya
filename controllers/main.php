<?php

    class Main Extends Controller {

        function __construct() {

            parent ::__construct(); 
            
            
            
        }

        function render() {
            sec_session_start();

            // Capturar el mensaje de inicio de sesión si existe
            if (isset($_SESSION['mensaje'])) {
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']); 
            }
    
            $this->view->render('main/index');
        }
    }

?>