<?php

require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Reservation.php';

class EventController {
    private $eventModel;
    private $reservationModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->reservationModel = new Reservation();
    }

    public function index() {
        $events = $this->eventModel->getUpcoming();
        
        foreach ($events as &$event) {
            $event['available_seats'] = $this->eventModel->getAvailableSeats($event['id']);
            $event['is_full'] = $event['available_seats'] <= 0;
        }
        
        require_once __DIR__ . '/../views/events/list.php';
    }
    public function show($id) {
        $event = $this->eventModel->getById($id);
        
        if (!$event) {
            header('Location: /MiniEvent/public/events');
            exit();
        }
        
        $event['available_seats'] = $this->eventModel->getAvailableSeats($id);
        $event['is_full'] = $event['available_seats'] <= 0;
        
        require_once __DIR__ . '/../views/events/details.php';
    }
    public function reserve() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /MiniEvent/public/events');
            exit();
        }

        $eventId = $_POST['event_id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        $errors = [];
        
        if (empty($eventId) || !is_numeric($eventId)) {
            $errors[] = "Événement invalide.";
        }

        if (empty($name) || strlen($name) < 3) {
            $errors[] = "Le nom doit contenir au moins 3 caractères.";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email est invalide.";
        }

        if (empty($phone) || !preg_match('/^[0-9\s\+\-\(\)]{8,20}$/', $phone)) {
            $errors[] = "Le numéro de téléphone est invalide.";
        }

        if (empty($errors)) {
            $event = $this->eventModel->getById($eventId);
            
            if (!$event) {
                $errors[] = "Cet événement n'existe pas.";
            } elseif (!$this->eventModel->hasAvailableSeats($eventId)) {
                $errors[] = "Désolé, il n'y a plus de places disponibles pour cet événement.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['reservation_errors'] = $errors;
            $_SESSION['reservation_data'] = $_POST;
            header('Location: /MiniEvent/public/event/' . $eventId);
            exit();
        }

        $this->reservationModel->event_id = $eventId;
        $this->reservationModel->name = $name;
        $this->reservationModel->email = $email;
        $this->reservationModel->phone = $phone;

        $result = $this->reservationModel->create();

        if ($result['success']) {
            $_SESSION['reservation_success'] = true;
            $_SESSION['reservation_event'] = $event['title'];
            $_SESSION['reservation_name'] = $name;
            header('Location: /MiniEvent/public/event/' . $eventId . '?success=1');
        } else {
            $_SESSION['reservation_errors'] = [$result['message']];
            $_SESSION['reservation_data'] = $_POST;
            header('Location: /MiniEvent/public/event/' . $eventId);
        }
        exit();
    }
}