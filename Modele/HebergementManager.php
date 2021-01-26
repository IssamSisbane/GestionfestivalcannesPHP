<?php
class HebergementManager extends Model
{
    /** 
     * Recupere tous les hebergements de la base de données
     * Appelle la fonction defini dans model
     *  */
    public function getHebergements()
    {
        return $this->getAll('hebergement', 'Hebergement');
    }

    /** 
     * Recupere tous les hebergements de la base de données
     * Appelle la fonction defini dans model
     *  */
    public function getHebergementsGerant(string $nom)
    {
        $req = $this->getBdd()->prepare('SELECT * from hebergement where nom_proprietaire = ?');
        $req->execute(array($nom));
        $var = null;
        
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new Hebergement($data);
        }
        return $var;
    }

    /**
     * Ajoute l'hebergement dans la base de données
     * @param Hebergement $hebergement
     */
    public function ajouterHebergement(Hebergement $hebergement)
    {
        $req = $this->getBdd()->prepare('INSERT INTO `hebergement`(`id`,`nom`, `nombrePlacesDisponibles`, `prixParNuit`, `type_hebergment_id`, `nom_proprietaire`) VALUES (?,?,?,?,?,?)');
        $req->execute(array($hebergement->get_id()
                            ,$hebergement->get_nom()
                            ,$hebergement->get_nombrePlacesDisponibles()
                            ,$hebergement->get_prixParNuit()
                            ,$hebergement->get_type_hebergment_id()
                            ,$hebergement->get_nom_proprietaire()
        ));
    }

    /**
     * Modifie l'hebergement dans la base de données
     * @param Hebergement $hebergement
     */
    public function modifierHebergement(Hebergement $hebergement)
    {
        $req = $this->getBdd()->prepare('UPDATE hebergement SET nom=?, nombrePlacesDisponibles=?, prixParNuit=?, type_hebergment_id=? WHERE id=?');
        $req->execute(array($hebergement->get_nom()
                            ,$hebergement->get_nombrePlacesDisponibles()
                            ,$hebergement->get_prixParNuit()
                            ,$hebergement->get_type_hebergment_id()
                            ,$hebergement->get_id()
        ));
    }

        /**
     * Supprime les services de l'hebergement selon l'id de ce dernier dans la base de données
     * @param int $idHebergement
     */
    public function supprimerServiceHebergement(int $idHebergement)
    {
        $req = $this->getBdd()->prepare('DELETE from service_propose_hebergement WHERE id_hebergement = ?');
        $req->execute(array($idHebergement));
    }

    /**
     * Supprime l'herbergement depuis son Id dans la base de données
     * @param int $idHebergement
     */
    public function supprimerHebergement(int $idHebergement)
    {
        $this->supprimerServiceHebergement($idHebergement);
        return $this->delete('hebergement',$idHebergement);
    }
    
    public function recupereMaxId()
    {
       return $this->getGreaterId('hebergement');
    }
}