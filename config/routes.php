<?php

require_once __DIR__ . '/../app/controllers/EventController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

class Router {
    private $eventController;
    private $adminController;

    public function __construct() {
        $this->eventController = new EventController();
        $this->adminController = new AdminController();
    }

    public function route() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace('/MiniEvent/public', '', $uri);
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($uri) {
            case '/':
            case '/events':
                $this->eventController->index();
                break;

            case (preg_match('/^\/event\/(\d+)$/', $uri, $matches) ? true : false):
                $this->eventController->show($matches[1]);
                break;

            case '/reservation':
                if ($method === 'POST') {
                    $this->eventController->reserve();
                }
                break;

            case '/admin/login':
                if ($method === 'GET') {
                    $this->adminController->showLogin();
                } elseif ($method === 'POST') {
                    $this->adminController->login();
                }
                break;

            case '/admin/logout':
                $this->adminController->logout();
                break;

            case '/admin':
            case '/admin/dashboard':
                $this->adminController->dashboard();
                break;

            case '/admin/events/create':
                if ($method === 'GET') {
                    $this->adminController->createEvent();
                } elseif ($method === 'POST') {
                    $this->adminController->storeEvent();
                }
                break;

            case (preg_match('/^\/admin\/events\/edit\/(\d+)$/', $uri, $matches) ? true : false):
                if ($method === 'GET') {
                    $this->adminController->editEvent($matches[1]);
                } elseif ($method === 'POST') {
                    $this->adminController->updateEvent($matches[1]);
                }
                break;

            case (preg_match('/^\/admin\/events\/delete\/(\d+)$/', $uri, $matches) ? true : false):
                $this->adminController->deleteEvent($matches[1]);
                break;

            case (preg_match('/^\/admin\/reservations\/(\d+)$/', $uri, $matches) ? true : false):
                $this->adminController->showReservations($matches[1]);
                break;

            default:
                http_response_code(404);
                echo "404 - Page non trouvée";
                break;
        }
    }
}