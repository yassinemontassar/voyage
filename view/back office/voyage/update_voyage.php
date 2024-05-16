<?php

include '../../../controlleur/voyageC.php'; // Assurez-vous que le chemin vers votre fichier est correct
include '../../../modele/voyage.php'; // Assurez-vous que le chemin vers votre fichier est correct

// Créer une instance du contrôleur de voyage
$volC = new voyageC();

// Créer un vol
$vol = null;

// Vérifier si le formulaire a été soumis
if (isset($_POST["submit"])) {
    // Vérifier la présence des champs requis
    if (
        isset($_POST["type"]) &&
        isset($_POST["date_depart"]) &&
        isset($_POST["date_arrivee"]) &&
        isset($_POST["prix"])
    ) {
        // Vérifier que les champs requis ne sont pas vides
        if (
            !empty($_POST['type']) &&
            !empty($_POST["date_depart"]) &&
            !empty($_POST["date_arrivee"]) &&
            !empty($_POST["prix"])
        ) {
            // Utiliser les noms de paramètres corrects lors de la création de l'objet Vol
            $vol = new Vol();
            $vol->setValues(
                $_POST['type'],
                $_POST['date_depart'],
                $_POST['date_arrivee'],
                NULL,
                NULL,
                $_POST['prix']
            );

            // Mettre à jour le vol dans la base de données
            $volC->updateVol($vol, $_POST['id_vol']);

            // Rediriger vers la liste des vols après la mise à jour
            header('Location:index.php');
        }
    }
}

// Récupérer les données du vol à partir de la base de données
if (isset($_GET['id_vol'])) {
    $oldVol = $volC->showVol($_GET['id_vol']);
} else {
    // Gérer le cas où l'ID du vol n'est pas défini
    echo "ID du vol non spécifié.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                        <h3 class="mb-0">Update Vol</h3>
                    </div>
                    <div class="card-body">
                        <form id="updateVolForm" action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_vol" value="<?php echo $_GET['id_vol']; ?>">
                            <div class="text-center mt-3">
                                <a href="index.php" class="btn btn-primary">Back to list</a>
                            </div>
                            <div class="form-group">
                                <label for="type">Type:</label>
                                <input type="text" class="form-control" id="type" name="type"
                                    value="<?php echo isset($_POST['type']) ? $_POST['type'] : $oldVol['type']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_depart">Date de Départ:</label>
                                <input type="date" class="form-control" id="date_depart" name="date_depart"
                                    value="<?php echo isset($_POST['date_depart']) ? $_POST['date_depart'] : $oldVol['date_depart']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_arrivee">Date d'Arrivée:</label>
                                <input type="date" class="form-control" id="date_arrivee" name="date_arrivee"
                                    value="<?php echo isset($_POST['date_arrivee']) ? $_POST['date_arrivee'] : $oldVol['date_arrivee']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="prix">Prix:</label>
                                <input type="number" class="form-control" id="prix" name="prix"
                                    value="<?php echo isset($_POST['prix']) ? $_POST['prix'] : $oldVol['prix']; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit"
                                style="margin-bottom:1rem;">Save</button>
                        </form>
                        <a href="index.php"><button class="btn btn-primary">Cancel</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('updateVolForm');

            form.addEventListener('submit', function (event) {
                var type = document.getElementById('type').value;
                var dateDepart = document.getElementById('date_depart').value;
                var dateArrivee = document.getElementById('date_arrivee').value;
                var prix = document.getElementById('prix').value;

                var errorMessage = '';

                if (type.trim() === '') {
                    errorMessage += 'Type field is required.\n';
                }

                if (dateDepart.trim() === '') {
                    errorMessage += 'Departure date field is required.\n';
                }

                if (dateArrivee.trim() === '') {
                    errorMessage += 'Arrival date field is required.\n';
                }

                if (prix.trim() === '') {
                    errorMessage += 'Price field is required.\n';
                }

                if (errorMessage !== '') {
                    alert(errorMessage);
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>

</body>

</html>