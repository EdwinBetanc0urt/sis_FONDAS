<script src="public/js/perfil.js"> </script>


<?php 
	include_once('controlador/conPerfil.php'); 


?>


		

	<?php if(!isset($_GET['li'])){?>	


	
	

		<!--formularios de contacto se cargaran dinamicamente en esta seccion-->
		<div class="formulario_contacto limpiar">
		<div  class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading" style='text-align:center; background:#ECF0F1; font-weight:bold; height:40px;'>PERFILES</div>
            <div class="panel-body">
			<form action=''  id='formulario_maestro' method='POST'>
			<table class="formularios form_l" style="border:1px solid #ccc;"> 
			
			<caption style="text-align:left;">Registro</caption>
				<tr>
						 <input type='hidden'  readonly  name='tipo_usuario' id='tipo_usuario' value='<?php  print($rows["tipo_usuario"]); ?>'  >
					
         <div class="form-group">
            <input class="form-control" type="text" onKeyUp="this.value=this.value.toUpperCase()"  name='nombre' id='nombre'  value='<?php print($rows["nombre"]); ?>' />
              <span class="mda-input-group-addon">
               <!--<em class="fa fa-user fa-lg"></em>-->
            </span>
			 <label>Nombre</label>
         
         </div>
      
<div class="panel-footer text-center">
                        <?php
                      imprimir_boton($form);
                     ?>    
	<button id="buscar" class="btn btn-default"  type="submit" name="buscar" value="busa
					">
			<span class="fa fa-search" > </span>
		
				Buscar
			</button>  <button id="actualizar" class="btn btn-primary"  type="submit" name="modificar"   value="actualizar">
		  <span class="fa fa-pencil" > </span>
		
		
				Actualizar
			</button>
			      </div>
				  </br>
				  </br>
				 
				  <?php 
       include_once('modelo/class_html.php');
    $html=new Html();
            $html->configurar_menu($codigo_perfil);   
          ?>
		
</table>


		</form>
		 </div>
        </div>
		</div>	
		</div><!--cierre de los formularios de contacto-->
	
 
     <?php }else{?>    
   
<h1 class="datos_form"><i class="fa fa-users" aria-hidden="true"></i>Perfiles<span class="description_form">Perfiles de los usuarios</span> <i class="fa fa-cog FR" aria-hidden="true"></i></h1>
 <div class="col-lg-12 col-md-6">
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
$_pagi_sql = "SELECT m.idcargo,UCASE(m.nombre) AS nombre, UCASE(descripcion) AS descripcion,m.estatus, (CASE  
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
    echo "<tr ><td style='width:20%;'>".$row['idcargo']."</td><td>".$row['nombre']."</td><td>".$row['descripcion']."</td><td><button class='btn btn-sm btn-info' type='button' data-toggle='tooltip' data-placement='top' title='Haga click para editar el cargo ".$row['nombre']." '  id='".$row['idcargo']."' name='editar'   onclick='eventoImg(this)' > <em class='fa fa-edit'></em> </button></td>"; 
	if ($row['estatus_cargo']=='Activo'){
		echo"<td align='left'  Style='text-align:center; color:green;font-weight: bold;'>".$row['estatus_cargo']."
		<button class='btn btn-sm btn-danger' type='button' title='Haga click para ".$row['estatus_cargo']." el cargo ".$row['nombre']."'  id='".$row['idcargo']."'  onclick='eventoImg(this)' name='eliminar'  estatus='".$row['estatus']."'> <em class='fa fa-trash-o'></em></button></td>";
		
	}else{
			echo"<td align='left'  Style='text-align:center; color:red;font-weight: bold;'>".$row['estatus_cargo']."
		<button class='btn btn-sm btn-danger' type='button' title='Haga click para ".$row['estatus_cargo']." el cargo ".$row['nombre']."'  id='".$row['idcargo']."'  onclick='eventoImg(this)' name='eliminar'  estatus='".$row['estatus']."'> <em class='fa fa-trash-o'></em></button></td>";
	
		
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
	
 
		 <?php }?>
		
<script language="JavaScript">

function limpiar(){
    window.location.replace("?form=Perfiles");
}
function ADD(){
    window.location.replace("?form=Perfiles");
}
function listar(){
    window.location.replace("?form=Perfiles");
}
function Back(){
    window.location.replace("?form=Perfiles");
}
function borrar(e){
	ta=document.getElementById("datatable1"); 
	
		var tr = e.parentNode.parentNode;
		var ta = tr.parentNode;
		ta.removeChild(tr);
	}
	
	 function Agregar() {
		  var cont_rep = 0;
		  var i = 0;
	
     hora_ini= document.getElementById("set_up").value;	  
    hora_fin= document.getElementById("close_up").value;	
	arrayfec_inicio=hora_ini.split(':'); 
    
    var infoa = arrayfec_inicio[2];
	arrayfec_fin=hora_fin.split(':'); 
    
    var infob = arrayfec_fin[2];
	  idcargo= document.getElementById("idcargo").value;	  
  	
    combo_curso = document.getElementById("idturno");  
    var  turno_txt =  combo_curso.options[combo_curso.selectedIndex].text;
  
 
cod_curso= document.getElementById("idturno").value;
 if  (combo_curso.value ==""||combo_curso.length==0){
  swal('Seleccione el turno!');
  return false;
  } 
  //hacemos una condicion 	
	  	
   campo=document.getElementById("datatable1"); 
 
  //----ESTE FOR ES UTILIZADO PARA NO REPETIR LAS UNIDADES DE CRÉDITOS QUE SE VAN A GUARDAR
	for(var j =0 ; j<campo.rows.length;j++){
			
				//usamos chilNodes para entrar al nodo adentro de la celda, y su correspondiente posicion
				if(document.all){
					cod_temp = campo.rows[j].cells[0].innerText;
				}else{
					cod_temp = campo.rows[j].cells[0].textContent;
				}
	
				if(cod_temp == cod_curso){
					cont_rep++;
				}
		
	}
	
	if(cont_rep==0){
   var campo = ' <tbody> <tr><td style="color:#fff;">'+cod_curso+'<input type="hidden" size="15" name="cod_turnos[]" value="'+cod_curso+'" /></td><td><input type="text" size="15" name="cursox_txt[]" value="'+turno_txt+'" class="form-control" /></td><td><input type="text" size="15" name="inicios[]" value="'+hora_ini+'"class="form-control" /><input type="hidden" name="infoas[]" value="'+infoa+'" /></td><td><input type="text" size="10" name="fines[]" value="'+hora_fin+'" class="form-control" /><input type="hidden" name="infobs[]" value="'+infob+'" /></td><td><button onclick="borrar(this)" class="btn btn-labeled btn-danger" style=" font-weight:bold; font-size:18px;cursor:pointer;"> <em class="fa fa-times"></em></button></td></tr></tbody>';
    $("#datatable1").append(campo);
i++; //aumentamos la i
}else{
		swal("No puedes agregar dos veces  "+turno_txt+"!");
	}
	}
</script>     

