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
          $this->Image("../public/img/logopdf.jpg" , 6 ,14, 198 , 22, "JPG" ,"");
				   $this->SetFont('Arial','B',9);

            //Movernos a la derecha
            $this->Cell(10);
            //T�tulo
        		$this->Cell(190,1,"FECHA: ".date("d/m/Y"),0,1,"C");    //Salto de l�nea
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
            $this->Cell(0,5,utf8_decode("___________________________________________________________________________"),0,1,"C",false);
           $this->SetFont('Arial','',9);
            $this->SetTextColor(0,0,0);
            $this->Cell(170);
        //N�mero de p�gina
    			$this->Cell(25,8,'P�gina '.$this->PageNo()."/{nb}",0,1,'C',true);

            //setlocale(LC_ALL,"es_VE.UTF8");
            $this->Ln(-7);
            $this->SetFont("Arial","I",7);
            $avanzar=5;
            $this->Cell($avanzar);
            $uni="Fondo de Desarrollo Agrario Socialista �FONDAS�";
            $dir="Av. Circunvalaci�n Esquina Sem�foro Carretera Nacional V�a Payara. Al Lado De AgroPatr�a Acarigua. Municipio P�ez  Edo. Portuguesa,Rep�blica Bolivariana de Venezuela.";
            $tel="Tel�fono: (0255-00000)";
            $this->Cell(600,4,$uni,0,1,"L");
            $this->Cell($avanzar);
            $this->Cell(70,4,$dir,0,1,"L");
            $this->Cell($avanzar);
            $this->Cell(70,4,$tel,0,1,"L");
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
//funciones para generar codigo de barras code 39
//------------------------------------------------------------------------------------------
    public function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5)
        {

                $wide = $baseline;
                $narrow = $baseline / 3 ;
                $gap = $narrow;

                $barChar['0'] = 'nnnwwnwnn';
                $barChar['1'] = 'wnnwnnnnw';
                $barChar['2'] = 'nnwwnnnnw';
                $barChar['3'] = 'wnwwnnnnn';
                $barChar['4'] = 'nnnwwnnnw';
                $barChar['5'] = 'wnnwwnnnn';
                $barChar['6'] = 'nnwwwnnnn';
                $barChar['7'] = 'nnnwnnwnw';
                $barChar['8'] = 'wnnwnnwnn';
                $barChar['9'] = 'nnwwnnwnn';
                $barChar['A'] = 'wnnnnwnnw';
                $barChar['B'] = 'nnwnnwnnw';
                $barChar['C'] = 'wnwnnwnnn';
                $barChar['D'] = 'nnnnwwnnw';
                $barChar['E'] = 'wnnnwwnnn';
                $barChar['F'] = 'nnwnwwnnn';
                $barChar['G'] = 'nnnnnwwnw';
                $barChar['H'] = 'wnnnnwwnn';
                $barChar['I'] = 'nnwnnwwnn';
                $barChar['J'] = 'nnnnwwwnn';
                $barChar['K'] = 'wnnnnnnww';
                $barChar['L'] = 'nnwnnnnww';
                $barChar['M'] = 'wnwnnnnwn';
                $barChar['N'] = 'nnnnwnnww';
                $barChar['O'] = 'wnnnwnnwn';
                $barChar['P'] = 'nnwnwnnwn';
                $barChar['Q'] = 'nnnnnnwww';
                $barChar['R'] = 'wnnnnnwwn';
                $barChar['S'] = 'nnwnnnwwn';
                $barChar['T'] = 'nnnnwnwwn';
                $barChar['U'] = 'wwnnnnnnw';
                $barChar['V'] = 'nwwnnnnnw';
                $barChar['W'] = 'wwwnnnnnn';
                $barChar['X'] = 'nwnnwnnnw';
                $barChar['Y'] = 'wwnnwnnnn';
                $barChar['Z'] = 'nwwnwnnnn';
                $barChar['-'] = 'nwnnnnwnw';
                $barChar['.'] = 'wwnnnnwnn';
                $barChar[' '] = 'nwwnnnwnn';
                $barChar['*'] = 'nwnnwnwnn';
                $barChar['$'] = 'nwnwnwnnn';
                $barChar['/'] = 'nwnwnnnwn';
                $barChar['+'] = 'nwnnnwnwn';
                $barChar['%'] = 'nnnwnwnwn';

                $this->SetFont('Arial','',10);
                $this->Text($xpos, $ypos + $height + 4, $code);
                $this->SetFillColor(0);

                $code = '*'.strtoupper($code).'*';
                for($i=0; $i<strlen($code); $i++){
                        $char = $code[$i];
                        if(!isset($barChar[$char])){
                                $this->Error('Invalid character in barcode: '.$char);
                        }
                        $seq = $barChar[$char];
                        for($bar=0; $bar<9; $bar++){
                                if($seq[$bar] == 'n'){
                                        $lineWidth = $narrow;
                                }else{
                                        $lineWidth = $wide;
                                }
                                if($bar % 2 == 0){
                                        $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
                                }
                                $xpos += $lineWidth;
                        }
                        $xpos += $gap;
                }
        }

}


