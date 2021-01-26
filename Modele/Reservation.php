<?php
class Reservation
{
    private $_id;
    private $_dateDebut;
    private $_dateFin;
    private $_prixFinal;
    private $_nombredeNuit;
    private $_idVip;
    private $_idHebergement;
    private $_type_vip;

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
     * Get the value of _dateDebut
     */ 
    public function get_dateDebut()
    {
        return $this->_dateDebut;
    }
    

    /**
     * Get the value of _dateFin
     */ 
    public function get_dateFin()
    {
        return $this->_dateFin;
    }  

    /**
     * Get the value of _prixFinal
     */ 
    public function get_prixFinal()
    {
        return $this->_prixFinal;
    }

    /**
     * Get the value of _nombreNuits
     */ 
    public function get_nombredeNuit()
    {
        return $this->_nombredeNuit;
    }


    /**
     * Get the value of _idVip
     */ 
    public function get_idVip()
    {
        return $this->_idVip;
    }


    /**
     * Get the value of _idHebergement
     */ 
    public function get_idHebergement()
    {
        return $this->_idHebergement;
    }


    /**
     * Get the value of _type_vip
     */ 
    public function get_type_vip()
    {
        return $this->_type_vip;
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

        return $this;
    }

    /**
     * Set the value of _dateDebut
     *
     * @return  self
     */ 
    public function set_dateDebut($_dateDebut)
    {
        /*
        if ($this->get_dateFin() <= $_dateDebut)
        {
            throw new Exception("Les dates de debut et de fin ne sont pas valides");
        }
        else
        {*/
            $this->_dateDebut = $_dateDebut;
        //}
        

        return $this;
    }

    /**
     * Set the value of _dateFin
     *
     * @return  self
     */ 
    public function set_dateFin($_dateFin)
    {
        /*if ($this->get_dateDebut() >= $_dateFin)
        {
            echo $this->get_dateDebut >= $_dateFin;
            throw new Exception("Les dates de debut et de fin ne sont pas valides");
        }
        else
        {*/
            $this->_dateFin = $_dateFin;
        //}
        return $this;
    }

    /**
     * Set the value of _prixFinal
     *
     * @return  self
     */ 
    public function set_prixFinal($_prixFinal)
    {
        $this->_prixFinal = $_prixFinal;

        return $this;
    }

    /**
     * Set the value of _nombreNuits
     *
     * @return  self
     */ 
    public function set_nombredeNuit($_nombredeNuit)
    {
        $this->_nombredeNuit = $_nombredeNuit;

        return $this;
    }

    

    /**
     * Set the value of _idVip
     *
     * @return  self
     */ 
    public function set_idVip($_idVip)
    {
        $this->_idVip = $_idVip;

        return $this;
    }



    /**
     * Set the value of _idHebergement
     *
     * @return  self
     */ 
    public function set_idHebergement($_idHebergement)
    {
        $this->_idHebergement = $_idHebergement;

        return $this;
    }

    

    /**
     * Set the value of _type_vip
     *
     * @return  self
     */ 
    public function set_type_vip($_type_vip)
    {
        if ($_type_vip == 'MembreJury' || $_type_vip == 'MembreEquipe' || $_type_vip == 'Invite')
        {
            $this->_type_vip = $_type_vip;
        }
        else
        {
            throw new Exception("Erreur de type du vip");
        }
        

        return $this;
    }
}