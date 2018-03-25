

// Carga inicial del listado de usuarios...
$(document).ready(function(){
	loadListing();
});



// Obtener información del archivo a subir...
$(document).on('change', 'form#form_register input#archivo', function(){
var archivo = $('form#form_register input#archivo')[0].files[0];
var parametros = new FormData($('form#form_register')[0]);
parametros.append('archivo', archivo);
	
	$.ajax({
	    url: 'index.php/users/get_file_info',
	    type: 'POST',
	    data: parametros,
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function(){
	      $('form#form_register input#archivo, form#form_register button').attr('disabled', 'disabled');
	    },
	    success: function(data){
	      var json = eval('(' + data + ')');
	      
	      // Archivo subido OK...
	      if(json.status == 'SUCCESS'){
	      	$('form#form_register input#archivo_name').val(json.file_name);
	      	$('form#form_register input#archivo_type').val(json.file_type);
	      	$('form#form_register input#archivo_temp').val(json.file_temp);
	      	$('form#form_register input#archivo_size').val(json.file_size);
	      }
	      // Error al subir archivo...
	      if(json.status == 'ERROR'){
	        showMessage('', json.error, 'error');
	        $('form#form_register input#archivo_name').val('');
	      	$('form#form_register input#archivo_type').val('');
	      	$('form#form_register input#archivo_temp').val('');
	      	$('form#form_register input#archivo_size').val('');
	      }
	    $('form#form_register input#archivo, form#form_register button').removeAttr('disabled');
	    }
    });
});



// Agregar nuevo usuario...
$(document).on('click', 'form#form_register button', function(){
var nombre = $('form#form_register input#nombre').val();
var apellido = $('form#form_register input#apellido').val();
var correo = $('form#form_register input#correo').val();
var archivo_name = $('form#form_register input#archivo_name').val();
var accion = $('form#form_register input#accion').val();

    if($.trim(nombre) == ''){
      showMessage('input#nombre', 'Por favor ingresa tu nombre.', 'error');
      return false;
    }
    if($.trim(apellido) == ''){
      showMessage('input#apellido', 'Por favor ingresa tu apellido.', 'error');
      return false;
    }
    if($.trim(correo) == ''){
      showMessage('input#correo', 'Por favor ingresa tu correo electrónico.', 'error');
      return false;
    }
    if($.trim(correo) != ''){
      if(!correo.match(/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/)) {
      showMessage('input#correo', 'El correo electrónico ingresado no es válido.', 'error');
      return false;
      }
    }
    if(accion == 'add_user'){
	    if($.trim(archivo_name) == ''){
	      showMessage('', 'Por favor selecciona un archivo adjunto.', 'error');
	      return false;
	    }
    }

var parametros = new FormData($('form#form_register')[0]);
showMessage('', 'Enviando datos...', '');

	$.ajax({
		url: 'index.php/users/add_user',
		type: 'POST',
		data: parametros,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){
	     	$('form#form_register input#archivo, form#form_register button').attr('disabled', 'disabled');
		},
		success: function(data){
		var json = eval('(' + data + ')');
		      
			// Archivo subido OK...
			if(json.status == 'SUCCESS'){
				showMessage('', 'Usuario agregado correctamente.', 'success');
				$('form#form_register')[0].reset();
			}
			// Error al subir archivo...
			if(json.status == 'ERROR'){
				showMessage('', json.error, 'error');
      			return false;
			}
		$('form#form_register input#archivo, form#form_register button').removeAttr('disabled');
		loadListing();
		}
	});
});





/* Editar usuario existente... */
/* 1). Cargar formulario de edición en ventana modal y obtener datos del usuario */
function editUser(id_user){
var editForm = $('#content-form').html();
$('#editUser_modal .modal-body').html(editForm);
$('#editUser_modal .modal-body h2').remove();
$('#editUser_modal .modal-body form').attr('name', 'form_register_edit');
$('#editUser_modal .modal-body form').attr('id', 'form_register_edit');
$('#editUser_modal .modal-body form#form_register_edit button.btn-primary').html('Editar Usuario');
$('#editUser_modal .modal-body form#form_register_edit button.btn-primary').after(
		'<input type="hidden" name="id_usuario" id="id_usuario" value="' + id_user + '" />'
	);
$('#editUser_modal .modal-body form#form_register_edit input#id_usuario').before(
		'<button type="button" class="btn btn-warning pull-right" data-dismiss="modal" aria-label="Cancelar">Cancelar</button>'
	);
$('#editUser_modal .modal-body form#form_register_edit > #div_archivo').remove();
$('#editUser_modal .modal-body form#form_register_edit input#accion').val('edit_user');

	$.ajax({
		url: 'index.php/users/get_user_info',
		type: 'GET',
		data: {
			accion : 'get_user',
			id_usuario : id_user
		},
		success: function(data){
		var json = eval('(' + data + ')');
			if(json.status == 'SUCCESS'){
				$('#editUser_modal .modal-body form#form_register_edit input#nombre').val(json.nombre);
				$('#editUser_modal .modal-body form#form_register_edit input#apellido').val(json.apellido);
				$('#editUser_modal .modal-body form#form_register_edit input#correo').val(json.correo);
			}
			if(json.status == 'ERROR'){
				showMessage('', json.error, 'error');
			}
		}
	});

$('#editUser_modal').modal({
		backdrop: 'static',
		keyboard: false,
		show: true
	});
}


