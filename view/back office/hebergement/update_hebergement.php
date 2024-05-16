<?php
include '../../../controlleur/hebergementC.php'; // Assurez-vous que le chemin vers votre fichier est correct
include '../../../modele/hebergement.php'; // Assurez-vous que le chemin vers votre fichier est correct

// Créer une instance du contrôleur d'hébergement
$hebergementC = new HebergementC();

// Créer un hébergement
$hebergement = null;

// Vérifier si le formulaire a été soumis
if (isset($_POST["submit"])) {
    // Vérifier la présence des champs requis
    if (
        isset($_POST["hebergement"]) &&
        isset($_POST["date_depart"]) &&
        isset($_POST["date_arrivee"]) &&
        isset($_POST["adulte"]) &&
        isset($_POST["enfant"]) &&
        isset($_POST["chambre"]) &&
        isset($_POST["lieu"]) &&
        isset($_POST["categorie"])
    ) {
        // Vérifier que les champs requis ne sont pas vides
        if (
            !empty($_POST['hebergement']) &&
            !empty($_POST["date_depart"]) &&
            !empty($_POST["date_arrivee"]) &&
            !empty($_POST["adulte"]) &&
            !empty($_POST["enfant"]) &&
            !empty($_POST["chambre"]) &&
            !empty($_POST["lieu"]) &&
            !empty($_POST["categorie"])
        ) {
            // Utiliser les noms de paramètres corrects lors de la création de l'objet Hebergement
            $hebergement = new Hebergement();
            $hebergement->setValues(
                $_POST['hebergement'],
                $_POST['date_depart'],
                $_POST['date_arrivee'],
                $_POST['adulte'],
                $_POST['enfant'],
                $_POST['chambre'],
                $_POST['lieu'], // Ajout du lieu
                $_POST['categorie'], // Ajout de la catégorie
                NULL,
                NULL
            );

            // Ajouter les champs supplémentaires pour l'hébergement (lieu et catégorie)
            $hebergement->setLieu($_POST['lieu']);
            $hebergement->setCategorie($_POST['categorie']);

            // Mettre à jour l'hébergement dans la base de données
            $hebergementC->updateHebergement($hebergement, $_POST['id_hebergement']);

            // Rediriger vers la liste des hébergements après la mise à jour
            header('Location:index.php');
            exit();
        }
    }
}

// Récupérer les données de l'hébergement à partir de la base de données
if (isset($_GET['id_hebergement'])) {
    $oldHebergement = $hebergementC->showHebergement($_GET['id_hebergement']);
} else {
    // Gérer le cas où l'ID de l'hébergement n'est pas défini
    echo "ID de l'hébergement non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un hébergement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Liste des hébergements</title>
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet" />
  <script src="assets/js/pace.min.js"></script>
  <!--favicon-->
  <link rel="icon" type="image/x-icon">
  <!-- Vector CSS -->
  <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <!-- simplebar CSS-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
  <!-- Sidebar CSS-->
  <link href="assets/css/sidebar-menu.css" rel="stylesheet" />
  <!-- Custom Style-->
  <link href="assets/css/app-style.css" rel="stylesheet" />
</head>

<body class="bg-theme bg-theme1">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Modifier un hébergement</h3>
                    </div>
                    <div class="card-body">
                        <form id="updateHebergementForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <input type="hidden" name="id_hebergement" value="<?php echo $_GET['id_hebergement']; ?>">
                            <div class="text-center mt-3">
                                <a href="index.php" class="btn btn-primary">Retour à la liste</a>
                            </div>
                            <div class="form-group">
                                <label for="type">Type d'hébergement:</label>
                                <select class="form-control" id="type" name="hebergement">
                                    <option value="">Sélectionnez un type</option>
                                    <option value="hotel" <?php echo ($oldHebergement['hebergement'] === 'hotel') ? 'selected' : ''; ?>>Hôtel</option>
                                    <option value="maison_hote" <?php echo ($oldHebergement['hebergement'] === 'maison_hote') ? 'selected' : ''; ?>>Maison d'hôte</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_depart">Date de Départ:</label>
                                <input type="date" class="form-control" id="date_depart" name="date_depart" value="<?php echo isset($_POST['date_depart']) ? $_POST['date_depart'] : $oldHebergement['date_depart']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_arrivee">Date d'Arrivée:</label>
                                <input type="date" class="form-control" id="date_arrivee" name="date_arrivee" value="<?php echo isset($_POST['date_arrivee']) ? $_POST['date_arrivee'] : $oldHebergement['date_arrivee']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="adulte">Nombre d'adultes:</label>
                                <input type="number" class="form-control" id="adulte" name="adulte" value="<?php echo isset($_POST['adulte']) ? $_POST['adulte'] : $oldHebergement['adulte']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="enfant">Nombre d'enfants:</label>
                                <input type="number" class="form-control" id="enfant" name="enfant" value="<?php echo isset($_POST['enfant']) ? $_POST['enfant'] : $oldHebergement['enfant']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="chambre">Nombre de chambres:</label>
                                <input type="number" class="form-control" id="chambre" name="chambre" value="<?php echo isset($_POST['chambre']) ? $_POST['chambre'] : $oldHebergement['chambre']; ?>">
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
                                <label for="categorie">Catégorie:</label>
                                <select class="form-control" id="categorie" name="categorie">
                                    <option value="">Sélectionnez une catégorie</option>
                                    <option value="1 étoile" <?php echo ($oldHebergement['categorie'] === '1 étoile') ? 'selected' : ''; ?>>1 étoile</option>
                                    <option value="2 étoiles" <?php echo ($oldHebergement['categorie'] === '2 étoiles') ? 'selected' : ''; ?>>2 étoiles</option>
                                    <option value="3 étoiles" <?php echo ($oldHebergement['categorie'] === '3 étoiles') ? 'selected' : ''; ?>>3 étoiles</option>
                                    <option value="4 étoiles" <?php echo ($oldHebergement['categorie'] === '4 étoiles') ? 'selected' : ''; ?>>4 étoiles</option>
                                    <option value="5 étoiles" <?php echo ($oldHebergement['categorie'] === '5 étoiles') ? 'selected' : ''; ?>>5 étoiles</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit" style="margin-bottom:1rem;">Enregistrer</button>
                        </form>
                        <a href="index.php"><button class="btn btn-primary">Annuler</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
function validateForm() {
    // Récupérer les valeurs des champs
    var type = document.getElementById("type").value;
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
    if (type === "" || dateDepart === "" || dateArrivee === "" || adulte === "" || enfant === "" || chambre === "" || lieu === "" || categorie === "") {
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
        alert("La date de départ doit être à partir de demain.");
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
        </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>