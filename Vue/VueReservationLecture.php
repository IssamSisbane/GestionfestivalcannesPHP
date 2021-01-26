<?php $this->_t = 'ReservationLecture'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/reservation.css" rel="stylesheet"/>
<link href="Assets/css/tableaux.css" rel="stylesheet" />

<p class="name-welcome"><b>Voici</b> la liste des reservations (<?= count($reservations)?>)</p>

<?php
if ($reservations != null) {
?>
    

    <table>
        <thead>
            <th>id</th>
            <th>date De Debut</th>
            <th>Date De Fin</th>
            <th>Prix Final</th>
            <th>Nombre De Nuit</th>
            <th>Nom du Vip</th>
            <th>Nom de l'Hebergement</th>
        </thead>
        <tbody>

            <?php foreach ($reservations as $reservation) :  //lecture par ligne
            
                $so = serialize($reservation); // Génère une représentation stockable d'une valeur
                $soe = urlencode($so); //Encode une chaîne en URL

                if (isset($vips))
                {
                    foreach ($vips as $vip) :
                        if ($vip->get_id() == $reservation->get_idVip() && get_class($vip) == $reservation->get_type_vip())
                        {
                            break;
                        }
                    endforeach;
                }

            ?>

                <tr>

                    <td><?php echo ($reservation->get_id()); ?></td>
                    <td><?php echo ($reservation->get_dateDebut()); ?></td>
                    <td><?php echo ($reservation->get_dateFin()); ?></td>
                    <td><?php echo ($reservation->get_prixFinal()); ?></td>
                    <td><?php echo ($reservation->get_nombredeNuit()); ?></td>
                    <td><?php echo ($vip->get_nom()); ?></td>
                    <td><?php echo ($hebergement->get_nom()); ?></td>

                </tr>

            <?php endforeach ?>

        </tbody>
    </table>

<?php
} else {
?>
    <p>Aucune reservation n'a été ajoutée</p>
<?php
}
?>