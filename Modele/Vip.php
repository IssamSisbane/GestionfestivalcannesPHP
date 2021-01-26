<?php
class Vip
{
    private $_id;
    private $_nom;
    private $_prenom;
    private $_dateNaissance;
    private $_serviceHebergement;

    // CONSTRUCTEUR
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    // HYDRATATION
    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            $method = 'set_'.ucfirst($key);
            

            if(method_exists($this, $method))
            {
                $this->$method($value);
            }
                
        }
    }

    // GETTERS

    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Get the value of _nom
     */ 
    public function get_nom()
    {
        return $this->_nom;
    }

    /**
     * Get the value of _prenom
     */ 
    public function get_prenom()
    {
        return $this->_prenom;
    }

    /**
     * Get the value of _dateNaissance
     */ 
    public function get_dateNaissance()
    {
        return $this->_dateNaissance;
    }

    /**
     * Get the value of _serviceHebergement
     */ 
    public function get_serviceHebergement()
    {
        return $this->_serviceHebergement;
    }


    // SETTERS

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function set_id($id)
    {
        $this->_id = $id;
    }

    /**
     * Set the value of _nom
     *
     * @return  self
     */ 
    public function set_nom($nom)
    {
        $this->_nom = $nom;
    }

    /**
     * Set the value of _prenom
     *
     * @return  self
     */ 
    public function set_prenom($prenom)
    {
        $this->_prenom = $prenom;
    }

    /**
     * Set the value of _dateNaissance
     *
     * @return  self
     */ 
    public function set_dateNaissance($dateNaissance)
    {
        $this->_dateNaissance = $dateNaissance;
    }

    /**
     * Set the value of _serviceHebergement
     *
     * @return  self
     */ 
    public function set_serviceHebergement($serviceHebergement)
    {
        $this->_serviceHebergement = $serviceHebergement;
    }

}