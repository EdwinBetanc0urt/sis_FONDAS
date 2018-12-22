<script src="public/js/cargo.js"> </script>


	<?php 
	  include_once("modelo/clsAsistencia.php");
   $micon = new Asistencia();
   $fecha='2017-02-19';
$row5= $micon->Buscar_Asistencia3($fecha);

 
	echo $row5['nombres'];echo '</br>';	
	?>
	
	

		<!--formularios de contacto se cargaran dinamicamente en esta seccion-->
		<div class="formulario_contacto limpiar">
		<div  class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading" style='text-align:center; background:#ECF0F1; font-weight:bold; height:40px;'>Reporte de Ausecias</div>
            <div class="panel-body">
			<form action=''  id='formulario_maestro' method='POST'>
			<table class="formularios form_l" style="border:1px solid #ccc;"> 
			
		
				
				
		   <div class="row">  
	   <div class="col-sm-4">
               <div class="mda-form-group">
                <label>Fecha Inicio</label>
						<br><input type='text'  style='width:90%;'  type="text" name="fecha_ini" id="fecha_asis"  placeholder="00-00-0000"   >
               </div>
            </div>
			<div class="col-sm-4">
               <div class="mda-form-group">
                <label>Fecha Fin</label>
						<br><input type='text'  style='width:90%;'  type="text" name="fecha_fin" id="fecha_final"  placeholder="00-00-0000"   >
               </div>
            </div>
			 <div class="col-sm-4">
               <div class="mda-form-group">
                <label>Tipo Permiso</label>
						<br> <select name='tipo_ausencia' id='tipo_ausencia' class="form-control" >
<?php  include_once('modelo/clsCargo.php');
    $cargo = new Cargo();
     $cargo->listar_ausencia(); ?>
    <option value=''>Seleccione el tipo tramite</option>
      <?php while($miturno=$cargo->row()){ ?>
         <option <?php if($rows['tipo_ausencia']==$miturno['tipo_ausencia']) print('selected'); ?>   value="<?php print($miturno['tipo_ausencia']); ?>"><?php print($miturno['nombre']); ?></option>
      <?php } ?></select> </div>
            </div>
			                     
        
            </div>
    	 
			<table class="formularios form_l"  >
			
<tr><td>

			<div class="col-md-6  col-md-offset-5" style="text-align:center">
		<button type="button" Onclick="imprimir()"  style="cursor:pointer;height:38px;font-weight:bold;" id="print"  class="btn btn-default pull-left">
          <span class="btn-label" style="height:36px;margin-top:-6px;"><i class="fa fa-print" ></i>
          </span>Imprimir
        </button>
			
		</div>	</td>
				</tr>
				
</table>
</table>


		</form>
		 </div>
        </div>
		</div>	
		</div><!--cierre de los formularios de contacto-->
	
 
 
		
<script language="JavaScript">

function imprimir(){
	fecha=document.getElementById('fecha_asis').value;
	fecha_final=document.getElementById('fecha_final').value;
	tipo=document.getElementById('tipo_ausencia').value;
				if( fecha==""){
                  swal("Seleccion la fecha inicio!");
				  
                   return false;
			}else if( fecha_final==""){
                  swal("Seleccion la fecha fin!");
				  
                   return false;
			}else if( tipo==""){
                  swal("Seleccion el tipo de Ausecia!");
				  
                   return false;
			}else{
				window.open("pdf/pdfTipo_Permiso.php?fecha="+fecha+"&fecha_final="+fecha_final+"&tipo="+tipo);
			}
    
}



</script>     

