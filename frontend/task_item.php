<link rel="stylesheet" href="frontend/style/tela_prin.css">


<div class="task" data-task-id="<?= $task['id'] ?>">
                   <input type="checkbox"
                    name="progress"
                    class="progress <?= $task['completo'] ? 'done' : '' ?>"
                    <?= $task['completo'] ? 'checked' : ''?>
                    >

                   <p class="task-description">
                       <?= htmlspecialchars($task['titulo'])?>
                   </p>

                   <div class="task-actions">
                       <a class="action-button edit-button">
                           <i class="fa-regular fa-pen-to-square"></i>
                       </a>

                       <form action="index.php" method="POST" class="to_do_form delete-task">
                            <input type="hidden" name="acao" value="deletar_ajax">
                            <input type="hidden" name="id" value="<?= $task['id']?>">
                            <button type="submit" class="action-button delete-button">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                       </form>

                   </div>

                   
                   <form action="index.php" method='POST' class="to_do_form edit-task hidden" id="editForm">
                        <input type="hidden" name="acao" value="editar_ajax">
                        <input type="hidden" name="id" value="<?= $task['id']?>">
                        <input type="text" name="description" placeholder="Edite a sua tarefa aqui" value="<?= htmlspecialchars($task['titulo']) ?>">

                       <button type="submit" class="form-button confirm-button">
                           <i class="fa-solid fa-check"></i>
                       </button>
                   </form>
               </div>