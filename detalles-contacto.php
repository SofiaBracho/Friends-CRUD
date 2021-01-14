<?php
    include 'inc/funciones/sesiones.php';
    include 'inc/funciones/funciones.php';
    include 'inc/templates/header.php';
    include 'inc/templates/barra.php';
    session_start();
    usuario_autenticado();
    $id_usuario = (int) $_SESSION['id'];
    $id_amigo = $_GET['id'];
    if(!filter_var($id_amigo, FILTER_VALIDATE_INT) ){
        die("Error!");
    }
?>

<div class="contenedor">
    <?php
        include 'inc/templates/sidebar.php';
    ?>

    <div class="contenido-principal">

        <?php
            include 'inc/funciones/conexion.php';

            // Extraer el amigos de la BD
            try {
                $sql = "SELECT amigos.*, rango.letra FROM amigos ";
                $sql .= " JOIN rango ";
                $sql .= " ON amigos.rango = rango.id_rango ";
                $sql .= " WHERE id_usuario={$id_usuario} && id={$id_amigo}";
                $resultado = $conn->query($sql);
                
                if($resultado->num_rows != 0) {
                    $amigo = $resultado->fetch_assoc();
                }else {
                    die("¡Error!, el contacto no existe.");
                }

            } catch (Exception $e) {
                $error = $e->getMessage();
                echo $error;
            }
        ?>

        <div class="info-contacto">
            <div class="contenedor-info">
                <div class="contenedor-info-basica">
                    <div class="grupo">
                        <img src="img/amigos/<?php echo $amigo['url_imagen']; ?>" alt="Imagen <?php echo $amigo['nombre']; ?>">
                        <h2><?php echo $amigo['nombre'] . ' ' . $amigo['apellido']; ?></h2>
                    </div>
                    <div class="opciones">
                        <a href="editar-contacto.php?id=<?php echo $amigo['id'] ?>" class="btn-editar btn"><i class="fa fa-pen-square"></i></a>
                        <button class="btn-borrar btn" id="borrar-contacto" data-id="<?php echo $amigo['id'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>

                <div class="contenedor-rango">
                    <p class="rango <?php echo $amigo['letra']; ?>"><?php echo $amigo['letra']; ?></p>
                </div>
            </div>

            <p> <b>Ocupación: </b> <?php echo $amigo['ocupacion']; ?></p>
            <p> <b>Cumpleaños: </b> 
            <?php
              //Windows cambiar idioma
              setlocale(LC_TIME, 'spanish');
            
              echo strftime( "%d de %B de %Y", strtotime($amigo['fecha_nacimiento'])); 
            ?>
            <p class="biografia"><?php echo $amigo['biografia']; ?></p>

            <?php 
                $like = json_decode($amigo['gusta']);
                $unlike = json_decode($amigo['disgusta']);
            ?>

            <div class="tablas">
                <table class="tabla-like">
                    <thead>
                        <tr>
                            <th>Le gusta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($like as $likes) { ?>
                                <tr>
                                    <td><?php echo $likes; ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <table class="tabla-unlike">
                    <thead>
                        <tr>
                            <th>No le gusta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($unlike as $unlikes) { ?>
                                <tr>
                                    <td><?php echo $unlikes; ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
    include 'inc/templates/footer.php';
?>