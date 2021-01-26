<?php
class Equipe
{
    private $_id;
    private $_idfilm;

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
     * Get the value of _idfilm
     */ 
    public function get_idfilm()
    {
        return $this->_idfilm;
    }

    /**
     * Set the value of _idfilm
     *
     * @return  self
     */ 
    public function set_idfilm($_idfilm)
    {
        $this->_idfilm = $_idfilm;

        return $this;
    }
}