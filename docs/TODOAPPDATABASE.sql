-- Create the database and use it
create database todoappdatabase;
use todoappdatabase;
-- Create the tables
create table usuario(
	id_usuario int primary key not null auto_increment,
    nombres varchar(20) not null,
    apellidos varchar(20) not null,
    correo varchar(100) not null,
    contrasena varchar(255) not null,
    fecha_registro timestamp default current_timestamp,
    fecha_actualizacion timestamp default current_timestamp on update current_timestamp
);
create table tarea(
	id_tarea int primary key not null auto_increment,
    id_usuario int not null,
    titulo varchar(30),
    descripcion varchar(100),
    fecha timestamp,
	FOREIGN KEY(id_usuario) REFERENCES usuario (id_usuario)
	ON DELETE CASCADE 
	ON UPDATE CASCADE
);




