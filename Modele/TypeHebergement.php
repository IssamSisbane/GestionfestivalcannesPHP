<?php
class TypeHebergement
{
    private $_id;
    private $_libelle;

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
     * Get the value of _libelle
     */ 
    public function get_libelle()
    {
        return $this->_libelle;
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
     * Set the value of _libelle
     *
     * @return  self
     */ 
    public function set_libelle($_libelle)
    {
        $this->_libelle = $_libelle;

        return $this;
    }
    
}
