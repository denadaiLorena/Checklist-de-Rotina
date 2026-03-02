<?php
/*O index.php manda nas demais classes, reutilizando e facilitando a manutenção do código*/
require_once __DIR__ . ('/backend/database/connection.php');
$pdo = (new Connection())->getConnection();

require_once __DIR__ . ('/backend/src/tasksController.php');
require_once __DIR__ . ('/backend/src/tasksRepository.php');
$repo = new TasksRepository($pdo);
$tasksController = new TasksController($repo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    switch ($acao) {

        case 'criar':
            $tasksController->criarTask();
            break;
        case 'deletar':
            $tasksController->deletarTask();
            break;
        case 'editar':
            $tasksController->editarTask();
            break;
        case 'marcar_feita':
            /*$tasksController->marcarFeita();*/
            break;
        case 'criar_ajax':
            $tasksController->criar_ajax();
            break;
        case 'deletar_ajax':
            /*$tasksController->deletarTaskAjax();*/
            break;
        default:
            header('Location: tela_prin.php?erro=acao_invalida');
            exit;
    }
}

require __DIR__ . '/frontend/tela_prin.php';