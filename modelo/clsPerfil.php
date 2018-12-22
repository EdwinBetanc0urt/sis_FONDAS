<?php
include_once('clsConexion_2.php');

class Perfil extends clsConexion {

	public $tipo_usuario;
	public $url_perfil;
	public $idservicio;
	public $idmodulo;
	public $idopcion;
	public $nombre;
	public $construir_cadena_sql=array(); 
	public $construir_cadena_sql_ver_servicio=array(); 

	public function incluir(){
		$exito = false;
		$this->iniciar_transaccion();
		
		$insert_padre = $this->ejecutar("INSERT INTO ttipo_usuario VALUES('','$this->nombre','1')");
		$id=$this->dameUltimoID();
		$insert_hijo = $this->ejecutar("INSERT INTO tservicios_usuarios_opciones(tipo_usuario,idservicio,idopciones) VALUES('$id','1','2')");
	
		//Validaciones
		if($insert_padre >  0 and $insert_hijo > 0 ){
			$this->terminar_transaccion();
			$exito = true;
		}
		else{
			$this->cortar_transaccion();
		}
		return $exito;
	}
 
 
 
	public function buscar(){
		return parent::ejecutar("select *,( CASE 
	        WHEN estatus=1 THEN  'Activo'
	        ELSE 'Desactivado' END) AS estatus from ttipo_usuario where 
	        nombre='$this->nombre' and estatus=1");
	}


	public function construir_cadena_sql($Parametro){
		if($Parametro==false) 
			$this->construir_cadena_sql=array();
     
		if($Parametro==true){
			$valor="('$this->tipo_usuario','$this->idservicio','$this->idopcion')";
			if(!(in_array($valor,$this->construir_cadena_sql)))
				$this->construir_cadena_sql[]=$valor;
		}
	}
   

	public function construir_cadena_sql_ver_servicio($Parametro){
		if($Parametro==false) 
			$this->construir_cadena_sql_ver_servicio=array();
		     
		if($Parametro==true){
			$valor="('$this->tipo_usuario','$this->idservicio',NULL)";
			if(!(in_array($valor,$this->construir_cadena_sql_ver_servicio)))
				$this->construir_cadena_sql_ver_servicio[]=$valor;
		}
   }


 
 	public function INSERTAR_OPCION_SERVICIO_PERFIL(){
		$value=implode(',',$this->construir_cadena_sql);
     
		return parent::ejecutar("INSERT INTO tservicios_usuarios_opciones(tipo_usuario,idservicio,idopciones) VALUES ".$value);
	}
 


	public function INSERTAR_SERVICIO_PERFIL(){
		$value=implode(',',$this->construir_cadena_sql_ver_servicio); 
		return parent::ejecutar("INSERT INTO tservicios_usuarios_opciones(tipo_usuario,idservicio,idopciones) VALUES ".$value);
	}



	public function Actualizar(){
		$exito = false;	
		$this->iniciar_transaccion();
		$update_padre = $this->ejecutar("UPDATE ttipo_usuario SET nombre='$this->nombre' WHERE tipo_usuario='$this->tipo_usuario'");
		$delete_detalle4 = $this->ejecutar("delete from tservicios_usuarios_opciones where tipo_usuario='$this->tipo_usuario'");
		
		//Validaciones
		if($update_padre >  0 OR $delete_detalle4 > 0 ){
			$this->terminar_transaccion();
			$exito = true;
		}
		else{
			$this->cortar_transaccion();
		}
		return $exito;
 	}
 
 
 public function IMPRIMIR_MODULOS(){
return parent::ejecutar("SELECT tmod.idmodulo, tmod.nombre ,tmod.icono FROM tmodulos tmod WHERE tmod.idmodulo 
    IN ( SELECT tser.idmodulo FROM tservicios tser WHERE tser.idmodulo = tmod.idmodulo 
    AND tser.idservicio IN ( SELECT tsuo.idservicio FROM tservicios_usuarios_opciones tsuo
    WHERE tsuo.tipo_usuario =  '$this->tipo_usuario') ) AND tmod.estatus=1 ");
 }
 
 public function IMPRIMIR_SERVICIOS(){
return parent::ejecutar("SELECT * FROM tservicios tser WHERE tser.idmodulo = '$this->idmodulo' 
    AND tser.idservicio IN ( SELECT tsuo.idservicio FROM tservicios_usuarios_opciones tsuo
    WHERE tsuo.tipo_usuario =  '$this->tipo_usuario' ) ORDER BY nombre ");
 }
 
 public function IMPRIMIR_OPCIONES(){
return parent::ejecutar("SELECT nombre,orden,nombre_boton,( CASE 
        WHEN estatus=1  THEN  'Activo'
        ELSE 'Desactivado' END) AS estatus FROM topciones topc WHERE topc.idopcion IN 
           ( SELECT tsuo.idopciones FROM tservicios_usuarios_opciones tsuo
    WHERE tsuo.tipo_usuario =  '$this->tipo_usuario' and idservicio in (SELECT idservicio from tservicios where 
    url='$this->url_perfil')
    ) ");
 }
 
 public function Consultar_SERVICIOS(){
return parent::ejecutar("select * from tservicios_usuarios_opciones tsuo 
    inner join ttipo_usuario tper on tper.tipo_usuario=tsuo.tipo_usuario
    inner join tservicios tser on tser.idservicio=tsuo.idservicio 
    where tper.tipo_usuario='$this->tipo_usuario' and tser.idservicio='$this->idservicio' 
    and tser.estatus=1 and tper.estatus=1");
 }
 
 public function Consultar_OPCIONES(){
return parent::ejecutar("select * from tservicios_usuarios_opciones tsuo 
    inner join ttipo_usuario tper on tper.tipo_usuario=tsuo.tipo_usuario 
    inner join tservicios tser on tser.idservicio=tsuo.idservicio
    inner join topciones topc on topc.idopcion=tsuo.idopciones 
    where topc.idopcion='$this->idopcion' and 
    tper.tipo_usuario='$this->tipo_usuario' and 
    tser.idservicio='$this->idservicio' 
    and tser.estatus=1 and tper.estatus=1 
    and topc.estatus=1");
 }
/*SELECT nombre, orden, (

CASE WHEN estatus =1
THEN  'Activo'
ELSE  'Desactivado'
END
) AS estatus
FROM topciones topc
WHERE topc.idopcion
IN (

SELECT tsuo.idopciones
FROM tservicios_usuarios_opciones tsuo
WHERE tsuo.tipo_usuario =  '1'
AND idservicio
IN (

SELECT idservicio
FROM tservicios
WHERE url =  'Empleado'
)
)*/

public function activar(){
			return parent::ejecutar("update ttipo_usuario set estatus=1 where tipo_usuario='$this->tipo_usuario'");
		}
		public function desactivar(){
			return parent::ejecutar("update tusuario set estatus=0 where tipo_usuario='$this->tipo_usuario'");
		}
		
		public function desactivar2(){
			return parent::ejecutar("update tusuario set estatus=0 where id_usuario='$this->id_usuario'");
		}


public function row(){
return  mysql_fetch_array($this->res);
 }
 public function num(){
return  mysql_num_rows($this->res);
 }

public function traer_codigo(){

return parent::ejecutar("SELECT MAX(tipo_usuario) AS tipo_usuario  FROM ttipo_usuario");
 }
 


  
 }
?>
