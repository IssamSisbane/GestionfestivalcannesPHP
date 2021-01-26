<?php

class ControllerStaff
{
    private $_vipManager;
    private $_view;

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
        {
            throw new Exception('Page introuvable');
        }
        else
        {
            if ($_SESSION['type_utilisateur_id'] == 3) // l'utilisateur est un membre du Staff et l'accès lui est reservé
            {
                $this->menu();
            }
            else
            {
                throw new Exception('Page inaccessible');
            }
        }
    }

    // Affiche le menu du membre du Staff
    private function menu()
    {
        $data = [];

        // On crée la vue adéquate et on affiche cette dernière (On passe un tableau vide en paramètre car on ne peux pas appeler la fonction sinon)
        $this->_view = new Vue('Staff');
        $this->_view->generate($data);
    }
}