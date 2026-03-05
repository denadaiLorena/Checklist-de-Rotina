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

    public function criar_ajax() {
        header('Content-Type: application/json; charset=utf-8');

        $titulo = filter_input(INPUT_POST, 'description');

        try {
            $id = $this->repo->criarTaskERetornarId($titulo);

            $task = [
                'id' => $id,
                'titulo' => $titulo,
                'completo' => false
            ];

            ob_start();
            include __DIR__ . ('/../../frontend/task_item.php');
            $task_html = ob_get_clean();

            echo json_encode([
                'ok' => true,
                'task_html' => $task_html
            ]);
            exit;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => 'Erro no banco']);
            exit;
        }

    }

    public function editarTask_ajax() {
        header('Content-Type: application/json; charset=utf-8');

        $titulo = filter_input(INPUT_POST, 'description');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        try {
            $this->repo->editarTask($id, $titulo);

            $task = [
                'id' => $id,
                'titulo' => $titulo
            ];

            ob_start();
            include __DIR__ . ('/../../frontend/task_item.php');
            $task_html = ob_get_clean();

             echo json_encode([
                'ok' => true,
                'task_html' => $task_html
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => 'Erro no banco']);
        }
        exit;
    }

    public function deletarTask_ajax() {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        try {
            $this->repo->deletarTask($id);
            $task = [
                'id' => $id
            ];

            ob_start();
            include __DIR__ . ('/../../frontend/task_item.php');
            $task_html = ob_get_clean();

             echo json_encode([
                'ok' => true,
                'task_html' => $task_html
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }

        exit;
    }
}