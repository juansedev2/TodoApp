<div class="container" id="container-todo">
    <?php if($user->taks): ?>
        <h1 class="text center">No hay tareas registradas para este usuario</h1>
    <?php else:?>
            <div class="row">
            <?php $contador = 1;?>
            <?php foreach($user->tasks as $task):?>
                <div class="col-sm mb-3 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Tarea <?=$contador++;?></h2>
                            <input type="text" hidden value="<?=$task["id_task"]?>">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?=$task["title"]?></h3>
                            <p class="card-text"><?=$task["description"]?></p>
                            <div class="d-flex width">
                                <form action="/actualizar-tarea/" method="post" class="forms-section">
                                    <input type="text" name="id_task" hidden value="<?=$task["id_task"]?>">
                                    <button type="submit" id="update-button-task" class="btn btn-info">Actualizar</button>
                                </form>
                                <form action="/eliminar-tarea/"method="post" class="forms-section">
                                    <input type="text" name="id_task" hidden value="<?=$task["id_task"]?>">
                                    <button type="button" id="delete-button-modal" class="btn btn-danger delete-task-button" value="<?=$task["id_task"]?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    <?php endif?>
</div>