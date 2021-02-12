<?php

//Llamar a las librerias
include_once 'inc/funciones/conexion.php';
include 'inc/funciones/sesiones.php';
session_start();

$lista = ''; //Inicializar la lista vacía
$busqueda = $_POST['busqueda']; //Este es el texto que vamos a buscar

$resultadosPorPagina = $_POST['nPorPagina'];
$indice = 0;
$paginaActual = 1;
$error = false;

$query = $conn->query("SELECT COUNT(*) AS total FROM amigos WHERE CONCAT(nombre, ' ', apellido) LIKE '%$busqueda%' ");
$resultado = $query->fetch_assoc();
$nResultados = $resultado['total'];
$totalPaginas = $nResultados / $resultadosPorPagina;

//Si estas en otra pagina
if(isset($_POST['paginaActual'])){
    //Validar que sea un numero
    if(is_numeric($_POST['paginaActual'])){
        //Validar que este en un rango valido
        if($_POST['paginaActual'] >= 1 && $_POST['paginaActual'] <= $totalPaginas + 1){
            $paginaActual = $_POST['paginaActual'];
            $indice = ($paginaActual - 1) * ($resultadosPorPagina);
        }else{
            echo "No existe esa página";
            $error = true;
        }
    }else{
        echo "Error al mostrar la página";
        $error = true;
    }
}

//Mostrar amigos
if(!$error) {
    //Continuar
    $id_usuario = (int) $_SESSION['id'];

    $sql = "SELECT amigos.*, rango.letra FROM amigos ";
    $sql .= " JOIN rango ";
    $sql .= " ON amigos.rango = rango.id_rango ";
    $sql .= " WHERE id_usuario={$id_usuario}";
    $sql .= " AND CONCAT(nombre, ' ', apellido) LIKE '%$busqueda%' ";
    $sql .= " ORDER BY rango";
    $sql .= " LIMIT {$indice}, {$resultadosPorPagina}";
    $resultado = $conn->query($sql);
    $conn->close();
    

    //Mostrar la cantidad de resultados
    $resultadosEnPagina = $resultado->num_rows;
    $lista .= '<p class="cant-resultados">Mostrando <span>' . $resultadosEnPagina . '</span> de <span>' . $nResultados . '</span> resultados</p>';

    while($amigo = $resultado->fetch_assoc()) {
        include 'vista-amigo.php';
    }
        
} else{
    echo 'Error';
}

//Mostrar paginacion
$actual = '';
$lista .= '<div id="paginas">';
$lista .= "<ul>";
    for ($i=0; $i < $totalPaginas; $i++) {
        if(($i + 1) == $paginaActual) {
            $actual = ' class="actual btn-pagina" ';
        }else{
            $actual = ' class="btn-pagina" ';
        }
        $lista .= '<li><a ' . $actual . 'href="#">' . ($i + 1) . '</a></li>';
    }
$lista .= "</ul>";
$lista .= '</div>';

echo $lista;
