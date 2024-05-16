<?php
include '../../controlleur/hebergementC.php'; // Assurez-vous que le chemin vers votre fichier est correct
include '../../modele/hebergement.php'; // Assurez-vous que le chemin vers votre fichier est correct

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
                null,
                null
            );

            // Ajouter les champs supplémentaires pour l'hébergement (lieu et catégorie)
            $hebergement->setLieu($_POST['lieu']);
            $hebergement->setCategorie($_POST['categorie']);

            // Mettre à jour l'hébergement dans la base de données
            $hebergementC->updateHebergement($hebergement, $_POST['id_hebergement']);

            // Rediriger vers la liste des hébergements après la mise à jour
            header('Location:liste_hebergement.php');
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
    <style>
        /* Styles CSS pour le fond d'écran semi-transparent */
        body {
            background-image: url('maldives1.jpg');/* Remplacez 'chemin/vers/votre/image.jpg' par le chemin de votre image */
            background-size: cover; /* Pour couvrir toute la page avec l'image */
            font-family: 'Arial', sans-serif; /* Fonte stylée */
            color: white; /* Texte blanc */
        }

        .card {
            background-color: rgba(255, 255, 255, 0.5); /* Fond semi-transparent pour la carte */
        }

        .form-group {
            margin-bottom: 1rem; /* Espacement entre les éléments du formulaire */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Modifier un hébergement</h3>
                    </div>
                    <div class="card-body">
                        <form id="updateHebergementForm" action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_hebergement" value="<?php echo $_GET['id_hebergement']; ?>">
                            <div class="text-center mt-3">
                                <a href="liste_hebergement.php" class="btn btn-secondary">Retour à la liste</a>
                            </div>
                            <div class="form-group">
                                <label for="hebergement">Type d'hébergement:</label>
                                <select class="form-control" id="hebergement" name="hebergement">
                                    <option value="Maison d'hôte" <?php echo ($oldHebergement['hebergement'] === "Maison d'hôte") ? 'selected' : ''; ?>>Maison d'hôte</option>
                                    <option value="Hôtel" <?php echo ($oldHebergement['hebergement'] === "Hôtel") ? 'selected' : ''; ?>>Hôtel</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_depart">Date de départ:</label>
                                <input type="date" class="form-control" id="date_depart" name="date_depart" value="<?php echo isset($_POST['date_depart']) ? $_POST['date_depart'] : $oldHebergement['date_depart']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_arrivee">Date d'arrivée:</label>
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
                                <label for="lieu">Lieu:</label>
                                <select class="form-control" id="lieu" name="lieu">
                                    <option value="Maldive" <?php echo ($oldHebergement['lieu'] === 'Maldive') ? 'selected' : ''; ?>>Maldive</option>
                                    <option value="Roma" <?php echo ($oldHebergement['lieu'] === 'Roma') ? 'selected' : ''; ?>>Roma</option>
                                    <option value="France" <?php echo ($oldHebergement['lieu'] === 'France') ? 'selected' : ''; ?>>France</option>
                                    <option value="Greece" <?php echo ($oldHebergement['lieu'] === 'Greece') ? 'selected' : ''; ?>>Greece</option>
                                    <option value="Canada" <?php echo ($oldHebergement['lieu'] === 'Canada') ? 'selected' : ''; ?>>Canada</option>
                                    <option value="Dubai" <?php echo ($oldHebergement['lieu'] === 'Dubai') ? 'selected' : ''; ?>>Dubai</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categorie">Catégorie:</label>
                                <select class="form-control" id="categorie" name="categorie">
                                    <option value="1 étoile" <?php echo ($oldHebergement['categorie'] === '1 étoile') ? 'selected' : ''; ?>>1 étoile</option>
                                    <option value="2 étoiles" <?php echo ($oldHebergement['categorie'] === '2 étoiles') ? 'selected' : ''; ?>>2 étoiles</option>
                                    <option value="3 étoiles" <?php echo ($oldHebergement['categorie'] === '3 étoiles') ? 'selected' : ''; ?>>3 étoiles</option>
                                    <option value="4 étoiles" <?php echo ($oldHebergement['categorie'] === '4 étoiles') ? 'selected' : ''; ?>>4 étoiles</option>
                                    <option value="5 étoiles" <?php echo ($oldHebergement['categorie'] === '5 étoiles') ? 'selected' : ''; ?>>5 étoiles</option>
                                </select>
                            </div>
                            <!-- Ajoutez ici les autres champs pour les attributs supplémentaires de l'objet Hebergement -->
                            <!-- Par exemple: -->
                            <!-- <div class="form-group">
                                <label for="autre_attribut">Autre attribut:</label>
                                <input type="text" class="form-control" id="autre_attribut" name="autre_attribut" value="<?php echo isset($_POST['autre_attribut']) ? $_POST['autre_attribut'] : $oldHebergement['autre_attribut']; ?>">
                            </div> -->
                            <button type="submit" class="btn btn-primary" name="submit">Enregistrer</button>
                        </form>
                        <a href="liste_hebergement.php"><button class="btn btn-primary">Annuler</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('updateHebergementForm');

            form.addEventListener('submit', function(event) {
                var hebergement = document.getElementById('hebergement').value;
                var dateDepart = document.getElementById('date_depart').value;
                var dateArrivee = document.getElementById('date_arrivee').value;
                var adulte = document.getElementById('adulte').value;
                var enfant = document.getElementById('enfant').value;
                var chambre = document.getElementById('chambre').value;
                var lieu = document.getElementById('lieu').value;
                var categorie = document.getElementById('categorie').value;

                var errorMessage = '';

                if (hebergement.trim() === '') {
                    errorMessage += 'Le type d\'hébergement est requis.\n';
                }

                if (dateDepart.trim() === '') {
                    errorMessage += 'La date de départ est requise.\n';
                }

                if (dateArrivee.trim() === '') {
                    errorMessage += 'La date d\'arrivée est requise.\n';
                }

                if (adulte.trim() === '' || adulte < 1) {
                    errorMessage += 'Le nombre d\'adultes doit être supérieur à zéro.\n';
                }

                if (enfant.trim() < 0) {
                    errorMessage += 'Le nombre d\'enfants ne peut pas être négatif.\n';
                }

                if (chambre.trim() === '' || chambre < 1) {
                    errorMessage += 'Le nombre de chambres doit être supérieur à zéro.\n';
                }

                if (lieu.trim() === '') {
                    errorMessage += 'Le lieu est requis.\n';
                }

                if (categorie.trim() === '') {
                    errorMessage += 'La catégorie est requise.\n';
                }

                if (errorMessage !== '') {
                    alert(errorMessage);
                    event.preventDefault(); // Empêcher la soumission du formulaire
                }
            });
        });
    </script>
</body>

</html>