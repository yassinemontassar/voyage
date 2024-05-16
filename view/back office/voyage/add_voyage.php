<?php

include('../../../controlleur/voyageC.php');
include('../../../modele/voyage.php');

// Créer une instance du contrôleur
$volC = new voyageC();
$erreur_msg = "";

if (
    isset($_POST["type"]) &&
    isset($_POST["date_depart"]) &&
    isset($_POST["date_arrivee"]) &&
    isset($_POST["destination"]) &&
    isset($_POST["compagnie_aerienne"]) &&
    isset($_POST["prix"])
) {
    // Continuer avec les autres validations des champs du formulaire
    if (
        !empty($_POST["type"]) &&
        !empty($_POST["date_depart"]) &&
        !empty($_POST["date_arrivee"]) &&
        !empty($_POST["destination"]) &&
        !empty($_POST["compagnie_aerienne"]) &&
        !empty($_POST["prix"])
    ) {
        // Création de l'objet Vol
        $vol = new Vol();
        $vol->setValues(
            $_POST["type"],
            $_POST["date_depart"],
            $_POST["date_arrivee"],
            $_POST["destination"],
            $_POST["compagnie_aerienne"],
            $_POST["prix"]
        );

        // Ajout du vol à la base de données
        $volC->addVol($vol);
        
        header('Location: liste_voyage.php');
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
    <title>Formulaire de Voyage</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
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
    <style>
        body {
            background-color: #0824c2; /* Bleu chic */
            font-family: 'Arial', sans-serif; /* Fonte stylée */
        }

        .card-header {
            background-color: #548ac9; /* Bleu foncé */
        }

        .form-group i {
            margin-right: 10px;
        }

        .btn-center {
            text-align: center;
        }
    </style>
</head>
<body class="bg-theme bg-theme1">
<div class="container mt-5">
    <h2 class="text-center">
        <a href="index.php" class="btn btn-primary">Liste des hébergements</a>
    </h2>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white">
                        <i class="fas fa-plane"></i> Formulaire de Voyage
                    </div>
                    <div class="card-body">
                    <form action="add_voyage.php" method="POST" id="voyageForm">
                                <div class="form-group">
                                    <label for="type"><i class="fas fa-tag"></i> Type de Voyage</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="">Sélectionnez le type</option>
                                        <option value="Économique">Économique</option>
                                        <option value="Business">Business</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_depart"><i class="fas fa-calendar-alt"></i> Date de Départ</label>
                                    <input type="date" class="form-control" id="date_depart" name="date_depart" placeholder="Date de départ">
                                </div>
                                <div class="form-group">
                                    <label for="date_arrivee"><i class="fas fa-calendar-alt"></i> Date d'Arrivée</label>
                                    <input type="date" class="form-control" id="date_arrivee" name="date_arrivee" placeholder="Date d'arrivée">
                                </div>
                                <div class="form-group">
                                    <label for="destination"><i class="fas fa-tag"></i>Destination</label>
                                    <select class="form-control" id="destination" name="destination">
                                        <option value="">Sélectionnez une destination</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Roma">Roma</option>
                                        <option value="France">France</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Dubai">Dubai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="compagnie_aerienne"><i class="fas fa-tag"></i>Compagnie Aérienne</label>
                                    <select class="form-control" id="compagnie_aerienne" name="compagnie_aerienne">
                                        <option value="">Sélectionnez une compagnie aérienne</option>
                                        <option value="Tunisair">Tunisair</option>
                                        <option value="Transavia">Transavia</option>
                                        <option value="Qatar Airways">Qatar Airways</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="prix"><i class="fas fa-money-bill"></i> Prix</label>
                                    <input type="number" class="form-control" id="prix" name="prix" placeholder="Prix du voyage" readonly>
                                </div>
                                <div class="form-group btn-center">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Ajouter Voyage</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
//Mettre le Prix automatiquement
document.addEventListener("DOMContentLoaded", function(){
    var typeSelect = document.getElementById("type");
    var destinationSelect = document.getElementById("destination");
    var compagnieSelect = document.getElementById("compagnie_aerienne");
    var prixInput = document.getElementById("prix");
    typeSelect.addEventListener("change", updatePrix);
    destinationSelect.addEventListener("change", updatePrix);
    compagnieSelect.addEventListener("change", updatePrix);
    function updatePrix(){
        var selectedDestination = destinationSelect.value;
        var selectedCompagnie = compagnieSelect.value;
        var selectedtype = typeSelect.value;
        var prix = 0;
        switch(selectedDestination){
            case "Roma":
                prix = 400;
                break;
            case "France":
                prix = 400;
                break;
            case "Greece":
                prix = 400;
            case "Dubai":
                prix = 600;
                break;
            case "Maldives":
                prix = 700;
                break;
                break;
            case "Canada":
                prix = 1000;
                break;
        }
        switch(selectedCompagnie){
            case "Tunisair":
                prix *= 1;
                break;
            case "Transavia":
                prix *= 1.5;
                break;
            case "Qatar Airways":
                prix *= 2;
                break;
        }
        switch(selectedtype){
            case "Business":
                prix *= 2;
                break;
            case "Économique":
                prix *= 1;
                break;
        }
        prixInput.value = prix.toFixed(2);
    }
});
</script>

</body>
</html>
