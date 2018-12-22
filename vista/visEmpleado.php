<script src="public/js/empleado.js"> </script>
<?php include_once('controlador/conEmpleado.php'); ?>
<?php if(!isset($_GET['li'])){?>
<div id='contenedor_formulario' >
<div id='titulo_form' style="text-align:center">Administración de Empleado</div>
<form action="" method="post" id="formulario_maestro" name='formulario_maestro'> 
	
<div class="tabs">
 <div class="tab">
       <input class='radio' type="radio" id="tab-1" name="tab-group-1" checked>
       <label for="tab-1" style='display:none;' >Datos Básicos</label>
       <div class="content" id="content-tab1">
<table width='100%'  id='formulario_persona'>

<td>Nacionalidad &nbsp;&nbsp;&nbsp;C&eacute;dula</td> <td>Nombres</td> 

<tr>

  <td><span Style="color:red;font-weight:bold;font-size:18px;">*</span>&nbsp;<select id="nacionalidad" ="" name="nacionalidad" title="Seleccione su nacionalidad"  class="select-independiente" style="width:80px;">
					<option value="" ></option>
					<option value="V" <?php if(!is_null(strtoupper(trim($rows['nacionalidad']))) and strtoupper(trim($rows['nacionalidad']))=='V') echo "selected";?> >V-</option>
					<option value="E" <?php if(!is_null(strtoupper(trim($rows['nacionalidad']))) and strtoupper(trim($rows['nacionalidad']))=='E') echo "selected";?> >E-</option>
			   </select><span Style="color:red;font-weight:bold;font-size:18px;">*</span>
							<input class='solocedula' ="" name="cedula"  id="cedula" value="<?php print($rows['cedula']); ?>" type="text" placeholder="C&eacute;dula"  title="Ingrese su c&eacute;dula." style="width:100px;" onKeyUp="this.value = this.value.replace (/[^0-9.]/, ''); " /></td>
							<td><span Style="color:red;font-weight:bold;font-size:18px;">*</span><input ="" name="nombre" id="nombre" value="<?php print($rows['nombre']); ?>" type="text" onKeyUp="this.value=this.value.toUpperCase()" placeholder="Nombres"  title="Ingrese sus nombre."/></td>
</tr>
<td>Apellidos</td> <td>Sexo </td>

<tr>
  <td><span Style="color:red;font-weight:bold;font-size:18px;">*</span><input Style="width:230px;" =""  name="apellido" id="apellido" value="<?php print($rows['apellido']); ?>" placeholder="Apellidos" onKeyUp="this.value=this.value.toUpperCase()" type="text" title="Ingrese sus apellidos." />
  <span Style="color:red;font-weight:bold;font-size:18px;">*</span>
							M <input name="sexo" type="radio" checked=""   value="M" <?php if($rows['sexo']=="M"){print("checked");} ?> style="width:30px;height:25px;"/> &nbsp;
				 F <input name="sexo" type="radio"  value="F" <?php if($rows['sexo']=="F"){print("checked");} ?> style="width:30px; height:25px;"/>
  </td>
<td>
<span Style="color:red;font-weight:bold;font-size:18px;">*</span>	<select style="width:190px;" ="" name="edo_civil" id="edo_civil">
					<option value="">Estado civil</option>
					<option  <?php if($rows['edo_civil']=="Casado") print("selected"); ?> value="Casado">Casado(a)</option>
					<option  <?php if($rows['edo_civil']=="Viudo") print("selected"); ?> value="Viudo">Viudo(a)</option>
					<option  <?php if($rows['edo_civil']=="Soltero") print("selected"); ?> value="Soltero">Soltero(a)</option>
						<option  <?php if($rows['edo_civil']=="Divorciado") print("selected"); ?> value="Divorciado">Divorciado(a)</option>
						<option  <?php if($rows['edo_civil']=="Concubinato") print("selected"); ?> value="Concubinato">Concubinato(a)</option>
				</select>
			</td>
</tr>

<td>Fecha Nacimiento&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel&eacute;fono M&oacute;vil</td> <td>Tel&eacute;fono Fijo</td>
<tr>
<td><span Style="color:red;font-weight:bold;font-size:18px;">*</span>
<input type="text" name="fecha_naci" id="fecha_naci"  placeholder="00-00-0000" =""  readonly=""  style="width:110px;  "    value="<?php print($rows['fecha_naci']); ?>" />
<span Style="color:red;font-weight:bold;font-size:18px;">*</span>
<select name="cod1" id="cod1" class="solonumeros" style="width:100px;"  >
									<option value="">Select</option>
								
									<option <?php if($rows['cod1']=="0416") print("selected"); ?> value="0416">0416</option>
									<option <?php if($rows['cod1']=="0426") print("selected"); ?> value="0426">0426</option>
									<option <?php if($rows['cod1']=="0412") print("selected"); ?> value="0412">0412</option>
									<option <?php if($rows['cod1']=="0414") print("selected"); ?> value="0414">0414</option>
									<option <?php if($rows['cod1']=="0424") print("selected"); ?> value="0424">0424</option>
									
								</select>
								<input Style="width:100px;"  name="tel_mob" =""   id="tel_mob" value="<?php print($rows['tel_mob']); ?>" type="text"  /></td>
<td><select name="cod2" id="cod2"  style="width:100px;" >
									<option value="">Select</option>
								
									<option <?php if($rows['cod2']=="0255") print("selected"); ?> value="0255">0255</option>
									<option <?php if($rows['cod2']=="0256") print("selected"); ?> value="0256">0256</option>
									<option <?php if($rows['cod2']=="0251") print("selected"); ?> value="0251">0251</option>
									
								</select>
								<input  name="tel_fijo" =""  id="tel_fijo" value="<?php print($rows['tel_fijo']); ?>" type="text" Style="width:100px" />
</td>
</tr>

<td>Estado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Municipio</td><td>Parroquia</td>
<tr>
<td><span Style="color:red;font-weight:bold;font-size:18px;">*</span><select id='idestado' name='idestado'  class="select_estado" style="width:160px;">
<?php  include_once('modelo/clstestado.php');
    $testado = new clstestado();
     $testado->listar(); ?>
    <option value=''>Seleccione el Estado</option>
      <?php while($mitestado=$testado->row()){ ?>
         <option <?php if($rows['idestado']==$mitestado['idestado']) print('selected'); ?>   value="<?php print($mitestado['idestado']); ?>"><?php print($mitestado['nombre']); ?></option>
      <?php } ?></select><span Style="color:red;font-weight:bold;font-size:18px;">*</span>&nbsp;<select id='idmunicipio' name='idmunicipio'  class="select_municipio" style="width:170px;" disabled>
<?php  include_once('modelo/clsMunicipio.php');
    $tmunicipio = new Municipio();
     $tmunicipio->listar(); ?>
    <option value=''>Seleccione el Municipio</option>
      <?php while($mitmunicipio=$tmunicipio->row()){ ?>
         <option <?php if($rows['idmunicipio']==$mitmunicipio['idmunicipio']) print('selected'); ?>   value="<?php print($mitmunicipio['idmunicipio']); ?>"><?php print($mitmunicipio['nombre']); ?></option>
      <?php } ?></select></td>
	  <td><span Style="color:red;font-weight:bold;font-size:18px;">*</span><select id='idparroquia' name='idparroquia'  class="select_parroquia" style="width:170px;" disabled>
<?php  include_once('modelo/clsParroquia.php');
    $tparroquia = new Parroquia();
     $tparroquia->listar(); ?>
    <option value=''>Seleccione la Parroquia</option>
      <?php while($mitparroquia=$tparroquia->row()){ ?>
         <option <?php if($rows['idparroquia']==$mitparroquia['idparroquia']) print('selected'); ?>   value="<?php print($mitparroquia['idparroquia']); ?>"><?php print($mitparroquia['nombre']); ?></option>
      <?php } ?></select></td>

</tr>




<td>Direcci&oacute;n</td><td>Correo</td>
<tr>
<td><span Style="color:red;font-weight:bold;font-size:18px;">*</span><textarea cols='60' rows='3' ="" required="required" name="direccion" id="direccion" style="text-transform:uppercase; resize:none;width:290px;" >
				<?php print($rows['direccion']); ?></textarea></td>
				<td><input  type="email"  name="correo"  id="correo" ="" value="<?php print($rows['correo']); ?>" style="190px;" /></td>
</tr>
<td>Fecha Ingreso</td><td>Cargo</td>
<tr>
<td><span Style="color:red;font-weight:bold;font-size:18px;">*</span>
<input type="text" name="fecha_ingreso" id="fecha_ingreso"  placeholder="00-00-0000" =""  readonly=""  style="width:110px;"    value="<?php print($rows['fecha_ingreso']); ?>" /></td>
				<td><select id='idcargo' name='idcargo'  class="solonumeros" style="width:170px;" >
<?php  include_once('modelo/clsCargo.php');
    $tcargo = new Cargo();
     $tcargo->listar(); ?>
    <option value=''>Seleccione el Cargo</option>
      <?php while($micargo=$tcargo->row()){ ?>
         <option <?php if($rows['idcargo']==$micargo['idcargo']) print('selected'); ?>   value="<?php print($micargo['idcargo']); ?>"><?php print($micargo['nombre']); ?></option>
      <?php } ?></select></td>
</tr>

	
</tr>

</table><!-- FIN DE LA TABLA -->
  </div><!-- FIN DEL CONTENEDOR-->
   
   </div><!-- FIN DE PRIMERA PESTAÑA-->
 <!-- SEGUNDA PESTANA -->
   
    <!-- FIN SEGUNDA PESTANA -->
 
 </div><!-- FIN DE LAS TABLAS -->
			<p><center><span Style="color:red;font-weight:lato;font-size:22px;">Los campos marcados con * son obligatorios.</span>&nbsp;&nbsp;&nbsp;</center></p>
<ol id='botonera' style="text-align:center;">

<?php
                      imprimir_boton($url);
                 if($rows['estatus']=='1'){
			 $rows['estatus']= ("<input type='submit' name='desactivar'   value='Desactivar'  ");
			 echo '<li><input Style="text-align:center; color:red;font-weight: bold;  class="'.$rows['estatus'].'"  '.$rows['estatus'].'/></li>'; 
			 } else if($rows['estatus']=='0'){
			  $rows['estatus']= ("<input type='submit'  name='activar'  value='Activar'  ");
			 echo '<li><input Style="text-align:center; color:green;font-weight: bold; class="'.$rows['estatus'].'"  '.$rows['estatus'].'/></li>';
			 }?>
</ol>
</form>
</div><?php if($msj){ ?>   <script> swal("<?php print($msj); ?>"); </script>   <?php  };  ?>
<?php }else{

?>
<div  style="margin:0 auto; padding-left: 0px; width:804px;" >
<br>
  <a href="?form=Empleado" ><img src="public/img/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
     <table style="width:100%;" class="tablapaginacion">
             <tr style="background: #3E6FAF; color: #000; font-family: verdana ;font-weight:bold; text-shadow:1px 1px white; width:100%;"> 
               <td style="width:25%;">C&eacute;dula</td>
               <td align='left'>Nombre</td>
               <td align='left'>Apellido</td>
               <td align='left'>Sexo</td>
               <td align='left'>Tel&eacute;fono</td>
			     <td align='left'>Estatus</td>
              
           </tr>
         <?php

           //Conexión a la base de datos 
  require_once("modelo/clsConexion.php");
  $mysql=new clsConexion();

//Sentencia sql (sin limit) 
$_pagi_sql = "SELECT
                      p.cedula,
                      p.nombre,
                      p.apellido,
                      p.sexo,
					  p.tel_mob,
                      ( CASE 
        WHEN d.estatus=1 THEN  'Activo'
        ELSE 'Desactivado' END) AS estatus
                      FROM tpersonas p 
                      INNER JOIN tpersonal AS d ON p.cedula = d.cedula 
					  
   ORDER BY p.cedula "; 
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
    echo "<tr><td style='width:20%;'>".$row['cedula']."</td><td align='left'>".$row['nombre']."</td><td align='left'>".$row['apellido']."</td><td align='left'>".$row['sexo']."</td><td align='left'>".$row['tel_mob']."</td><td align='left'>".$row['estatus']."</td></tr>"; 
} 
//Incluimos la barra de navegación 
         ?>
       </table>
<div class="pagination">
       <ul>
           <?php echo"<li>".$_pagi_navegacion."</li>";?>
       </ul>
   </div>
</div>
  <?php }?>
<script language="JavaScript">

function limpiar(){
    window.location.replace("?form=Empleado");
}
function listar(){
    window.location.replace("?form=Empleado&li");
}
</script>