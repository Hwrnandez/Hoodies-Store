drop database if exists hoodiesstore;
create database hoodiesstore;
use hoodiesstore; 

create table cliente (
id_cliente int not null primary key auto_increment,
nombre_cliente varchar (50) not null,
apellido_cliente varchar (20) not null,
telefono_cliente varchar (9) not null,
direccion_cliente varchar(250) not null,
estado_cliente boolean default(1) not null,
correo_cliente varchar (50) not null unique,
clave_cliente varchar (100) not null
);

create table administrador (
id_administrador int not null primary key auto_increment,
nombre_administrador varchar (50) not null,
apellido_administrador varchar (50) not null,
correo_administrador varchar(59) not null unique,
clave_administrador varchar (100) not null
);

SELECT * FROM administrador;
create table talla_producto(
id_talla int not null primary key auto_increment,
nombre_talla varchar (5) not null
);

create table categoria(
id_categoria_hoodie int not null primary key auto_increment,
descripcion_categoria varchar (50) not null,
nombre_categoria varchar (40) not null unique,
img_categoria varchar (25) not null
);

create table marca (
id_marca int not null primary key auto_increment,
nombre_marca varchar (40) not null,
imagen_marca varchar (50) not null
);

create table producto(
id_producto int not null primary key auto_increment,
id_categoria_hoodie int not null,
constraint fk_producto_categoria
foreign key (id_categoria_hoodie) references categoria (id_categoria_hoodie),
id_marca int not null,
constraint fk_producto_marca
foreign key (id_marca) references  marca (id_marca),
nombre_producto varchar (50) not null unique,
descripcion_producto varchar (50) not null,
precio_producto DECIMAL(5,2) not null,
id_administrador int not null,
constraint fk_producto_administrador
foreign key(id_administrador) references administrador (id_administrador),
estado_producto boolean not null,
imagen_producto varchar (25) not null,
existencia_producto int not null
);

create table pedido (
id_pedido int not null primary key auto_increment,
direccion_pedido varchar (200) not null,
estado_pedido enum ('Pendiente','Finalizado','Entregado')not null,
fecha_regristo_pedido date not null,
id_cliente int,
constraint fk_pedido_cliente
foreign key (id_cliente) references cliente (id_cliente)
);

create table detalle_pedido(
id_detalle int not null primary key auto_increment,
id_pedido int,
constraint fk_detalle_pedido
foreign key (id_pedido) references pedido (id_pedido),
id_producto int,
constraint fk_id_producto
foreign key (id_producto) references producto (id_producto),
cantidad_producto int not null,
precio_producto numeric (5,2) not null
);

CREATE TABLE valoracion(
id_comentario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
descripcion_comentario VARCHAR(250) NOT NULL,
puntuacion INT UNSIGNED NOT NULL,
fecha_comentario DATE DEFAULT current_timestamp(),
estado_comentario BOOLEAN NOT NULL,
id_cliente INT NOT NULL,
CONSTRAINT fk_valoracion_cliente
FOREIGN KEY (id_cliente)
REFERENCES cliente (id_cliente),
id_producto INT NOT NULL,
CONSTRAINT fk_valoracion_producto
FOREIGN KEY (id_producto)
REFERENCES producto (id_producto)
);