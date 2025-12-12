<?php

require_once __DIR__ . '/../../config/database.php';

class Reservation {
    private $conn;
    private $table = 'reservations';

    public $id;
    public $event_id;
    public $name;
    public $email;
    public $phone;
    public $created_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        if ($this->emailExistsForEvent($this->email, $this->event_id)) {
            return ['success' => false, 'message' => 'Vous avez déjà réservé pour cet événement.'];
        }

        $query = "INSERT INTO " . $this->table . " 
                  (event_id, name, email, phone) 
                  VALUES (:event_id, :name, :email, :phone)";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyer les données
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        
        $stmt->bindParam(':event_id', $this->event_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        
        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Erreur lors de la réservation.'];
    }

    private function emailExistsForEvent($email, $eventId) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE email = :email AND event_id = :event_id 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    public function getByEventId($eventId) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE event_id = :event_id 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function countByEventId($eventId) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE event_id = :event_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['total'];
    }
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getAll() {
        $query = "SELECT r.*, e.title as event_title, e.date as event_date 
                  FROM " . $this->table . " r 
                  INNER JOIN events e ON r.event_id = e.id 
                  ORDER BY r.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    public function validate() {
        $errors = [];

        if (empty($this->name) || strlen($this->name) < 3) {
            $errors[] = "Le nom doit contenir au moins 3 caractères.";
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email est invalide.";
        }

        if (empty($this->phone) || !preg_match('/^[0-9\s\+\-\(\)]{8,20}$/', $this->phone)) {
            $errors[] = "Le numéro de téléphone est invalide.";
        }

        return $errors;
    }
}