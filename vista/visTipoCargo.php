<script src="public/js/cargo.js"> </script>
<?php 

$idcargo= $_GET['idcargo'];
if($idcargo!=""){
  ?>
<script>


search();
function search(){
    var idcargo='<?php echo ($idcargo); ?>'
	
    $.post("controlador/ajax_combo.php",{idcargo:idcargo,nivel:'AGRO_cargo'},function(data){
		 var datos=data.split(",");
          //swal(" Hola...."+datos[1]+"");
			$("#idcargo").val(+datos[0]);										
			$("#nombre").val(datos[1]);										
			$("#descripcion").val(datos[2]);															
					   
					   $("#actualizar").css({"display":"block","float":"left"});
					   $("#incluir").css({"display":"none"});
		  								
			
		 
	
							});
}
</script>
 <?php
}
?>

<script > 

function eventoImg(_this){
    idcargo = _this.id;
    nombre = _this.getAttribute("name");
    estatus = _this.getAttribute("estatus");
    if(nombre == 'editar'){
      //swal('Hola...'+idcargo+'----- '+estatus+'');  
	 
			
		
  window.location.replace("?form=TipoCargo&li&idcargo="+idcargo+"");

   
  
    }else if(nombre="eliminar" && estatus==1) {
       swal({   
title: "¿Está seguro que quiere desactivar el Tipo de Cargo?",  
type: "warning",   
 showCancelButton: true,   
 confirmButtonColor: "#DD6B55", 
 confirmButtonText: "Aceptar!",   
 cancelButtonText: "Cancelar!",   
 closeOnConfirm: false,  
 closeOnCancel: false },
  
 function(isConfirm){   
 if (isConfirm) {    
//swal('Hola...'+idcargo+'----- '+estatus+'');
 $.post("controlador/conCargo.php",{idcargo:idcargo,nivel:'AGRO_activar'},function(data){
		       var datos=data.split(",");
        	swal("Tipo de cargo desactivado con exito!", "", "success"); 
  location.reload(true);
	
		 
	
				});
 } else 
{

	swal("Cancelled", "¡Gracias por no se desactiva el tipo de cargo!''", "success"); 
  } 
  
  });
   

    }else if(nombre="eliminar" && estatus==0) {
        
		swal({   
title: "¿Está seguro que quiere activar el tipo de cargo?",  
type: "warning",   
 showCancelButton: true,   
 confirmButtonColor: "#DD6B55", 
 confirmButtonText: "Aceptar!",   
 cancelButtonText: "Cancelar!",   
 closeOnConfirm: false,  
 closeOnCancel: false },
  
 function(isConfirm){   
 if (isConfirm) {    
//swal('Hola...'+idcargo+'----- '+estatus+'');
 $.post("controlador/conCargo.php",{idcargo:idcargo,nivel:'AGRO_desactivar'},function(data){
		       var datos=data.split(",");
        	swal("Tipo Cargo activado con exito!", "", "success"); 
  location.reload(true);
	
		 
	
				});
 } else 
{

	swal("Cancelled", "¡Gracias por no se activa el tipo de cargo!''", "success"); 
  } 
  
  });
   
		

    }
	
	
	
	
}
</script>

<?php include_once('controlador/conCargo.php'); 


?>


		

	<?php if(!isset($_GET['li'])){?>	

<h1 class="datos_form"><i class="fa fa-users" aria-hidden="true"></i>Tipo Cargos <span class="description_form">Registros y modificaciones de los cargos</span> <i class="fa fa-cog FR" aria-hidden="true"></i></h1>
 <div class="col-lg-8 col-md-6">
        <div class="panel panel-info">
               <div class="panel-heading" style='background:#ECF0F1;'><img src='public/img/nuevo.png' style='width:40px; height:40px;cursor:pointer;' Onclick='ADD()'></div>
          <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        
                         <th>Editar</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    <tbody>
         <?php

           //Conexión a la base de datos 
  require_once("modelo/clsConexion.php");
  $mysql=new clsConexion();

//Sentencia sql (sin limit) 
$_pagi_sql = "SELECT m.idcargo,UCASE(m.nombre) AS nombre, UCASE(descripcion) AS descripcion,m.estatus,(CASE  
        WHEN m.estatus=1 THEN  'Activo'
        ELSE 'Desactivado' END) AS estatus_cargo FROM tcargo m ORDER BY m.idcargo 
 "; 
//cantidad de resultados por página (opcional, por defecto 20) 
$_pagi_cuantos = 10; 
//Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
$_pagi_separador = " ";
//Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_num_enlaces=5;
//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
@include("public/librerias/paginador/paginator.inc.php"); 

