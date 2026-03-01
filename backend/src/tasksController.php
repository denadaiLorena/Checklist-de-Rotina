<?php

class tasksController {
    public function __construct() {
        $repo = new TasksRepository();
    }

    public function criarTask() {
            $titulo = $description = filter_input(INPUT_POST, 'description');

        try {
            $this->repo->criarTask($titulo);
            header('Location: tela_prin.php?ok=1');
            exit;
        } catch (PDOException $e) {
            echo "Erro ao criar tarefa: " . $e->getMessage();
            exit;
        }
       


    }
}