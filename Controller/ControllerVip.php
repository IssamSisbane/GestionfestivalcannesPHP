<?php
class ControllerVip
{
    private $_vipManager;
    private $_membreEquipeManager;
    private $_view;

    // CONSTRUCTEUR
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page introuvable');
        } else {
            if ($_SESSION['type_utilisateur_id'] == 3) {

                if (isset($_GET['action']) && isset($_GET['vip'])) {

                    if ($_GET['action'] == 'afficher') {

                        if (isset($_POST['submitModif'])) {

                            $this->modifier($_POST); // on modifie le vip en base de données

                        }

                        $this->afficherVip($_GET['vip']); // On affiche le formulaire de modification de vip
                    }

                    if ($_GET['action'] == 'supprimer') {

                        $this->supprimer($_GET['vip']); // on supprimer le vip en base de données
                    }
                } else {

                    if (isset($_GET['action']) && $_GET['action'] == 'ajouter') {

                        if (isset($_POST['submitAjout'])) {

                            $this->ajouter($_POST); // on ajoute le vip en base de données

                        }

                        if (isset($_GET['class']))
                            $this->ajouterAffichage($_GET['class']); // on affiche le formulaire d'ajout de vip selon son type

                    } else {

                        $this->afficherVips(); // on affiche tous les vips

                    }
                }
            } else {
                throw new Exception('Page inaccessible');
            }
        }
    }

    // Affiche tous les vips
    private function afficherVips()
    {
        // On recupère tous les vips
        $this->_vipManager = new VipManager();
        //$vips = $this->_vipManager->getVips();

        $vips = $this->_vipManager->getAllVips();

        // On crée et on affiche la Vue adequate en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('Vip');
        $this->_view->generate(array('vips' => $vips));
    }

    /**
     * Affiche le formulaire adéquat de modification selon le vip et son type
     * @param NewVip $vip
     */
    private function afficherVip($vip)
    {
        $so = urldecode($vip);
        $vip = unserialize($so);

        $class = get_class($vip);

        // On ne recupère rien si le vip n'est qu'un Invite
        $elements = null;
        $selectionne = null;

        if ($class == 'MembreEquipe') // On recupère tous les films et le film auquel appartient le vip si c'est un membre d'equipe
        {
            $this->_vipManager = new MembreEquipeManager();
            $elements = $this->_vipManager->recupererTousLesFilms();
            $selectionne = $this->_vipManager->recupererTitreFilm($vip->get_id_equipe());
        }

        if ($class == 'MembreJury') // On recupère toutes les compétitions et la competition a laquelle appartient le vip si c'est un membre du Jury
        {
            $this->_vipManager = new MembreJuryManager();
            $elements = $this->_vipManager->recupererToutesLesCompetitions();
            $selectionne = $this->_vipManager->recupererLibelleCompetition($vip->get_id_jury());
        }

        // On crée et on affiche la Vue adequate en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue($class.'Affiche');
        $this->_view->generate(array('vip' => $vip, 'elements' => $elements, 'selectionne' => $selectionne));
    }

    /**
     * Supprime le vip designé par l'id passé en parametre de la base de données
     * @param int $idVip
     */
    private function supprimer($vip)
    {
        //On decode et recupère le vip
        $vipDecode = urldecode($vip);
        $vip = unserialize($vipDecode);

        $manager = (get_class($vip)).'Manager'; 
        if(class_exists($manager))
            $this->_vipManager = new $manager();
            $this->_vipManager->supprimer($vip->get_id());

        // On retourne à la page oû toutes les vips sont affichés
        header('Location: index.php?url=vip&message=suppression effectuée');
    }

    /**
     * Modifier en base de donnée le vip choisi
     * @param array $data recupération de $_POST
     */
    private function modifier($data)
    {
        // On recupère tous les attributs du futur objet depuis le tableau passé en paramètre
        $tab = [];
        $tab['id'] = $data['id'];
        $tab['nom'] = $data['nom'];
        $tab['prenom'] = $data['prenom'];
        $tab['dateNaissance'] = $data['dateNaissance'];

        // On recupère la valeur de Service_Hebergement qui est une case à cocher 1 -> case cochée, 0-> case non cochée
        if (isset($data['Service_Hebergement'])) {
            $tab['serviceHebergement'] = 1;
        } else {
            $tab['serviceHebergement'] = 0;
        }

        // Le champs special contient l'id de l'equipe ou l'id du jury ou rien si le Vip n'est qu'un simple invité
        if (isset($data['special']))
            $tab['special'] = $data['special'];

        // On appele la bonne méthode de modification selon le type du vip que l'on veut modifier
        $method = 'modifier'.($data['class']); 
        if(method_exists($this, $method))
            $this->$method($tab);        
    }

    /**
     * Appelle la fonction qui va modifier l'objet MembreEquipe
     * en base de donnée en créant 
     * l'objet possédant les attributs passés en paramètre.
     * @param array $tab
     */
    private function modifierMembreEquipe($tab)
    {
        // On recupere l'id de l'equipe du Film choisi
        $this->_membreEquipeManager = new MembreEquipeManager();
        $tab['id_equipe'] = $this->_membreEquipeManager->recupererIdEquipe($tab['special']);

        // On crée l'objet et on appelle la fonction qui va l'ajouter en base de données
        $MembreEquipe = new MembreEquipe($tab);
        var_dump($tab);
        $this->_membreEquipeManager->modifierMembreEquipe($MembreEquipe);

        // On retourne à la page oû toutes les vips sont affichés
        header('Location: index.php?url=vip&message=modification effectuée');
    }

    /**
     * Appelle la fonction qui va modifier l'objet MembreJury
     * en base de donnée en créant 
     * l'objet possédant les attributs passés en paramètre.
     * @param array $tab
     */
    private function modifierMembreJury($tab)
    {
        // On recupere l'id du jury de la competition choisie
        $this->_membreJuryManager = new MembreJuryManager();
        $nbMembre = $this->_membreJuryManager->recupererNombreDeMembre($tab['special']);
        $nbMembreLimit = $this->_membreJuryManager->recupererNombreDeMembreMax($tab['special']);

        if ($nbMembre <= $nbMembreLimit)
        {
            $tab['id_jury'] = $this->_membreJuryManager->recupererIdJury($tab['special']);

            // On crée l'objet et on appelle la fonction qui va l'ajouter en base de données
            $MembreJury = new MembreJury($tab);
            var_dump($tab);
            $this->_membreJuryManager->modifierMembreJury($MembreJury);

            // On retourne à la page oû toutes les vips sont affichés
            header('Location: index.php?url=vip&message=modification effectuée');
        }
        else
        {
            throw new Exception("Vous ne pouvez ajouter plus de membre de Jury pour cette competition, le nombre maximum de jury pour cette competition à été atteint.");
        }
        
    }

    /**
     * Appelle la fonction qui va modifier l'objet Invite
     * en base de donnée en créant 
     * l'objet possédant les attributs passés en paramètre.
     * @param array $tab
     */
    private function modifierInvite($tab)
    {

        $this->_membreEquipeManager = new InviteManager();

        $Invite = new Invite($tab);
        var_dump($tab);
        $this->_membreEquipeManager->modifierInvite($Invite);

        // On retourne à la page oû toutes les vips sont affichés
        header('Location: index.php?url=vip&message=modification effectuée');
    }

    /**
     * Affiche le formualire d'ajout de vip 
     * selon le type de ce dernier 
     * MembreEquipe / MembreJury / Invite
     * @param class $class La class de l'objet que l'on va crée
     */
    private function ajouterAffichage(string $class)
    {
        // On crée le manager adequat dependant de la classe de l'objet que l'on veut créer
        $manager = $class.'Manager';
        $this->_vipManager = new $manager();

        // On recupère l'id le plus élevé afin de le proposer à l'utilisateur comme un AutoIncrement
        $NouvelId = $this->_vipManager->recupereMaxId();

        
        
        // On recupère tous les films (MembreEquipe) ou toutes les competitions (MembreJury) ou rien (Invite) selon le type de vip
        $elements = null;

        if ($class == 'MembreEquipe')
        {
            $elements = $this->_vipManager->recupererTousLesFilms();
        }
        if ($class == 'MembreJury')
        {
            $elements = $this->_vipManager->recupererToutesLesCompetitions();
        }


        // On crée et on affiche la Vue adequate en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('VipAjout');
        $this->_view->generate(array('class' => $class, 'NouvelId' => $NouvelId, 'elements' => $elements));
    }

    /**
     * Appelle la bonne methode d'ajout selon le type de Vip 
     * et crée un tableau contenant les informations nécessaires 
     * à la création de ce dernier
     * @param array $data recupération de $_POST
     */
    private function ajouter($data)
    {
        // On recupère tous les attributs du futur objet depuis le tableau passé en paramètre
        $tab = [];
        $tab['id'] = $data['id'];
        $tab['nom'] = $data['nom'];
        $tab['prenom'] = $data['prenom'];
        $tab['dateNaissance'] = $data['dateNaissance'];

        // On recupère la valeur de Service_Hebergement qui est une case à cocher 1 -> case cochée, 0-> case non cochée
        if (isset($data['Service_Hebergement'])) {
            $tab['serviceHebergement'] = 1;
        } else {
            $tab['serviceHebergement'] = 0;
        }

        // Le champs special contient l'id de l'equipe ou l'id du jury ou rien si le Vip n'est qu'un simple invité
        if (isset($data['special']))
            $tab['special'] = $data['special'];

        // On appele la bonne méthode d'ajout selon le type du vip que l'on veut créer
        $method = 'ajouter'.($data['class']);  
        if(method_exists($this, $method))
            $this->$method($tab);    

    }

    /**
     * Ajoute un Membre d'une Equipe de Film 
     * en base de données avec les élements de $tab
     * @param array $tab
     */
    public function ajouterMembreEquipe($tab)
    {
        
        $this->_vipManager = new MembreEquipeManager();
        $tab['id_equipe'] = $this->_vipManager->recupererIdEquipe($tab['special']);

        // On crée l'objet MembreEquipe et on l'ajoute à la base de données
        $vip = new MembreEquipe($tab);
        $this->_vipManager->ajouterMembreEquipe($vip);

        // On retourne à la page oû toutes les vips sont affichés
        header('Location: index.php?url=vip&message=ajout effectué');
    }

    /**
     * Ajoute un Membre du Jury en base de données avec les élements de $tab
     * @param array $tab
     */
    public function ajouterMembreJury($tab)
    {
        // On recupere l'id du jury choisi
        $this->_membreJuryManager = new MembreJuryManager();
        $nbMembre = $this->_membreJuryManager->recupererNombreDeMembre($tab['special']);
        $nbMembreLimit = $this->_membreJuryManager->recupererNombreDeMembreMax($tab['special']);

        if ($nbMembre <= $nbMembreLimit)
        {
            $tab['id_jury'] = $this->_membreJuryManager->recupererIdJury($tab['special']);

            // On crée l'objet MembreJury et on l'ajoute à la base de données
            $vip = new MembreJury($tab);
            $this->_vipManager = new MembreJuryManager();
            $this->_vipManager->ajouterMembreJury($vip);

            // On retourne à la page oû toutes les vips sont affichés
            header('Location: index.php?url=vip&message=ajout effectué');
        }
        else
        {
            throw new Exception("Vous ne pouvez ajouter plus de membre de Jury pour cette competition, le nombre maximum de jury pour cette competition à été atteint");
        }
    }

    /**
     * Ajoute un Invité en base de données 
     * avec les éléments de $tab
     * @param array $tab
     */
    public function ajouterInvite($tab)
    {
        // On crée l'objet Invite et on l'ajoute à la base de données
        $vip = new Invite($tab);
        $this->_vipManager = new InviteManager();
        $this->_vipManager->ajouterInvite($vip);

        // On retourne à la page oû toutes les vips sont affichés
        header('Location: index.php?url=vip&message=ajout effectué');
    }
}
