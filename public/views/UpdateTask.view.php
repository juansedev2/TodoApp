<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar tarea</title>
    <?php include_once "./public/partials/GeneralHead.partial.php"?>
</head>
<body>
    <header>
        <?php include_once "./public/partials/NavBarLogin.partial.php" ?>
    </header>
    <div class="container">
        <h1 class="text-center">Actualizar tarea</h1>
    </div>
    <div class="container">
        <form action="/update-task/" method="post">
            <div class="row">
                <div class="column">
                    <div class="col-sm mb-3 mt-3">
                        <div class="card">
                            <div class="card-header">
                            <h2 class="card-title">Información de la tarea</h2>
                            <input type="text" name="task-id" readonly hidden value="<?=$task->id_task?>">
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Título de la tarea</span>
                                <input type="text" class="form-control" name="task-title"value="<?=$task->title?>" placeholder="Título de la tarea" aria-label="Task-title" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">Descripción de la tarea </span>
                                <textarea name="task-description" id="task-description" class="form-control" aria-label="With textarea" required><?=$task->description?></textarea>
                            </div>
                            <div class="mt-3">
                                <h6>Última actualización: <?=$task->updated_at?></h6>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" id="cancel-button">Cancelar</button>
                                <button type="submit" class="btn btn-info text-center">Actualizar</button>
                            </div>
                        </div>          
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/public/js/ReturnScript.js"></script>
    <?php include_once "./public/partials/BootstrapJS.partial.php"?>
</body>
</html>