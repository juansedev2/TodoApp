# Documentación de rápida instalación

## Aplicación: TodoApp

### Autor: Juansedev2

![AppTestimg](https://github.com/juansedev2/TodoApp/blob/develop/public/assets/img/todolist.png)

---

TodoAPP Es una aplicación simple para registrar tareas por hacer para un usuario, pero fue diseñada como una aplicación también pensada en los temas de seguridad, por lo que maneja una sólida base de seguridad para el uso de esta aplicación en cuanto a la lógica del negocio. Toda la documentación de TodoApp se encuentra en el directorio de docs, por favor revisarla en caso de entender tanto su nacimiento como su diseño; pero en resumen TodoApp es una aplicación para creación de tareas, teniendo dos tipos de uso:

Usuario invitado: Puede usar una versión demo con su navegador web, toda la información funciona bajo su sesión, puede ver, crear y eliminar tareas mientras dure su sesión.

Usuario registrado: El usuario registrado en el sistema puede ver, crear, actualizar y eliminar sus tareas en el sistema, además de que esta información persiste aún cuando su sesión se ha finalizado en el navegador, así que podrá interactuar con ellas cuando lo necesite.

Esta aplicación consta de la posibilidad de ser probada tanto en un entorno de producción como enterno de desarrollo (local), por lo cual tan solo hay que configurar el modo de produccion en la sección de configuración (core/config/Config.php) en el apartado de production, poner valor de true si es para producción, en dado caso poner false, de esta manera, se puede emular por así decirlo el funcionamiento de la aplicación en ambos contextos, en cuanto a demás dudas de funcionamiento, problemas de la aplcación y demás, favor contactarse con el administrador.

---

Para usar la aplicación en entorno de desarrollo, clona el repositorio, luego puedes acceder a la misma a través del servidor local de PHP:

- Accede vía terminal al directorio de la app en la raíz y utiliza el siguiente comando:

```conf
    php -S localhost:3000
```

- **Antes de continuar, descarga el archivo de backup de la base de datos ubicado en el directorio de docs y cargar en PHPMYADMIN o MySQL Workbench O el cliente de MySQL preferido, para crear la base de datos y probar la aplicación, de no hacerlo, no podrás usar la aplicación en su totalidad**

- A través de XAMPP, deja activado el servicio de Apache y MySQL (revisa la configuración de la aplicación si llegas a tener problemas de conexión **core/conf/Config.php**)

- Luego Accede al navegador web por esa misma dirección y deberías ver la aplicación en funcionamiento

**Ante cualquier novedad que presentes o tengas alguna duda, puede enviarme un mensaje a infojuansedev2@gmail.com.**
