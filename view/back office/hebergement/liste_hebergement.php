<?php
include "../../../controlleur/hebergementC.php";

$c = new HebergementC();
$tab = $c->listHebergements();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="style4.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Liste des hébergements</title>
    <style>
        body {
            background-color: #384edd; /* Bleu chic */
            font-family: 'Arial', sans-serif; /* Fonte stylée */
            color: white; /* Texte blanc */
        }

        .custom-table {
            background-color: #3875dd; /* Bleu foncé pour le fond de la table */
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
        <h1 class="text-center">Liste des hébergements</h1>
        <h2 class="text-center">
            <a href="add_hebergement.php" class="btn btn-primary">Ajouter un hébergement</a>
        </h2>

        <table class="table custom-table">
            <thead class="thead-dark">
                <tr>
                    <th>Id Hébergement</th>
                    <th>Type</th>
                    <th>Date de Départ</th>
                    <th>Date d'Arrivée</th>
                    <th>Adulte</th>
                    <th>Enfant</th>
                    <th>Chambre</th>
                    <th>Lieu</th> <!-- Nouvelle colonne pour le lieu -->
                    <th>Catégorie</th> <!-- Nouvelle colonne pour la catégorie -->
                    <th>Id vol</th>
                    <th>Id Activités</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tab as $hebergement) : ?>
                    <tr>
                        <td><?= $hebergement['id_hebergement']; ?></td>
                        <td><?= $hebergement['hebergement']; ?></td>
                        <td><?= $hebergement['date_depart']; ?></td>
                        <td><?= $hebergement['date_arrivee']; ?></td>
                        <td><?= $hebergement['adulte']; ?></td>
                        <td><?= $hebergement['enfant']; ?></td>
                        <td><?= $hebergement['chambre']; ?></td>
                        <td><?= $hebergement['lieu']; ?></td> <!-- Affichage du lieu -->
                        <td><?= $hebergement['categorie']; ?></td> <!-- Affichage de la catégorie -->
                        <td><?= $hebergement['id_vol']; ?></td>
                        <td><?= $hebergement['ida']; ?></td>
                        <td>
                            <a href="update_hebergement.php?id_hebergement=<?= $hebergement['id_hebergement']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        </td>
                        <td>
                            <a href="delete_hebergement.php?id_hebergement=<?= $hebergement['id_hebergement']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
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
