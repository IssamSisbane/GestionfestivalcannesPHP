<?php

require_once('Vue/Vue.php');

class ControllerAccueil
{

    // CONSTRUCTEUR
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
        {
            throw new Exception('Page introuvable');
        }
        else
        {
            if ($_SESSION['type_utilisateur_id'] == 3) // l'utilisateur est un membre du Staff
            {
                header('Location: index.php?url=staff');
            }
            else  // l'utilisateur est un Gerant
            {
                header('Location: index.php?url=gerant');
            }
        }
    }
}