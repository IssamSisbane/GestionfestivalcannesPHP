<?php $this->_t = 'VipAjout'; ?>

<link href="Assets/css/style.css" rel="stylesheet" />
<link href="Assets/css/vip.css" rel="stylesheet" />

<?php
    if ($class == 'MembreEquipe')
    {
        if (isset($elements))
        {
?>
        <h1>Ajout Membre d'equipe</h1>

        <form method="post">

            <input class="btn" type="submit" name="submitAjout" id="valider" value="valider">

            <div class="form-vips">
                <div id="form-item">
                    <div class="textbox">
                        <label for="id">Id : </label>
                        <input type="text" for="id" name="id" value=<?= $NouvelId ?> required>
                    </div>
                </div>
                
                <div id="form-item">
                    <div class="textbox">
                        <label for="nom">Nom : </label>
                        <input type="text" for="nom" name="nom" required>
                    </div>

                    <div class="textbox">
                        <label for="prenom">Prenom : </label>
                        <input type="text" for="prenom" name="prenom" required>
                    </div>

                    <div class="textbox">
                        <label for="dateNaissance">Date de Naissance : </label>
                        <input type="date" for="dateNaissance" name="dateNaissance" min="1920-01-01" max="2003-01-01" required>
                    </div>
                </div>

                <div id="form-item">
                    <div class="textbox">
                        <label for="Service_Hebergement">Service Hebergement</label>
                        <input type="checkbox" id="Service_Hebergement" name="Service_Hebergement" value="Service Hebergement">
                    </div>
                    <div>
                        <label for="film">Choisir Le Film :</label>
                        <select id="film" name="special" size=4>

                        <?php foreach($elements as $film) :?>
                                    <option for="film" value="<?= $film->get_titre() ?>"><?= $film->get_titre() ?> </option>
                        <?php endforeach; ?>
                    </div>
                </div>
                <input type="hidden" for="class" name="class" required value=<?php echo $class; ?>>
            </div>
        </form>

<?php
        }
    }
    if ($class == 'MembreJury')
    {
?>   
        <h1>Ajout Membre de Jury</h1>

        <form method="post">

            <input class="btn" type="submit" name="submitAjout" id="valider" value="valider">

            <div class="form-vips">
                <div id="form-item">
                    <div class="textbox">
                        <label for="id">Id : </label>
                        <input type="text" for="id" name="id" value=<?= $NouvelId ?> required>
                    </div>
                </div>

                <div id="form-item">
                    <div class="textbox">
                        <label for="nom">Nom : </label>
                        <input type="text" for="nom" name="nom" required>
                    </div>

                    <div class="textbox">
                        <label for="prenom">Prenom : </label>
                        <input type="text" for="prenom" name="prenom" required>
                    </div>

                    <div class="textbox">
                        <label for="dateNaissance">Date de Naissance : </label>
                        <input type="date" for="dateNaissance" name="dateNaissance" min="1920-01-01" max="2003-01-01" required>
                    </div>
                </div>

                <div id="form-item">
                    <div class="textbox">
                        <label for="Service_Hebergement">Service Hebergement : </label>
                        <input type="checkbox" id="Service_Hebergement" name="Service_Hebergement" value="Service Hebergement">
                    </div>

                    <div>
                        <label for="jury">Choisir Le Jury :</label>
                        <select id="jury" name="special" size="5" >

                        <?php foreach($elements as $jury) :?>
                                    <option value="<?= $jury->get_libelle() ?>"><?= $jury->get_libelle() ?> </option>
                        <?php endforeach; ?>
                    </div>

                    </div>
                        <input type="hidden" for="class" name="class" required value=<?php echo $class; ?>>
                    <div>
                </div>


        </form>

<?php
    }
    if ($class == 'Invite')
    {
?>
        <h1>Ajout Invite</h1>
        <form method="post">
            
            <input class="btn" type="submit" name="submitAjout" id="valider" value="valider">
            
            <div class="form-vips">
                <div id="form-item">
                    <div class="textbox">
                        <label for="id">Id : </label>
                        <input type="text" for="id" name="id" value=<?= $NouvelId ?> required>
                    </div>
                </div>

                <div id="form-item">
                    <div class="textbox">
                        <label for="nom">Nom : </label>
                        <input type="text" for="nom" name="nom" required>
                    </div>

                    <div class="textbox">
                        <label for="prenom">Prenom : </label>
                        <input type="text" for="prenom" name="prenom" required>
                    </div>

                    <div class="textbox">
                        <label for="dateNaissance">Date de Naissance : </label>
                        <input type="date" for="dateNaissance" name="dateNaissance" min="1920-01-01" max="2003-01-01" required>
                    </div>
                </div>

                <div id="form-item">
                    <div class="textbox">
                        <label for="Service_Hebergement">Service Hebergement : </label>
                        <input type="checkbox" id="Service_Hebergement" name="Service_Hebergement" value="Service Hebergement">
                    </div>
                </div>

                    </div>
                        <input type="hidden" for="class" name="class" required value=<?php echo $class; ?>>
                    <div>


        </form>

<?php } ?>