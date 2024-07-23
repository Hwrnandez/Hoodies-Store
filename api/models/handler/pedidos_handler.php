<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*   Clase para manejar el comportamiento de los datos de las tablas PEDIDO y DETALLE_PEDIDO.
*/
class PedidoHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $id_pedido = null;
    protected $id_detalle = null;
    protected $cliente = null;
    protected $producto = null;
    protected $cantidad = null;
    protected  $estado = null;
 
    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/productos/';
 
    /*
    *   ESTADOS DEL PEDIDO
    *   Pendiente (valor por defecto en la base de datos). Pedido en proceso y se puede modificar el detalle.
    *   Finalizado. Pedido terminado por el cliente y ya no es posible modificar el detalle.
    *   Entregado. Pedido enviado al cliente.
    *   Anulado. Pedido cancelado por el cliente después de ser finalizado.
    */
 
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    // Método para verificar si existe un pedido en proceso con el fin de iniciar o continuar una compra.
    public function getOrder()
    {
        $this->estado = 'Pendiente';
        $sql = 'SELECT id_pedido
                FROM pedido
                WHERE estado_pedido = ? AND id_cliente = ?';
        $params = array($this->estado, $_SESSION['idCliente']);
        if ($data = Database::getRow($sql, $params)) {
            $_SESSION['idPedido'] = $data['id_pedido'];
            return true;
        } else {
            return false;
        }
    }
 
    // Método para iniciar un pedido en proceso.
    public function startOrder()
    {
        if ($this->getOrder()) {
            return true;
        } else {
            $sql = 'INSERT INTO pedido(direccion_pedido, fecha_regristo_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM cliente WHERE id_cliente = ?),now(), ?)';
            $params = array($_SESSION['idCliente'], $_SESSION['idCliente']);
            // Se obtiene el ultimo valor insertado de la llave primaria en la tabla pedido.
            if ($_SESSION['idPedido'] = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }
 
    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad_producto, id_pedido)
                VALUES(?, (SELECT precio_producto FROM producto WHERE id_producto = ?), ?, ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }
 
    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readDetail()
    {
        $sql = 'SELECT id_detalle, nombre_producto, detalle_pedido.precio_producto, detalle_pedido.cantidad_producto
                FROM detalle_pedido
                INNER JOIN pedido USING(id_pedido)
                INNER JOIN producto USING(id_producto)
                WHERE id_pedido = ?';
        $params = array($_SESSION['idPedido']);
        return Database::getRows($sql, $params);
    }
 
    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        $this->estado = 'Finalizado';
        $sql = 'UPDATE pedido
                SET estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }
 
    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE detalle_pedido
                SET cantidad_producto = ?
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->cantidad, $this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }
 
    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalle_pedido
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }
 
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT p.id_pedido,CONCAT(c.nombre_cliente," ",c.apellido_cliente) as cliente,
                DATE_FORMAT(p.fecha_regristo_pedido, "%d-%m-%Y") AS fecha, p.estado_pedido, p.direccion_pedido
                FROM pedido p
                INNER JOIN cliente c USING(id_cliente)
                WHERE nombre_cliente LIKE ?
                ORDER BY direccion_pedido';
        $params = array($value);
        return Database::getRows($sql, $params);
    }
 
    public function updateRow()
    {
        $sql = 'UPDATE pedido
                SET estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }
 
    public function readAll()
    {
        $sql = 'SELECT p.id_pedido,CONCAT(c.nombre_cliente," ",c.apellido_cliente) as cliente,
        DATE_FORMAT(p.fecha_regristo_pedido, "%d-%m-%Y") AS fecha, p.estado_pedido, p.direccion_pedido
        FROM pedido p
        INNER JOIN cliente c USING(id_cliente)
        ORDER BY p.fecha_regristo_pedido DESC, p.estado_pedido DESC';
        return Database::getRows($sql);
    }
 
    public function readAllreport()
    {
        $sql = 'SELECT p.id_pedido,CONCAT(c.nombre_cliente," ",c.apellido_cliente) as cliente,
        DATE_FORMAT(p.fecha_regristo_pedido, "%d-%m-%Y") AS fecha, p.estado_pedido, p.direccion_pedido
        FROM pedido p
        INNER JOIN cliente c USING(id_cliente)
        ORDER BY p.estado_pedido DESC';
        return Database::getRows($sql);
    }
 
 
    public function readOne()
    {
        $sql = 'SELECT p.id_pedido,CONCAT(c.nombre_cliente," ",c.apellido_cliente) as cliente,
        DATE_FORMAT(p.fecha_regristo_pedido, "%d-%m-%Y") AS fecha,p.estado_pedido, p.direccion_pedido
        from pedido p
        inner join cliente c USING(id_cliente)
        WHERE p.id_pedido = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        //$_SESSION['idmod'] = $data['id_modelo'];
 
        return $data;
    }
 
    /*
    *   Métodos para generar gráficos.
    */
    public function cantidadPedidosEstado()
    {
        $sql = 'SELECT estado_pedido, COUNT(id_pedido) AS cantidad
            FROM pedido
            GROUP BY estado_pedido
            ORDER BY cantidad DESC;';
        return Database::getRows($sql);
    }
 
    public function prediccionGanancia()
    {
        $sql = "WITH ventas AS (
                SELECT
                    DATE_FORMAT(p.fecha_regristo_pedido, '%Y-%m') AS mes,
                    ROUND(SUM(dp.cantidad_producto * dp.precio_producto), 2) AS ventas_mensuales,
                    CASE
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '01' THEN 'Enero'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '02' THEN 'Febrero'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '03' THEN 'Marzo'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '04' THEN 'Abril'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '05' THEN 'Mayo'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '06' THEN 'Junio'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '07' THEN 'Julio'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '08' THEN 'Agosto'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '09' THEN 'Septiembre'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '10' THEN 'Octubre'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '11' THEN 'Noviembre'
                        WHEN DATE_FORMAT(p.fecha_regristo_pedido, '%m') = '12' THEN 'Diciembre'
                    END AS nombre_mes,
                    ROW_NUMBER() OVER (ORDER BY DATE_FORMAT(p.fecha_regristo_pedido, '%Y-%m')) AS mes_indice
                FROM pedido p
                JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
                WHERE p.estado_pedido = 'Finalizado'
                GROUP BY DATE_FORMAT(p.fecha_regristo_pedido, '%Y-%m')
                ORDER BY DATE_FORMAT(p.fecha_regristo_pedido, '%Y-%m') DESC
                LIMIT 6 -- Cambia este valor según la cantidad de meses que desees mostrar
            ),
            coeficientes AS (
                SELECT
                    COUNT(*) AS n,
                    SUM(mes_indice) AS sum_x,
                    SUM(ventas_mensuales) AS sum_y,
                    SUM(mes_indice * ventas_mensuales) AS sum_xy,
                    SUM(mes_indice * mes_indice) AS sum_xx
                FROM ventas
            ),
            calculos AS (
                SELECT
                    (n * sum_xy - sum_x * sum_y) / (n * sum_xx - sum_x * sum_x) AS slope,
                    (sum_y - ((n * sum_xy - sum_x * sum_y) / (n * sum_xx - sum_x * sum_x)) * sum_x) / n AS intercept
                FROM coeficientes
            ),
            prediccion AS (
                SELECT
                    ROUND(c.slope * (MAX(v.mes_indice) + 1) + c.intercept, 2) AS prediccion_siguiente_mes,
                    CASE
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '01' THEN 'Enero'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '02' THEN 'Febrero'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '03' THEN 'Marzo'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '04' THEN 'Abril'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '05' THEN 'Mayo'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '06' THEN 'Junio'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '07' THEN 'Julio'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '08' THEN 'Agosto'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '09' THEN 'Septiembre'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '10' THEN 'Octubre'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '11' THEN 'Noviembre'
                        WHEN DATE_FORMAT(ADDDATE(MAX(p.fecha_regristo_pedido), INTERVAL 1 MONTH), '%m') = '12' THEN 'Diciembre'
                    END AS nombre_siguiente_mes
                FROM ventas v
                JOIN pedido p ON DATE_FORMAT(p.fecha_regristo_pedido, '%Y-%m') = v.mes
                CROSS JOIN calculos c
            )
            SELECT
                v.mes,
                v.ventas_mensuales,
                v.nombre_mes,
                p.prediccion_siguiente_mes,
                p.nombre_siguiente_mes
            FROM ventas v
            CROSS JOIN prediccion p
            ORDER BY v.mes ASC;
 ";
 
        $params = array();
        return Database::getRows($sql, $params);
    }
 
    public function PorcentajeEstadoPedidos()
    {
        $sql = 'SELECT estado_pedido, COUNT(*) as cantidad_pedidos
                FROM pedido
                GROUP BY estado_pedido';
        return Database::getRows($sql);
    }
   
    public function readFactura()
    {
        $sql = 'SELECT dp.id_detalle,
                p.nombre_producto, m.nombre_marca, c.nombre_categoria,
                dp.cantidad_producto, DATE_FORMAT(pe.fecha_regristo_pedido, "%h:%i %p - %e %b %Y") AS fecha,
                CONCAT(cl.nombre_cliente, " ", cl.apellido_cliente) AS nombre_completo,
                p.precio_producto
                FROM detalle_pedido dp
                INNER JOIN producto p ON dp.id_producto = p.id_producto
                INNER JOIN pedido pe ON dp.id_pedido = pe.id_pedido
                INNER JOIN marca m ON p.id_marca = m.id_marca
                INNER JOIN categoria c ON p.id_categoria_hoodie = c.id_categoria_hoodie
                INNER JOIN cliente cl ON pe.id_cliente = cl.id_cliente
                WHERE dp.id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}