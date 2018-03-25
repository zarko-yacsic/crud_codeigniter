<?php
include('assets/php/connect.php');
?>
<h2 class="margin-bottom-40">Lista de Usuarios</h2>
<?php
$sql = "SELECT * FROM usuarios ORDER BY apellido, nombre ASC;";
$rs = mysqli_query($_conn, $sql);

if(mysqli_num_rows($rs) > 0){
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
    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)){
    ?>
    <tr>
      <td><?php echo utf8_encode($row['nombre']);?></td>
      <td><?php echo utf8_encode($row['apellido']);?></td>
      <td><?php echo utf8_encode($row['correo']);?></td>
      <td>
        <ul class="ul_actions">
          <li><?php
          $file_path = 'uploads/' . $row['archivo_dir'] . '/' . $row['archivo'];
          if(file_exists($file_path)){
            echo '<a href="' . $file_path . '" data-toggle="tooltip" data-placement="bottom" title="Ver archivo" target="_blank"><span class="glyphicon glyphicon-download-alt"></span></a>';
          }
          else{
            echo '<span class="disabled_file"><span class="glyphicon glyphicon-download-alt"></span></span>';
          }
          ?></li>
          <li><a href="javascript:editUser(<?php echo $row['id'];?>);" data-toggle="tooltip" data-placement="bottom" title="Editar"><span class="glyphicon glyphicon-edit"></span></a></li>
          <li><a href="javascript:deleteUser(<?php echo $row['id'];?>);" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a></li>
        </ul>
      </td>
    </tr>
    <?php
    }
    mysqli_free_result($rs);
    ?>
    </tbody>
  </table>
</div>
<script>
  // Inicializar tooltips...
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<?php
}
else{
  echo '<div class="alert alert-info" role="alert">No existen usuarios registrados actualmente.</div>';
}

mysqli_close($_conn);
?>