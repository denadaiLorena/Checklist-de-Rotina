<?php

class TasksRepository {
    public function __construct() {
        $pdo = new Connection();
    }

    public function criarTask(string $titulo) {
        $description = filter_input(INPUT_POST, 'description');

        if ($description) {
            $sql = $pdo->prepare("INSERT INTO task (description VALUES (:description)");
            $sql->bindValue(':description', $description);

            $sql->execute();
        }
    }

}