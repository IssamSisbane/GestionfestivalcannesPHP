<?php

abstract class Model
{
    private static $_bdd;

    // INSTANCIE LA CONNEXION A LA BDD
    private static function setBdd()
    {
        try {
            $host = 'iutdoua-web.univ-lyon1.fr';
            $user = 'p1906661';
            $pwd = '444815';
            $db = 'p1906661';

            self::$_bdd = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pwd);
            self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * RECUPERE LA CONNEXION A LA BDD
     * @return database $_bdd
     */
    protected function getBdd()
    {
        if (self::$_bdd == null) {
            self::setBdd();
        }
        return self::$_bdd;
    }

    /** 
     * Recupere tous les elements d'une table
     * @param string $table le nom de la table en base de données
     * @param string $obj le nom de l'objet dans le modele
     * @return array $var un tableau d'objet
     * */
    protected function getAll($table, $obj)
    {
        $var = [];
        $req = $this->getBdd()->prepare('SELECT * FROM ' . $table);
        $req->execute();

        $var = null;

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new $obj($data);
        }
        return $var;
        $req->closeCursor();
    }

    protected function getAllEligible($table, $obj)
    {
        $var = [];
        $req = $this->getBdd()->prepare('SELECT * FROM ' . $table . ' WHERE serviceHebergement = 1');
        $req->execute();

        $var = null;

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new $obj($data);
        }
        return $var;
        $req->closeCursor();
    }

    /**
     * Recupere une ligne de la table designée par son id
     * @param string $table le nom de la table en base de données
     * @param string $obj le nom de l'objet dans le modele
     * @param int $id
     * @return array $result
     */
    protected function getById($table, $obj, $id)
    {
        $req = $this->getBdd()->prepare('SELECT * FROM ' . $table . ' WHERE id = ?');
        $req->execute(array($id));
        $result = $req->fetch(PDO::FETCH_ASSOC);
        $result = new $obj($result);
        return $result;
    }

    /**
     * Supprime une ligne de la table designée par son id
     * @param string $table le nom de la table en base de données
     * @param int $id
     */
    protected function delete($table, $id)
    {
        try {
            $req =  $this->getBdd()->prepare('DELETE from ' . $table . ' WHERE id = ?');
            $req->execute(array($id));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Retourne l'id le plus grand de la table
     * @param table $table
     * @return int id maximum
     */
    protected function getGreaterId($table)
    {
        try {
            $req = $this->getBdd()->prepare('SELECT MIN(id)+1 as id FROM ' . $table . ' a
            WHERE NOT EXISTS (SELECT NULL FROM ' . $table . ' WHERE id = a.id + 1)');
            $req->execute();
            $result = $req->fetch();
            return $result['id'];
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
