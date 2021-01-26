<?php
class MembreEquipeManager extends Model
{

    /**
     * Ajoute en base de données l'objet passé en paramètre
     * @param MembreEquipe $MeembreEquipe
     */
    public function ajouterMembreEquipe(MembreEquipe $MembreEquipe)
    {
        $req = $this->getBdd()->prepare("INSERT INTO `membre_equipe`(`id`, `nom`, `prenom`, `dateNaissance`, `serviceHebergement`, `id_equipe`) VALUES (?,?,?,?,?,?)");
        $req->execute(array($MembreEquipe->get_id(),
                            $MembreEquipe->get_nom(),
                            $MembreEquipe->get_prenom(),
                            $MembreEquipe->get_dateNaissance(),
                            $MembreEquipe->get_serviceHebergement(),
                            $MembreEquipe->get_id_equipe()                       
        ));
    }
    
    /**
     * Modifie en base de donnée l'objet passé en paramètre
     * @param MembreEquipe $MembreEquipe
     */
    public function modifierMembreEquipe(MembreEquipe $MembreEquipe)
    {
        $req = $this->getBdd()->prepare("UPDATE `membre_equipe` SET `nom`=?,`prenom`=?,`dateNaissance`=?,`serviceHebergement`=?,`id_equipe`=? WHERE id=?");
        $req->execute(array($MembreEquipe->get_nom(),
                            $MembreEquipe->get_prenom(),
                            $MembreEquipe->get_dateNaissance(),
                            $MembreEquipe->get_serviceHebergement(),
                            $MembreEquipe->get_id_equipe(),
                            $MembreEquipe->get_id()
        ));
    }

    /**
     * Supprimer le Membre d'equipe designé par son id
     * @param int $vipId
     */
    public function supprimer($idVip)
    {
        return $this->delete('membre_equipe',$idVip);
    }

    /**
     * Renvoi l'id le plus grand de la table
     * @return int id maximum
     */
    public function recupereMaxId()
    {
        return $this->getGreaterId('membre_equipe');
    }

    /**
     * Renvoi le titre du Film en fonction de l'id de l'equipe
     * @param int idEquipeFilm
     * @return string libelle
     */
    public function recupererTitreFilm(int $idEquipeFilm)
    {
        $req = $this->getBdd()->prepare("SELECT film.titre as titre FROM film join equipe on equipe.id_film = film.id WHERE equipe.id = ?");
        $req->execute(array($idEquipeFilm));
        $result = $req->fetch();
        return $result['titre'];
    }

    /**
     * Renvoi l'id de l'equipe de Film en fonction de titre de ce dernier
     * @param string $TitreEquipeFilm
     * @return int id
     */
    public function recupererIdEquipe(string $TitreEquipeFilm)
    {
        $req = $this->getBdd()->prepare("SELECT equipe.id as id FROM equipe join film on equipe.id_film = film.id WHERE film.titre = ?");
        $req->execute(array($TitreEquipeFilm));
        $result = $req->fetch();
        var_dump($result);
        return $result['id'];
    }

    /**
     * Recupère tous les films
     * @return array Objets Film
     */
    public function recupererTousLesFilms()
    {
        return $this->getAll('film','Film');
    }  
}