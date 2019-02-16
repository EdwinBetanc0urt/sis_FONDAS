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
            <div class="panel-heading" style='text-align:center; background:#ECF0F1; font-weight:bold; height:40px;'>Reporte de Asistencia</div>
            <div class="panel-body">
			<form action=''  id='formulario_maestro' method='POST'>
			<table class="formularios form_l" style="border:1px solid #ccc;"> 
			
		
				
				
		   <div class="row">  
	   <div class="col-sm-4">
               <div class="mda-form-group">
                <label>Fecha Asistencia</label>
						<br><input type='text'  style='width:90%;'  type="text" name="fecha_asis" id="fecha_asis"  placeholder="00-00-0000"   >
               </div>
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
				if(fecha==""){
                  swal("Seleccion la fecha que quieres imprimir!");
				  
                   return false;
			}else{
				window.open("pdf/pdfAsistencia.php?fecha="+fecha);
			}
    
}



</script>     

