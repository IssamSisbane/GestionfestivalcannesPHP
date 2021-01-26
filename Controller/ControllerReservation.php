<?php
class ControllerReservation
{
    private $_reservationManager;
    private $_vipManager;
    private $_hebergementManager;
    private $_view;

    // CONSTRUCTEUR
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
        {
            throw new Exception('Page introuvable');
        }
        else
        {
            if ($_SESSION['type_utilisateur_id'] == 3)
            {
                if (isset($_GET['action']) && isset($_GET["reservation"]))
                {
                    if ($_GET['action'] == 'modifier')
                    {
                        if(isset($_POST['submitModif']))
                        {
                            $this->modifier($_POST); // On modifie la reservation en base de données
                        }

                        $this->afficherLaReservation($_GET['reservation']); // On affiche le formulaire de modification de reservation
                    }

                    if ($_GET['action'] == 'supprimer')
                    {
                        $this->supprimer($_GET['reservation']); // On supprime la reservation de la base de données
                    }


                }
                else
                {
                    if (isset($_GET['action']) && $_GET['action'] == 'ajouter')
                    {
                        if(isset($_POST['submitVip']))
                        {
                            $this->ajouterSuggestion($_POST);
                        }

                        if(isset($_POST['submitAjout']))
                        {
                            $this->ajouter($_POST); // On ajoute la reservation en base de données
                        }

                        $this->ajouterAffichage(); // On affiche le formulaire de création de reservation
                    }
                    else{
                        $this->afficherReservations(); // On affiche toutes les reservations
                    }
                    
                }
                
            }
            else
            {
                throw new Exception('Page inaccessible');
            }
        }
    }

    // Affiche toutes les reservations
    private function afficherReservations()
    {
        // On recupère toutes les reservartions
        $this->_reservationManager = new ReservationManager();
        $reservations = $this->_reservationManager->getReservations();

        // On recupère tous les hebergements
        $this->_hebergementManager = new HebergementManager();
        $hebergements = $this->_hebergementManager->getHebergements();

        // On recupère tous les vips
        $this->_vipManager = new VipManager();
        $vips = $this->_vipManager->getAllVipsEligible();

        // On crée et on affiche la vue en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('Reservation');
        $this->_view->generate(array('reservations' => $reservations, 'hebergements' => $hebergements, 'vips' => $vips));
    }

    /**
     * Affiche le formulaire de modification de la reservation qur laquelle on a cliqué
     * @param Reservation $reservation
     */
    private function afficherLaReservation($reservation)
    {
        // On recrée l'objet hebergement passée dans l'url
        $reservationDecode = urldecode($reservation);
        $reservation = unserialize($reservationDecode);

        // On recupère tous les vips
        $this->_vipManager = new VipManager();
        $vips = $this->_vipManager->getAllVipsEligible();

        // On recupère tous les hebergements
        $this->_hebergementManager = new HebergementManager();
        $hebergements = $this->_hebergementManager->getHebergements();

        // On crée et on affiche la vue en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new Vue('ReservationAffiche');
        $this->_view->generate(array('reservation' => $reservation, 'vips' => $vips, 'hebergements' => $hebergements));
    }

    /**
     * Verification des champs et des contraintes et modification en base de donnée de la reservation choisie
     * @param array $data recupération de $_POST
     */
    private function modifier($data)
    {
        // On verifie si les dates sont valides
        if ($data['dateDebut'] < $data['dateFin'])
        {
            // On decode et recupère l'objet hebergement
            $hebergement = $data['hebergement'];
            $hebergementDecode = urldecode($hebergement);
            $hebergement = unserialize($hebergementDecode);
            
            // On verifie si l'hebergement à encore des places disponibles
            if ($hebergement->get_nombrePlacesDisponibles() > 0)
            {
                // On calcule le nombre de nuits de la reservation
                $data['nombredeNuit'] = $this->calculerNombreNuits($data['dateDebut'],$data['dateFin']);

                // On calcule le prix final de la reservation
                $data['idHebergement'] = $hebergement->get_id();
                $prixFinal = $data['nombredeNuit']*$hebergement->get_prixParNuit();
                $data['prixFinal'] = $prixFinal;

                // On décode et recupère l'objet vip 
                $vip = $data['vip'];
                $vipDecode = urldecode($vip);
                $vip = unserialize($vipDecode);

                // On recupère l'id et le type pour la creation du futur objet
                $data['idVip'] = $vip->get_id();
                $data['type_vip'] = get_class($vip);

                
            
                // On crée l'objet reservation et on modifie la base de données avec les valeurs du nouvel l'objet
                $reservation = new Reservation($data);
                $this->_reservationManager = new ReservationManager();

                if (get_class($vip) == "MembreEquipe") {

                        // On verifie si une equipe de film concurrente est déjà logée dans l'hebergement choisi
                        $equipe_concurrentes = $this->_reservationManager->recupererReservationEquipeConcurrentes($vip->get_id(), $hebergement->get_id());
                        if ($equipe_concurrentes == 0)
                        {
                            $this->_reservationManager->modifierReservation($reservation);
                        }
                        else
                        {
                            throw new Exception("Une equipe de film concurrentes est déjà logée dans cet hebergement !\nVeuillez en choisir un autre.");
                        }
                }
                else
                {
                    $this->_reservationManager->modifierReservation($reservation);
                }
                

                // On retourne à la page oû toutes les reservations sont affichées
                header('Location: index.php?url=reservation&message=modification effectuée');
            }
            else
            {
                throw new Exception("L'hebergement n'a plus de places disponibles");
            }
        }
        else
        {
            throw new Exception("Probleme avec les dates");
        }

    }

    /**
     * Supprime en base de données la reservation designée par l'id passé en paramètre
     * @param int $idReservation
     */
    private function supprimer($idReservation)
    {
        // On supprimer la reservation qui porte l'id $idReservation
        $this->_reservationManager = new ReservationManager();
        $this->_reservationManager->supprimerReservation($idReservation);

        // On retourne à la page oû toutes les reservations sont affichées
        header('Location: index.php?url=reservation&message=suppression effectuée');
    }

    // Affiche le formulaire d'ajout de reservation
    private function ajouterAffichage()
    {
        // On recupère les listes de tous les vips
        $this->_vipManager = new VipManager();
        $vips = $this->_vipManager->getAllVipsEligible();

        // On recupère la liste de tous les hebergements
        $this->_hebergementManager = new HebergementManager();
        $hebergements = $this->_hebergementManager->getHebergements();

        // On recupère l'id maximum pour l'autoIncrement
        $this->_reservationManager = new ReservationManager();
        $maxId = $this->_reservationManager->recupereMaxId();

        // On crée et on affiche la vue en passant en parametre les variables dont on a besoin pour l'affichage
        $this->_view = new vue('ReservationAjout');
        $this->_view->generate(array('hebergements' => $hebergements, 
                                     'vips' => $vips,
                                      'maxId' => $maxId
                                    ));
    }

        /**
     * Recupère le vip et cherche l'hebergement oû sont logés les autres membres de 
     * l'equipe de film ou du jury selon le type du vip
     * @param array $data on recupère $_POST
     */
    private function ajouterSuggestion($data)
    {

        // On sécode et recupère l'objet vip
        $vip = $data['vip'];
        $vipDecode = urldecode($vip);
        $vip = unserialize($vipDecode);

        
        // On verifie si une reservation existe déjà pour le vip
        $this->_reservationManager = new ReservationManager();
        $existe = $this->_reservationManager->recupererReservationExistante($vip->get_id());
        $reservationTrouve = null;

        // On cherche si une reservation existe pour un membre de la même equipe que le vip selon son type
        if ($existe == false)
        {
            if (get_class($vip) == "MembreEquipe")
            {
                $reservationTrouve = $this->_reservationManager->recupererReservationAutreMembreEquipe($vip->get_id_equipe());
            }
            if (get_class($vip) == "MembreJury")
            {
                $reservationTrouve = $this->_reservationManager->recupererReservationAutreMembreJury($vip->get_id_jury());
            }

            if ($reservationTrouve != false)
            {
                $_POST['reservationTrouve'] = $reservationTrouve->get_idHebergement();
            }
            
        }
        else
        {
            throw new Exception("Il y a déjà une reservation pour ce vip");
        }
    }
    
    /**
     * Verification des champs et des contraintes et ajout en base de données de la reservation créé avec les champs de $data
     * @param array $data recupération de $_POST
     */
    private function ajouter($data)
    {
        // On verifie si les dates sont valides
        if ($data['dateDebut'] < $data['dateFin'])
        {
            // On decode et recupère l'objet hebergement
            $hebergement = $data['hebergement'];
            $soH = urldecode($hebergement);
            $hebergement = unserialize($soH);
            
            // On verifie si l'hebergement à encore des places disponibles
            if ($hebergement->get_nombrePlacesDisponibles() > 0)
            {
                // On calcule le nombre de nuits de la reservation
                $data['nombredeNuit'] = $this->calculerNombreNuits($data['dateDebut'],$data['dateFin']);

                // On calcule le prix final de la reservation
                $data['idHebergement'] = $hebergement->get_id();
                $prixFinal = $data['nombredeNuit']*$hebergement->get_prixParNuit();
                $data['prixFinal'] = $prixFinal;

                // On décode et recupère l'objet vip 
                $vip = $data['vip'];
                $soV = urldecode($vip);
                $vip = unserialize($soV);

                // On recupère l'id et le type pour la creation du futur objet
                $data['idVip'] = $vip->get_id();
                $data['type_vip'] = get_class($vip);
                
                // Création de l'objet reservation et ajout à la base de données
                $reservation = new Reservation($data);
                $this->_reservationManager = new ReservationManager();

                if (get_class($vip) == "MembreEquipe") {
                    // On verifie si une equipe de film concurrente est déjà logée dans l'hebergement choisi
                    $equipe_concurrentes = $this->_reservationManager->recupererReservationEquipeConcurrentes($vip->get_id(), $hebergement->get_id());
                    if ($equipe_concurrentes == 0)
                    {
                        $this->_reservationManager->ajouterReservation($reservation);
                        header("Location: index.php?url=reservation&message=ajout effectué");
                    }
                    else
                    {
                        throw new Exception("Une equipe de film concurrentes est déjà logés dans cet hebergement !\nVeuillez en choisir un autre.");
                    }
                }
                else{
                    $this->_reservationManager->ajouterReservation($reservation);
                    header("Location: index.php?url=reservation&message=ajout effectué");
                }
                

                // On retourne à la page oû toutes les reservations sont affichées
                //header('Location: index.php?url=reservation');
            }
            else
            {
                throw new Exception("L'hebergement n'a plus de places disponibles");
            } 
        }
        else
        {
            echo "probleme avec les dates";
        }
    }

    /**
     * Calculer l'ecart de jour entre les 2 dates passés en paramètres
     * @param date $dateDebut
     * @param date $dateFin
     * @return int nombre de nuits
     */
    private function calculerNombreNuits($dateDebut, $dateFin)
    {
        $dateDebut = new DateTime($dateDebut);
        $dateFin = new DateTime($dateFin);
        $nombredeNuit = $dateDebut->diff($dateFin);
        $nombredeNuit = $nombredeNuit->format('%a');
        $nombredeNuit = intval($nombredeNuit);

        return $nombredeNuit;
    }
}