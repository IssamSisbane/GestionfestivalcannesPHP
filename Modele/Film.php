<?php
class Film
{
    private $_id;
    private $_titre;
    private $_anneeSortie;
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
     * Get the value of _titre
     */ 
    public function get_titre()
    {
        return $this->_titre;
    }

    /**
     * Set the value of _titre
     *
     * @return  self
     */ 
    public function set_titre($_titre)
    {
        $this->_titre = $_titre;

        return $this;
    }

    /**
     * Get the value of _anneeSortie
     */ 
    public function get_anneeSortie()
    {
        return $this->_anneeSortie;
    }

    /**
     * Set the value of _anneeSortie
     *
     * @return  self
     */ 
    public function set_anneeSortie($_anneeSortie)
    {
        $this->_anneeSortie = $_anneeSortie;

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