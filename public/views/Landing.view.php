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
        <div class="container">
            <div class="text-center">
                <img src="/public/assets/img/todolist.png" class="img-fluid" alt="todolistimage">        
            </div>
            <div class="text-center mb-5 mt-5">
                <h1>TodoApp</h1>
                <h2>Una aplicación web para hacer tu lista de tareas</h2>
                <h3>Usa el menú de navegación que está en la parte superior de tu pantalla para comenzar</h3>
            </div>
        </div>
    </main>
    <?php include_once "./public/partials/BootstrapJS.partial.php"?>
</body>
</html>