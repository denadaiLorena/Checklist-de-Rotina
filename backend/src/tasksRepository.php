<?php

require_once __DIR__ . ('/../database/connection.php');

class TasksRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function editarTask(int $id, string $titulo) {
            $sql = $this->pdo->prepare("UPDATE tasks SET titulo = :titulo WHERE id = :id");
            $sql->bindValue(':titulo', $titulo);
            $sql->bindValue(':id', $id, PDO::PARAM_INT);

            $sql->execute();
    }

    public function deletarTask(int $id) {
        $sql = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $sql->bindvalue(':id', $id, PDO::PARAM_INT);

        $sql->execute();
    }

    public function criarTaskERetornarId(string $titulo): int {
            $sql = $this->pdo->prepare("INSERT INTO tasks (titulo) VALUES (:titulo) RETURNING id");
            $sql->bindValue(':titulo', $titulo);
            $sql->execute();
            
            $id = (int) ($sql->fetchColumn());
            return $id;
    }

    public function marcarFeita(int $id, bool $completo) {
        $sql = $this->pdo->prepare("UPDATE tasks SET completo = :completo WHERE id = :id");
        $sql->bindValue(':completo', (bool)$completo, PDO::PARAM_BOOL);
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }
}