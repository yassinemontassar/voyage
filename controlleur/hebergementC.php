<?php

require_once(__DIR__ . '/../config.php');
// for sending mails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
class MailSender
{
    private $user_name, $password, $email_to_send_to, $subject, $msg;

    public function __construct($user_name, $password)
    {
        $this->user_name = $user_name;
        $this->password = $password;
    }

    public function set_user_name($val)
    {
        $this->user_name = $val;
    }

    public function get_user_name()
    {
        return $this->user_name;
    }

    public function set_password($val)
    {
        $this->password = $val;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function set_email_to_send_to($val)
    {
        $this->email_to_send_to = $val;
    }

    public function get_email_to_send_to()
    {
        return $this->email_to_send_to;
    }

    public function set_subject($val)
    {
        $this->subject = $val;
    }

    public function get_subject()
    {
        return $this->subject;
    }

    public function set_msg($val)
    {
        $this->msg = $val;
    }

    public function get_msg()
    {
        return $this->msg;
    }

    public function send_normal_mail($email_to_send_to, $email_subject, $email_msg){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username =  $this->get_user_name(); # 'cashogo.tn@gmail.com';
            $mail->Password = $this->get_password(); # 'sznc taqr oqzc lpjk';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom($mail->Username);

            $mail->addAddress($email_to_send_to);

            $mail->isHTML(true);
            $mail->Subject = $email_subject;
            $mail->Body    = $email_msg;

            $mail->send();
            #echo 'Message has been sent';
            return "mail sent";
        }
        catch (Exception $e) {
            #echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return "$mail->ErrorInfo";
        }
    }

    
}
class HebergementC {
    public function listHebergements() {
        $sql = "SELECT * FROM hebergement";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteHebergement($id) {
        $sql = "DELETE FROM hebergement WHERE id_hebergement = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addHebergement(Hebergement $hebergement){
        $sql = "INSERT INTO hebergement  
        VALUES (
            NULL, 
            :id_vol,
            :ida,
            :hebergement,
            :date_depart,
            :date_arrivee,
            :adulte,
            :enfant,
            :chambre,
            :lieu,
            :categorie
        )";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            if($query->execute([
                'id_vol' => $hebergement->getid_vol(),
                'ida' => $hebergement->getida(),
                'hebergement' => $hebergement->getHebergement(),
                'date_depart' => $hebergement->getDateDepart(),
                'date_arrivee' => $hebergement->getDateArrivee(),
                'adulte' => $hebergement->getAdulte(),
                'enfant' => $hebergement->getEnfant(),
                'chambre' => $hebergement->getChambre(),
                'lieu' => $hebergement->getLieu(),
                'categorie' => $hebergement->getCategorie()
            ])){
                    $date = new DateTime();
                    HebergementC::send_email("abdelliahmed846@gmail.com","bouhmid",$date->format('Y-m-d H:i:s'));
                }
            }
        catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function showHebergement($id) {
        $sql = "SELECT * FROM hebergement WHERE id_hebergement = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $hebergement = $query->fetch();
            return $hebergement;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function updateHebergement($hebergement, $id) {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE hebergement SET 
                    hebergement = :hebergement, 
                    date_depart = :date_depart, 
                    date_arrivee = :date_arrivee, 
                    adulte = :adulte,
                    enfant = :enfant,
                    chambre = :chambre,
                    lieu = :lieu,
                    categorie = :categorie
                WHERE id_hebergement = :id_hebergement'
            );

            $query->execute([
                'id_hebergement' => $id,
                'hebergement' => $hebergement->getHebergement(),
                'date_depart' => $hebergement->getDateDepart(),
                'date_arrivee' => $hebergement->getDateArrivee(),
                'adulte' => $hebergement->getAdulte(),
                'enfant' => $hebergement->getEnfant(),
                'chambre' => $hebergement->getChambre(),
                'lieu' => $hebergement->getLieu(),
                'categorie' => $hebergement->getCategorie()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function searchHebergement($recherche) {
        $sql = "SELECT * FROM hebergement
        WHERE hebergement LIKE :recherche 
        OR lieu LIKE :recherche 
        OR categorie LIKE :recherche";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recherche', '%' . $recherche . '%');
            $query->execute();
            $hebergements = $query->fetchAll();
            return $hebergements;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function sortHebergements() {
        $sql = "SELECT * FROM hebergement ORDER BY date_depart ASC";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    public function send_email($email, $name, $date){
        $Username =  'cashogo.tn@gmail.com';
        $Password = 'sznc taqr oqzc lpjk';
        $mail_sender = new MailSender($Username, $Password);

        $email_to_send_to = $email;

        $subject = "Bienvenue Mr.$name";
        $msg = "Votre réservation est bien confirmée à $date.";

        $mail_send_res = $mail_sender->send_normal_mail($email_to_send_to, $subject, $msg);

        if ($mail_send_res == "mail sent") {
        } else {
            return "error : " . $mail_send_res;
        }
    }
}

?>