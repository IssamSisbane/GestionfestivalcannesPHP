<?php
class MembreJury extends Vip
{
    private $_id_jury;

    public function __construct($data)
    {
        Vip::__construct($data);
        $this->set_id_jury($data['id_jury']);
    }

    

    /**
     * Get the value of _id_jury
     */ 
    public function get_id_jury()
    {
        return $this->_idJury;
    }

    /**
     * Set the value of _id_jury
     *
     * @return  self
     */ 
    public function set_id_jury($_id_jury)
    {
        $this->_idJury = $_id_jury;

        return $this;
    }
}