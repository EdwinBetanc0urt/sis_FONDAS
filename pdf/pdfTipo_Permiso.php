<?php
  require_once("../modelo/clsConexion.php");
   require_once("fpdf.php");
   require_once("Query.php");

  class clsFpdf extends FPDF {
	   var $widths;
        var $aligns;
	        // $id="02";
	 //Cabecera de p�gina
		public function Header()
		{

			    //Logo
            //$this->Image("../public/img/banner.jpg" , 8 ,8, 180 , 22, "JPG" ,"");
          //$this->Image("../public/img/sello.png" , 8 ,14, 40 , 20, "PNG" ,"");
          $this->Image("../public/img/logopdf.jpg" , 8 ,14, 245 , 22, "JPG" ,"");
				   $this->SetFont('Arial','B',9);

            //Movernos a la derecha
            $this->Cell(10);
            //T�tulo
        		   $this->Ln(7);
        		$this->Cell(100,7,"",0,1,"C");
            $this->Ln(10);


		}

		//Pie de p�gina
		public function Footer()
		{
    			//Posici�n: a 2 cm del final
    			$this->SetY(-25);
    			//Arial italic 8
    			$this->SetFont("Arial","I",5);
    		$this->SetFont('Arial','',13);
            $this->SetFillColor(240,240,240);
            $this->SetTextColor(200, 200, 200);
            $this->Cell(0,5,utf8_decode("____________________________________________________________________________________________________________________________"),0,1,"C",false);
           $this->SetFont('Arial','',9);
            $this->SetTextColor(0,0,0);
            $this->Cell(170);
        //N�mero de p�gina
    			$this->Cell(45,8,'P�gina '.$this->PageNo()."/{nb}",0,1,'C',true);

            //setlocale(LC_ALL,"es_VE.UTF8");
            $this->Ln(-7);
            $this->SetFont("Arial","I",7);
            $avanzar=50;
            $this->Cell($avanzar);
            $uni="Fondo de Desarrollo Agrario Socialista �FONDAS�";
            $dir="Av. Circunvalaci�n Esquina Sem�foro Carretera Nacional V�a Payara. Al Lado De AgroPatr�a Acarigua. Municipio P�ez  Edo. Portuguesa,Rep�blica Bolivariana de Venezuela.";
            $tel="Tel�fono: (0255-00000)";
            $this->Cell(800,5,$uni,0,1,"L");
            $this->Cell($avanzar);
            $this->Cell(100,5,$dir,0,1,"L");
            $this->Cell($avanzar);
            $this->Cell(100,5,$tel,0,1,"L");
    			//Fecha
    			$lcFecha=date("d/m/Y  h:m a");
    			$this->Cell(0,3,$lcFecha,0,0,"C");
		}

		function SetWidths($w){
            //Set the array of column widths
            $this->widths=$w;
        }

        function SetAligns($a){
            //Set the array of column alignments
            $this->aligns=$a;
        }

        function Row($data){
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=5*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++){
                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                //Draw the border
                $this->Rect($x,$y,$w,$h);
                /*
                //Print the text
                if((count($data)-1)==$i && (strtolower($data[count($data)-1])=='desactivado'))
                $this->SetTextColor(255, 0, 0);
                else
                $this->SetTextColor(0, 0, 0);
                */
                $this->MultiCell($w,5,$data[$i],0,$a);
                //Put the position to the right of the cell
                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }

        function CheckPageBreak($h){
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
        }

        function NbLines($w,$txt){
            //Computes the number of lines a MultiCell of width w will take
            $cw=&$this->CurrentFont['cw'];
            if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
            $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);
            if($nb>0 and $s[$nb-1]=="\n")
                $nb--;
            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $nl=1;
            while($i<$nb){
                $c=$s[$i];
                if($c=="\n"){
                    $i++;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep=$i;
                $l+=$cw[$c];
                if($l>$wmax){
                    if($sep==-1){
                        if($i==$j)
                            $i++;
                    }
                    else
                        $i=$sep+1;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                }
                else
                $i++;
            }
            return $nl;
        }
		//------------------------------------------------------------------------------------------


}

