<?php

require_once(__DIR__ . '/../config.php');

class Vol {
    // Attributs
    private $id_vol;             // identifiant du vol
    private $type;               // type de vol
    private $date_depart;        // date de départ du vol
    private $date_arrivee;       // date d'arrivée du vol
    private $destination;        // destination du vol
    private $compagnie_aerienne; // compagnie_aerienne du vol
    private $prix;               // prix du vol

    // Constructeur sans paramètres
    public function __construct(){}

    // Méthode pour définir les valeurs des attributs
    public function setValues($type, $date_depart, $date_arrivee, $destination, $compagnie_aerienne,$prix) {
        $this->type = $type;
        $this->date_depart = $date_depart;
        $this->date_arrivee = $date_arrivee;
        $this->destination = $destination;
        $this->compagnie_aerienne = $compagnie_aerienne;
        $this->prix = $prix;
    }

    // Getter et setter pour chaque attribut

    public function getIdVol() {
        return $this->id_vol;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getDateDepart() {
        return $this->date_depart;
    }

    public function setDateDepart($date_depart) {
        $this->date_depart = $date_depart;
    }

    public function getDateArrivee() {
        return $this->date_arrivee;
    }

    public function setDateArrivee($date_arrivee) {
        $this->date_arrivee = $date_arrivee;
    }
    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }
    public function gedestination() {
        return $this->destination;
    }

    public function sedestination($destination) {
        $this->destination = $destination;
    }
    public function getcompagnie_aerienne() {
        return $this->compagnie_aerienne;
    }

    public function setcompagnie_aerienne($compagnie_aerienne) {
        $this->compagnie_aerienne = $compagnie_aerienne;
    }

    // Méthode pour sauvegarder les données dans la base de données
    public function save() {
        try {
            $db = $GLOBALS['db'];
            // Préparer la requête SQL
            $query = "INSERT INTO vols (type, date_depart, date_arrivee, destination, compagnie_aerienne, prix) VALUES (?, ?, ?, ?, ?, ?)";

            // Préparer la déclaration SQL
            $statement = $db->prepare($query);

            // Lier les valeurs
            $statement->bindParam(1, $this->type);
            $statement->bindParam(2, $this->date_depart);
            $statement->bindParam(3, $this->date_arrivee);
            $statement->bindParam(4, $this->destination);
            $statement->bindParam(5, $this->compagnie_aerienne);
            $statement->bindParam(6, $this->prix);

            // Exécuter la requête
            $result = $statement->execute();

            // Fermer la connexion à la base de données
            $db = null;

            return $result;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }
}

?>
