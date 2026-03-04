<?php

require_once __DIR__ . ('/../database/connection.php');

class TasksRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function criarTask(string $titulo) {
        $log = __DIR__ . '/debug.log';
        $T0 = microtime(true);

        if ($titulo) {
            $sql = $this->pdo->prepare("INSERT INTO tasks (titulo) VALUES (:titulo)");
            file_put_contents($log, "Repo prepare: ".round((microtime(true)-$T0)*1000,1)."ms\n", FILE_APPEND);

            $sql->bindValue(':titulo', $titulo);
            file_put_contents($log, "Repo bind: ".round((microtime(true)-$T0)*1000,1)."ms\n", FILE_APPEND);

            $sql->execute();
            file_put_contents($log, "Repo execute: ".round((microtime(true)-$T0)*1000,1)."ms\n", FILE_APPEND);
        }
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

        header('Location: index.php?ok=1');
        exit;
    }

    public function criarTaskERetornarId(string $titulo): int {
            $sql = $this->pdo->prepare("INSERT INTO tasks (titulo) VALUES (:titulo) RETURNING id");
            $sql->bindValue(':titulo', $titulo);
            $sql->execute();
            
            $id = (int) ($sql->fetchColumn());
            return $id;
    }

}