//Leemos y escribimos los registros de la página actual 
while($row = mysql_fetch_array($_pagi_result)){ 
    echo "<tr ><td style='width:20%;'>".$row['idcargo']."</td><td align='left'>".$row['nombre']."</td><td align='left'>".$row['descripcion']."</td><td align='left'><img src='public/img/editar.png'  style='text-align:center; cursor:pointer;' data-toggle='tooltip' data-placement='top' title='Haga click para editar el cargo ".$row['nombre']." '  id='".$row['idcargo']."' name='editar'   onclick='eventoImg(this)'></td>"; 
	if ($row['estatus_cargo']=='Activo'){
		echo"<td align='left'  Style='text-align:center; color:green;font-weight: bold;'>".$row['estatus_cargo']."&nbsp;&nbsp;<img src='public/img/eliminar.png' style='text-align:center; cursor:pointer;' data-toggle='tooltip' data-placement='top' title='Haga click para ".$row['estatus_cargo']." el cargo ".$row['nombre']."'  id='".$row['idcargo']."'  onclick='eventoImg(this)' name='eliminar'  estatus='".$row['estatus']."'></td>";
		
	}else{
			echo"<td align='left'  Style='text-align:center; color:red;font-weight: bold;'>".$row['estatus_cargo']."&nbsp;&nbsp;<img src='public/img/eliminar.png' style='text-align:center; cursor:pointer;' data-toggle='tooltip' data-placement='top' title='Haga click para ".$row['estatus_cargo']." el cargo ".$row['nombre']."'  id='".$row['idcargo']."'  onclick='eventoImg(this)' name='eliminar' estatus='".$row['estatus']."'></td>";
	
		
	}
	echo "</tr>";
} 
//Incluimos la barra de navegación 
         ?>
           </tbody>
                </table>
                <hr>
<div class="pagination">
       <ul>
           <?php echo"<li>".$_pagi_navegacion."</li>";?>
       </ul>
   </div>
   </div>
          </div>

        </div>
    </div>
     <?php }else{?>    
   

		<h1 class="datos_form"><i class="fa fa-users" aria-hidden="true"></i>Tipo Cargos <span class="description_form">Registro y modificacion de los tipos de cargos</span> <i class="fa fa-cog FR" aria-hidden="true"></i></h1>

		<!--formularios de contacto se cargaran dinamicamente en esta seccion-->
		<div class="formulario_contacto limpiar">
		<div  class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading" style='text-align:center; background:#ECF0F1; font-weight:bold; height:40px;'>TIPO CARGOS</div>
            <div class="panel-body">
			<form action=''  id='formulario_maestro' method='POST'>
			<table class="formularios form_l" style="border:1px solid #ccc;"> 
			
			<caption style="text-align:left;">Registro</caption>
				<tr>
					<td class="label_input">
						<label>Código:</label>
						<input type='text' style='width:100px;' readonly  name='idcargo' id='idcargo'  >
					</td>
					<td class="label_input">
						<label>Nombre:</label>
						<br><input type='text' onKeyUp="this.value=this.value.toUpperCase()" style='width:60%;'  name='nombre' id='nombre'  value='<?php print($rows["nombre"]); ?>' >
					</td>
				</tr>
				
				<tr>
					<td class="label_input">
						<label>Descripción</label>
						<br>
						<textarea cols='60' rows='3' class='form-control' required="required" name="descripcion" id="descripcion" style="text-transform:uppercase;border:2px solid #D5D5D5 !important;border-radius: 5px;
	 resize:none;width:290px; " >
				<?php print($rows['descripcion']); ?></textarea></td>
				</tr>
		
    	

			<table class="formularios form_l"  >
			
<tr><td>

			<div class="col-md-6  col-md-offset-3" style="text-align:center">
		<button id="actualizar" class="btn btn-default"  type="submit" name="modificar"  style='display:none;' value="actualizar">
		
				Actualizar
			</button>
			<button id="incluir" class="btn btn-default"  type="submit" name="incluir" value="registrar">
			
				Registrar
			</button>
			<button  class="btn btn-danger" Onclick='limpiar()'  type="button" name="cacelar" value="Cancelar">
			
				Cancelar
			</button>
			<button class="btn fa-default" Onclick='Back()'  type="button" name="cacelar" value="Retroceder">
				<span class="fa fa-backward" > </span>
				Retroceder
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
	
 
 
		 <?php }?>
		
<script language="JavaScript">

function limpiar(){
    window.location.replace("?form=TipoCargo&li");
}
function ADD(){
    window.location.replace("?form=TipoCargo&li");
}
function listar(){
    window.location.replace("?form=TipoCargo");
}
function Back(){
    window.location.replace("?form=TipoCargo");
}

</script>