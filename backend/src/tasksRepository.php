<?php

require_once __DIR__ . ('/../database/connection.php');

class TasksRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function criarTask(string $titulo) {

        if ($titulo) {
            $sql = $this->pdo->prepare("INSERT INTO tasks (titulo) VALUES (:titulo)");
            $sql->bindValue(':titulo', $titulo);

            $sql->execute();

            header('Location: index.php?ok=1');
            exit;
        }
    }

    public function editarTask(int $id, string $titulo) {
        if ($titulo) {
            $sql = $this->pdo->prepare("UPDATE tasks SET titulo = :titulo WHERE id = :id");
            $sql->bindValue(':titulo', $titulo);
            $sql->bindValue(':id', $id, PDO::PARAM_INT);

            $sql->execute();

            header('Location: index.php?ok=1');
            exit;
        }
    }

    public function deletarTask(int $id) {
        $sql = $this->pdo->preparate("DELETE FROM tasks WHERE id = :id");
        $sql->bindvalue(':id', $id, PDO::PARAM_INT);

        $sql->execute();

        header('Location: index.php?ok=1');
        exit;
    }

}