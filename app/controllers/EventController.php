<?php
class EventController {
    public function index() {
        $events = [];  

        require __DIR__ . '/../views/events/list.php';
    }
    public function show($id) {}
    public function reserve() {}
}
