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
            <div class="container mb-3 mt-3">
                <h1 class="text-center">Acerca de TodoApp</h1>
            </div>
            <p class="fs-4 lh-lg">
                TodoApp es una aplicación web que te permite crear tareas para que las puedas ver en tu pantalla, con eso haces una gestión de tus actividades a realizar de manera fácil y rápida.
                Puedes usar dos versiones, la primera es la versión de invitado donde puedes usar rápidamente la aplicación de un modo sencillo, te permite crear tareas y eliminarlas, la segunda opción es
                como un usuario registrado, debes registrarte en la aplicación y tendrás acceso a más funciones, donde no solamente puedes crear tus tareas y eliminarlas, también podrás editarlas y mantenerlas
                registradas para que cada vez que ingreses a la aplicación, no pierdas el registro de las mismas. La decisión de registrarte es tuya, ve a la opción de "Registrarse" en el menú de navegación superior para poder hacerlo, o bien, si solo
                quieres usar rápida la app o dar un vistazo rápido, ve a la opción de "Modo invitado" para usarlo. Agradecemos que uses nuestra aplicación y ante cualquier comentario, sugerencia o aporte que desees realizar, puedes
                realizarlo al correo de administración: <u>administraciontodoapp@todoapp.com</u>
            </p>
            <p class="fs-4 lh-lg"><b>Gracias por tu atención: Atentamente la administración de TodoApp</b></p>
        </div>
    </main>
    <?php include_once "./public/partials/BootstrapJS.partial.php"?>
</body>
</html>