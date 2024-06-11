<?php
//Metódo que permite editar la información del admin que se ha logueado.    
            case 'createValoracion':
                $_POST = Validator::validateForm($_POST);
                // Verificar si el cliente ha comprado el producto antes de permitir la valoración
                if (!$valoraciones->setIdCliente($_SESSION['idCliente']) || !$valoraciones->setIdProducto($_POST['idProducto'])) {
                    $result['error'] = 'Datos inválidos';
                } elseif ($valoraciones->readCountValoracion() == 0) {
                    $result['error'] = 'No puedes valorar este producto porque no lo has comprado';
                } elseif (
                    !$valoraciones->setCalificaionValoracion($_POST['calificacionValoracion']) ||
                    !$valoraciones->setComentarioValoracion($_POST['comentarioValoracion'])
                ) {
                    $result['error'] = $valoraciones->getDataError();
                } elseif ($valoraciones->createValoracion()) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoración agregada';
                } else {
                    $result['error'] = 'Ocurrió un problema al guardar la valoración';
                }
                break;
                //Metodo para leer los comentarios de un producto
            case 'readComentarios':
                if (!$valoraciones->setIdProducto($_POST['idProducto'])) {
                    $result['error'] = $valoraciones->getDataError();
                } elseif ($result['dataset'] = $valoraciones->readComentarios()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Este producto no ha sido comentado';
                }
                break;