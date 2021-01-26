<?php
require 'Model.php';
    /**
     * Class ConnexionManager
     * Gere tous ce qui est relatif aux connexions et utilisateur avec la base de donnée
     */
    class ConnexionManager extends Model
    {
        
        /**
         * retourne l'utilisateur avec le login entré depuis la base de donnée
         * @param string Lpseudo Le pseudo entré par l'utilisateur
         * @param string LmotDePasse le mot de passe entré par l'utilisateur
         * @return array|string|number $result : un tableau contenant le pseudo et le motDePasse.
        */
        public function login(string $Lpseudo,string $LmotDePasse)
		{
			$q = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE pseudo = :Lpseudo");
			$q->execute(['Lpseudo' => $Lpseudo]);
            $result = $q->fetch();
            return $result;
        }
}