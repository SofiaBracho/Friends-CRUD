<?php
    include 'inc/funciones/sesiones.php';
    include 'inc/funciones/funciones.php';
    include 'inc/templates/header.php';
    include 'inc/templates/barra.php';
    session_start();
    usuario_autenticado();
?>

<div class="contenedor">
    <?php
        include 'inc/templates/sidebar.php';
    ?>

    <div class="contenido-principal">

        <h2>Agregar amigo</h2><small>Llena todos los campos</small>
        <div class="agregar-contacto">
            <form method="post" action="modelo-contacto.php" id="formulario-registro" enctype="multipart/form-data">
                <div class="campos">
                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre">
                    </div>
                    <div class="campo">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido">
                    </div>
                    <div class="campo">
                        <label for="ocupacion">Ocupacion:</label>
                        <input type="text" name="ocupacion" id="ocupacion" placeholder="Ocupacion">
                    </div>

                    <div class="campo biografia">
                        <label for="biografia">Biografía:</label>
                        <textarea name="biografia" id="biografia" rows="10" placeholder="Una descripción de la persona..."></textarea>
                    </div>
                    
                    <div class="like-unlike">
                        <label for="like">Le gusta:</label>
                        <div id="lista-like">
                            <input type="text" name="like[]" placeholder="¿Qué le gusta?">
                        </div>
                        <a href="#" id="btn-like"><i class="fa fa-plus"></i></a>
                    </div>
                    
                    <div class="like-unlike">
                        <label for="unlike">No le gusta:</label>
                        <div id="lista-unlike">
                            <input type="text" name="unlike[]" placeholder="¿Qué no le gusta?">
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
                            <input type="text" class="form-control datetimepicker-input" name="fecha" data-target="#fecha" placeholder="Fecha de nacimiento"/>
                        </div>
                    </div>
                    <!-- /.form group -->

                    <div class="campo rango">
                        <label for="rango">Rango:</label>
                        <select name="rango" class="seleccion" id="rango">
                            <option selected>--Seleccione--</option>
                            <option value="1">S</option>
                            <option value="2">A</option>
                            <option value="3">B</option>
                            <option value="4">C</option>
                            <option value="5">D</option>
                        </select>
                    </div>
                    <div class="campo">
                        <label for="imagen">Imagen:</label>
                        <input type="file" name="imagen" id="imagen">
                    </div>

                    <div class="campo-enviar">
                        <input type="hidden" name="registro" value="nuevo" id="registro">
                        <input type="hidden" name="usuario" value="<?php echo $_SESSION['id']; ?>">
                        <input type="submit" value="Agregar" class="btn-agregar">
                    </div>
                    

                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include 'inc/templates/footer.php';
?>