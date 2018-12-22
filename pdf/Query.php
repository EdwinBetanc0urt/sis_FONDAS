<?php
function Query($caso,$array){
 $sql=null;
 switch($caso){
   
 case 1:{
	$sql="SELECT per. * , DATE_FORMAT( per.fecha_sol,  '%d-%m-%Y' ) AS fecha_sol, DATE_FORMAT( per.fechainicio_permiso,  '%d-%m-%Y' ) AS fecha_ini, DATE_FORMAT( per.fechafinal_permiso,  '%d-%m-%Y' ) AS fecha_fin, DATE_FORMAT( per.fecha_rev_jefe,  '%d-%m-%Y' ) AS fecha_revision, DATE_FORMAT( per.fecha_rev_rh,  '%d-%m-%Y' ) AS fecha_aprobacion, tper.nombre,CONCAT( tper.nombre,  ' ', tper.apellido ) AS nombres5, tper.apellido, trb.idtrabajador, tper.cedula, r.nombre AS renglon, ti.nombre AS nombre_permiso,( CASE WHEN per.estatus =1 THEN 'Activo' ELSE 'Desactivado' END ) AS estatus_cargo,per.estado AS estados,( 

	CASE 
		WHEN per.estado =1 
			THEN 'ESPERA' 
		WHEN per.estado =2
			THEN  'REVISADO' 
		WHEN per.estado =3
			THEN  'APROBADO' ELSE 'REPROBADO' 
	END 


	) AS estado, CONCAT( p.nombre,  ' ', p.apellido ) AS nombres, CONCAT( p1.nombre,  ' ', p1.apellido ) AS nombres1,ca.nombre AS cargo,de.nombre AS departamento,dep.nombre AS adscripcion, CONCAT( sup.nombre,  ' ', sup.apellido ) AS supervisor
FROM tpermiso AS per
LEFT JOIN ttrabajador AS trb ON per.idsolicitante = trb.idtrabajador
LEFT JOIN tpersonas AS tper ON trb.idpersona = tper.idpersona
LEFT JOIN trenglon_ausencia AS r ON per.idrenglon = r.idrenglon
LEFT JOIN ttipo_ausencia AS ti ON r.tipo_ausencia = ti.tipo_ausencia
LEFT JOIN ttrabajador AS tr ON per.idjefedep = tr.idtrabajador
LEFT JOIN tpersonas AS p ON tr.idpersona = p.idpersona
LEFT JOIN tdepartamento AS de ON tr.iddepartamento = de.iddepartamento
LEFT JOIN tdepartamento AS dep ON trb.iddepartamento = dep.iddepartamento
LEFT JOIN ttrabajador AS t ON per.otorgante_id = t.idtrabajador
LEFT JOIN tpersonas AS p1 ON t.idpersona = p1.idpersona

LEFT JOIN ttrabajador AS traba ON dep.idtrabajador = traba.idtrabajador
LEFT JOIN tpersonas AS sup ON traba.idpersona = sup.idpersona
LEFT JOIN tcargo AS ca ON trb.idcargo = ca.idcargo
         WHERE per.idpermiso='$array[0]'";
		}break; 
		
		case 2:{
	$sql="SELECT DISTINCT CONCAT( p.nombre,  ' ', p.apellido ) AS nombres, p.cedula, d.idpersona,d.idtrabajador
FROM ttrabajador AS d
LEFT JOIN tpersonas AS p ON d.idpersona = p.idpersona WHERE d.estatus='1'";
		}break; 
		
		case 3:{
	$sql="SELECT a.idasistencia, a.hora_asistencia AS entrada1, a.comentario_asistencia,a.condicion_asistencia, DATE_FORMAT( a.fecha_asistencia,  '%d-%m-%Y' ) AS fecha_asistencia
FROM tasistencia AS a
WHERE a.fecha='$array[0]' AND a.tipo_asistencia='Entradaam'";
		}break;	
		
		 case 4:{
	$sql="SELECT a.idasistencia, a.hora_asistencia AS salida1, a.comentario_asistencia,a.condicion_asistencia, DATE_FORMAT( a.fecha_asistencia,  '%d-%m-%Y' ) AS fecha_asistencia
FROM tasistencia AS a
WHERE a.fecha='$array[0]' AND a.tipo_asistencia='Salidaam'";
		}break; 
		
		
		case 5:{
	$sql="SELECT a.idasistencia, a.hora_asistencia AS entrada2, a.comentario_asistencia,a.condicion_asistencia, DATE_FORMAT( a.fecha_asistencia,  '%d-%m-%Y' ) AS fecha_asistencia
FROM tasistencia AS a
WHERE a.fecha='$array[0]' AND a.tipo_asistencia='Entradapm'";
		}break; 
		
		case 6:{
	$sql="SELECT a.idasistencia, a.hora_asistencia AS salida2, a.comentario_asistencia,a.condicion_asistencia, DATE_FORMAT( a.fecha_asistencia,  '%d-%m-%Y' ) AS fecha_asistencia
FROM tasistencia AS a
WHERE a.fecha='$array[0]' AND a.tipo_asistencia='Salidapm'";
 		}break;
		case 7:{
	$sql="SELECT per. * , DATE_FORMAT( per.fecha_sol,  '%d-%m-%Y' ) AS fecha_sol, DATE_FORMAT( per.fechainicio_permiso,  '%d-%m-%Y' ) AS fecha_ini, DATE_FORMAT( per.fechafinal_permiso,  '%d-%m-%Y' ) AS fecha_fin, DATE_FORMAT( per.fecha_rev_jefe,  '%d-%m-%Y' ) AS fecha_revision, DATE_FORMAT( per.fecha_rev_rh,  '%d-%m-%Y' ) AS fecha_aprobacion,  CONCAT( tper.nombre,  ' ', tper.apellido ) AS nombres4, trb.idtrabajador, tper.cedula, r.nombre AS renglon, ti.nombre AS nombre_permiso,( CASE WHEN per.estatus =1 THEN 'Activo' ELSE 'Desactivado' END ) AS estatus_cargo,per.estado AS estados,( CASE WHEN per.estado =1 THEN 'ESPERA' WHEN per.estado =2
THEN  'REVISADO' WHEN per.estado =3
THEN  'APROBADO' ELSE 'REPROBADO' END ) AS estado, CONCAT( p.nombre,  ' ', p.apellido ) AS nombres, CONCAT( p1.nombre,  ' ', p1.apellido ) AS nombres1
FROM tpermiso AS per
LEFT JOIN ttrabajador AS trb ON per.idsolicitante = trb.idtrabajador
LEFT JOIN tpersonas AS tper ON trb.idpersona = tper.idpersona
LEFT JOIN trenglon_ausencia AS r ON per.idrenglon = r.idrenglon
LEFT JOIN ttipo_ausencia AS ti ON r.tipo_ausencia = ti.tipo_ausencia
LEFT JOIN ttrabajador AS tr ON per.idjefedep = tr.idtrabajador
LEFT JOIN tpersonas AS p ON tr.idpersona = p.idpersona
LEFT JOIN ttrabajador AS t ON per.otorgante_id = t.idtrabajador
LEFT JOIN tpersonas AS p1 ON t.idpersona = p1.idpersona
					   	WHERE per.fecha_sol
					  
BETWEEN '$array[0]' AND '$array[1]' AND ti.tipo_ausencia='$array[2]' ";
		}break;
		
		case 8:{
	$sql="SELECT * FROM tparentesco
WHERE idparticipante='$array[0]'";
		}break;
		case 9:{
	$sql="SELECT DATE_FORMAT(a.fecha_inicio,  '%d-%m-%Y' ) AS  fecha_inicio,
							DATE_FORMAT(a.fecha_fin,  '%d-%m-%Y' ) AS fecha_fin,
					  a.idasignacion,
                      a.idcurso,
                      a.descripcion,
                      ( CASE 
        WHEN a.estatus=1 THEN  'Activo'
        WHEN a.estatus=2 THEN  'Culminado'
        ELSE 'Desactivado' END) AS estatus,
                      a.idcurso,c.nombre as curso
                      FROM tasignacion a 
                      INNER JOIN tcurso c ON a.idcurso = c.idcurso
					   WHERE a.idasignacion='$array[0]'";
		}break;
		case 10:{
	$sql="SELECT CONCAT( p.nombre, ' ', p.apellido ) AS animador, p.cedula AS cedula_animador,a.idcurso, c.idanimador, p1.cedula AS cedula_coordinador, CONCAT( p1.nombre, ' ', p1.apellido ) AS coordinador, c.idcoordinador, a.idasignacion, cu.nombre AS curso
FROM `tcurso_animador` AS c
LEFT JOIN tpersonal AS d ON c.idanimador = d.idpersonal
LEFT JOIN tpersonas AS p ON d.idpersona = p.idpersona
LEFT JOIN tpersonal AS d1 ON c.idcoordinador = d1.idpersonal
LEFT JOIN tpersonas AS p1 ON d1.idpersona = p1.idpersona
LEFT JOIN tasignacion AS a ON c.idasignacion = a.idasignacion
LEFT JOIN tcurso AS cu ON a.idcurso = cu.idcurso
                     	
                      WHERE c.idasignacion='$array[0]'";
		}break;
		case 11:{
	$sql="SELECT  CONCAT(p.nombre,' ',p.apellido )  AS nombres
                       ,p.cedula, c.idparticipante,c.idcurso,cu.nombre as curso
							FROM tcurso_asignacion as c 
						LEFT join tparticipante as d on c.idparticipante=d.idparticipante        
                      LEFT  join tpersonas as p on d.cedula=p.cedula        
                       LEFT join tcurso as cu on c.idcurso=cu.idcurso     
                     WHERE c.idasignacion='$array[0]'";
		}break;
		
		
//Fin Horario Normal 		
				
			
	

		}

  return $sql;
}

?>
