$(document).ready(function(){
     		
		
//Registrar
$("#Incluir").click(function(){
permitido=true;
var obj_name="";
	 nombre=document.getElementById("nombre");	
	 estado=document.getElementById("idestado");	
		   	    
			if(nombre.value=="" ||nombre.length==0 ){
			swal("El nombre de la ciudad está vacío");nombre.focus();permitido=false;
			 obj_name=nombre.id; 
			 return false;}
			 if(nombre.length<5 ){
			swal("5 carácter mínimo");nombre.focus();permitido=false;
			 obj_name=nombre.id; 
			 return false;}
			 
             if(nombre.value.replace(/^\s+|\s+$/gi,"").length==0){swal("Tiene un espacio en blanco");nombre.focus();
			 permitido=false;
			 obj_name=nombre.id;
			 return false;
			 }	
if(!(/^([a-z ñáéíóú]{2,60})$/i.test(nombre.value.replace(/^\s+|\s+$/gi,"")))){ //para no permitir que se queda en blanco
		swal('Este campo permite solo letras')
		permitido=false;
	    obj_name=nombre.id;
		nombre.focus();return false;
	}

if(estado.value.replace(/^\s+|\s+$/gi,"").length==0 || estado.value.replace(/^\s+|\s+$/gi,"")=="0"){ //para no permitir que se queda en blanco
swal('Seleccione el estado')
permitido=false;
return false;

}	
			
});

//fin Registrar
//**********************
//**********************
//inicio buscar


$("#buscar").click(function(){
  permitido=true;
var obj_name="";
	 nombre=document.getElementById("nombre");	
		   	    
			if(nombre.value=="" ||nombre.length==0 ){
			swal("Ingrese el nombre a buscar");nombre.focus();permitido=false;
			 obj_name=nombre.id; 
			 return false;}
             if(nombre.value.replace(/^\s+|\s+$/gi,"").length==0){swal("Tiene un espacio en blanco");nombre.focus();
			 permitido=false;
			 obj_name=nombre.id;
			 return false;
			 }
if(!(/^([a-z ñáéíóú]{2,60})$/i.test(nombre.value.replace(/^\s+|\s+$/gi,"")))){ //para no permitir que se queda en blanco
		swal('Este campo permite solo letras')
		permitido=false;
	    obj_name=nombre.id;
		nombre.focus();return false;
	}			 
});

	//fin buscar
	//*****************
//************
//******************
//inicio Modificar
//************
$("#actualizar").click(function(){
	
	
 permitido=true;
var obj_name="";
	 nombre=document.getElementById("usuario");	
	 pre=document.getElementById("pre1");	
	 pre2=document.getElementById("pre2");	
	 resp=document.getElementById("resp1");	
	 resp2=document.getElementById("resp2");	
	 var a= $('#resp1').val();
	var b= $('#resp2').val();   
			if(nombre.value=="" ||nombre.length==0 ){
			swal("El nombre de usuario esta vacío");nombre.focus();permitido=false;
			 obj_name=nombre.id; 
			 return false;}
             if(nombre.value.replace(/^\s+|\s+$/gi,"").length==0){swal("Tiene un espacio en blanco");nombre.focus();
			 permitido=false;
			 obj_name=nombre.id;
			 return false;
			 }	


if(pre.value.replace(/^\s+|\s+$/gi,"").length==0 || pre.value.replace(/^\s+|\s+$/gi,"")=="0"){ //para no permitir que se queda en blanco
swal('Seleccione la pregunta 1')
permitido=false;
return false;

	}
	   
			if(resp1.value=="" ||resp1.length==0 ){
			swal("Ingrese la respusta 1");resp1.focus();permitido=false;
			 obj_name=resp1.id; 
			 return false;}
			else if(a.length<6 ){
			swal("6 carácter mínimo");
			
			 return false;}         

			 if(pre2.value.replace(/^\s+|\s+$/gi,"").length==0 || pre2.value.replace(/^\s+|\s+$/gi,"")=="0"){ //para no permitir que se queda en blanco
swal('Seleccione la pregunta 2')
permitido=false;
return false;

	}	
if(resp2.value=="" ||resp2.length==0 ){
			swal("Ingrese la respusta 2");resp2.focus();permitido=false;
			 obj_name=resp2.id; 
			 return false;}
			 else if(b.length<6 ){
			swal("6 carácter mínimo");
			
			 return false;}
			 
			 
             if(resp2.value.replace(/^\s+|\s+$/gi,"").length==0){swal("Tiene un espacio en blanco");resp2.focus();
			 permitido=false;
			 obj_name=resp2.id;
			 return false;
			 }

});
//fin Modificar
//******************



});