setlocale(LC_ALL,"es_VE.UTF8");
   $Pdf=new clsFpdf();
    $DB=new clsConexion();
   $Pdf->AliasNbPages();
   //$Pdf->AddPage('P',array(330,183));
    $Pdf->AddPage('P');

   $Pdf->SetFont('Arial','B',10);
    $Pdf->Ln(5);
    $Pdf->SetTextColor(000);
    $Pdf->SetFillColor(222,216,199);

 //$M=$Pdf->fListar();

   include_once("Query.php");
   $idpermiso=$_GET['idpermiso'];
      $data=$DB->Getone(Query(1,array($idpermiso)));


	  $contenido = 'Yo '.ucfirst($data['nombre']).' '.ucfirst($data['apellido']).', en mi funcion de "'.ucfirst($data['cargo']).'" me dirijo a usted, para agradecerle me conceda permiso por :  ';
    $contenido .=$data['motivo_permiso']. "  , el cual ".utf8_encode('tendr�')." como fecha de inicio desde el dia ".date('d-m-Y',strtotime($data['fecha_ini']));
    $contenido .=",  con una duraci".utf8_encode('�')."n de  ".$data['duracion']." d".utf8_encode('�')."as. Fu".utf8_encode('�')." Revisado por: ".$data['nombres']." Jefe del departamento: ".$data['departamento']." el d".utf8_encode('�')."a ".$data['fecha_revision']." Y fu".utf8_encode('�')." ".$ver." el d".utf8_encode('�')."a  ".$data['fecha_aprobacion']." por: ".$data['nombre1']." Jefe de RECURSO HUMANO.";
      $obs="Observaci".utf8_encode('�')."n: ";
   $Pdf->AliasNbPages();
    $Pdf->SetMargins(12, 10, 10);
    $Pdf->Ln(5);

    $Pdf->SetfillColor(219,223,230);
    $Pdf->SetFont('Arial','B',12);
    $Pdf->SetXY($Pdf->Getx()+25,$Pdf->Gety()-17);
    $Pdf->SetDrawColor(130,69,19);
     $Pdf->Line(6,40,203,40);
	    $Pdf->SetDrawColor(130,69,19);

	 $Pdf->Line(203,40,203,203);
    $Pdf->Ln(20);
	$Pdf->SetTextColor(000);
   $Pdf->SetFillColor(900,240,440);
   $Pdf->SetDrawColor(0,0,0);
    $Pdf->SetFont('Arial', 'B',12);
    $Pdf->SetTextColor(55,55,55);
    $Pdf->Cell(180, 8, utf8_decode('DATOS DEL TRABAJADOR '), 0, 1, 'C');
	$Pdf->Line(6,55,203,55);
	 $Pdf->SetFont('Arial', '',10);

	$Pdf->Cell(120, 6, utf8_decode('APELLIDOS Y NOMBRES: '.$data['nombres5']), 0, 0, 'L');
	$Pdf->Cell(160, 6, 'C�DULA: '.$data['cedula'], 0, 1, 'L');
	$Pdf->Line(6,65,203,65);
		 $Pdf->Line(120,65,120,55);
		   $Pdf->Ln(4);

