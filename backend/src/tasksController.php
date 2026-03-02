<?php
require_once __DIR__ . ('/tasksRepository.php');

class tasksController {
    private TasksRepository $repo;

    public function __construct(TasksRepository $repo) {
        $this->repo = $repo;
    }

    public function criarTask() {
        ini_set('log_errors', '1');
        ini_set('error_log', __DIR__ . '/debug.log');

        $T0 = microtime(true);
        file_put_contents(__DIR__ . '/hit.txt', "bateu " . date('c') . PHP_EOL, FILE_APPEND);
        error_log("T0 start");
        $titulo = filter_input(INPUT_POST, 'description');

        try {
            $T1 = microtime(true);
            error_log("T1 antes repo: ".round(($T1-$T0)*1000,1)."ms");
            $this->repo->criarTask($titulo);
            $T2 = microtime(true);
            error_log("T2 depois repo: ".round(($T2-$T0)*1000,1)."ms");

            header('Location: index.php?ok=1');
            exit;
        } catch (PDOException $e) {
            echo "Erro ao criar tarefa: " . $e->getMessage();
            exit;
        }
    }

    public function editarTask() {
        $T0 = microtime(true);
        error_log("T0 start");
        $titulo = filter_input(INPUT_POST, 'description');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        try {
            $T1 = microtime(true);
            error_log("T1 antes repo: ".round(($T1-$T0)*1000,1)."ms");
            $this->repo->editarTask($id, $titulo);
            header('Location: index.php?ok=editado');
            $T2 = microtime(true);
            error_log("T2 depois repo: ".round(($T2-$T0)*1000,1)."ms");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao editar tarefa: " . $e->getMessage();
            exit;
        }
    }

    public function deletarTask() {
        $T0 = microtime(true);
        error_log("T0 start");
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        try {
            $T1 = microtime(true);
            error_log("T1 antes repo: ".round(($T1-$T0)*1000,1)."ms");
            $this->repo->deletarTask($id);
            header('Location: index.php?ok=deletado');
            $T2 = microtime(true);
            error_log("T2 depois repo: ".round(($T2-$T0)*1000,1)."ms");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao deletar tarefa: " . $e->getMessage();
            exit;
        }
    }
}