$fecha=$_GET['fecha'];
 $idtipo=$_GET['idtipo'];
 $arreglo2 = explode("-",$fecha);
   $dia= $arreglo2[0];
   $mes= $arreglo2[1];
   $ano= $arreglo2[2];
    $fecha_completo = $ano.'-'.$mes.'-'.$dia;

	$fecha2=$_GET['fecha_final'];
 $idtipo=$_GET['tipo'];
 $arreglo3 = explode("-",$fecha2);
   $dia= $arreglo3[0];
   $mes= $arreglo3[1];
   $ano= $arreglo3[2];
    $fecha_fin = $ano.'-'.$mes.'-'.$dia;
setlocale(LC_ALL,"es_VE.UTF8");
   $Pdf=new clsFpdf();
    $DB=new clsConexion();
	  $data=$DB->Getall(Query(7,array($fecha_completo,$fecha_fin,$idtipo)));


	    $Pdf->AddPage('P',array(260,183));

   $Pdf->SetFont('Arial','B',10);
    $Pdf->Ln(5);
    $Pdf->SetTextColor(000);
    $Pdf->SetFillColor(222,216,199);
   $Pdf->AliasNbPages();



   $Pdf->SetFont('Arial','B',10);
    $Pdf->Ln(5);
    $Pdf->SetTextColor(000);
    $Pdf->SetFillColor(222,216,199);


  //nos traemos los datos
	  include_once("Query.php");


   $Pdf->AliasNbPages();
    $Pdf->SetMargins(12, 10, 10);
    $Pdf->Ln(5);

    $Pdf->SetfillColor(219,223,230);
    $Pdf->SetFont('Arial','B',12);
    $Pdf->SetXY($Pdf->Getx()+25,$Pdf->Gety()-17);
    $Pdf->Ln(10);

    $Pdf->Cell(230, 5, utf8_decode('PERMISO POR RANGO'), 0, 1, 'C');
	$Pdf->Cell(50,5,"FECHA: ".date("d/m/Y"),0,1,"L");    //Salto de l�nea
             $Pdf->Ln(10);



      $Pdf->SetTextColor(000);
   $Pdf->SetFillColor(900,240,440);
   $Pdf->SetDrawColor(0,0,0);
        $Pdf->SetFont('Arial','B',10);
   $Pdf->Cell(60,10,"Empleado",1,0,"C",true);
   $Pdf->Cell(30,10,"C�dula",1,0,"C",true);
   $Pdf->Cell(25,10,"Fecha Inicio",1,0,"C",true);
   $Pdf->Cell(25,10,"Fecha Fin",1,0,"C",true);
   $Pdf->Cell(20,10,"Condici�n",1,0,"C",true);
   $Pdf->Cell(40,10,"Tipo Ausencia",1,0,"C",true);
   $Pdf->Cell(40,10,"",1,1,"Ausencia",true);

   $Pdf->SetTextColor(000);
   $Pdf->SetFillColor(255,255,255);
  $Pdf->SetFont('Arial','B',8);
  $Pdf->SetWidths(array(60,30,25,25,20,40,40));
//un arreglo con alineacion de cada celda
$Pdf->SetAligns(array('L','C','C','C','C','C','C'));

    //un arreglo con su medida  a lo ancho
 srand(microtime()*1000000);
  for($i=0;$i<count($data);$i++){

  $Pdf->Row(array(utf8_decode($data[$i]['nombres4']),
   utf8_decode($data[$i]['cedula']),
   utf8_decode($data[$i]['fecha_ini']),
   utf8_decode($data[$i]['fecha_fin']),
   utf8_decode($data[$i]['estado']),
   utf8_decode($data[$i]['nombre_permiso']),

   utf8_decode($data[$i]['renglon'])));


         }


$Pdf->Output();

  ?>
