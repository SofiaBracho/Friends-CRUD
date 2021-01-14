<?php
// die(json_encode($_FILES));

include_once 'inc/funciones/conexion.php';

if($_POST['registro'] == 'nuevo' ) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $ocupacion = $_POST['ocupacion'];
    $biografia = $_POST['biografia'];
    $rango = (int) $_POST['rango'];
    $fecha = $_POST['fecha'];
    $fecha_formateada = date('Y-m-d', strtotime($fecha) );

    //Crear un arreglo con los inputs llenos
    $likes = $_POST['like'];
    $json_like = array();
    foreach ($likes as $like) {
        if($like != '') {
            $json_like[] = $like;
        }
    }
    $json_like = json_encode($json_like);

    //Crear un arreglo con los inputs llenos
    $unlikes = $_POST['unlike'];
    $json_unlike = array();
    foreach ($unlikes as $unlike) {
        if($unlike != '') {
            $json_unlike[] = $unlike;
        }
    }
    $json_unlike = json_encode($json_unlike);

    $id_usuario = (int) $_POST['usuario'];

    $directorio = "img/amigos/";
    
    if(!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }
    
    if(move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name'])) {
        $imagen_url = $_FILES['imagen']['name'];
        $imagen_resultado = "Se subió correctamente";
    } else {
        $respuesta = array(
            "error" => error_get_last()
        );
    }

    try {
        $stmt = $conn->prepare("INSERT INTO amigos (nombre, apellido, ocupacion, biografia, gusta, disgusta, rango, url_imagen, id_usuario, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssisis", $nombre, $apellido, $ocupacion, $biografia, $json_like, $json_unlike, $rango, $imagen_url, $id_usuario, $fecha_formateada);
        $stmt->execute();
        $amigo_id = $stmt->insert_id;

        if($stmt->affected_rows) {
            $respuesta = array(
                'id_insertado' => $amigo_id,
                'respuesta' => 'exito',
                'imagen_resultado' => $imagen_resultado
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    die(json_encode($respuesta));
}

if($_POST['registro'] == 'editar' ) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $ocupacion = $_POST['ocupacion'];
    $biografia = $_POST['biografia'];
    $rango = (int) $_POST['rango'];

    $fecha = $_POST['fecha'];
    $fecha_formateada = date('Y-m-d', strtotime($fecha) );

    //Crear un arreglo con los inputs llenos
    $likes = $_POST['like'];
    $json_like = array();
    foreach ($likes as $like) {
        if($like != '') {
            $json_like[] = $like;
        }
    }
    $json_like = json_encode($json_like);

    //Crear un arreglo con los inputs llenos
    $unlikes = $_POST['unlike'];
    $json_unlike = array();
    foreach ($unlikes as $unlike) {
        if($unlike != '') {
            $json_unlike[] = $unlike;
        }
    }
    $json_unlike = json_encode($json_unlike);

    $id = (int) $_POST['contacto'];

    if($_FILES['imagen']['name'] != '') {

        $directorio = "img/amigos/";
        
        if(!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        
        if(move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name'])) {
            $imagen_url = $_FILES['imagen']['name'];
            $imagen_resultado = "Se subió correctamente";
        } else {
            $respuesta = array(
                "error" => error_get_last()
            );
        }
    }

    try {
        if($_FILES['imagen']['name'] != '') {
            $stmt = $conn->prepare("UPDATE amigos SET nombre = ?, apellido = ?, ocupacion = ?, biografia = ?, gusta = ?, disgusta = ?, rango = ?, url_imagen = ?, fecha_nacimiento = ? WHERE id = ? ");
            $stmt->bind_param("ssssssissi", $nombre, $apellido, $ocupacion, $biografia, $json_like, $json_unlike, $rango, $imagen_url, $fecha_formateada, $id);
        } else {
            $stmt = $conn->prepare("UPDATE amigos SET nombre = ?, apellido = ?, ocupacion = ?, biografia = ?, gusta = ?, disgusta = ?, rango = ?, fecha_nacimiento = ? WHERE id = ? ");
            $stmt->bind_param("ssssssisi", $nombre, $apellido, $ocupacion, $biografia, $json_like, $json_unlike, $rango, $fecha_formateada, $id);
        }
        $stmt->execute();

        if($stmt->affected_rows) {
            $respuesta = array(
                'id_insertado' => $id,
                'respuesta' => 'exito'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    die(json_encode($respuesta));
}

if($_POST['registro'] == 'eliminar' ) {

    $id = (int) $_POST['id'];

    try {
        $resultado = $conn->query("SELECT url_imagen FROM amigos WHERE id = {$id}");
        $resultado = $resultado->fetch_assoc();

        $directorio = "img/amigos/";
        unlink($directorio . $resultado['url_imagen']);

        $stmt = $conn->prepare("DELETE FROM amigos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt->affected_rows) {
            $respuesta = array(
                'id_insertado' => $id,
                'respuesta' => 'exito'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    die(json_encode($respuesta));
}