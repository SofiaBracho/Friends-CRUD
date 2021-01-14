<?php
$lista .= 
    '<a class="link-amigo" href="detalles-contacto.php?id=' . $amigo['id'] . '">
        <div class="card">
            <div class="datos">
                <img src="img/amigos/' . $amigo['url_imagen'] . '" alt="Imagen ' . $amigo['nombre'] . '">
                <div class="info">
                    <h3>' . $amigo['nombre'] . ' ' . $amigo['apellido'] . '</h3>
                    <p>Ocupación: ' . $amigo['ocupacion'] . '</p>
                </div>
            </div>
            <p class="rango ' . $amigo['letra'] . '">' . $amigo['letra'] . '</p>
        </div>
    </a>'
?>