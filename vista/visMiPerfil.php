<script src="public/js/miperfil.js"> </script>

<?php
include_once("controlador/corRecuperar.php");
	
	include_once("modelo/clsRecuperar.php");
	$miuser = new clsRecuperar();
	$miuser->usuario = $_SESSION['usuario'];
	$miuser->buscar();
	//nos traemos los datos
	$rows = $miuser->row(); ?>



		
		
			<!--formularios de contacto se cargaran dinamicamente en esta seccion-->
		<div class="formulario_contacto limpiar">
		
			
  <!-- START row-->
            <div class="row">
               <div class="col-md-12">
                  <form action="" data-parsley-validate="" novalidate="" method='POST' class="form-horizontal">
                     <!-- START panel-->
                     <div class="panel panel-default">
                         <div class="panel-heading"  style='text-align:center; background:#ECF0F1; font-weight:bold; height:40px;'>CONFIGURACIONES DE CUENTAS</div>
                        <div class="panel-body">
                             
                           <fieldset>
                              <div class="form-group">
							 <input type='hidden' readonly="readonly" name='id_usuario' value='<?php print($rows["id_usuario"]); ?>' >
				
                                 <label class="col-sm-2 control-label">Nombre Usuario</label>
                                 <div class="col-sm-3">
                                    <input type='text'  name='usuario' id='usuario' class='form-control' value='<?php print($rows["usuario"]); ?>'>
                                 </div>
								  <label class="col-sm-2 control-label">Pregunta 1</label>
                                
                                 <div class="col-sm-3">
                                    <select   name='pre1' class='form-control' title="Seleccione el tipo de pregunta." id='pre1'>
<?php  include_once('modelo/clsPregunta.php');
    $pregunta = new Pregunta();
     $pregunta->listar(); ?>
    <option value=''>SELECCIONE LA PREGUNTA!</option>
      <?php while($mipregunta=$pregunta->row()){ ?>
         <option <?php if($rows["pre1"]==$mipregunta['idpregunta']) print("selected"); ?> value="<?php print($mipregunta['idpregunta']); ?>"><?php print($mipregunta['nombre']); ?></option>
      <?php } ?></select>
                                 </div>
                                 
                              </div>
                           </fieldset>
                           <fieldset>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label">Respuesta 1</label>
                                 <div class="col-sm-3">
                                    <input type='text' class="form-control" name='resp1' id='resp1' value='<?php print($rows["resp1"]); ?>' >
                                 </div>
								  <label class="col-sm-2 control-label">PREGUNTA 2</label>
                                
                                 <div class="col-sm-3">
                                  <select  class='form-control' name='pre1' title="Seleccione el tipo de pregunta." id='pre1'>
<?php  include_once('modelo/clsPregunta.php');
    $pregunta = new Pregunta();
     $pregunta->listar(); ?>
    <option value=''>SELECCIONE LA PREGUNTA!</option>
      <?php while($mipregunta=$pregunta->row()){ ?>
         <option <?php if($rows["pre1"]==$mipregunta['idpregunta']) print("selected"); ?> value="<?php print($mipregunta['idpregunta']); ?>"><?php print($mipregunta['nombre']); ?></option>
      <?php } ?></select>
                                 </div>
                                 
                              </div>
                           </fieldset>
                           <fieldset>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label">Respuesta Secreta2</label>
                                 <div class="col-sm-3">
                                    <input type='text' class="form-control" name='resp2' id='resp2' value='<?php print($rows["resp2"]); ?>' >
                                 </div>
								  
                                 
                              </div>
                           </fieldset>
                          
						    
                              
                           </div>
						
						
                        </div>
                        <div class="panel-footer text-center">
                         
			<button id="actualizar" class="btn btn-default"  type="submit" name="modificar2" value="Actualizar">
				<span class="fa fa-edit" > </span>
				Actualizar
			</button>
			<button  class="btn btn-danger" Onclick='limpiar()'  type="button" name="cacelar" value="Cancelar">
				<span class="fa fa-reply" > </span>
				Cancelar
			</button>
			      </div>
                     </div>
                     <!-- END panel-->
                  </form>
               </div>
           
		</div><!--cierre de los formularios de contacto-->

 
	<?php if($msj){ ?>   <script>swal("<?php print($msj); ?>"); </script>   <?php  };  ?>
		<!--cierre de los formularios de contacto-->
	<script>
function limpiar(){
    window.location.replace("?form=MiPerfil");
}</script>