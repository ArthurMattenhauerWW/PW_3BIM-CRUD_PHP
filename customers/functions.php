<?php

include "../config.php";
include DBAPI;

$customers = null;
$customer = null;

/**
 *  Formatar Datas
 */
function formatdata($data, $formato) {
	$dt = new DateTime($data, new DateTimeZone("America/Sao_Paulo")); //"-0300"
	return($dt->format($formato));
}

/**
 *  Listagem de Clientes
 */
function index() {
	global $customers;
	$customers = find("customers");
	//pd ser find all
}
//n precisa fechar pq é puro php
/**
 *  Visualização de um Cliente
 */
function view($id = null) {
  global $customer;
  $customer = find('customers', $id);
}

?>