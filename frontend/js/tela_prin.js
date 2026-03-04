

$(document).ready(function(){
    $(document).on('click', '.edit-button', function() {
        var $task = $(this).closest('.task');
        $task.find('.progress').addClass('hidden');
        $task.find('.task-description').addClass('hidden');
        $task.find('.task-actions').addClass('hidden');
        $task.find('.edit-task').removeClass('hidden');
        $task.find('input[name="description"]').focus();
        });

    $(document).on('change', '.progress', function() {
        $(this).toggleClass('done', $(this).is(':checked'));
    });
});

document.getElementById('createTaskForm').addEventListener('submit', async (e) => {

    e.preventDefault(); /*Não deixa recarregar a página*/

    const form = e.target;
    const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    });

    const data = await res.json();
    const task = data.task;

    console.log("STATUS: ", res.status);
    console.log("JSON recebido: ", data);

    if(!res.ok || !data.ok) {
        alert("Erro ao criar tarefa");
        return;
    }

    document.getElementById('tasksList').insertAdjacentHTML('afterbegin', data.task_html);

    form.reset();

});

document.addEventListener('submit', async (e) => {
    const form = e.target;

    if (!form.classList.contains('edit-task')) {
        return; /*Se o formulário não for de edição, não faz nada*/
    }

    e.preventDefault(); /*Não deixa recarregar a página*/
    const loading = document.getElementById('loadingOverlay');
    loading.classList.remove('hidden');
    
    const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    });

    const data = await res.json();
    loading.classList.add('hidden');

    const task = data.task;

    console.log("STATUS: ", res.status);
    console.log("JSON recebido: ", data);

    if(!res.ok || !data.ok) {
        alert("Erro ao criar tarefa");
        return;
    }

    const taskElement = form.closest('.task');
    if (!taskElement) {
        console.error("Task não encontrada no DOM");
        return;
    }
    const titleElement = taskElement.querySelector('.task-description');
    const novoTitulo = (data.task?.titulo ?? form.querySelector('input[name="description"]')?.value ?? "").trim();

    if (titleElement) {
        titleElement.textContent = novoTitulo;
    }
    taskElement.querySelector('.edit-task').classList.add('hidden');
    taskElement.querySelector('.progress').classList.remove('hidden');
    taskElement.querySelector('.task-description').classList.remove('hidden');
    taskElement.querySelector('.task-actions').classList.remove('hidden');

});