<h2 class="margin-bottom-40">Lista de Usuarios</h2>

<?php
if(count($users) == 0){
  echo '<div class="alert alert-info" role="alert">No existen usuarios registrados actualmente.</div>';
}
else{
?>
<div class="cl-background">
  <table id="tb_registros" class="table table-striped">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo electrónico</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php
      for ($i=0; $i < count($users); $i++){
      ?>
      <tr>
        <td><?php echo $users[$i]['nombre']; ?></td>
        <td><?php echo $users[$i]['apellido']; ?></td>
        <td><?php echo $users[$i]['correo']; ?></td>
        <td>
          <ul class="ul_actions">
            <li><?php
            $file_path = 'public/uploads/' . $users[$i]['archivo_dir'] . '/' . $users[$i]['archivo'];
            if(file_exists($file_path)){
              if($users[$i]['archivo_type'] == 'image/jpeg' || $users[$i]['archivo_type'] == 'image/png'){
                echo '<a href="' . $file_path . '" data-toggle="lightbox" data-title="' . $users[$i]['archivo'] . '"><span data-toggle="tooltip" data-placement="bottom" title="Ver imagen" target="_blank"><span class="glyphicon glyphicon-picture"></span></span></a>';
              }
              else{
                echo '<a href="' . $file_path . '" data-toggle="tooltip" data-placement="bottom" title="Ver archivo" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a>';
              }
            }
            else{
              echo '<span class="disabled_file"><span class="glyphicon glyphicon-download-alt"></span></span>';
            }
            ?></li>
            <li><a href="javascript:editUser(<?php echo $users[$i]['id']; ?>);" data-toggle="tooltip" data-placement="bottom" title="Editar"><span class="glyphicon glyphicon-edit"></span></a></li>
            <li><a href="javascript:deleteUser(<?php echo $users[$i]['id']; ?>);" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a></li>
          </ul>
        </td>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>
<?php
}
?>
<script>
  // Inicializar tooltips...
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>