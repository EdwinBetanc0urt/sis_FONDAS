<?php
include_once('modelo/clsTurno.php');

$turno= new turno(); 
$turno->nombre_tTurno= $_POST['nombre_tTurno'];
$turno->inicio_tTurno= $_POST['inicio_tTurno'];
$turno->final_tTurno= $_POST['final_tTurno'];
$turno->estatus_tTurno= $_POST['estatus_tTurno'];

if($_POST['incluir']){
if(!$turno->buscar()){
if($turno->incluir()!=-1)
	 echo "<script> swal('Good job!', 'Registro exitoso', 'success');</script>";
 }else{ 
 echo "<script> swal('Oops...', 'Hay un turno registrado con esta nombre en este estado', 'error'); </script>";

  //$msj = 'Hay un cargo registrado con este nombre_tCargo en este estado '; 
}
 }

if($_POST['buscar']){
if($turno->buscar()){
	$existe = 'yes';
 	$rows = $turno->row();
 }else{ 
 echo "<script> swal('Oops...', 'No existe!', 'error'); </script>";

}
 }

if($_POST['modificar']){
if($turno->modificar()){
	echo "<script> swal('Good job!', 'Modificación exitosa', 'success');</script>";

 }else{ 
 echo "<script> swal('Oops...', 'No se pudo modificar!', 'error'); </script>";
  
}
 }


 
 
 ?>