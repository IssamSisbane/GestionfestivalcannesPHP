<?php

require_once('Vue/Vue.php');

class Router
{
    private $_ctrl;
    private $_view;

    // Renvoi au bon controller selon l'url
    public function routeReq()
    {
        session_start();

        if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') 
        {
            // On deconnecte l'utilisateur
            unset($_SESSION['pseudo']);
            unset($_SESSION['type_utilisateur_id']);
        }

        if(isset($_SESSION['pseudo']))
        {
            try {
                // CHARGEMENT AUTO DES CLASSES
                spl_autoload_register(function ($class) {
                    require_once('Modele/' . $class . '.php');
                });

                $url = '';

                // LE CONTROLLER EST INCLUS SELON L'ACTION DE L'UTILISATEUR
                if (isset($_GET['url'])) {
                    $url = explode('/', filter_var(
                        $_GET['url'],
                        FILTER_SANITIZE_URL
                    ));

                    $controller = ucfirst(strtolower($url[0]));
                    $controllerClass = "Controller" . $controller;
                    $controllerFile = "Controller/" . $controllerClass . ".php";

                    if (file_exists($controllerFile)) 
                    {
                        require_once($controllerFile);
                        $this->_ctrl = new $controllerClass($url);
                    } 
                    else 
                    {
                        throw new Exception('Page introuvable');
                    }

                } 
                else 
                {
                    require_once('Controller/ControllerAccueil.php');
                    $this->_ctrl = new ControllerAccueil($url);
                }

            } catch (Exception $e) {
                $errorMsg = $e->getMessage();
                $this->_view = new Vue('Erreur');
                $this->_view->generate(array('errorMsg' => $errorMsg));
            }
        }
        else
        {
            require_once('ControllerLogin.php');
            $this->_ctrl = new ControllerLogin();
        }
    }
}
