<?php 
class IdTransaccion{
  private $y;
  private $ddd;
  private $hh;
  private $mm;
  private $ss;
  private $an;
  private $id;
  public function __construct (){
    $this->setIdTrans ();
  }
  private function setIdTrans (){
    $this->y =
      substr (date ('y'), strlen (date ('y')) - 1, strlen (date ('y')));
    $this->ddd = date ('z');	//Devuelve el día del año desde 0 a 365
    if ($this->ddd < 10)
      $this->ddd = '00'.$this->ddd;	//añadimos 2 ceros en el caso de ser menos de 10
    else if ($this->ddd > 9 && $this->ddd < 100)
      $this->ddd = '0'.$this->ddd;	//añadimos un 0 en el caso de ser mayor de 9 y menor de 100
    $this->hh = date ('H');	//Devuelve la hora en formato 00 a 24
    $this->mm = date ('i');	//Devuelve los minutos desde 00 a 59
    $this->ss = date ('s');	//Devueve los segundos en 00 a 59
    $this->an = rand ('11', '99');	//Devuelve un valor aleatorio ente 10-99
  }
  public function getIdTrans (){
    return $this->id =
      $this->y.$this->ddd.$this->hh.$this->mm.$this->ss.$this->an;
  }
}

class Desofuscar{
  private $pal_sec_ofuscada;
  private $clave_xor;
  private $cad1_0 = "0";
  private $cad2_0 = "00";
  private $cad3_0 = "000";
  private $cad4_0 = "0000";
  private $cad5_0 = "00000";
  private $cad6_0 = "000000";
  private $cad7_0 = "0000000";
  private $cad8_0 = "00000000";
  private $pal_sec = "";
  public function __construct ($ofuscada, $clave, $idcomercio){
    $this->pal_sec_ofuscada = $ofuscada;
    $this->clave_xor = $clave.substr ($idcomercio, 0, 9).'***';
    $this->init ();		//Desofuscamos
  }
  private function init (){
    $trozos = explode (";", $this->pal_sec_ofuscada);
    $tope = count ($trozos);
    $xor = array ();
    for ($i = 0; $i < $tope; $i++)
      {
	$res = "";
	$pal_sec_ofus_bytes[$i] = decbin (hexdec ($trozos[$i]));
	if (strlen ($pal_sec_ofus_bytes[$i]) == 7){
	    $pal_sec_ofus_bytes[$i] = $this->cad1_0.$pal_sec_ofus_bytes[$i];
	  }
	if (strlen ($pal_sec_ofus_bytes[$i]) == 6){
	    $pal_sec_ofus_bytes[$i] = $this->cad2_0.$pal_sec_ofus_bytes[$i];
	  }
	if (strlen ($pal_sec_ofus_bytes[$i]) == 5){
	    $pal_sec_ofus_bytes[$i] = $this->cad3_0.$pal_sec_ofus_bytes[$i];
	  }
	if (strlen ($pal_sec_ofus_bytes[$i]) == 4){
	    $pal_sec_ofus_bytes[$i] = $this->cad4_0.$pal_sec_ofus_bytes[$i];
	  }
	if (strlen ($pal_sec_ofus_bytes[$i]) == 3){
	    $pal_sec_ofus_bytes[$i] = $this->cad5_0.$pal_sec_ofus_bytes[$i];
	  }
	if (strlen ($pal_sec_ofus_bytes[$i]) == 2){
	    $pal_sec_ofus_bytes[$i] = $this->cad6_0.$pal_sec_ofus_bytes[$i];
	  }
	if (strlen ($pal_sec_ofus_bytes[$i]) == 1){
	    $pal_sec_ofus_bytes[$i] = $this->cad7_0.$pal_sec_ofus_bytes[$i];
	  }
	$pal_sec_xor_bytes[$i] = decbin (ord ($this->clave_xor[$i]));
	if (strlen ($pal_sec_xor_bytes[$i]) == 7){
	    $pal_sec_xor_bytes[$i] = $this->cad1_0.$pal_sec_xor_bytes[$i];
	  }
	if (strlen ($pal_sec_xor_bytes[$i]) == 6){
	    $pal_sec_xor_bytes[$i] = $this->cad2_0.$pal_sec_xor_bytes[$i];
	  }
	if (strlen ($pal_sec_xor_bytes[$i]) == 5){
	    $pal_sec_xor_bytes[$i] = $this->cad3_0.$pal_sec_xor_bytes[$i];
	  }
	if (strlen ($pal_sec_xor_bytes[$i]) == 4){
	    $pal_sec_xor_bytes[$i] = $this->cad4_0.$pal_sec_xor_bytes[$i];
	  }
	if (strlen ($pal_sec_xor_bytes[$i]) == 3){
	    $pal_sec_xor_bytes[$i] = $this->cad5_0.$pal_sec_xor_bytes[$i];
	  }
	if (strlen ($pal_sec_xor_bytes[$i]) == 2){
	    $pal_sec_xor_bytes[$i] = $this->cad6_0.$pal_sec_xor_bytes[$i];
	  }
	if (strlen ($pal_sec_xor_bytes[$i]) == 1){
	    $pal_sec_xor_bytes[$i] = $this->cad7_0.$pal_sec_xor_bytes[$i];
	  }
	for ($j = 0; $j < 8; $j++){
	    (string) $res .=
	      (int) $pal_sec_ofus_bytes[$i][$j] ^ (int)
	      $pal_sec_xor_bytes[$i][$j];
	  }
	$xor[$i] = $res;
	$this->pal_sec .= chr (bindec ($xor[$i]));
      }
  }
  public function getDesofuscar ()
  {
    return $this->pal_sec;
  }
}

?>
