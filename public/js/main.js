document.addEventListener('DOMContentLoaded', () => {
    const taskListElement = document.getElementById("unorderedListOfTasks");
    const inputElement = document.querySelector(".input");
    const addBtn = document.querySelector('.addBtn');

    async function fetchTasks() {
        try {
            const response = await fetch('/tasks/all');
            const tasks = await response.json();
            renderTasks(tasks);
        } catch (error) {
            console.error('Error fetching tasks:', error);
        }
    }

    async function addTask(taskText) {
        try {
            const response = await fetch('/tasks/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({name: taskText})
            });
            const newTask = await response;
            renderTasks();
        } catch (error) {
            console.error('Error adding task:', error);
        }
    }

    async function deleteTask(taskId) {
        try {
            await fetch(`/tasks/delete/${taskId}`, {
                method: 'DELETE'
            });
            renderTasks();
        } catch (error) {
            console.error('Error deleting task:', error);
        }
    }

    async function toggleTaskCompletion(taskId) {
        try {
            const response = await fetch(`/tasks/get/${taskId}`);
            const task = await response.json();
            let isCompleted = !task.data[0].complete;
            await fetch(`/tasks/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({id: taskId, complete: isCompleted})
            });
            renderTasks();
        } catch (error) {
            console.error('Error updating task:', error);
        }
    }

    function renderTasks() {
        fetch('/tasks/all')
            .then(response => response.json())
            .then(tasks => {
                taskListElement.innerHTML = "";
                tasks.data.tasks.forEach(task => {
                    const li = document.createElement("li");

                    const checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.className = "taskCheckbox";
                    checkbox.checked = task.completed;
                    checkbox.onclick = () => toggleTaskCompletion(task.id);

                    const taskText = document.createElement("span");
                    taskText.className = "taskText";
                    taskText.textContent = task.name;
                    if (task.complete) {
                        taskText.classList.add("completed");
                    }

                    const deleteButton = document.createElement("button");
                    deleteButton.textContent = "Delete";
                    deleteButton.className = "removedBtn";
                    deleteButton.onclick = () => deleteTask(task.id);

                    li.appendChild(checkbox);
                    li.appendChild(taskText);
                    li.appendChild(deleteButton);
                    taskListElement.appendChild(li);
                });
            })
            .catch(error => console.error('Error rendering tasks:', error));
    }

    function handleAddTask() {
        const taskText = inputElement.value.trim();
        if (taskText) {
            addTask(taskText).then(() => {
                inputElement.value = "";
            });
        }
    }

    addBtn.addEventListener('click', handleAddTask);
    inputElement.addEventListener('keypress', event => {
        if (event.key === 'Enter') {
            handleAddTask();
        }
    });

    fetchTasks();
});
