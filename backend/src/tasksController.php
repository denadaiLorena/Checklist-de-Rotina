<?php
require_once __DIR__ . ('/tasksRepository.php');

class tasksController {
    private TasksRepository $repo;

    public function __construct(TasksRepository $repo) {
        $this->repo = $repo;
    }

    public function criarTask() {
        $titulo = filter_input(INPUT_POST, 'description');

        try {
            $this->repo->criarTask($titulo);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            echo "Erro ao criar tarefa: " . $e->getMessage();
            exit;
        }
    }

    public function editarTask() {
        $titulo = filter_input(INPUT_POST, 'description');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        try {
            $this->repo->editarTask($id, $titulo);
            header('Location: index.php?ok=editado');
            exit;
        } catch (PDOException $e) {
            echo "Erro ao editar tarefa: " . $e->getMessage();
            exit;
        }
    }

    public function deletarTask() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        try {
            $this->repo->deletarTask($id);
            header('Location: index.php?ok=deletado');
            exit;
        } catch (PDOException $e) {
            echo "Erro ao deletar tarefa: " . $e->getMessage();
            exit;
        }
    }
}