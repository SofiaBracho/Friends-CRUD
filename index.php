<?php
    include 'inc/funciones/funciones.php';
    include 'inc/templates/header.php';
    include 'inc/templates/barra.php';
    include 'inc/funciones/sesiones.php';
    session_start();
    usuario_autenticado();
?>

<div class="contenedor">
    <?php
        include 'inc/templates/sidebar.php';
    ?>

    <div class="contenido-principal">

        <h2>Lista de amigos</h2>
        <input type="text" id="busqueda" placeholder="Busca un amigo...">
        
        <div class="lista-contactos">

            <!-- Aqui se insertan los contactos y la paginacion -->

        </div>
    </div>
</div>

<?php
    include 'inc/templates/footer.php';
?>