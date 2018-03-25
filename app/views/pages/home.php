<section>
  <div class="container">
    <div class="row">
      <p class="description">Este ejemplo consiste en un formulario hecho con el framework <strong>Codeigniter</strong>, el cual envía la información mediante AJAX usando jQuery. El listado de usuarios se actualiza automáticamente en la misma vista, de modo que el navegador nunca se redireccionará. Además incluye una subida de archivos, la cual también se realiza de manera asíncrona. La información enviada se almacena en una base de datos MySQL y los archivos se alojan en un directorio dentro del proyecto. En el listado de usuarios, los archivos con extensiones .jpg y .png se despliegan usando la librería <a href="http://ashleydw.github.io/lightbox/" target="_blank"><strong>Ekko-Lightbox</strong></a>, la cual usa las ventanas modales de Bootstrap, mientras que los demás tipos de archivos se abren en una nueva ventana.</p>
      <div class="col-md-6 margin-bottom-40" id="content-form">
        <h2 class="margin-bottom-20">Registro Nuevo Usuario</h2>
        <form name="form_register" id="form_register" role="form" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" size="50" placeholder="Ingresa tu nombre" />
          </div>
          <div class="form-group">
            <label for="apellido" class="col-form-label">Apellido:</label>
            <input type="text" class="form-control" name="apellido" id="apellido" size="50" placeholder="Ingresa tu apellido" />
          </div>
          <div class="form-group">
            <label for="correo" class="col-form-label">Correo electrónico:</label>
            <input type="email" class="form-control" name="correo" id="correo" size="50" placeholder="Ingresa tu correo electrónico" />
          </div>
          <div class="form-group" id="div_archivo">
            <label for="archivo" class="col-form-label">Archivo adjunto:</label>
            <input type="file" class="form-control" name="archivo" id="archivo" />
            <input type="hidden" name="archivo_name" id="archivo_name" />
            <input type="hidden" name="archivo_type" id="archivo_type" />
            <input type="hidden" name="archivo_temp" id="archivo_temp" />
            <input type="hidden" name="archivo_size" id="archivo_size" />
          </div>
          <div class="form-group margin-top-40">
            <button type="button" class="btn btn-primary pull-left">Agregar Usuario</button>
            <input type="hidden" name="accion" id="accion" value="add_user" />
            <div>&nbsp;</div>
          </div>
        </form>
      </div>
      <div class="col-md-6 margin-bottom-40" id="content-list"></div>
    </div>
  </div>
</section>


<!-- Modal editar usuario... -->
<div class="modal fade" id="editUser_modal" tabindex="-1" role="dialog" aria-labelledby="editUser_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Editar Usuario Existente</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>


<!-- Modal eliminar usuario... -->
<div class="modal fade" id="deleteUser_modal" tabindex="-1" role="dialog" aria-labelledby="deleteUser_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Eliminar Usuario</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="form_delete_user" id="form_delete_user" role="form">
          <div class="form-group">
            <p><span></span><strong></strong></p>
            <p><span></span></p><br>
            <input type="hidden" name="accion" id="accion" />
            <input type="hidden" name="id_usuario" id="id_usuario" />
            <input type="hidden" name="archivo" id="archivo" />
            <input type="hidden" name="archivo_dir" id="archivo_dir" />
            <button type="button" class="btn btn-primary pull-left">Eliminar Usuario</button>
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal" aria-label="Cancelar">Cancelar</button><br>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

