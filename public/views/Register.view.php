<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <?php include_once "./public/partials/GeneralHead.partial.php"?>
    <link href="/public/css/Register.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include_once "./public/partials/NavBar.partial.php" ?>
    </header>
    <main>
        <div class="container mw-200 container-form border border-black border-opacity-25 rounded p-5">
            <form method="post" action="/register/">
                <div class="mb-4 mt-4">
                  <h1 class="text-center">Formulario de registro</h1>
                </div>
                <div>
                  <p class="text-center">Registrate para acceder a mas funcionalidades de la app</p>
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Nombres</label>
                  <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Apellidos</label>
                  <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                  <input type="email" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="inputPassword5" class="form-label">Contraseña</label>
                  <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
                  <div id="passwordHelpBlock" class="form-text">
                    Su contraseña debe tener entre 8 y 20 caracteres, contener letras y números, y no debe contener espacios, caracteres especiales ni emoji.
                  </div>
                </div>
                <div class="mb-3">
                  <label for="inputPassword5" class="form-label">Confirmar contraseña</label>
                  <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
                </div>
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </main>
    <?php include_once "./public/partials/BootstrapJS.partial.php"?>
</body>
</html>