<?php

class ControllerGerant
{
    private $_view;

    // CONSTRUCTEUR
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
        {
            throw new Exception('Page introuvable');
        }
        else
        {
            if ($_SESSION['type_utilisateur_id'] == 4) // l'utilisateur est un Gerant et l'accès lui est reservé
            {
                $this->menu();
            }
            else
            {
                throw new Exception('Page inaccessible');
            }
            
        }
    }

    // Affiche le menu du Gerant
    private function menu()
    {
        $data = [];

        // On crée la vue adéquate et on affiche cette dernière (On passe un tableau vide en paramètre car on ne peux pas appeler la fonction sinon)
        $this->_view = new Vue('Gerant');
        $this->_view->generate($data);
    }
}