/* 2). Guardar datos actualizados */
$(document).on('click', 'form#form_register_edit button.btn-primary', function(){
	var parametros = new FormData($('form#form_register_edit')[0]);
	showMessage('', 'Enviando datos...', '');
	$.ajax({
		url: 'index.php/users/edit_user',
		type: 'POST',
		data: parametros,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data){
		var json = eval('(' + data + ')');		      
			if(json.status == 'SUCCESS'){
				showMessage('', 'Datos modificados correctamente.', 'success');
				$('#editUser_modal .modal-body form#form_register_edit button[data-dismiss=modal]')
					.html('Finalizar')
					.toggleClass('btn-warning btn-success');
			}
			if(json.status == 'ERROR'){
				showMessage('', json.error, 'error');
			}
		loadListing();
		}
	});
});



/* Eliminar un usuario... */
/* 1). Obtener datos del usuario */
function deleteUser(id_user){
	$.ajax({
		url: 'index.php/users/get_user_info',
		type: 'GET',
		data: {
			accion : 'get_user',
			id_usuario : id_user
		},
		success: function(data){
		var json = eval('(' + data + ')');
			if(json.status == 'SUCCESS'){
				$('#deleteUser_modal .modal-body p:nth-of-type(1) span').html('Usted está a punto de eliminar al usuario ');
				$('#deleteUser_modal .modal-body p:nth-of-type(1) strong').html(json.nombre + ' ' + json.apellido);
				$('#deleteUser_modal .modal-body p:nth-of-type(2) span').html('Desea continuar...?');
				$('#deleteUser_modal .modal-body form#form_delete_user input#id_usuario').val(id_user);
				$('#deleteUser_modal .modal-body form#form_delete_user input#archivo').val(json.archivo);
				$('#deleteUser_modal .modal-body form#form_delete_user input#archivo_dir').val(json.archivo_dir);
				$('#deleteUser_modal .modal-body form#form_delete_user input#accion').val('delete_user');
				$('#deleteUser_modal .modal-body form#form_delete_user button.btn-primary').removeAttr('disabled');
				$('#deleteUser_modal .modal-body form#form_delete_user button[data-dismiss=modal]')
					.html('Cancelar')
					.removeClass('btn-success btn-warning')
					.addClass('btn-warning');
				$('#deleteUser_modal').modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});
			}
			if(json.status == 'ERROR'){
				showMessage('', json.error, 'error');
			}
		}
	});
}

/* 2). Eliminar el usuario */
$(document).on('click', 'form#form_delete_user button.btn-primary', function(){
	var parametros = new FormData($('form#form_delete_user')[0]);
	showMessage('', 'Eliminando usuario...', '');
	$.ajax({
		url: 'index.php/users/delete_user',
		type: 'POST',
		data: parametros,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data){
		var json = eval('(' + data + ')');		      
			if(json.status == 'SUCCESS'){
				showMessage('', 'Usuario eliminado correctamente.', 'success');
				$('#deleteUser_modal .modal-body form#form_delete_user button.btn-primary').attr('disabled', 'disabled');
				$('#deleteUser_modal .modal-body form#form_delete_user button[data-dismiss=modal]')
					.html('Finalizar')
					.removeClass('btn-success btn-warning')
					.addClass('btn-success');
			}
			if(json.status == 'ERROR'){
				showMessage('', json.error, 'error');
			}
		loadListing();
		}
	});
});

 


/* Cargar listado de usuarios... */
function loadListing(){
	$('div#content-list').load('index.php/users/index/' + Math.floor((Math.random() * 1000) + 1));
}



/* Notificaciones Alertify.js... */
function showMessage(element, message, type){
	var icon;
	if(type == 'error'){
		icon = 'glyphicon-remove';
	}
	else if(type == 'success'){
		icon = 'glyphicon-ok';
	}
	else{
		icon = 'glyphicon-exclamation-sign';
	}
	alertify.log('<span class="glyphicon ' + icon + '"></span> ' + message, type);
	if(element != ''){
		$('form#form_register ' + element).focus().select();
	}
}



/*  Ekko Lightbox... */
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	event.preventDefault();
	$(this).ekkoLightbox();
});





