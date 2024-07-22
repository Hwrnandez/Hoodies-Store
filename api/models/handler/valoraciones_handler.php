<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
 */
class ComentarioHandler
{
    /*
     *   Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $search = null;
    protected $idProducto = null;
    protected $idDetalle = null;
    protected $puntuacion = null;
    protected $mensaje = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $existencias = null;
    protected $imagen = null;
    protected $categoria = null;
    protected $estado = null;

    /*
     *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */

    /*
    public function searchRows()
    {
        $this->search = $this->search === '' ? '%%' : '%' . $this->search . '%';

        $sql = 'select id_comentario,id_detalle,CONCAT(nombre_cliente," ",apellido_cliente) as cliente,
        CONCAT(descripcion_marca," ",nombre_producto) as modelo,contenido_comentario,
        puntuacion_comentario,estado_comentario,
        DATE_FORMAT(cm.fecha_comentario, "%d-%m-%Y - %h:%i %p") AS fecha_comentario
        from comentarios cm
        INNER JOIN detalle_pedidos dp USING(id_detalle)
        INNER JOIN pedidos p USING(id_pedido)
        INNER JOIN clientes c USING(id_cliente)
        INNER JOIN productos mo USING (id_producto)
        INNER JOIN marcas ma USING (id_marca)
        WHERE CONCAT(nombre_cliente," ",apellido_cliente) like ? 
        OR CONCAT(descripcion_marca," ",nombre_producto) like ?
        ORDER BY fecha_comentario DESC, estado_comentario DESC';

        $params = array($this->search, $this->search);
        return Database::getRows($sql, $params);
    }
        */

    public function createRow()
    {

        $sql = 'INSERT INTO comentario(contenido_comentario,fecha_comentario,estado_comentario,puntuacion_comentario, id_detalle) VALUES(?,now(),true,?)';
        $params = array($this->mensaje, $this->puntuacion, $this->idDetalle,);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT 
    cm.id_comentario,
    cm.id_detalle,
    CONCAT(c.nombre_cliente, " ", c.apellido_cliente) AS cliente,
    mo.nombre_producto AS modelo,
    cm.contenido_comentario,
    cm.puntuacion_comentario,
    cm.estado_comentario,
    DATE_FORMAT(cm.fecha_comentario, "%d-%m-%Y - %h:%i %p") AS fecha_comentario
FROM 
    comentario cm
INNER JOIN 
    detalle_pedido dp ON cm.id_detalle = dp.id_detalle
INNER JOIN 
    pedido p ON dp.id_pedido = p.id_pedido
INNER JOIN 
    cliente c ON cm.id_cliente = c.id_cliente
INNER JOIN 
    producto mo ON cm.id_producto = mo.id_producto
INNER JOIN 
    marca ma ON mo.id_marca = ma.id_marca
ORDER BY 
    fecha_comentario DESC, estado_comentario DESC
LIMIT 
    0, 1000;';
        return Database::getRows($sql);
    }

