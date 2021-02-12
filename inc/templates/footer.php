<footer>Todos los derechos reservados Friends! 2020</footer>

<script src="js/sweetalert2.all.min.js"></script>
<script src="js/vendor/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="js/daterangepicker.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Select2 -->
<script src="js/select2.full.min.js"></script>
<?php
    $actual = obtenerPaginaActual();

    if($actual === 'login' || $actual === 'crear-cuenta') {
        echo '<script src="js/formulario.js"></script>';
    } else {
        echo '<script src="js/scripts.js"></script>';
    }
?>

</body>
</html>