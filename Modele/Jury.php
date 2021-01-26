<?php
class Jury
{
    private $_id;
    private $_nombreMembreJury;
    private $_idCompetition;

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


    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

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
     * Get the value of _nombreMembreJury
     */ 
    public function get_nombreMembreJury()
    {
        return $this->_nombreMembreJury;
    }

    /**
     * Set the value of _nombreMembreJury
     *
     * @return  self
     */ 
    public function set_nombreMembreJury($_nombreMembreJury)
    {
        $this->_nombreMembreJury = $_nombreMembreJury;

        return $this;
    }

    /**
     * Get the value of _idCompetition
     */ 
    public function get_idCompetition()
    {
        return $this->_idCompetition;
    }

    /**
     * Set the value of _idCompetition
     *
     * @return  self
     */ 
    public function set_idCompetition($_idCompetition)
    {
        $this->_idCompetition = $_idCompetition;

        return $this;
    }
}