<?php

require_once 'connexion.php';

class Reclamation {

    public string $name;
    public string $email;
    public string $subject;
    public string $message;

    public function __construct($name, $email, $subject, $message) {
        $this->name = $name ?? '';
        $this->email = $email ?? '';
        $this->subject = $subject ?? '';
        $this->message = $message ?? '';
    }

}
?>
