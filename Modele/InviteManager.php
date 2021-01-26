<?php
class InviteManager extends Model
{

    /**
     * Modifie en base de données l'objet passé en paramètre
     * @param Invite $Invite
     */
    public function modifierInvite(Invite $Invite)
    {
        $req = $this->getBdd()->prepare("UPDATE `invite` SET `nom`=?,`prenom`=?,`dateNaissance`=?,`serviceHebergement`=? WHERE id=?");
        $req->execute(array($Invite->get_nom(),
                            $Invite->get_prenom(),
                            $Invite->get_dateNaissance(),
                            $Invite->get_serviceHebergement(),
                            $Invite->get_id()
        ));
    }

    /**
     * Ajoute en base de données l'objet passé en paramètre
     * @param Invite $Invite
     */
    public function ajouterInvite(Invite $Invite)
    {
        $req = $this->getBdd()->prepare("INSERT INTO `invite` (`id`, `nom`, `prenom`, `dateNaissance`, `serviceHebergement`) VALUES (?,?,?,?,?)");
        $req->execute(array($Invite->get_id(),
                            $Invite->get_nom(),
                            $Invite->get_prenom(),
                            $Invite->get_dateNaissance(),
                            $Invite->get_serviceHebergement(),
                            
        ));
    }

    /**
     * Supprimer l'invite designé par son id
     * @param int $vipId
     */
    public function supprimer($idVip)
    {
        return $this->delete('invite',$idVip);
    }

    /**
     * Renvoi l'id le plus grand de la table
     * @return id maximum
     */
    public function recupereMaxId()
    {
        return $this->getGreaterId('invite');
    }
}