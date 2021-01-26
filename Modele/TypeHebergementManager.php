<?php
class TypeHebergementManager extends Model
{
    // Recupère tous les types d'hebergement de la base de données
    public function getTypesHebergement()
    {
        return $this->getAll('type_hebergement', 'TypeHebergement');
    }

    /**
     * Recupère un type d'hebergement par son id
     * @param int $id
     */
    public function recupererTypeHebergementParId(int $id)
    {
        return $this->getById('type_hebergement','TypeHebergement',$id);
    }

    /**
     * Recupère l'id d'un type d'hebergement par son libelle
     * @param string libelle
     * @return int result['id'] retourne l'id
     */
    public function recupererIdTypeHebergementParLibelle(string $libelle)
    {
        $req = $this->getBdd()->prepare('SELECT id from type_hebergement where libelle = ?');
        $req->execute(array($libelle));
        $result = $req->fetch();
        return $result['id'];
    }
}