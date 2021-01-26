<?php $this->_t = 'HebergementAffiche'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/hebergement.css" rel="stylesheet" />

<?php if ($_GET['action'] == "ajouter") { ?>
    <p class="name-welcome"><b>Ajout</b> d'un hebergement</p>
<?php }else{ ?>
    <p class="name-welcome"><b>Modification</b> de l'hebergement</p>
<?php } ?>
<div class="hebergements">
    <div class="item-carre-center">
        <div id="carre"></div>
        <a href="index.php?url=hebergement&action=supprimer&hebergement=<?= $hebergement->get_id() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?');">Supprimer</a>
    </div>
</div>


<form method="post">
    <input class="btn" type="submit" name="submitModif" id="valider" value="valider">
    <div class="form-hebergement">
        <div id="form-item">
            <div class="textbox">
                <label for="id">Id :</label>
                <input type="number" for="id" name="id" required value=<?php echo $hebergement->get_id(); ?>>
            </div>

            <div class="textbox">
                <label for="nom">Nom : </label>
                <input type="text" for="nom" name="nom" required value=<?php echo $hebergement->get_nom(); ?>>
            </div>
        </div>

        <div id="form-item">
            <label for="nom">Services proposés : </label>
            <?php

            $i = 0;

            foreach ($TousServices as $service) : // On parcourt tous les services


                if (isset($ServicesTrouve[$i]) && $service->get_id() == $ServicesTrouve[$i]->get_id()) // On coche les services proposés par l'hebergement
                { ?>
                    <div class="textbox">
                        <input type="checkbox" id="<?php echo $service->get_libelle(); ?>" name="service[]" value="<?php echo $service->get_libelle(); ?>" checked>
                        <label for="<?php echo $service->get_libelle(); ?>"><?php echo $service->get_libelle(); ?></label>
                    </div>
                <?php
                $i = $i+1;
                } else // On affiche decoché les services qui ne sont pas proposés par l'hebergement
                { ?>
                    <div class="textbox">
                        <input type="checkbox" id="<?php echo $service->get_libelle(); ?>" name="service[]" value="<?php echo $service->get_libelle(); ?>">
                        <label for="<?php echo $service->get_libelle(); ?>"><?php echo $service->get_libelle(); ?></label>
                    </div>
                <?php
                }
                ?>



            <?php endforeach; ?>
        </div>



        
        <div id="form-item">
            <div class="textbox">
                <label for="nombrePlacesDisponibles">Nombre de places disponibles : </label>
                <input type="number" for="nombrePlacesDisponibles" name="nombrePlacesDisponibles" required value=<?php echo $hebergement->get_nombrePlacesDisponibles(); ?>>
            </div>

            <div class="textbox">
                <label for="prixParNuit">Prix par nuit : </label>
                <input type="number" for="prixParNuit" name="prixParNuit" required value=<?php echo $hebergement->get_prixParNuit(); ?>>
            </div>

            <div class="textbox">
                <label id="type_hebergement_label" for="type_hebergement_choix">Choisir un type d'Hebergement':</label>
                <select for="type_hebergement_label" id="type_hebergement_choix" name="type_hebergement_choix" size='2' required>


                    <?php foreach ($TousTypesHebergement as $type) : {
                            if ($type->get_id() == $TypeTrouve->get_id()) { // on selectionne le type de l'hebergement et on affiche les autres
                    ?>
                                <option for="type_hebergement_choix" value="<?php echo $TypeTrouve->get_libelle(); ?>" selected><?php echo $TypeTrouve->get_libelle(); ?> </option>
                            <?php
                            } else {
                            ?>
                                <option for="type_hebergement_choix" value="<?php echo $type->get_libelle(); ?>"><?php echo $type->get_libelle(); ?> </option>
                    <?php
                            }
                        }
                    endforeach;
                    ?>
            </div>
        </div>
    </div>
</form>