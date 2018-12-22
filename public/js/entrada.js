$(document).ready(function(){
    

$("#enviar2").click(function(){

permitido=true;
var obj_name="";
     nombre=document.getElementById("usuario");	
	
			if(nombre.value=="" ||nombre.length==0 ){
			swal("El nombre de usuario está vacío");nombre.focus();permitido=false;
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



});

$("#confirmar2").click(function(){

permitido=true;
var obj_name="";
     resp1=document.getElementById("resp1");	
     resp2=document.getElementById("resp2");	
	var a= $('#resp1').val();
	var b= $('#resp2').val();
			if(resp1.value=="" ||resp1.length==0 ){
			swal("Ingrese la respuesta 1");resp1.focus();permitido=false;
			 obj_name=resp1.id; 
			 return false;}
			else if(a.length<6 ){
			swal("6 carácter mínimo");
			
			 return false;}
			 
            
if(resp2.value=="" ||resp2.length==0 ){
			swal("Ingrese la respuesta 2");resp2.focus();permitido=false;
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

//fin Registrar
//**********************
//**********************
//inicio buscar


$("#nueva_contra").click(function(){
  permitido=true;
var obj_name="";
	 contra=document.getElementById("password1");	
     contra1=document.getElementById("password2");	
	var a= $('#password1').val();
	var b= $('#password2').val();	   	    
			if(contra.value=="" ||contra.length==0 ){
			swal("Ingrese la contraseña");contra.focus();permitido=false;
			 obj_name=contra.id; 
			 return false;}
			  else if(a.length<6 ){
			swal("La contraseña debe tener al menos 6 caracteres!");
			
			 return false;}
			 if(contra1.value=="" ||contra1.length==0 ){
			swal("Confirmar la contraseña");contra1.focus();permitido=false;
			 obj_name=contra1.id; 
			 return false;}
			 else if(b.length<6 ){
			swal("La contraseña debe tener al menos 6 caracteres!");
			
			 return false;}
			 else if(contra.value!=contra1.value ){
			swal("Ambas contraseñas ingresadas deben ser idénticas!");
			
			 return false;}
			 
             
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
	 nombre=document.getElementById("nombre");	
	 descripcion=document.getElementById("descripcion");	
	 hora_inicio=document.getElementById("set_up");	
	 hora_fin=document.getElementById("close_up");	
		   	  
			if(nombre.value=="" ||nombre.length==0 ){
			swal("El nombre del cargo está vacío");nombre.focus();permitido=false;
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

if(descripcion.value.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		swal('Ingrese una descripción del cargo');descripcion.focus();
		permitido=false;
		obj_name=descripcion.id;
		
     return false;
	}	if(hora_inicio.value.replace(/^\s+|\s+$/gi,"").length==0 || hora_inicio.value.replace(/^\s+|\s+$/gi,"")=="0"){ //para no permitir que se queda en blanco
swal('Seleccione la hora inicio')
permitido=false;
return false;

}		
if(hora_fin.value.replace(/^\s+|\s+$/gi,"").length==0 || hora_fin.value.replace(/^\s+|\s+$/gi,"")=="0"){ //para no permitir que se queda en blanco
swal('Seleccione la hora fin')
permitido=false;
return false;

}		
});
//fin Modificar
//******************



});