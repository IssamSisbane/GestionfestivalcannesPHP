<?php
class ControllerLogin
{
    private $_connexionManager;

    // CONSTRUCTEUR
    public function __construct()
    {
        try {
            include 'Modele/ConnexionManager.php';
            require 'Vue/VueLogin.php';


            if (isset($_POST['formlogin'])) {

                if (!empty($_POST['lpseudo']) && !empty($_POST['lpassword'])) {

                    $this->connexion($_POST['lpseudo'], $_POST['lpassword']); // On verifie si le pseudo et le mot de passe sont valides et correpsondent

                } else {
                    throw new Exception("Veuillez completer tous les champs !");
                }
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Connecte l'utilisateur si le pseudo et le mot de passe sont corrects
     * @param string $pseudo
     * @param string $password
     */
    public function connexion($pseudo, $password)
    {
        $this->_connexionManager = new ConnexionManager();
        $result = $this->_connexionManager->login($pseudo, $password);

        if ($result == true) {
            //le compte existe bien !

            $passwordBdd = $result['motDePasse'];

            if ($passwordBdd == $password) {

                // On connecte l'utilisateur
                $_SESSION['pseudo'] = $result['pseudo'];
                $_SESSION['type_utilisateur_id'] = $result['type_utilisateur_id'];


                // On envoie l'utilisateur sur la page d'accueil
                header('Location: index.php?url=accueil');
            } else {
                throw new Exception("Le mot de passe n'est pas correct");
            }
        } else {
            throw new Exception("Le compte portant le pseudo : " . $pseudo . " n'existe pas !");
        }
    }
}
