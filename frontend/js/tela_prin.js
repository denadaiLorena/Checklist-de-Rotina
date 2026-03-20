

/*$(document).ready(function () {
    $(document).on('click', '.edit-button', function () {
        var $task = $(this).closest('.task');
        
        $task.find('.marcar-task').addClass('hidden');
        $task.find('.progress').addClass('hidden');
        $task.find('.task-description').addClass('hidden');
        $task.find('.task-actions').addClass('hidden');
        $task.find('.edit-task').removeClass('hidden');
        $task.find('input[name="description"]').focus();
    });

    $(document).on('change', '.progress', function () {
        $(this).toggleClass('done', $(this).is(':checked'));
    });
});

*/



window.addEventListener('DOMContentLoaded', () => {
    
    window.addEventListener('submit', async (e) => {
        e.preventDefault(); /*Não deixa recarregar a página*/

        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;

        const editForm = form.classList.contains('edit-task');
        const deleteForm = form.classList.contains('delete-task');
        const createForm = form.classList.contains('to_do_form') && !editForm && !deleteForm;

        const loading = document.getElementById('loadingOverlay');
        loading.classList.remove('hidden');

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            });

            const data = await res.json();

            console.log("STATUS: ", res.status);
            console.log("JSON recebido: ", data);

            if (!res.ok || !data.ok) {
                alert("Erro ao criar tarefa");
                return;
            }

            if (createForm) {
                document.getElementById('tasksList').insertAdjacentHTML('afterbegin', data.task_html);
                form.reset();
                return;
            }
            const taskElement = form.closest('.task');
            if (!taskElement) {
                console.error("Task não encontrada no DOM");
                return;
            }

            if (editForm) {
                const titleElement = taskElement.querySelector('.task-description');
                const novoTitulo = (data.task?.titulo ?? form.querySelector('input[name="description"]')?.value ?? "").trim();

                if (titleElement) {
                    titleElement.textContent = novoTitulo;
                }
                
                taskElement.querySelector('.edit-task')?.classList.add('hidden');
                taskElement.querySelector('.marcar-task')?.classList.remove('hidden');
                taskElement.querySelector('.progress')?.classList.remove('hidden');
                taskElement.querySelector('.task-description')?.classList.remove('hidden');
                taskElement.querySelector('.task-actions')?.classList.remove('hidden');
            } else if (deleteForm) {
                taskElement.remove();
            }
        } catch (error) {
            console.error(error);
            alert("Erro ao processar a requisição");
        } finally {
            loading?.classList.add('hidden');
        }
    });

    window.addEventListener('change', async (e) => {
        const checkbox = e.target;
        if (!checkbox.classList.contains('progress')) return;
        
        const taskElement = checkbox.closest('.task');
        const form = checkbox.closest('form');

        if (!taskElement) { return; }

        const taskId = taskElement.dataset.taskId;
        const completo = checkbox.checked ? 1 : 0;

        const formData = new FormData(form);
        formData.append('completo', checkbox.checked ? 1 : 0);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                body: formData
            });
            
            const data = await res.json();
        
            if (!res.ok || !data.ok) {
                checkbox.checked = !checkbox.checked;
                alert(data.error || "Erro ao marcar tarefa");
                return;
            }

            checkbox.classList.toggle('done', checkbox.checked);
        } catch (error) {
            console.error(error);
            checkbox.checked = !checkbox.checked;
            alert("Erro ao processar a requisição");
        }
    });

    window.addEventListener('click', (e) => {
        const marcarBtn = e.target.closest(".marcar-task");
        if (!marcarBtn) return;

        const card = e.target.closest('.task');
        if (!card) return;

        const checkbox = card.querySelector('input[type=checkbox]');
        const texto = card.querySelector('.task-description');

        checkbox.checked = !checkbox.checked;
        texto.classList.toggle('done', checkbox.checked);
    });

    window.addEventListener('dblclick', (e) => {
        const editarBtn = e.target.closest(".task-description");
        if (!editarBtn) return;

        const card = e.target.closest('.task');
        if (!card) return;

        card.querySelector('.marcar-task')?.classList.add('hidden');
        card.querySelector('.progress')?.classList.add('hidden');
        card.querySelector('.task-description')?.classList.add('hidden');
        card.querySelector('.task-actions')?.classList.add('hidden');
        card.querySelector('.edit-task')?.classList.remove('hidden');
        card.querySelector('input[name="description"]')?.focus();
    });
});


/*
window.addEventListener('DOMContentLoaded', () => {
  // Seleciona o formulário
  const form = document.querySelector('form');
  form.addEventListener('submit', (event) => {
    event.preventDefault(); // evita envio real
    console.log('Formulário enviado!');
  });

  // Seleciona um input checkbox
  const checkbox = document.querySelector('input[type="checkbox"]');
  checkbox.addEventListener('change', (event) => {
    console.log('Checkbox alterado!', event.target.checked);
  });
});

Vou pegar essas funções ali e colocar dentro desta para evitar código desnecessário e confusões*/ 