$Pdf->Cell(120, 6, 'DEPENDENCIA DE ADSCRIPCI�N: '.$data['adscripcion'], 0, 1, 'L');
  $Pdf->Ln(4);
	$Pdf->Cell(120, 6, 'SUPERSISOR: '.$data['supervisor'], 0, 1, 'L');
	$Pdf->Line(6,75,203,75);
	 $Pdf->Ln(4);
	$Pdf->Cell(120, 6, 'MOTIVO DEL PERMISO: '.$data['motivo_permiso'], 0, 1, 'L');
	$Pdf->Ln(4);
	$Pdf->Line(6,85,203,85);
	$Pdf->Line(6,95,203,95);
	$Pdf->Line(6,105,203,105);
	$Pdf->Cell(120, 6, 'CONDICI�N: '.$data['estado'], 0, 0, 'L');
	$Pdf->Cell(160, 6, 'COMPROBANTE A PRESENTAR: ', 0, 1, 'L');
	 $Pdf->Line(100,105,100,95);
		$Pdf->Ln(4);
		$Pdf->Line(6,115,203,115);
	  $Pdf->Line(70,115,70,105);
	  $Pdf->Line(120,115,120,105);
	$Pdf->SetFont('Arial', 'B',10);

		$Pdf->Cell(60, 6, 'CLASE DE PERMISO', 0, 0, 'C');
	    $Pdf->Cell(60, 6, 'DURACI�N', 0, 0, 'C');
	    $Pdf->Cell(60, 6, 'TIEMPO', 0, 1, 'C');
		 $Pdf->Line(70,125,70,105);
	  $Pdf->Line(120,125,120,105);
	$Pdf->Ln(4);
	$Pdf->SetFont('Arial', '',10);

	$Pdf->Cell(60, 6, '', 0, 0, 'C');
	    $Pdf->Cell(60, 6, ''.$data['fecha_ini'].' / '.$data['fecha_fin'], 0, 0, 'L');
	    $Pdf->Cell(60, 6, ''.$data['duracion'], 0, 1, 'C');
		$Pdf->Line(70,135,70,105);
	  $Pdf->Line(120,135,120,105);
	  $Pdf->Line(6,145,203,145);

	$Pdf->Ln(4);
	 $Pdf->SetFont('Arial', 'B',10);
   $Pdf->Cell(60, 6, 'SOLICITANTE', 0, 0, 'C');
	    $Pdf->Cell(60, 6, 'SUPERVISOR', 0, 0, 'C');
	    $Pdf->Cell(60, 6, 'OFICINA R.R.H.H', 0, 1, 'C');
	$Pdf->Line(6,125,203,125);
	$Pdf->Line(6,135,203,135);
$Pdf->Line(70,145,70,105);
	  $Pdf->Line(120,145,120,105);


  if ($data['estado']=='APROBADO'){
		   $Pdf->SetTextColor(107,142,35);
		     $ver=$data['estado'];

	  }else{
		  $Pdf->SetTextColor(220,20,60);
		    $ver=$data['estado'];
	  }
    //$Pdf->Cell(180, 6, utf8_decode(ucfirst($ver)), 0,'L');
	 $Pdf->Ln(20);
    $Pdf->SetFont('Arial', '',14);
    $Pdf->SetTextColor(55,55,55);
    $Pdf->Ln(10);
     $Pdf->Line(6,40,6,203);
  	$Pdf->Line(6,203,203,203);

	$Pdf->SetXY($Pdf->Getx()+165,$Pdf->Gety()+5);

  $Pdf->Cell(40, 5, $Pdf->code39($Pdf->getx(),$Pdf->gety(),'0000'.$data['idpermiso']), 0, 1,'C');


$Pdf->Output();

  ?>
