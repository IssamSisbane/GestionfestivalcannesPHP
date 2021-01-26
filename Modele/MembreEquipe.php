<?php
class MembreEquipe extends Vip
{
    private $_id_equipe;

    public function __construct($data)
    {
        Vip::__construct($data);
        $this->set_id_equipe($data['id_equipe']);
    }

    /**
     * Get the value of _id_equipe
     */ 
    public function get_id_equipe()
    {
        return $this->_id_equipe;
    }

    /**
     * Set the value of _id_equipe
     *
     * @return  self
     */ 
    public function set_id_equipe($_id_equipe)
    {
        $this->_id_equipe = $_id_equipe;

        return $this;
    }
}