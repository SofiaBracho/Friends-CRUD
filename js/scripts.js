$(function() {
    eventListeners();

    function eventListeners() {
        $('#btn-like').on('click', agregarLike);
        $('#btn-unlike').on('click', agregarUnlike);        
    }

    const listaLikes = document.querySelector('#lista-like');
    const listaUnlikes = document.querySelector('#lista-unlike');

    function agregarLike(e) {
        e.preventDefault();

        let nuevoLike = document.createElement('input');
        nuevoLike.setAttribute('type', 'text');
        nuevoLike.setAttribute('name', 'like[]');
        nuevoLike.setAttribute('placeholder', '¿Qué le gusta?');

        listaLikes.appendChild(nuevoLike);
    }

    function agregarUnlike(e) {
        e.preventDefault();

        let nuevoUnlike = document.createElement('input');
        nuevoUnlike.setAttribute('type', 'text');
        nuevoUnlike.setAttribute('name', 'unlike[]');
        nuevoUnlike.setAttribute('placeholder', '¿Qué no le gusta?');

        listaUnlikes.appendChild(nuevoUnlike);
    }

    // Al agregar un nuevo registro
    $('#formulario-registro').on('submit', function(e) {
        e.preventDefault();

        let nombre = document.querySelector('#nombre').value;
        let apellido = document.querySelector('#apellido').value;
        let ocupacion = document.querySelector('#ocupacion').value;
        let biografia = document.querySelector('#biografia').value;
        let rango = document.querySelector('#rango').value;
        let imagen = document.querySelector('#imagen').value;
        let registro = document.querySelector('#registro').value;

        if(nombre != '' && apellido != '' && ocupacion != '' && biografia != '' && rango != '') {
            if(registro == 'editar' || imagen != '') {
                let datos = new FormData(this);

                $.ajax({
                    type: $(this).attr('method'),
                    data: datos,
                    url: $(this).attr('action'),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    async: true,
                    cache: false,
                    success: function(data) {
                        let resultado = data;

                        console.log(resultado);

                        if(resultado.respuesta == 'exito') {
                            swal({
                                type: 'success',
                                title: 'Correcto',
                                text: 'Se guardó correctamente'
                            })
                            setTimeout(function() { 
                                window.location.href = 'index.php';
                            }, 2000);
                        } else {
                            let error = resultado.error;
                            swal({
                                type: 'error',
                                title: 'Error',
                                text: error
                            })
                        }
                    }
                });
            } else {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Debes llenar todos los campos'
                })
            }
        }
    });

    // Al eliminar un registro
    $('#borrar-contacto').on('click', function(e) {
        let id = $(this).attr('data-id');
        
        swal({
            title: '¿Estás seguro que deseas eliminar el amigo?',
            text: 'No podrás revertirlo',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value) {
                // Borrar de la BD
                $.ajax({
                    type: 'post',
                    data: {
                        'id': id,
                        'registro': 'eliminar'
                    },
                    url: 'modelo-contacto.php',
                    dataType: 'json',
                    success: function(data) {
                        if(data.respuesta == 'exito') {
                            // Mostrar mensaje
                            swal({
                                title: '¡Borrado!',
                                text: 'El contacto ha sido borrado',
                                type: 'success'
                            })
                            setTimeout(function() { 
                                window.location.href = 'index.php';
                            }, 2000);
                        } else {
                            swal({
                                title: 'Error',
                                text: 'Hubo un error al eliminar',
                                type: 'error'
                            })
                        }
                    }
                });
            }
        })
    });

    //Buscador

    nPorPagina = 5;

    obtenerContactos('', nPorPagina);
    //Busca un texto y escribe en el html los registros que coinciden
    function obtenerContactos(busqueda, nPorPagina, paginaActual){
        $.ajax({
            type: 'post',
            data: {
                'busqueda': busqueda,
                'nPorPagina': nPorPagina,
                'paginaActual': paginaActual
            },
            url: 'paginacion-contacto.php',
            dataType: 'html',
            success: function(data) {
                $('.lista-contactos').html(data);
            }
        }).then((result) => {
            //Al hacer click en la paginacion cambia de pagina
            $('a.btn-pagina').on('click', function(e){
                e.preventDefault();
                let pagina = this.innerText;
                obtenerContactos(busqueda, nPorPagina, pagina);
            });
        }).catch((err) => {
            
        });
    }

    //Al hacer una busqueda
    $('#busqueda').on('keyup', function(){
        let valorBusqueda = this.value;
        obtenerContactos(valorBusqueda, nPorPagina);
    });

    //Date range picker
    $('#fecha').datetimepicker({
        format: 'L'
    });
    //Initialize Select2 Elements
    $('.seleccion').select2()

    //Menú Opciones
    $('#btn-opciones').on('click', function(e){
        e.preventDefault();
        //Boton de cerrar sesion
        let cerrarSesion = $('#logout')[0];
        
        if(cerrarSesion.style.display == 'none' || cerrarSesion.style.display == '') {
            //Mostrar las opciones del menú
            $('#logout').show();
        }else {
            //Ocultar las opciones del menú
            $('#logout').hide();
        }
        
    });
    
})