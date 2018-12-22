

var vacaciones = ( function( psFechaEntrada = "" ) {

	var atrFechaEntrada = psFechaEntrada;

    return {

		getDiasPorAntiguedad: function (piAntiguedad = 0) {
			let liDiasVacaciones = 0;
			switch( true ) {
				case ( piAntiguedad == 1 ):
					liDiasVacaciones = 15;
					break;

				case (piAntiguedad == 2):
					liDiasVacaciones = 16;
					break;
				
				case (piAntiguedad == 3):
					liDiasVacaciones = 17;
					break;

				case (piAntiguedad == 4):
					liDiasVacaciones = 18;
					break;

				//primer quinquenio de 5 años a 9 años
				case (piAntiguedad >= 5 && piAntiguedad <= 9):
					liDiasVacaciones = 19;
					break;

				//segundo quinquenio de 10 años a 14 años
				case ((piAntiguedad >= 5) && (piAntiguedad <= 9)):
					liDiasVacaciones = 20;
					break;

				//tercer quinquenio 15 años
				case ((piAntiguedad >= 10) && (piAntiguedad <= 15)):
					liDiasVacaciones = 21;
					break;

				//mas de 16 años o mas
				case (piAntiguedad >= 16):
					liDiasVacaciones = 25;
					break;

				default:
				case (piAntiguedad <= 0):
					//default:
					liDiasVacaciones = 0;
					break;
			} //cierre del switch

			return liDiasVacaciones;
		} ,


		getFechaFormato: function( pmFecha = "" , pmFormatoE = "amd" , pmFormatoR = "dma" ) {
			if ( pmFecha == "" ) {
				pmFecha = date("d-m-Y");
			}
			switch ( pmFormatoE ) {
				default:
				case 'dma':
					lsDia = pmFecha.substr( -0 , 2 );
					lsMes = pmFecha.substr( -3 , 2 );
					lsAno = pmFecha.substr( -6 , 4 );
					break;
				case 'amd':
					lsDia = pmFecha.substr( -2 , 8 );
					lsMes = pmFecha.substr( -5 , 2 );
					lsAno = pmFecha.substr( -0 , 4 );
					break;

				case 'mda':
					lsDia = pmFecha.substr( 3 , 2 );
					lsMes = pmFecha.substr( 0 , 2 );
					lsAno = pmFecha.substr( 6 , 4 );
					break;
			}
			switch ( pmFormatoR ) {
				default:
				case 'amd':
					// año - mes - dia
					lsFecha = lsAno + "-" + lsMes + "-" + lsDia;
					break;
				case 'dma':
					// dia - mes - año
					lsFecha = lsDia + "-" + lsMes + "-" + lsAno;
					break;
				case 'mda':
					// mes - dia - año
					lsFecha = lsMes + "-" + lsDia + "-" + lsAno;
					break;
				case 'mad':
					// mes - dia - año
					lsFecha = lsMes + "-" + lsDia + "-" + lsAno;
					break;
				case 'am':
					// año - mes
					lsFecha = lsAno + "-" + lsMes;
					break;
				case 'ad':
					// año - dia
					lsFecha = lsAno + "-" + lsDia;
					break;
				case 'ma':
					// mes - año
					lsFecha = lsMes + "-" + lsAno;
					break;
				case 'md':
					// mes - dia
					lsFecha = lsMes + "-" + lsDia;
					break;
				case 'dm':
					// dia - mes
					lsFecha = lsDia + "-" + lsMes;
					break;
				case 'da':
					// dia - año
					lsFecha = lsDia + "-" + lsAno;
					break;
				case 'a':
					//año
					lsFecha = lsAno;
					break;
				case 'm':
					// mes
					lsFecha = lsMes;
					break;
				case 'd':
					// dia
					lsFecha = lsDia;
					break;
			}
			return lsFecha;
		} ,


		getDiasDeVacaciones: function( psFechaIngreso, paPeriodos = array() ) {
			lsDia = substr( psFechaIngreso , 8 , 2 );
			lsMes = substr( psFechaIngreso , 5 , 2 );
			lsAno = substr( psFechaIngreso , 0 , 4 );

			objFecha_Ingreso = new DateTime( psFechaIngreso );
			liCont = 1;
			lsVacaciones = 0;
			if ( count( paPeriodos ) <= 0 ) {
				liCont = -1;
			}
			arrRetorno = array();
			foreach (paPeriodos as key => value) {

				objFecha_Periodo = new DateTime( value . "-" . lsMes . "-" . lsDia );
				annos = objFecha_Periodo->diff(objFecha_Ingreso);
				antiguedad =  annos->y + 1 ;
				
				diasvacaciones = vacaciones.getDiasPorAntiguedad( antiguedad );
				lsVacaciones = lsVacaciones + diasvacaciones ;
				arrRetorno["periodo"][liCont]["anno"] = value;
				arrRetorno["periodo"][liCont]["dias"] = diasvacaciones;

				liCont ++;
			}

			arrRetorno["dias_vacaciones"] = lsVacaciones;
			return arrRetorno;
		} ,

		getPeriodosAntiguedad: function( psFechaIngreso) {

			lsAno = substr( psFechaIngreso , 0 , 4 );
			objFecha_Ingreso = new DateTime( psFechaIngreso );

			arrRetorno = array();

			objFecha_Periodo = new DateTime( date("Y-m-d") );

			annos = objFecha_Periodo->diff(objFecha_Ingreso);
			antiguedad =  annos->y ;

			//echo "antiguedad";

			for (liControl = 0; liControl  <= antiguedad ; liControl ++) { 
				arrRetorno[ liControl ] = lsAno + liControl;
			}

			return arrRetorno;
		}
	}
})();


console.log( "fecha " + vacaciones.getFechaFormato( "2018-12-01", "amd", "mad" ) );


