DROP DATABASE IF EXISTS checkpointStore;
CREATE DATABASE checkpointStore;
USE checkpointStore;

CREATE TABLE administradores(
  id_admin int primary key auto_increment,
  nombre varchar(50) not null,
  appat varchar(50) not null,
  apmat varchar(50) not null,
  email varchar(80) not null,
  password varchar(255) not null,
  estado boolean not null,
  foto_path varchar(255) not null,
  telefono varchar(10) not null
);

CREATE TABLE clientes(
  id_cliente int primary key auto_increment,
  nombre varchar(50) not null,
  appat varchar(50) not null,
  apmat varchar(50) not null,
  email varchar(80) not null,
  password varchar(255) not null,
  estado boolean not null,
  foto_path varchar(255) not null,
  telefono varchar(10)  not null,
  codigo_postal VARCHAR(5) not null,
  estado_domicilio VARCHAR(30) not null,
  alc_mun VARCHAR(40) not null,
  colonia VARCHAR(40) not null,
  calle VARCHAR(30) not null,
  no_ext VARCHAR(10) not null,
  no_int VARCHAR(10)
);

CREATE TABLE empleados(
  id_empleado int primary key auto_increment,
  nombre varchar(50) not null,
  appat varchar(50) not null,
  apmat varchar(50) not null,
  email varchar(80) not null,
  password varchar(255) not null,
  estado boolean not null,
  foto_path varchar(255) not null,
  telefono varchar(10) not null
);

CREATE TABLE productos(
  id_producto int primary key auto_increment,
  nombre varchar(50) not null,
  categoria1 varchar(50) not null,
  categoria2 varchar(50) not null,
  categoria3 varchar(50) not null,
  precio double not null,
  estado boolean not null,
  descripcion text not null,
  cantidad int not null,
  foto_path varchar(255)  not null
);

CREATE TABLE carrito(
  id_cliente int not null,
  id_producto int not null,
  cantidad int not null,
  total double not null,
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
  FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE ventas(
  id_venta int primary key auto_increment,
  id_empleado int not null,
  id_cliente int not null,
  fecha date not null,
  hora time not null,
  total double not null,
  FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

CREATE TABLE detalle_venta(
  id_venta int not null,
  id_producto int not null,
  cantidad int not null,
  importe double not null,
  FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
  FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE pedidos(
  id_pedido int primary key auto_increment,
  id_cliente int not null,
  fecha date not null,
  hora time not null,
  total double not null,
  pendiente boolean not null,
  cancelado boolean not null,
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

CREATE TABLE detalle_pedidos(
  id_pedido int not null,
  id_producto int not null,
  cantidad int not null,
  importe double not null,
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
  FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE estado_pedidos(
  id_pedido int not null,
  id_empleado int not null,
  estado varchar(30) not null,
  FOREIGN KEY(id_pedido) REFERENCES pedidos(id_pedido),
  FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

-- Creación del administrador
-- password = admin
INSERT INTO administradores VALUES (DEFAULT, "Administrador", "Appat Admin", "Apmat Admin", "admin@admin.com", "$2y$10$0x8N0REE0XEklLiJoJx8euRbLKJ7DJzb6/CW5gn.1ELNTqlt.mKI6", true, "", "");