<?php
class ServiceManager extends Model
{
    // Recupère tous les services dans la base de données
    public function getServices()
    {
        return $this->getAll('service', 'Service');
    }

    // Recupère un service par son id
    public function getServiceById(int $id)
    {
        return $this->getById('service','Service',$id);
    }

    /**
     * Recupère tous les services d'un hebergement
     * @param int $idHebergement
     * @return array $var tableau d'objets Services
     */
    public function getServiceHebergement(int $idHebergement)
    {
        $var = [];
        $req = $this->getBdd()->prepare('SELECT * FROM `service` JOIN service_propose_hebergement ON service_propose_hebergement.id_service = service.id WHERE service_propose_hebergement.id_hebergement = ?');
        $req->execute(array($idHebergement));

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new Service($data);
        }
        return $var;
        $req->closeCursor();
    }

    /**
     * Supprime les services d'un hebergement par son id
     * @param int idHebergement
     */
    public function deleteServiceHebergement(int $idHebergement)
    {
        $req = $this->getBdd()->prepare('DELETE from service_propose_hebergement WHERE id_hebergement = ?');
        $req->execute(array($idHebergement));
    }

    /**
     * Ajoute un service à un hebergement
     * @param int $idHebergement
     * @param int $idService
     */
    public function ajouterServicesHebergement(int $idHebergement,int $idService)
    {
        $req = $this->getBdd()->prepare('INSERT INTO `service_propose_hebergement`(`id_hebergement`,`id_service`) VALUES (?,?)');
        $req->execute(array($idHebergement,$idService));
    }

    /**
     * Recupere l'id d'un service par son libelle
     * @param string $libelle
     * @return int $result['id'] retourne l'id
     */
    public function recupererIdServiceByLibelle(string $libelle)
    {
        $req = $this->getBdd()->prepare('SELECT id from `service` where libelle = ?');
        $req->execute(array($libelle));
        $result = $req->fetch();
        return $result['id'];
    }
}