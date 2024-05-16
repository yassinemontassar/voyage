<?php

require_once(__DIR__ . '/../config.php');

require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class voyageC
{
    public function listVols()
    {
        $sql = "SELECT * FROM voyage";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteVol($id)
    {
        $sql = "DELETE FROM voyage WHERE id_vol = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addVol(Vol $vol)
    {
        $sql = "INSERT INTO voyage  
        VALUES (
            NULL, 
            :type,
            :date_depart,
            :date_arrivee,
            :destination,
            :compagnie_aerienne,
            :prix
        )";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'type' => $vol->getType(),
                'date_depart' => $vol->getDateDepart(),
                'date_arrivee' => $vol->getDateArrivee(),
                'destination' => $vol->gedestination(),
                'compagnie_aerienne' => $vol->getcompagnie_aerienne(),
                'prix' => $vol->getPrix()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function showVol($id)
    {
        $sql = "SELECT * FROM voyage WHERE id_vol = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $vol = $query->fetch();
            return $vol;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function updateVol($vol, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE voyage SET 
                    type = :type, 
                    date_depart = :date_depart, 
                    date_arrivee = :date_arrivee, 
                    prix = :prix
                WHERE id_vol = :id_vol'
            );

            $query->execute([
                'id_vol' => $id,
                'type' => $vol->getType(),
                'date_depart' => $vol->getDateDepart(),
                'date_arrivee' => $vol->getDateArrivee(),
                'prix' => $vol->getPrix()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function search($recherche)
{
    $sql = "SELECT * FROM voyage
    WHERE type LIKE :recherche 
    OR date_depart LIKE :recherchee 
    OR date_arrivee LIKE :rechercheee
    OR prix LIKE :rechercheeee";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindValue(':recherche', '%' . $recherche . '%');
        $query->bindValue(':recherchee', '%' . $recherche . '%');
        $query->bindValue(':rechercheee', '%' . $recherche . '%');
        $query->bindValue(':rechercheeee', '%' . $recherche . '%');
        $query->execute();
        $vols = $query->fetchAll();
        return $vols;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
public function SortVols(){
    $sql = "SELECT * FROM voyage ORDER BY date_depart ASC";
    $db = config::getConnexion();
    try {
        $liste = $db->query($sql);
        return $liste;
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
}
public function getAllIdVol() {
    try {
        // Get database connection
        $db = config::getConnexion();

        // Prepare SQL statement to fetch all id_vol values from the voyage table
        $query = "SELECT id_vol FROM voyage";

        // Prepare and execute the SQL statement
        $statement = $db->prepare($query);
        $statement->execute();

        // Fetch all id_vol values as an associative array
        $idVols = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $idVols;
    } catch (PDOException $e) {
        // Handle database errors
        echo "Database Error: " . $e->getMessage();
        return false;
    }
}
public function getQrCode($data){
    if ($data == null) {
        return '<img src="" />';
    }
    $text = 'Type: ' . $data['type'] . '"' . "\n" . 
        'Date de Départ: ' . $data['date_depart'] . "\n" . 
        'Date d\'Arrivée: ' . $data['date_arrivee'] . "\n" . 
        'Destination: ' . $data['destination'] . "\n" . 
        'Compagnie Aérienne: ' . $data['compagnie_aerienne'] . "\n" . 
        'Prix: ' . $data['prix'];
    $qr_code = QrCode::create($text)
        ->setSize(300)
        ->setMargin(5);

    $writer = new PngWriter;

    $result = $writer->write($qr_code);

    // Encode the image string to a data URI
    $dataUri = 'data:' . $result->getMimeType() . ';base64,' . base64_encode($result->getString());

    // Now you can use this data URI in an <img> tag like this:
    return '<img src="' . $dataUri . '" alt="QR Code" onclick="openPopup(this.src)" />';
}
}


?>
