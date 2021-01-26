<?php
class VipManager extends Model
{
    /**
     * Recupere Tous les vips
     */
    public function getAllVips()
    {
        $var = array_merge($this->getAll('membre_jury','MembreJury'), $this->getAll('membre_equipe','MembreEquipe'), $this->getAll('invite','Invite')) ;
        return $var;
    }

    /**
     * Recupere Tous les vips que l'on doit gèrer pour l'hebergement
     */
    public function getAllVipsEligible()
    {
        $var = array_merge($this->getAllEligible('membre_jury','MembreJury'), $this->getAllEligible('membre_equipe','MembreEquipe'), $this->getAllEligible('invite','Invite')) ;
        return $var;
    }

    /**
     * Supprimer les vip designé par son id
     * @param int $vipId
     */
    public function deleteVip($idVip)
    {
        return $this->delete('vip',$idVip);
    }
}