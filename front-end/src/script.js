const url = `http://localhost:8080`

function drag(event) {
    event.dataTransfer.setData("card", event.target.id);
}

function over(event) {
    event.preventDefault();
}

function drop(event, status) {
    event.preventDefault();
    const target = document.getElementById(status);
    const data = event.dataTransfer.getData("card");
    const card = document.getElementById(data);
    target.appendChild(card);
    updateTask(data, status)
    event.dataTransfer.clearData();
}

function addCard(elemento) {
    const text = prompt("Qual é a tarefa?");

    const ulId = elemento.previousElementSibling.id;
    const board = document.getElementById(ulId);
    const template = taskTemplate(text)
    postTask(text, ulId)
    board.innerHTML = board.innerHTML + template;

}

function removeCard(elemento) {

    deleteTask(elemento.parentElement.id)
    document.getElementById(elemento.parentElement.id).remove();
}

function loadTasks() {
    $.get(url, function (response) {
        response.forEach(element => {
            const board = document.getElementById(element.status)
            const template = taskTemplate(element.title, element.id)
            board.innerHTML = board.innerHTML + template;
        });
    })
}

function postTask (title, status) {

    $.ajax({
        url: url,
        type: 'POST',
        contentType: "application/json",
        data: JSON.stringify({"title":title, "status":status}),
        success: function(data) {

        }
    });

}

function updateTask (id, status) {
    $.ajax({
        url: url,
        type: 'PUT',
        contentType: "application/json",
        data: JSON.stringify({"id":id, "status":status}),
        success: function(data) {
        }
    });
}

function deleteTask (id) {
    $.ajax({
        url: `${url}?id=${id}`,
        type: 'DELETE',
        success: function(data) {
        }
    });
}

function taskTemplate (text, id) {
    return(
    `<li id="${id}"`+
        ` draggable="true" ondragstart="drag(event)"
    >
      <p>` +
        text +
        `</p>
      <p class="x" onclick="removeCard(this)">x</p>
    </li>`
    )
}