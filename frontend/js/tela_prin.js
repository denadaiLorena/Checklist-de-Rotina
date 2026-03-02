

$(document).ready(function(){
    $('.edit-button').on('click', function() {
        var $task = $(this).closest('.task');
        $task.find('.progress').addClass('hidden');
        $task.find('.task-description').addClass('hidden');
        $task.find('.task-actions').addClass('hidden');
        $task.find('.edit-task').removeClass('hidden');
        });

    $('.progress').on('click', function() {
        if($(this).is(':checked')) {
            $(this).addClass('done');
        } else {
            $(this).removeClass('done');
        }
    
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