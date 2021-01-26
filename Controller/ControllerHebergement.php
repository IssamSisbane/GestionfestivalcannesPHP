<?php
class ControllerHebergement
{
    private $_hebergementManager;
    private $_view;
    private $_typeHebergementManager;
    private $_ServiceManager;
    private $_reservationManager;

    // CONSTRUCTEUR
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page introuvable');
        } else {
            if (isset($_GET['action']) && isset($_GET['hebergement'])) {

                if ($_GET['action'] == 'afficher') {

                    if(isset($_POST['submitModif']))
                    {
                        $this->modifier($_POST); // On modifie l'hebergement en base de données
                    }
                    
                    $this->afficherHebergement($_GET['hebergement']); // On affiche le formulaire de modification d'hebergement

                }

                if ($_GET['action'] == 'afficherReservations')
                {
                    $this->afficherReservationsHebergement($_GET['hebergement']); // On affiche les reservations correspondantes à l'hebergement passé par url
                }

                if ($_GET['action'] == 'supprimer') {

                    $this->supprimer($_GET['hebergement']); // On supprime l'hebergement

                }
                    

            } else {

                if (isset($_GET['action']) && $_GET['action'] == 'ajouter') {
                    
                    if(isset($_POST['submitAjout']))
                    {
                        $this->ajout($_POST); // On ajoute l'hebergment en base de données
                    }

                    $this->ajoutAffichage(); // On affiche le formulaire d'ajout d'hebergement
                }
                else
                {
                    $this->afficherHebergements(); // On affiche tous les hebergements
                }
                

            }
        }
    }

    // Affiche tous les hebergements
    private function afficherHebergements()
    {
        // On recupère tous les hebergements en base de données
        $this->_hebergementManager = new HebergementManager();

        // Si l'utilisateur est un gérant on ne recupère que les hebergements dont il est le proprietaire sinon on recupère tous les hebergements
        if ($_SESSION['type_utilisateur_id'] == 4)
        {
            $hebergements = $this->_hebergementManager->getHebergementsGerant($_SESSION['pseudo']);
        }
        else
        {
            $hebergements = $this->_hebergementManager->getHebergements();
        }
        

        // On crée et on affiche la vue en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('Hebergement');
        $this->_view->generate(array('hebergements' => $hebergements));
    }

        /**
     * Affiche toutes les reservations de l'hebergement passé en paramètre.
     * @param Hebergement $hebergement l'hebergement que l'on veut traiter
     */
    private function afficherReservationsHebergement($hebergement)
    {
        // On recréer l'objet hebergement passée dans l'url
        $so = urldecode($hebergement);
        $hebergement = unserialize($so);

        // On recupère l'id de l'hebergement
        $id = $hebergement->get_id();

        // On recupère les reservations propres à l'hebergement passé en paramètre
        $this->_reservationManager = new ReservationManager();
        $reservations = $this->_reservationManager->RecupererReservationParHebergement($id);

        $this->_vipManager = new VipManager();
        $vips = $this->_vipManager->getAllVips();

        // Selon le type d'utilisateur on affiche une vue différente
        if ($_SESSION['type_utilisateur_id'] == 4)
        {
            $this->_view = new Vue('ReservationLecture'); // Gerant
        } 
        else
        {
            $this->_view = new Vue('Reservation'); // Staff
        }
            

        // On affiche la vue et on passe les variables dont on a besoin pour l'affichage
        $this->_view->generate(array('reservations' => $reservations, 'hebergement' => $hebergement, 'vips' => $vips));
    }

    /**
     * Affiche le formualire de modification de l'hebergement sur lequel on à cliqué
     * @param Hebergement $hebergement 
     */
    private function afficherHebergement($hebergement)
    {
        // On recréer l'objet hebergement passé dans l'url
        $so = urldecode($hebergement);
        $hebergement = unserialize($so);

        // On recupère tous les types d'hebergements ainsi que le type de l'hebergement que l'on veut afficher
        $this->_typeHebergementManager = new TypeHebergementManager();
        $TousTypesHebergement = $this->_typeHebergementManager->getTypesHebergement();
        $TypeTrouve = $this->_typeHebergementManager->recupererTypeHebergementParId($hebergement->get_type_hebergment_id());

        // On recupère tous les services ainsi que ceux de l'hebergement que l'on veut afficher
        $this->_ServiceManager = new ServiceManager();
        $TousServices = $this->_ServiceManager->getServices();
        $ServicesTrouve = $this->_ServiceManager->getServiceHebergement($hebergement->get_id());

        // On crée et on affiche la vue en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('HebergementAffiche');
        $this->_view->generate(array(
            'hebergement' => $hebergement,
            'TousTypesHebergement' => $TousTypesHebergement, 'TypeTrouve' => $TypeTrouve,
            'TousServices' => $TousServices, 'ServicesTrouve' => $ServicesTrouve
        ));
    }



    /**
     * Supprime en base de données l'hebergement designé par l'id passé en paramètre
     * @param int $idHebergement
     */
    private function supprimer($idHebergement)
    {

        // On supprimer l'hebergement qui porte l'id $idHebergement
        $this->_HebergementManager = new HebergementManager();
        $this->_HebergementManager->supprimerHebergement($idHebergement);

        // On retourne à la page oû tous les hebergements sont affichés
        header('Location: index.php?url=hebergement&message=suppression effectuée');
    }

    /**
     * Modifie en base de donnée l'hebergement choisi
     * @param array $data recupération de $_POST
     *  */ 
    private function modifier($data)
    {

        // On recupère tous les attributs du futur objet depuis le tableau passé en paramètre
        $tab = [];
        $tab['id'] = $data['id'];
        $tab['nom'] = $data['nom'];
        $tab['nombrePlacesDisponibles'] = $data['nombrePlacesDisponibles'];
        $tab['prixParNuit'] = $data['prixParNuit'];

        // On recupère les libelles afin de pouvoir retrouver leur id et les ajouter dans le futur objet
        $libelle = $data['type_hebergement_choix'];
        $service = $_POST['service'];
        
        // On recupère l'id du type d'hebergement
        $this->_typeHebergementManager = new TypeHebergementManager();
        $type_hebergment_id = $this->_typeHebergementManager->recupererIdTypeHebergementParLibelle($libelle);
        $tab['type_hebergment_id'] = $type_hebergment_id;

        // On supprimer tous les anciens services de l'hebergement
        $this->_ServiceManager = new ServiceManager();
        $this->_ServiceManager->deleteServiceHebergement($tab['id']);

        // On ajoute les nouveaux services de l'hebergement
        for($i=0;$i<count($service);$i++)
        {
            $idService = $this->_ServiceManager->recupererIdServiceByLibelle($service[$i]);
            $this->_ServiceManager->ajouterServicesHebergement($tab['id'],$idService);
        }
        

        // On crée l'objet hebergement et on modifie la base de données avec les valeurs du nouvel l'objet
        $hebergement = new Hebergement($tab);
        $this->_hebergementManager = new HebergementManager();
        $this->_hebergementManager->modifierHebergement($hebergement);

        // On retourne à la page oû tous les hebergements sont affichés
        header('Location: index.php?url=hebergement&message=modification effectuée');
    }

    // Affiche le formulaire d'ajout d'hebergement
    private function ajoutAffichage()
    {
        // On recupère Tous les types d'hebergements en Base de données
        $this->_typeHebergementManager = new TypeHebergementManager();
        $TousTypesHebergement = $this->_typeHebergementManager->getTypesHebergement();
        
        $this->_hebergementManager = new HebergementManager();
        $maxId = $this->_hebergementManager->recupereMaxId();

        // On recupère Tous les Services en Base de données
        $this->_ServiceManager = new ServiceManager();
        $TousServices = $this->_ServiceManager->getServices();

        // On crée et on affiche la vue en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('HebergementAjout');
        $this->_view->generate(array('TousTypesHebergement' => $TousTypesHebergement,
                                     'TousServices' => $TousServices,
                                     'maxId' => $maxId
                            ));
    }

    /**
     * Ajoute l'hebergement en base de données
     * @param array $data recupération de $_POST
     */
    private function ajout($data)
    {
        // On recupère tous les attributs du futur objet depuis le tableau passé en paramètre
        $tab = [];
        $tab['id'] = $data['id'];
        $tab['nom'] = $data['nom'];
        $tab['nombrePlacesDisponibles'] = $data['nombrePlacesDisponibles'];
        $tab['prixParNuit'] = $data['prixParNuit'];
        $tab['nom_proprietaire'] = $data['nom_proprietaire'];

        // On recupère les libelles afin de pouvoir retrouver leur id et les ajouter dans le futur objet
        $libelle = $data['type_hebergement_choix'];
        $service = $_POST['service'];

        // Recupération du type d'hebergement
        $this->_typeHebergementManager = new TypeHebergementManager();
        $type_hebergment_id = $this->_typeHebergementManager->recupererIdTypeHebergementParLibelle($libelle);
        $tab['type_hebergment_id'] = $type_hebergment_id;

        // Création de l'objet hebergement et ajout à la base de données
        $hebergement = new Hebergement($tab);
        $this->_hebergementManager = new HebergementManager();
        $this->_hebergementManager->ajouterHebergement($hebergement);

        // Modification des services de l'hebergement
        $this->_ServiceManager = new ServiceManager();
        for($i=0;$i<count($service);$i++)
        {
            $idService = $this->_ServiceManager->recupererIdServiceByLibelle($service[$i]);
            $this->_ServiceManager->ajouterServicesHebergement($tab['id'],$idService);
        }

        // On retourne à la page oû tous les hebergements sont affichés
        header('Location: index.php?url=hebergement&message=ajout effectué');
    }


}
