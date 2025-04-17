DROP DATABASE IF EXISTS checkpointStore;
CREATE DATABASE checkpointStore;
USE checkpointStore;

CREATE TABLE administradores(
  id_admin int primary key auto_increment,
  nombre_admin varchar(50) not null,
  appat_admin varchar(50) not null,
  apmat_admin varchar(50) not null,
  correo_admin varchar(50) not null,
  password_admin varchar(30) not null,
  estado_admin boolean not null,
  foto_path_admin varchar(255) not null,
  telefono_admin varchar(10) not null
);

CREATE TABLE clientes(
  id_cliente int primary key auto_increment,
  nombre_cliente varchar(50) not null,
  appat_cliente varchar(50) not null,
  apmat_cliente varchar(50) not null,
  correo_cliente varchar(50) not null,
  password_cliente varchar(255) not null,
  estado_cliente boolean not null,
  foto_path_cliente varchar(255) not null,
  telefono_cliente varchar(10)  not null,
  domicilio_cliente text not null
);

CREATE TABLE empleados(
  id_empleado int primary key auto_increment,
  nombre_empleado varchar(50) not null,
  appat_empleado varchar(50) not null,
  apmat_empleado varchar(50) not null,
  correo_empleado varchar(50) not null,
  password_empleado varchar(255) not null,
  estado_empleado boolean not null,
  foto_path_empleado varchar(255) not null,
  telefono_empleado varchar(10) not null
);

CREATE TABLE productos(
  id_producto int primary key auto_increment,
  nombre_producto varchar(50) not null,
  tipo_producto varchar(50) not null,
  plataforma_producto varchar(50),
  precio_producto double not null,
  estado_producto boolean not null,
  descripcion_producto text not null,
  cantidad_producto int not null,
  foto_path_producto varchar(255)  not null
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
  fecha_venta date not null,
  hora_venta time not null,
  total_venta double not null,
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
  fecha_pedido date not null,
  hora_pedido time not null,
  total_pedido double not null,
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