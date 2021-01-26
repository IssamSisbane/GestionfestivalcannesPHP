<?php
class Hebergement
{
    private $_id;
    private $_nom;
    private $_nombrePlacesDisponibles;
    private $_prixParNuit;
    private $_type_hebergment_id;
    private $_nom_proprietaire;

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
     * Get the value of _nombrePlacesDisponibles
     */ 
    public function get_nombrePlacesDisponibles()
    {
        return $this->_nombrePlacesDisponibles;
    }


    /**
     * Get the value of _prixParNuit
     */ 
    public function get_prixParNuit()
    {
        return $this->_prixParNuit;
    }


    /**
     * Get the value of _type_hebergment_id
     */ 
    public function get_type_hebergment_id()
    {
        return $this->_type_hebergment_id;
    }

    
    /**
     * Get the value of _nom_proprietaire
     */ 
    public function get_nom_proprietaire()
    {
        return $this->_nom_proprietaire;
    }



    // SETTERS
    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function set_id($_id)
    {
        $this->_id = $_id;
    }


    /**
     * Set the value of _nom
     *
     * @return  self
     */ 
    public function set_nom($_nom)
    {
        $this->_nom = $_nom;
    }


    /**
     * Set the value of _nombrePlacesDisponibles
     *
     * @return  self
     */ 
    public function set_nombrePlacesDisponibles($_nombrePlacesDisponibles)
    {
        $this->_nombrePlacesDisponibles = $_nombrePlacesDisponibles;
    }


    /**
     * Set the value of _prixParNuit
     *
     * @return  self
     */ 
    public function set_prixParNuit($_prixParNuit)
    {
        $this->_prixParNuit = $_prixParNuit;
    }

    
    /**
     * Set the value of _type_hebergment_id
     *
     * @return  self
     */ 
    public function set_type_hebergment_id($_type_hebergment_id)
    {
        $this->_type_hebergment_id = $_type_hebergment_id;
    }


    /**
     * Set the value of _nom_proprietaire
     *
     * @return  self
     */ 
    public function set_nom_proprietaire($_nom_proprietaire)
    {
        $this->_nom_proprietaire = $_nom_proprietaire;

        return $this;
    }
}