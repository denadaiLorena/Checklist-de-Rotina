<?php
require_once __DIR__ . ('/tasksRepository.php');

class tasksController {
    private TasksRepository $repo;

    public function __construct(TasksRepository $repo) {
        $this->repo = $repo;
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

            echo json_encode([
                'ok' => true,
                'task' => [
                    'id' => $id,
                    'titulo' => $titulo
                ]
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
    
            $resposta = [
                'ok' => true,
                'task' => [
                    'id' => $id
                ]
            ];
            echo json_encode($resposta);
            
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    public function marcarFeita_ajax() {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $completo = filter_input(INPUT_POST, 'completo', FILTER_VALIDATE_INT);

        try {
            $this->repo->marcarFeita($id, $completo);

            $resposta = [
                'ok' => true,
                'task' => [
                    'id' => $id,
                    'completo' => $completo
                ]
            ];
            echo json_encode($resposta);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}