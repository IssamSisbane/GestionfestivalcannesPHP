<?php
class MembreJuryManager extends Model
{

    /**
     * Ajoute en base de données l'objet passé en paramètre
     * @param MembreJury $MembreJury
     */
    public function ajouterMembreJury(MembreJury $MembreJury)
    {
        $req = $this->getBdd()->prepare("INSERT INTO `membre_jury`(`id`, `nom`, `prenom`, `dateNaissance`, `serviceHebergement`, `id_jury`) VALUES (?,?,?,?,?,?)");
        $req->execute(array($MembreJury->get_id(),
                            $MembreJury->get_nom(),
                            $MembreJury->get_prenom(),
                            $MembreJury->get_dateNaissance(),
                            $MembreJury->get_serviceHebergement(),
                            $MembreJury->get_id_jury(),
                            
        ));
    }

    /**
     * Modifie en base de données l'objet passé en paramètre
     */
    public function modifierMembreJury(MembreJury $MembreJury)
    {
        $req = $this->getBdd()->prepare("UPDATE `membre_jury` SET `nom`=?,`prenom`=?,`dateNaissance`=?,`serviceHebergement`=?,`id_jury`=? WHERE id=?");
        $req->execute(array($MembreJury->get_nom(),
                            $MembreJury->get_prenom(),
                            $MembreJury->get_dateNaissance(),
                            $MembreJury->get_serviceHebergement(),
                            $MembreJury->get_id_jury(),
                            $MembreJury->get_id()
        ));
    }

    /**
     * Supprimer le Membre du jury designé par son id
     * @param int $vipId
     */
    public function supprimer($idVip)
    {
        return $this->delete('membre_jury',$idVip);
    }

    /**
     * Renvoi l'id le plus grand de la table
     * @return int id maximum
     */
    public function recupereMaxId()
    {
        return $this->getGreaterId('membre_jury');
    }

    /**
     * Renvoi un tableau qui contient tous les objets competitions
     * @return array Objets Competition
     */
    public function recupererToutesLesCompetitions()
    {
        return $this->getAll('competition','Competition');
    }

    /**
     * Renvoi le libelle de la Competition en fonction de l'id du jury
     * @param int $idJury
     * @return string libelle
     */
    public function recupererLibelleCompetition(int $idJury)
    {
        $req = $this->getBdd()->prepare("SELECT libelle FROM competition join jury on jury.id_competition = competition.id WHERE jury.id = ?");
        $req->execute(array($idJury));
        $result = $req->fetch();
        return $result['libelle'];
    }

    /**
     * Renvoi l'id du jury en fonction du nom de la competition
     * @param string $LibelleCompetition
     * @return int id
     */
    public function recupererIdJury(string $LibelleCompetition)
    {
        $req = $this->getBdd()->prepare("SELECT jury.id as id FROM jury join competition on competition.id = jury.id_competition WHERE libelle = ?");
        $req->execute(array($LibelleCompetition));
        $result = $req->fetch();
        var_dump($result);
        return $result['id'];
    }

    /**
     * Renvoi le nombre de membre d'un jury selon la competition
     * @param string $LibelleCompetition
     * @return int nb
     */
    public function recupererNombreDeMembre(string $LibelleCompetition)
    {
        $req = $this->getBdd()->prepare("SELECT count(*) as nb from membre_jury 
                                        join jury on jury.id = membre_jury.id_jury 
                                        join competition on competition.id = jury.id_competition 
                                        where competition.libelle = ?");
        $req->execute(array($LibelleCompetition));
        $result = $req->fetch();
        var_dump($result);
        return $result['nb'];
    }

    /**
     * Renvoi le nombre de membre maximum d'un jury selon la competition
     * @param string $libelleCompetition
     * @return int nb
     */
    public function recupererNombreDeMembreMax(string $LibelleCompetition)
    {
        $req = $this->getBdd()->prepare("SELECT jury.nombre_membre as nb from jury JOIN competition on competition.id = jury.id_competition where competition.libelle = ?");
        $req->execute(array($LibelleCompetition));
        $result = $req->fetch();
        var_dump($result);
        return $result['nb'];
    }
}