<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Intermédiaire</title>
    <?php
    include './src/Utils/head.php';
    ?>
</head>
<body data-bs-theme="dark">
    <header>
        <div class="container">
            <h1>PHP Intermédiaire</h1>
        </div>
    </header>
    <div class="container">
        <?php include './src/Widgets/navbar.php'; ?>
    </div>
    <main class="container">
        <section class="row">
            <article class="col-lg-8 offset-lg-2">
                <header>
                    <h2>Création d'un compte</h2>
                </header>
                <?php
                /* on a bien un type de compte */
                
                    /* selon le type de compte */
                                    
                    ?>
                    <h3>Le compte suivant a été enregistré : </h3>
                        <?php
                        
                        ?>
                    <p>
                        <a href="./classesetpdo.php"><button class="btn btn-outline-secondary btn-small" type="button">Retour à la page des comptes</button></a>
                    </p>
                    <?php
                /* sinon */
                    /* on récupère le type de compte ou c'est null */
                    
                    ?>
                    <form method="post">
                        <fieldset class="form-control my-2">
                            <legend>
                                Détenteur du compte
                            </legend>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="nom" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-control my-2">
                            <legend>Agence</legend>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="numagence">Numéro d'agence</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="numagence" id="numagence" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-control my-2">
                            <legend>
                                Détails du compte
                            </legend>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="type">Type compte</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="hidden" name="type" id="type" value="<?php  ?>" readonly />
                                    <?php ?>
                                </div>
                            </div>
                            <?php
                            /* selon le type de compte */
                                    /* un compte */
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Découvert autorisé</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="decouvert" id="decouvert" value="0" />
                                        </div>
                                    </div>
                                    <?php
                                    /* un compte chèque */
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Découvert autorisé</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="decouvert" id="decouvert" value="0" />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Numéro de carte</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" readonly class="form-control" name="numcarte" id="numcarte" value="<?php ?>" />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="codepin">Code secret</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" readonly class="form-control" name="codepin" id="codepin" value="<?php ?>" />
                                        </div>
                                    </div>
                                <?php
                                /* un compte intéret */
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="taux">Taux d'intérêts</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <select class="form-select" name="taux" id="taux">
                                                <option value="" selected>Choisir le taux d'intéret</option>
                                                <option value="0.015">1.5%</option>
                                                <option value="0.030">3%</option>
                                                <option value="0.050">5%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                /* le type de compte n'existe pas */
                                    ?>
                                    <script>
                                        //document.location.href = './classesetpdo.php';
                                    </script>
                                    <?php
                            
                            ?>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="solde">Solde</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" name="solde" id="solde" />
                                </div>
                            </div>
                        </fieldset>
                        <p>
                            <button class="btn btn-outline-success btn-small" type="submit">
                                Créer et enregistrer le compte
                            </button>
                            <button class="btn btn-outline-warning btn-small" type="reset">
                                Vider le formulaire
                            </button>
                            <a href="./classesetpdo.php"><button class="btn btn-outline-secondary btn-small" type="button">Annuler</button></a>
                        </p>
                    </form>
                <?php
                
                ?>
            </article>

        </section>
    </main>
    <?php
    include './src/Widgets/footer.php';
    ?>
</body>
</html>