$(document).ready(function(){

	

	//menu acordeon
	var antlist;
	var actlist;
	var vec=0;
	$(".menu_content li.list_padre").click(function(){
	
		//cerramos todos los menu
		antlist = actlist;
		actlist = $(this);
	
		if(vec>0){
			if(actlist.text()!=antlist.text()){ 
				//acordeon
				antlist.find("ul").slideUp(300);
				antlist.removeClass('active-list');
				actlist.find("ul").slideDown(300);
				actlist.addClass('active-list');
			}else{
				antlist.find("ul").slideUp(300);
				antlist.removeClass('active-list');
				//reseteamos el acordeon
				actlist="";
				vec=0;
			}
		}else{
			actlist.find("ul").slideDown(300);
			actlist.addClass('active-list');
			vec=1;
		}
		
	});
	//cierre del menu acordeon

});