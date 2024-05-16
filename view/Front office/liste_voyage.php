<?php
include "../../controlleur/voyageC.php";

$c = new voyageC();
$tab = $c->listVols();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="style4.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Liste des vols</title>
    <style>
        body {
            background-image: url('maldives1.jpg');/* Remplacez 'votre-image.jpg' par l'URL de votre image */
            background-size: cover;
            font-family: 'Arial', sans-serif; /* Fonte stylée */
            color: white; /* Texte blanc */
        }

        .custom-table {
            background-color: rgba(0, 0, 0, 0.5); /* Rendre le fond de la table semi-transparent */
            color: white; /* Texte blanc */
        }

        .custom-table th,
        .custom-table td {
            border-color: white; /* Bordures blanches */
        }

        .custom-table th {
            font-weight: bold; /* Texte en gras pour les en-têtes */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Liste des vols</h1>
        <h2 class="text-center">
            <a href="add_voyage.php" class="btn btn-primary">Ajouter un vol</a>
        </h2>

        <table class="table custom-table">
            <thead class="thead-dark">
                <tr>
                    <th>Id Vol</th>
                    <th>Type</th>
                    <th>Date de Départ</th>
                    <th>Date d'Arrivée</th>
                    <th>Destination</th>
                    <th>Compagnie Aérienne</th>
                    <th>Prix</th>
                    <th>QrCode</th>
                    <th>Modifier</th> <!-- Nouvelle colonne pour le bouton Modifier -->
                    <th>Supprimer</th> <!-- Nouvelle colonne pour le bouton Supprimer -->
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tab as $vol) : ?>
                    <tr>
                        <td><?= $vol['id_vol']; ?></td>
                        <td><?= $vol['type']; ?></td>
                        <td><?= $vol['date_depart']; ?></td>
                        <td><?= $vol['date_arrivee']; ?></td>
                        <td><?= $vol['destination']; ?></td>
                        <td><?= $vol['compagnie_aerienne']; ?></td>
                        <td><?= $vol['prix']; ?></td>
                        <td><?php echo $c->getQrCode($vol); ?></td>
                        <td>
                            <a href="update_voyage.php?id_vol=<?= $vol['id_vol']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        </td>
                        <td>
                            <a href="delete_voyage.php?id_vol=<?= $vol['id_vol']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Inclure les scripts Bootstrap (jQuery et Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>