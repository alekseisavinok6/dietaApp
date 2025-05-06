create databas prueba_dietaapp;
use prueba_dietaapp;

create table clientes(
    id_cliente int auto_increment primary key,
    nombre varchar(30) not null,
    apellido varchar(30) not null,
    correo varchar(50) unique not null,
    password varchar(255) not null,
    edad int not null,
    sexo enum('Hombre','Mujer') not null,
    altura int,
    peso_deseado int,
    enfermedades text,
    alergias text
);