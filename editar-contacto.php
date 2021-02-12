<?php
    include 'inc/funciones/sesiones.php';
    include 'inc/funciones/funciones.php';
    include 'inc/templates/header.php';
    include 'inc/templates/barra.php';
    session_start();
    usuario_autenticado();
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
                $sql = "SELECT * FROM amigos WHERE id={$id_amigo}";
                $resultado = $conn->query($sql);
                $amigo = $resultado->fetch_assoc();
            } catch (Exception $e) {
                $error = $e->getMessage();
                echo $error;
            }

            $likes = json_decode($amigo['gusta']);
            $unlikes = json_decode($amigo['disgusta']);
        ?>

        <h2>Editar amigo</h2><small>Llena todos los campos</small>
        <div class="agregar-contacto">
            <form method="post" action="modelo-contacto.php" id="formulario-registro" enctype="multipart/form-data">
                <div class="campos">
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $amigo['nombre'] ?>">
                    </div>
                    <div class="campo">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido" value="<?php echo $amigo['apellido'] ?>">
                    </div>
                    <div class="campo">
                        <label for="ocupacion">Ocupacion:</label>
                        <input type="text" name="ocupacion" id="ocupacion" placeholder="Ocupacion" value="<?php echo $amigo['ocupacion'] ?>">
                    </div>

                    <div class="campo biografia">
                        <label for="biografia">Biografía:</label>
                        <textarea name="biografia" id="biografia" rows="10" placeholder="Una descripción de la persona..."><?php echo $amigo['biografia'] ?></textarea>
                    </div>
                    
                    <div class="like-unlike">
                        <label for="like">Le gusta:</label>
                        <div id="lista-like">
                            <?php
                                if(!count($likes)) { ?>
                                    <input type="text" name="like[]" placeholder="¿Qué le gusta?">
                            <?php   }else {
                                        foreach ($likes as $like) { ?>
                                            <input type="text" name="like[]" placeholder="¿Qué le gusta?" value="<?php echo $like; ?>">
                            <?php       }
                                    }
                            ?>
                        </div>
                        <a href="#" id="btn-like"><i class="fa fa-plus"></i></a>
                    </div>
                    
                    <div class="like-unlike">
                        <label for="unlike">No le gusta:</label>
                        <div id="lista-unlike">
                            <?php
                                if(!count($unlikes)) { ?>
                                    <input type="text" name="unlike[]" placeholder="¿Qué no le gusta?">
                            <?php   }else {
                                        foreach ($unlikes as $unlike) { ?>
                                            <input type="text" name="unlike[]" placeholder="¿Qué no le gusta?" value="<?php echo $unlike; ?>">
                            <?php       } 
                                    }
                            ?>
                        </div>
                        <a href="#" id="btn-unlike"><i class="fa fa-plus"></i></a>
                    </div>
                    
                    <!-- Date -->
                    <div class="contenedor-fecha">
                        <label for="fecha" name="fecha">Cumpleaños:</label>
                        <div class="date campo" id="fecha" data-target-input="nearest">
                            <div class="input-group-append" data-target="#fecha" data-toggle="datetimepicker">
                                <div class="input-group-text icono"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" name="fecha" data-target="#fecha" placeholder="Fecha de nacimiento" value="<?php echo(date('m-d-Y', strtotime($amigo['fecha_nacimiento']))); ?>">
                        </div>
                    </div>
                    <!-- /.form group -->

                    <div class="campo rango">
                        <label for="rango">Rango:</label>
                        <select name="rango"  class="seleccion" id="rango">
                            <option value="1" <?php echo ($amigo['rango'] == 1) ? 'selected' : '' ?>>S</option>
                            <option value="2" <?php echo ($amigo['rango'] == 2) ? 'selected' : '' ?>>A</option>
                            <option value="3" <?php echo ($amigo['rango'] == 3) ? 'selected' : '' ?>>B</option>
                            <option value="4" <?php echo ($amigo['rango'] == 4) ? 'selected' : '' ?>>C</option>
                            <option value="5" <?php echo ($amigo['rango'] == 5) ? 'selected' : '' ?>>D</option>
                        </select>
                    </div>

                    <div class="campo">
                        <img src="img/amigos/<?php echo $amigo['url_imagen']; ?>" width="200px">
                    </div>

                    <div class="campo">
                        <label for="imagen">Imagen:</label>
                        <input type="file" name="imagen" id="imagen">
                    </div>
                </div>
                <div class="campo-enviar">
                    <input type="hidden" name="registro" value="editar" id="registro">
                    <input type="hidden" name="contacto" value="<?php echo $id_amigo; ?>">
                    <input type="submit" value="Agregar" class="btn-agregar">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include 'inc/templates/footer.php';
?>