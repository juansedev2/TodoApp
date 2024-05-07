<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoApp</title>
    <?php include_once "./public/partials/GeneralHead.partial.php"?>
    <link href="/public/css/Landing.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include_once "./public/partials/NavBar.partial.php" ?>
    </header>
    <main>
        <div class="container-sm mw-300 container-form border border-black border-opacity-25 rounded p-5">
        <form action="/login/" method="POST">
            <div class="mb-5">
                <h2 class="text-center">Iniciar sesión</h2>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
              <div id="emailHelp" class="form-text">Recuerda siempre cuidar de tus credenciales</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="exampleInputPassword1" required>
              <div id="passwordlHelp" class="form-text"></div>
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