//$(function () {
$(document).ready(function() {
    
    var tableuser = $('#TabUsers').DataTable({
        serverSide: true,
        processing: true,
        ajax: 
        {   
            url:'/users/get',
            data: function (d) {
                d.search = $('#search').val();
            }
        },
        order: [[ 0, "asc" ]],
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Todos"]],
        /*dom: '',
        buttons: [
            'copy', 'csv', 'print'
        ],*/
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'profile_photo_path', name: 'profile_photo_path', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'rolname', name: 'roles.name'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at', searchable: false},
            {data: 'updated_at', name: 'updated_at', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            "sProcessing":     '<div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div>',
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "print": "Imprimir",
                "csv": "Excel"
            }
        }
    });

    $('#search').on('keyup', function(e) {
        tableuser.draw();
        e.preventDefault();
    });

    $(document).on('click', 'button.dropdown-item.send_password',function (e) {
        var ids = [];
        ids.push($(this).data('user'));

        $.ajax({
            method: "GET",
            url: "/user/send/password",
            data: { id: ids }
        }).done(function( msg ) {
            Swal.fire({
                title: "Envio de contraseña",
                text: "Se ha enviado el correo de reestablecimiento de contraseña",
                icon: 'success'
              });
        });

        tableuser.draw();
        e.preventDefault();
    });

    $(document).on('click', 'button.dropdown-item.tokens_delete',function (e) {
        var ids = [];
        ids.push($(this).data('user'));

        $.ajax({
            method: "GET",
            url: "/user/tokens/delete",
            data: { id: ids }
        }).done(function( msg ) {
            Swal.fire({
                title: "Sesiones cerradas",
                text: "Se han cerrado las sesiones exitosamente ",
                icon: 'success'
              });
        });

        tableuser.draw();
        e.preventDefault();
    });

    $('#adduser').on('click', function() {
        $('#formCreateUser').attr('action',$(this).data('default'));
    });

    $(document).on('click', '.dropdown-item.editar',function (e) {
        $('#modalNewUser').modal('toggle');
        $('#formCreateUser').attr('action',$(this).data('action'));

        $.ajax({
            method: "GET",
            url: "/user/get/info",
            data: { id: $(this).data('user') }
        })
        .done(function( msg ) {
            $('#rolp').val(msg.rol);
            $('#name').val(msg.name);
            $('#email').val(msg.email);
        });
        
        /*$('#addchangeModal').find('#kind').val($(this).data('kind'));
        $('#name').append('<option value="'+ $(this).data('idname') +'" selected>'+ $(this).data('name') +'</option>').trigger('change');
        $('#addchangeModal').find('#email').val($(this).data('email'));
        $('#addchangeModal').find('#password').val('akeppa2020');
        $('#addchangeModal').find('#password-confirm').val('akeppa2020');
        $('#addchangeModal').find('#form-user').attr('action',$(this).data('action'));*/
    });

    //Email
    //$('#email').inputmask({ alias: "email" });

    /*$('.dt-buttons .btn:first-child').on('click', function() {
        Swal.fire({
            icon: 'success',
            title: 'Buen trabajo!',
            text: 'Se a copiado con exito el contenido de la tabla\nControl + V para pegar',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        })
    });*/

    $('#random').on('click', function() {
        var randomstring = Math.random().toString(36).slice(-8);
        $('#password').val(randomstring);
        $('#password_confirmation').val(randomstring);
    });

    $(document).on('click', '#TabUsers .desactivar',function (e) {
        Swal.fire({
            title: "¿Estas seguro?",
            text: "Escriba el motivo de la baja",
            icon: 'warning',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: "Si, dar de baja!",
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            preConfirm: (reason) => {
              if(!reason){
                Swal.showValidationMessage(
                    `Debes escribir un motivo de baja`
                )
              } else {
                return fetch($(this).data('href')+`?reason=${reason}`)
                    .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                    })
                    .catch(error => {
                    Swal.showValidationMessage(
                        `Ocurrio un error al enviar la petición: ${error}`
                    )
                    })
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.value) {
              Swal.fire({
                title: "Usuario dado de baja con exito",
                text: "El usuario "+result.value.user+' se a dado de baja',
                icon: 'success'
              });
              tableuser.ajax.reload();
            }
        })
    });

    $(document).on('click', '#TabUsers .activar',function (e) {
        Swal.fire({
            title: "¿Estas seguro?",
            text: "Escriba el motivo de la alta",
            icon: 'warning',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: "Si, dar de alta!",
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            preConfirm: (reason) => {
              if(!reason){
                Swal.showValidationMessage(
                    `Debes escribir un motivo de alta`
                )
              } else {
                return fetch($(this).data('href')+`?reason=${reason}`)
                    .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                    })
                    .catch(error => {
                    Swal.showValidationMessage(
                        `Ocurrio un error al enviar la petición: ${error}`
                    )
                    })
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.value) {
              Swal.fire({
                title: "Usuario dado de alta con exito",
                text: "El usuario "+result.value.user+' se a dado de alta',
                icon: 'success'
              });
              tableuser.ajax.reload();
            }
        })
    });

    $('#rol').on('change', function() {
        $('#rolname').val($(this).find(':selected').data('rolname'));
        
        $('#permisos-check input[type="checkbox"]').prop('checked', false);

        $.ajax({
            method: "POST",
            url: "/roles/get/permission",
            data: { "_token": $('#rol').data('token'), id: $(this).val() }
        })
        .done(function( msg ) {
            $.each(msg, function(index, value) {
                $('#'+$.trim(value.name)).prop('checked', true);
            });
        });
    });

    $('#usersSelectAll').on('change', function() {
        var c = this.checked ? $('#TabUsers .form-check-input.user').prop('checked', true) : $('#TabUsers .form-check-input.user').prop('checked', false);
    });

    $('#send_password_all').on('click', function() {
        var boxes = $('input.user:checked');
        var ids = [];

        boxes.each(function() {
           ids.push(this.value);
        });

        $.ajax({
            method: "GET",
            url: "/user/send/password",
            data: { id: ids }
        }).done(function( msg ) {
            Swal.fire({
                title: "Envio de contraseña",
                text: "Se ha enviado el correo de reestablecimiento de contraseña",
                icon: 'success'
              });
        });
    });

    $('#send_sessions_all').on('click', function() {
        var boxes = $('input.user:checked');
        var ids = [];

        boxes.each(function() {
           ids.push(this.value);
        });

        $.ajax({
            method: "GET",
            url: "/user/tokens/delete",
            data: { id: ids }
        }).done(function( msg ) {
            Swal.fire({
                title: "Sesiones cerradas",
                text: "Se han cerrado las sesiones exitosamente ",
                icon: 'success'
              });
        });

        tableuser.draw();
        e.preventDefault();
    });

    $('#desactivate_all').on('click', function(e) {
        var boxes = $('input.user:checked');
        var ids = [];

        boxes.each(function() {
           ids.push(this.value);
        });

        Swal.fire({
            title: '¿Estas seguro que deseas dar de baja los usuarios?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Dar de baja',
            denyButtonText: `No dar de baja`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    method: "GET",
                    url: "/user/desactivate/all",
                    data: { id: ids }
                });
              Swal.fire('Usuarios dados de baja con exito!', '', 'success')
            } else if (result.isDenied) {
              Swal.fire('No ha habido cambios', '', 'info')
            }
          })

        /*$.ajax({
            method: "GET",
            url: "/user/desactivate/all",
            data: { id: ids }
        }).done(function( msg ) {
            Swal.fire({
                title: "Sesiones cerradas",
                text: "Se han dado de baja los usuarios",
                icon: 'success'
              });
        });*/

        tableuser.draw();
        e.preventDefault();
    });
    
});