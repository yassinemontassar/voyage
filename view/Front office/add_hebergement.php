<?php

include('../../controlleur/hebergementC.php');
include('../../controlleur/voyageC.php');
include('../../modele/hebergement.php');
include('../../modele/voyage.php');

// Créer une instance du contrôleur
$hebergementC = new HebergementC();
$voyageC = new voyageC();
$idVols = $voyageC->getAllIdVol();
function getAllIdAct() {
    try {
        $db = config::getConnexion();
        $query = "SELECT ida FROM activites";
        $statement = $db->prepare($query);
        $statement->execute();
        $idVols = $statement->fetchAll(PDO::FETCH_COLUMN);
        return $idVols;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        return false;
    }
}
$idActs = getAllIdAct();
$erreur_msg = "";
if (
    isset($_POST["hebergement"]) &&
    isset($_POST["date_depart"]) &&
    isset($_POST["date_arrivee"]) &&
    isset($_POST["adulte"]) &&
    isset($_POST["enfant"]) &&
    isset($_POST["chambre"]) &&
    isset($_POST["lieu"]) &&
    isset($_POST["categorie"]) &&
    isset($_POST["id_vol"]) &&
    isset($_POST["ida"])
) {
    // Continuer avec les autres validations des champs du formulaire
    if (
        !empty($_POST["hebergement"]) &&
        !empty($_POST["date_depart"]) &&
        !empty($_POST["date_arrivee"]) &&
        !empty($_POST["adulte"]) &&
        !empty($_POST["enfant"]) &&
        !empty($_POST["chambre"]) &&
        !empty($_POST["lieu"]) &&
        !empty($_POST["categorie"]) &&
        !empty($_POST["id_vol"]) &&
        !empty($_POST["ida"])
    ) {
        // Création de l'objet Hebergement
        $hebergement = new Hebergement();
        $hebergement->setValues(
            $_POST["hebergement"],
            $_POST["date_depart"],
            $_POST["date_arrivee"],
            $_POST["adulte"],
            $_POST["enfant"],
            $_POST["chambre"],
            $_POST["lieu"],
            $_POST["categorie"],
            $_POST["id_vol"],
            $_POST["ida"]
        );

        // Ajout de l'hébergement à la base de données
        $hebergementC->addHebergement($hebergement);

        header('Location: liste_hebergement.php');
        exit();
    } else {
        // Afficher un message d'erreur si les champs obligatoires ne sont pas tous remplis
        $erreur_msg .= 'Erreur : Veuillez remplir tous les champs obligatoires.<br>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Hébergement</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('maldives1.jpg');
            background-size: cover;
            font-family: 'Arial', sans-serif;
            color: black; /* Pour assurer une meilleure visibilité du texte */
        }

        .card {
            background-color: rgba(255, 255, 255, 0.5); /* Couleur de fond transparente pour le formulaire */
        }

        .card-header {
            background-color: rgba(56, 100, 221, 0.8); /* Fond semi-transparent pour le titre */
        }

        .form-group i {
            margin-right: 10px;
        }

        .btn-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <h2 class="text-center">
            <a href="liste_hebergement.php" class="btn btn-primary">Liste des hebergement </a>
        </h2>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-white">
                            <i class="fas fa-hotel"></i> Formulaire d'Hébergement
                        </div>
                        <div class="card-body">

                            <form action="" method="POST" id="hebergementForm">
                                <div class="form-group">
                                    <label for="hebergement"><i class="fas fa-tag"></i> Type d'Hébergement</label>
                                    <select class="form-control" id="hebergement" name="hebergement">
                                        <option value="Hôtel">Hôtel</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_depart"><i class="fas fa-calendar-alt"></i> Date de Début</label>
                                    <input type="date" class="form-control" id="date_depart" name="date_depart" placeholder="Date de début">
                                </div>
                                <div class="form-group">
                                    <label for="date_arrivee"><i class="fas fa-calendar-alt"></i> Date de Fin</label>
                                    <input type="date" class="form-control" id="date_arrivee" name="date_arrivee" placeholder="Date de fin">
                                </div>
                                <div class="form-group">
                                    <label for="adulte"><i class="fas fa-users"></i> Nombre d'Adultes</label>
                                    <input type="number" class="form-control" id="adulte" name="adulte" placeholder="Nombre d'adultes">
                                </div>
                                <div class="form-group">
                                    <label for="enfant"><i class="fas fa-child"></i> Nombre d'Enfants</label>
                                    <input type="number" class="form-control" id="enfant" name="enfant" placeholder="Nombre d'enfants">
                                </div>
                                <div class="form-group">
                                    <label for="chambre"><i class="fas fa-bed"></i> Nombre de Chambres</label>
                                    <input type="number" class="form-control" id="chambre" name="chambre" placeholder="Nombre de chambres">
                                </div>
                                <div class="form-group">
                                    <label for="id_vol"><i class="fas fa-tag"></i>Id Vol</label>
                                    <select class="form-control" id="id_vol" name="id_vol">
                                        <option value="">Sélectionnez un id vol</option>
                                        <?php
                                            foreach ($idVols as $idVol) {
                                                echo '<option value="' . $idVol . '">' . $idVol . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ida"><i class="fas fa-tag"></i>Id Activites</label>
                                    <select class="form-control" id="ida" name="ida">
                                        <option value="">Sélectionnez un id Activite</option>
                                        <?php
                                            foreach ($idActs as $idAct) {
                                                echo '<option value="' . $idAct . '">' . $idAct . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="lieu"><i class="fas fa-map-marker-alt"></i> Lieu</label>
                                    <select class="form-control" id="lieu" name="lieu">
                                        <option value="">Sélectionnez un lieu</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Roma">Roma</option>
                                        <option value="France">France</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Dubai">Dubai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="categorie"><i class="fas fa-clipboard-list"></i> Catégorie</label>
                                    <select class="form-control" id="categorie" name="categorie">
                                        <option value="">Sélectionnez une catégorie</option>
                                        <option value="1 étoile">1 étoile</option>
                                        <option value="2 étoiles">2 étoiles</option>
                                        <option value="3 étoiles">3 étoiles</option>
                                        <option value="4 étoiles">4 étoiles</option>
                                        <option value="5 étoiles">5 étoiles</option>
                                    </select>
                                </div>
                                <div class="form-group btn-center">
                                    <button type="button" class="btn btn-primary" id="submitBtn">Ajouter Hébergement</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script>
    function validateForm() {
        // Récupérer les valeurs des champs
        var hebergement = document.getElementById("hebergement").value;
        var dateDepart = document.getElementById("date_depart").value;
        var dateArrivee = document.getElementById("date_arrivee").value;
        var adulte = document.getElementById("adulte").value;
        var enfant = document.getElementById("enfant").value;
        var chambre = document.getElementById("chambre").value;
        var lieu = document.getElementById("lieu").value;
        var categorie = document.getElementById("categorie").value;

        // Récupérer la date actuelle
        var currentDate = new Date(); // Date actuelle

        // Vérifier si les champs obligatoires sont vides
        if (hebergement === "" || dateDepart === "" || dateArrivee === "" || adulte === "" || enfant === "" || chambre === "" || lieu === "" || categorie === "") {
            alert("Veuillez remplir tous les champs obligatoires.");
            return false;
        }

        // Vérifier si les valeurs numériques sont valides
        if (isNaN(adulte) || isNaN(enfant) || isNaN(chambre) || adulte < 0 || enfant < 0 || chambre < 0) {
            alert("Les nombres d'adultes, d'enfants et de chambres doivent être des valeurs numériques positives.");
            return false;
        }

        // Vérifier que la date de départ est dans le futur
        var departureDate = new Date(dateDepart); // Date de départ du formulaire
        if (departureDate <= currentDate) {
            alert("La date de départ doit être a partir de demain .");
            return false;
        }

        // Vérifier que la date de départ est antérieure à la date d'arrivée
        if (departureDate >= new Date(dateArrivee)) {
            alert("La date de départ doit être antérieure à la date d'arrivée.");
            return false;
        }

        // Le formulaire est valide, permettre la soumission
        return true;
    }
    document.getElementById("submitBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Empêcher le comportement par défaut du bouton
        if(validateForm()){
            if (confirm("Confirmez-vous l'ajout de cet hébergement ?")) {
                document.getElementById("hebergementForm").submit(); // Soumettre le formulaire si l'utilisateur clique sur "OK"
            }
        }
    });
        </script>
</body>

</html>