<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoApp - Binvendo</title>
    <?php include_once "./public/partials/GeneralHead.partial.php"?>
    <link rel="stylesheet" href="/public/css/BotonAddTask.css">
    <link rel="stylesheet" href="/public/css/UserContainer.css">
</head>
<body>
    <header>
        <?php include_once "./public/partials/NavBarLogin.partial.php" ?>
    </header>
    <main>
        <div class="container">
            <?php include_once "./public/partials/GreetUser.partial.php" ?>
        </div>
        <?php include_once "./public/partials/AlertTaskStatus.partial.php" ?>
        <?php include_once "./public/partials/TasksForUserContainer.partial.php" ?> 
        <div class="container add-boton-container mt-5 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill add-icon" id="add-icon-button" viewBox="0 0 16 16" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
            </svg>
            <div class="mb-3 mt-3">
                <h1>Agregar tarea</h1>
            </div>
        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirmar la eliminación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body" id="modal-alert-delete-task">
                        <h5>¿Deseas eliminar la tarea?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="/eliminar-tarea/" method="post">
                            <?php require "./public/partials/TokenCSRF.partial.php" ?>
                            <input type="text" value="" id="id_task_input_button" name="id_task_input_button"  hidden>
                            <button type="submit" class="btn btn-danger" id="confirm-delete-button">Si, eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar una nueva tarea</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/create-task/" method="post">
                            <?php require "./public/partials/TokenCSRF.partial.php" ?>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Título:</label>
                                <input type="text" class="form-control" name="title-task" id="title-task" min="1" max="20" required>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Descripción:</label>
                                <textarea class="form-control" name="description-task" id="description-task" min="1" max="200" required></textarea>
                            </div>
                            <div class="mb-3 text-danger" id="help-text"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="create-task-button">Crear tarea</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/public/js/UserLoginMode.js"></script>
    <?php include_once "./public/partials/BootstrapJS.partial.php"?>
</body>
</html>