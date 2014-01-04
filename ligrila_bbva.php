<?php

/**
*
* @class Ligrila_Bbva
* 
* @author Leandro López <leandro@ligrila.com>
* @copyright     Copyright (c) Ligrila Software. (http://www.ligrila.com)
* @link          http://www.ligrila.com Ligrila Software
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*
*/


define('BBVA_CHECKOUT_URL','https://w3.grupobbva.com/TLPV/tlpv/TLPV_pub_RecepOpModeloServidor');
require_once('ligrila_bbva_utils.php');
class Ligrila_Bbva{

	function __construct(){
		$this->bbvaUtils = new Ligrila_Bbva_Utils;
	}

	function getConfigData($var){
		return null;
	}
	
	function checkoutParams($order){
		$params = $this->bbvaUtils->checkoutParams($order);
		extract($order);
		extract($params);

		$peticion = "<tpv><oppago><idterminal>$idTerminal</idterminal>
		<idcomercio>$idComercio</idcomercio>
		<idtransaccion>$transactionID</idtransaccion>       
		<moneda>$moneda</moneda>
		<importe>$importe</importe>
		<urlcomercio>$urlRespuesta</urlcomercio>
		<idioma>$idioma</idioma>
		<pais>$pais</pais>
		<urlredir>$urlRedireccion</urlredir>
		<localizador>$localizador</localizador>
		<firma>$firma</firma></oppago></tpv>";

		return $peticion;
	}


	function checkout($order){
		$peticion = $this->checkoutParams($order);
		echo $this->generateForm($peticion);
		exit;
	}


	function generateForm($peticion){
		if(defined('CAKE_CORE_INCLUDE_PATH')){
			$bbvaText = __('Ir al bbva');
			$loading = sprintf("<img src=\"%s\" alt=\"%s\"></img>",Router::url('/img/loading.gif',true),__('Cargando...'));
		} else{
			$bbvaText = 'Ir al bbva';
			$loading = sprintf("<img src=\"%s\" alt=\"%s\"></img>",'/img/loading.gif','Cargando...');
		}
		$form = '<html><body>
			'.$loading.'
			<form action="'.BBVA_CHECKOUT_URL.'" id="bbva_standard_checkout" name="Bbva" method="post">
			<input type="hidden" id="peticion" name="peticion" value="'.$peticion.'"></input>
			<input type="submit" value="'.$bbvaText.'"></input>
			</form><script type="text/javascript">document.getElementById("bbva_standard_checkout").submit(); </script></body></html>';
		return $form;
	}
}

?>