    public function readAllActive()
    {
        $sql = 'SELECT 
    cm.id_producto,
    cm.id_comentario,
    cm.id_detalle,
    CONCAT(c.nombre_cliente, " ", c.apellido_cliente) AS cliente,
    mo.nombre_producto AS modelo,
    cm.contenido_comentario,
    cm.puntuacion_comentario,
    cm.estado_comentario,
    DATE_FORMAT(cm.fecha_comentario, "%d-%m-%Y - %h:%i %p") AS fecha_comentario
FROM 
    comentario cm
INNER JOIN 
    detalle_pedido dp ON cm.id_detalle = dp.id_detalle
INNER JOIN 
    pedido p ON dp.id_pedido = p.id_pedido
INNER JOIN 
    cliente c ON cm.id_cliente = c.id_cliente
INNER JOIN 
    producto mo ON cm.id_producto = mo.id_producto
WHERE 
    cm.id_producto = 1 AND cm.estado_comentario = TRUE
ORDER BY 
    cm.puntuacion_comentario DESC
LIMIT 
    0, 1000;';
        //echo $this->idProducto. ' que';
        $params = array($this->idProducto);

        return Database::getRows($sql, $params);
    }
    public function readByIdDetalle()
    {
        $sql = 'SELECT 
    cm.id_producto,
    cm.id_comentario,
    cm.id_detalle,
    CONCAT(c.nombre_cliente, " ", c.apellido_cliente) AS cliente,
    mo.nombre_producto AS modelo,
    cm.contenido_comentario,
    cm.puntuacion_comentario,
    cm.estado_comentario,
    DATE_FORMAT(cm.fecha_comentario, "%d-%m-%Y - %h:%i %p") AS fecha_comentario
FROM 
    comentario cm
INNER JOIN 
    detalle_pedido dp ON cm.id_detalle = dp.id_detalle
INNER JOIN 
    pedido p ON dp.id_pedido = p.id_pedido
INNER JOIN 
    cliente c ON cm.id_cliente = c.id_cliente
INNER JOIN 
    producto mo ON cm.id_producto = mo.id_producto
INNER JOIN 
    marca ma ON mo.id_marca = ma.id_marca
WHERE 
    cm.id_detalle = 1
ORDER BY 
    cm.puntuacion_comentario DESC
LIMIT 
    0, 1000;';
        //echo $this->idProducto. ' que';
        $params = array($this->idDetalle);

        return Database::getRows($sql, $params);
    }
    public function readByIdComentario()
    {
        $sql = 'SELECT 
    cm.id_producto,
    cm.id_comentario,
    cm.id_detalle,
    CONCAT(c.nombre_cliente, " ", c.apellido_cliente) AS cliente,
    CONCAT(ma.nombre_marca, " ", mo.nombre_producto) AS modelo,
    cm.contenido_comentario,
    cm.puntuacion_comentario,
    cm.estado_comentario,
    DATE_FORMAT(cm.fecha_comentario, "%d-%m-%Y - %h:%i %p") AS fecha_comentario
FROM 
    comentario cm
INNER JOIN 
    detalle_pedido dp ON cm.id_detalle = dp.id_detalle
INNER JOIN 
    pedido p ON dp.id_pedido = p.id_pedido
INNER JOIN 
    cliente c ON cm.id_cliente = c.id_cliente
INNER JOIN 
    producto mo ON cm.id_producto = mo.id_producto
INNER JOIN 
    marca ma ON mo.id_marca = ma.id_marca
WHERE 
    cm.id_comentario = 1;';
        //echo $this->idProducto. ' que';
        $params = array($this->id);

        return Database::getRows($sql, $params);
    }


    public function readOne()
    {
        $sql = 'SELECT 
    cm.id_comentario,
    cm.id_detalle,
    CONCAT(c.nombre_cliente, " ", c.apellido_cliente) AS cliente,
    mo.nombre_producto AS modelo,
    cm.contenido_comentario,
    cm.puntuacion_comentario,
    cm.estado_comentario,
    DATE_FORMAT(cm.fecha_comentario, "%d-%m-%Y - %h:%i %p") AS fecha_comentario
FROM 
    comentario cm
INNER JOIN 
    detalle_pedido dp ON cm.id_detalle = dp.id_detalle
INNER JOIN 
    pedido p ON dp.id_pedido = p.id_pedido
INNER JOIN 
    cliente c ON cm.id_cliente = c.id_cliente
INNER JOIN 
    producto mo ON cm.id_producto = mo.id_producto
INNER JOIN 
    marca ma ON mo.id_marca = ma.id_marca
WHERE 
    cm.id_comentario = 1
ORDER BY 
    cm.fecha_comentario DESC, cm.estado_comentario DESC;';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        //$_SESSION['idmod'] = $data['id_producto'];

        return $data;
    }

    public function readFilename()
    {
        $sql = 'SELECT foto
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE comentarios
                SET estado_comentario = ?
                WHERE id_comentario = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readProductosCategoria()
    {
        $sql = 'SELECT mo.id_producto, mo.descripcion,mo.foto, mo.estado,ma.descripcion as marca
        FROM productos mo
        INNER JOIN ctg_marcas ma USING(id_marca)
        WHERE mo.id_marca LIKE ? OR estado="A"
        ORDER BY mo.descripcion';
            /*'SELECT id_producto, imagen_producto, nombre_producto, nombre_producto, precio_producto, existencias_producto
            FROM producto
            INNER JOIN categoria USING(id_categoria)
            WHERE id_categoria = ? AND estado_producto = true
            ORDER BY nombre_producto'*/;
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }

    /*
     *   Métodos para generar gráficos.
     */
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, COUNT(id_producto) cantidad
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY cantidad DESC LIMIT 5';
        return Database::getRows($sql);
    }

    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM producto)), 2) porcentaje
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    /*
     *   Métodos para generar reportes.
     */
    public function productosCategoria()
    {
        $sql = 'SELECT nombre_producto, precio_producto, estado_producto
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                WHERE id_categoria = ?
                ORDER BY nombre_producto';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }
}
