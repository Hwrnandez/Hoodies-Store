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
 
 
 
CREATE TABLE comentario(
id_comentario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
contenido_comentario VARCHAR(250) NOT NULL,
fecha_comentario DATE DEFAULT current_timestamp(),
estado_comentario BOOLEAN NOT NULL,
puntuacion_comentario INT NOT NULL,
id_detalle INT NOT NULL,
CONSTRAINT FK_id_detalle
FOREIGN KEY (id_detalle)
REFERENCES detalle_pedido (id_detalle),
id_cliente INT NOT NULL,
CONSTRAINT fk__cliente
FOREIGN KEY (id_cliente)
REFERENCES cliente (id_cliente),
id_producto INT NOT NULL,
CONSTRAINT fk_comentario_producto
FOREIGN KEY (id_producto)
REFERENCES producto (id_producto)
);
 
INSERT INTO categoria (descripcion_categoria, nombre_categoria, img_categoria) VALUES 
('Hoodies hombre', 'Hombre', 'default.png'),
('Hoodies mujer', 'Mujer', 'default.png');
INSERT INTO marca (nombre_marca, imagen_marca) VALUES 
('Nike', 'default.png'),
('Adidas', 'default.png'),
('Puma', 'default.png'),
('Under Armour', 'default.png'),
('Reebok', 'default.png'),
('New Balance', 'default.png'),
('Converse', 'default.png'),
('Vans', 'default.png'),
('Fila', 'default.png'),
('Lacoste', 'default.png');
INSERT INTO producto (id_categoria_hoodie, id_marca, nombre_producto, descripcion_producto, precio_producto, id_administrador, estado_producto, imagen_producto, existencia_producto) VALUES 
(1, 1, 'Hoodie Nike Rojo', 'Hoodie de color rojo de la marca Nike', 49.99, 1, true, 'default.png', 100),
(2, 2, 'Hoodie Nike negro', 'Hoodie de color negro', 79.99, 1, true, 'default.png', 150);
INSERT INTO valoracion (descripcion_comentario, puntuacion, estado_comentario, id_cliente, id_producto) VALUES 
('¡El producto es increíble! Me encanta la calidad y el diseño.', 5, true, 1, 1),
('Buen producto, aunque el envío fue un poco lento.', 4, true, 2, 2);   
INSERT INTO cliente (nombre_cliente, apellido_cliente, telefono_cliente, direccion_cliente, estado_cliente, correo_cliente, clave_cliente) VALUES 
('Juan', 'Pérez', 1234567890, 'Calle 123, Ciudad X', true, 'juan@example.com', 'clave123'),
('María', 'Gómez', 9876543210, 'Avenida Principal, Ciudad Y', true, 'maria@example.com', 'clave456'),
('Carlos', 'Martínez', 5551234567, 'Carrera 45, Ciudad Z', true, 'carlos@example.com', 'clave789'),
('Ana', 'López', 3334445556, 'Avenida Central, Ciudad W', true, 'ana@example.com', 'claveabc'),
('Pedro', 'Rodríguez', 7778889990, 'Calle 67, Ciudad V', true, 'pedro@example.com', 'clavexyz'),
('Laura', 'Hernández', 1112223334, 'Calle 89, Ciudad U', true, 'laura@example.com', 'clave1234'),
('Sofía', 'Díaz', 6667778889, 'Carrera 10, Ciudad T', true, 'sofia@example.com', 'clave5678'),
('Pablo', 'García', 4445556667, 'Avenida Sur, Ciudad S', true, 'pablo@example.com', 'clave90ab'),
('Elena', 'Torres', 2223334445, 'Calle Este, Ciudad R', true, 'elena@example.com', 'clavecdef'),
('Javier', 'Fernández', 8889990001, 'Calle Oeste, Ciudad Q', true, 'javier@example.com', 'claveghij'),
('Luisa', 'Suárez', 1113335557, 'Avenida Norte, Ciudad P', true, 'luisa@example.com', 'claveklmn'),
('Diego', 'Vargas', 7778881113, 'Calle 11, Ciudad O', true, 'diego@example.com', 'claveopqr'),
('Valentina', 'Ramírez', 3334447772, 'Carrera 30, Ciudad N', true, 'valentina@example.com', 'clavestuv'),
('Andrés', 'López', 9990001114, 'Avenida 5, Ciudad M', true, 'andres@example.com', 'clavewxyz'),
('Gabriela', 'Castro', 4445558885, 'Calle 22, Ciudad L', true, 'gabriela@example.com', 'clave12345'),
('Mateo', 'Gutierrez', 6667772220, 'Carrera 40, Ciudad K', true, 'mateo@example.com', 'clave67890'),
('Camila', 'Sánchez', 2223336668, 'Avenida 15, Ciudad J', true, 'camila@example.com', 'claveabcde'),
('Daniel', 'Martínez', 8889992222, 'Calle 33, Ciudad I', true, 'daniel@example.com', 'clavefghij'),
('Isabella', 'Chávez', 1112223339, 'Carrera 25, Ciudad H', true, 'isabella@example.com', 'claveklmno');
INSERT INTO pedido (estado_pedido, fecha_regristo_pedido, direccion_pedido, id_cliente) VALUES
('Pendiente', '2024-01-01', 'Calle Sol 123, Ciudad Metrópolis', 1),
('Pendiente', '2024-02-01', 'Calle Sol 123, Ciudad Metrópolis', 1),
('Finalizado', '2024-03-02', 'Avenida Luna 456, Ciudad Estrella', 2),
('Entregado', '2024-05-03', 'Carrera Galaxia 789, Ciudad Nebulosa', 3),
('Pendiente', '2024-05-04', 'Calle Espacial 321, Ciudad Cósmica', 4),
('Finalizado', '2024-05-05', 'Avenida Saturno 654, Ciudad Interplanetaria', 5),
('Entregado', '2024-05-06', 'Carrera Andrómeda 987, Ciudad Celestial', 6),
('Pendiente', '2024-05-07', 'Calle Marte 210, Ciudad Astral', 7),
('Finalizado', '2024-05-08', 'Avenida Mercurio 543, Ciudad Galáctica', 8),
('Entregado', '2024-05-09', 'Carrera Plutón 876, Ciudad Universal', 9),
('Pendiente', '2024-05-10', 'Calle Júpiter 135, Ciudad Nebulosa', 10),
('Finalizado', '2024-05-11', 'Avenida Venus 468, Ciudad Metrópolis', 11),
('Entregado', '2024-05-12', 'Carrera Tierra 791, Ciudad Estrella', 12),
('Pendiente', '2024-04-13', 'Calle Urano 234, Ciudad Cósmica', 13),
('Finalizado', '2024-04-14', 'Avenida Neptuno 567, Ciudad Interplanetaria', 14),
('Entregado', '2024-04-15', 'Carrera Marte 890, Ciudad Celestial', 15),
('Pendiente', '2024-05-16', 'Calle Saturno 321, Ciudad Astral', 16),
('Finalizado', '2024-05-17', 'Avenida Mercurio 654, Ciudad Galáctica', 17),
('Entregado', '2024-05-18', 'Carrera Plutón 987, Ciudad Universal', 18),
('Pendiente', '2024-05-19', 'Calle Júpiter 210, Ciudad Nebulosa', 19);

            

				INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(3, (SELECT precio_producto FROM producto WHERE id_producto = 3), 2, 1);
                INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(4, (SELECT precio_producto FROM producto WHERE id_producto = 4), 2, 2);
                INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(3, (SELECT precio_producto FROM producto WHERE id_producto = 3), 2, 3);
                INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(4, (SELECT precio_producto FROM producto WHERE id_producto = 4), 2, 4);
                INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(4, (SELECT precio_producto FROM producto WHERE id_producto = 4), 2, 5);
                INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(3, (SELECT precio_producto FROM producto WHERE id_producto = 3), 2, 6);