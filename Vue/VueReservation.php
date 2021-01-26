<?php $this->_t = 'Reservation'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/reservation.css" rel="stylesheet"/>
<link href="Assets/css/tableaux.css" rel="stylesheet" />




<?php
if ($reservations != null) {
?>

<p class="name-welcome"><b>Voici</b> la liste des reservations (<?= count($reservations)?>)</p>

<div class="boutonsRESERVATION">
    <a id="ajouter" href="index.php?url=reservation&action=ajouter">Ajouter</a>
</div>

    <table>
        <thead>
            <th>id</th>
            <th>date De Debut</th>
            <th>Date De Fin</th>
            <th>Prix Final</th>
            <th>Nombre De Nuit</th>
            <th>Nom du Vip</th>
            <th>Nom de l'Hebergement</th>
            <th>actions</th>
        </thead>
        <tbody>

            <?php foreach ($reservations as $reservation) :  //lecture par ligne
                if (isset($vips))
                {
                    foreach ($vips as $vip) :
                        if ($vip->get_id() == $reservation->get_idVip() && get_class($vip) == $reservation->get_type_vip())
                        {
                            break;
                        }
                    endforeach;
                }

                if (isset($hebergements))
                {
                    foreach ($hebergements as $hebergement) :
                        if ($hebergement->get_id() == $reservation->get_idHebergement())
                        {
                            break;
                        }
                    endforeach;
                }

                $so = serialize($reservation); // Génère une représentation stockable d'une valeur
                $soe = urlencode($so);
            ?>

                <tr>

                    <td><?php echo ($reservation->get_id()); ?></td>
                    <td><?php echo ($reservation->get_dateDebut()); ?></td>
                    <td><?php echo ($reservation->get_dateFin()); ?></td>
                    <td><?php echo ($reservation->get_prixFinal()); ?></td>
                    <td><?php echo ($reservation->get_nombredeNuit()); ?></td>
                    <td><?php echo ($vip->get_nom()); ?></td>
                    <td><?php echo ($hebergement->get_nom()); ?></td>

                    <td>
                        <a href="index.php?url=reservation&action=modifier&reservation=<?= $soe ?>">Modifier</a>
                        <a href="index.php?url=reservation&action=supprimer&reservation=<?= $reservation->get_id() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?');">Supprimer</a>
                    </td>

                </tr>

            <?php endforeach ?>

        </tbody>
    </table>

<?php
} else {
?>
    <h1>Aucune reservation n'a été ajoutée</h1>
<?php
}
?>