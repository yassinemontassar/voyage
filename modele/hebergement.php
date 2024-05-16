<?php

require_once(__DIR__ . '/../config.php');

class Hebergement {
    // Attributs
    private $id_hebergement; // identifiant de l'hébergement
    private $hebergement;    // type d'hébergement
    private $date_depart;    // date de début de l'hébergement
    private $date_arrivee;   // date de fin de l'hébergement
    private $adulte;         // nombre d'adultes
    private $enfant;         // nombre d'enfants
    private $chambre;        // nombre de chambres
    private $lieu;           // lieu de l'hébergement
    private $categorie;      // catégorie de l'hébergement
    private $id_vol;      // identifiant du voyage associé
    private $ida;      // identifiant de l'activité associée

    // Constructeur sans paramètres
    public function __construct() {}

    // Méthode pour définir les valeurs des attributs
    public function setValues($hebergement, $date_depart, $date_arrivee, $adulte, $enfant, $chambre, $lieu, $categorie,$id_vol,$ida) {
        $this->hebergement = $hebergement;
        $this->date_depart = $date_depart;
        $this->date_arrivee = $date_arrivee;
        $this->adulte = $adulte;
        $this->enfant = $enfant;
        $this->chambre = $chambre;
        $this->lieu = $lieu;
        $this->categorie = $categorie;
        $this->id_vol = $id_vol;
        $this->ida = $ida;
    }

    // Getter et setter pour chaque attribut

    public function getIdHebergement() {
        return $this->id_hebergement;
    }

    public function getHebergement() {
        return $this->hebergement;
    }

    public function setHebergement($hebergement) {
        $this->hebergement = $hebergement;
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

    public function getAdulte() {
        return $this->adulte;
    }

    public function setAdulte($adulte) {
        $this->adulte = $adulte;
    }

    public function getEnfant() {
        return $this->enfant;
    }

    public function setEnfant($enfant) {
        $this->enfant = $enfant;
    }

    public function getChambre() {
        return $this->chambre;
    }

    public function setChambre($chambre) {
        $this->chambre = $chambre;
    }

    public function getLieu() {
        return $this->lieu;
    }

    public function setLieu($lieu) {
        $this->lieu = $lieu;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
    }
    public function getid_vol() {
        return $this->id_vol;
    }
    public function setid_vol($id_vol) {
        $this->id_vol = $id_vol;
    }
    public function getida() {
        return $this->ida;
    }
    public function setida($ida) {
        $this->ida = $ida;
    }

    // Méthode pour sauvegarder les données dans la base de données
    public function save() {
        try {
            $db = $GLOBALS['db'];
            // Préparer la requête SQL
            $query = "INSERT INTO hebergement (hebergement, date_depart, date_arrivee, adulte, enfant, chambre, lieu, categorie,id_vol,ida) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Préparer la déclaration SQL
            $statement = $db->prepare($query);

            // Lier les valeurs
            $statement->bindParam(1, $this->hebergement);
            $statement->bindParam(2, $this->date_depart);
            $statement->bindParam(3, $this->date_arrivee);
            $statement->bindParam(4, $this->adulte);
            $statement->bindParam(5, $this->enfant);
            $statement->bindParam(6, $this->chambre);
            $statement->bindParam(7, $this->lieu);
            $statement->bindParam(8, $this->categorie);
            $statement->bindParam(9, $this->id_vol);
            $statement->bindParam(10, $this->ida);

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