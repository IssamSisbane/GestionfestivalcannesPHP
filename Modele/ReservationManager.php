<?php
class ReservationManager extends Model
{
    // recupère toutes les reservations
    public function getReservations()
    {
        return $this->getAll('reservation','Reservation');
    }

    /**
     * Supprime la reservation depuis son Id dans la base de données
     * @param int $idReservation
     */
    public function supprimerReservation(int $idReservation)
    {
        return $this->delete('reservation',$idReservation);
    }

    /**
     * Ajoute la reservation dans la base de données
     * @param Reservation $reservation
     */
    public function ajouterReservation(Reservation $reservation)
    {
        $req = $this->getBdd()->prepare("INSERT INTO `reservation` (`id`, `dateDebut`, `dateFin`, `prixFinal`, `nombreDeNuit`, `idVip`, `idHebergement`, `type_vip`) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $req->execute(array($reservation->get_id(),
                            $reservation->get_dateDebut(),
                            $reservation->get_DateFin(),
                            $reservation->get_prixFinal(),
                            $reservation->get_nombredeNuit(),
                            $reservation->get_idVip(),
                            $reservation->get_idHebergement(),
                            $reservation->get_type_vip()
        ));
    }

    /**
     * Modifie la reservation dans la base de données
     * @param Reservation $reservation
     */
    public function modifierReservation(Reservation $reservation)
    {
        $req = $this->getBdd()->prepare("UPDATE `reservation` SET `dateDebut`=?, `dateFin`=?, `prixFinal`=?, `nombreDeNuit`=?, `idVip`=?, `idHebergement`=? 
                                        WHERE `reservation`.`id` =?");
        $req->execute(array($reservation->get_dateDebut(),
                            $reservation->get_DateFin(),
                            $reservation->get_prixFinal(),
                            $reservation->get_nombredeNuit(),
                            $reservation->get_idVip(),
                            $reservation->get_idHebergement(),
                            $reservation->get_id()
        ));
    }

    /**
     * recupere les reservations pour un hebergement
     * @param int $idHebergement
     * @return array $var tableau d'objets Reservation
     */
    public function RecupererReservationParHebergement(int $idHebergement)
    {
        $req = $this->getBdd()->prepare("SELECT * from `reservation` WHERE idHebergement=?");
        $req->execute(array($idHebergement));

        $var = null;

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new Reservation($data);
        }
        return $var;
        $req->closeCursor();
    }

    /**
     * Renvoi l'id le plus grand de la table
     * @return int id maximum
     */
    public function recupereMaxId()
    {
        return $this->getGreaterId('reservation');
    }

    public function recupererReservationAutreMembreEquipe(int $id)
    {
        $req = $this->getBdd()->prepare("SELECT * from reservation join membre_equipe on membre_equipe.id = reservation.idVip where membre_equipe.id_equipe = ?");
        $req->execute(array($id));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if ($result != false)
        {
            $result = new Reservation($result);
        }
        return $result;
    }

    public function recupererReservationAutreMembreJury(int $id)
    {
        $req = $this->getBdd()->prepare("SELECT * from reservation join membre_jury on membre_jury.id = reservation.idVip where membre_jury.id_jury = ?");
        $req->execute(array($id));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if ($result != false)
        {
            $result = new Reservation($result);
        }
        return $result;
    }

    public function recupererReservationExistante(int $id)
    {
        $req = $this->getBdd()->prepare("SELECT * from reservation where idVip = ?");
        $req->execute(array($id));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function recupererReservationEquipeConcurrentes(int $idVip, int $idHebergement)
    {
        $req = $this->getBdd()->prepare("SELECT count(*) as nb from membre_equipe 
                                        join reservation on reservation.idVip = membre_equipe.id 
                                        where membre_equipe.id_equipe != ? and reservation.type_vip = 'MembreEquipe' and reservation.idHebergement = ? ");
        $req->execute(array($idVip,$idHebergement));
        $result = $req->fetch();
        return $result['nb'];

    }
}