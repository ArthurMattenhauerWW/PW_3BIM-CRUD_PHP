<?php
ob_start();

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
 *  Formatar Telefones
 */
function telefone($tel) {
	return "(" . substr($tel, 0, 2) . ")" . substr($tel, 2, 5) . "-" . substr($tel, 7, 4);
}

function celular($tel) {
	return "(" . substr($tel, 0, 2) . ")" . " " . substr($tel, 2, 5) . "-" . substr($tel, 7, 4);
}

/**
 *  Formatar CEP
 */
function cep($cep) {
	return substr($cep, 0, 5) . "." . substr($cep, 5, 3);
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

function add() {

  if (!empty($_POST['customer'])) {
    
    //$today = date_create('now', new DateTimeZone('America/Sao_Paulo'));

	$today = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $customer = $_POST['customer'];
    $customer['modified'] = $customer['created'] = $today->format("Y-m-d H:i:s");
    
    save('customers', $customer);
    header('location: index.php');
  }
}

function save($table = null, $data = null) {

  $database = open_database();

  $columns = null;
  $values = null;

  //print_r($data);

  foreach ($data as $key => $value) {
	//$columns = $columns . trim($key, "'") . ",";
    $columns .= trim($key, "'") . ",";
    $values .= "'$value',";
  }

  // remove a ultima virgula
  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');
  
  //$sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
  $sql = "INSERT INTO  $table ($columns) VALUES ($values);";

  try {
    $database->query($sql);

    $_SESSION['message'] = 'Registro cadastrado com sucesso.';
    $_SESSION['type'] = 'success';
  
  } catch (Exception $e) { 
  
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
    $_SESSION['type'] = 'danger';
  } 

  close_database($database);
}

/**
 *	Atualizacao/Edicao de Cliente
 */
function edit() {

  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

  if (isset($_GET['id'])) {

    $id = $_GET['id'];

    if (isset($_POST['customer'])) {

      $customer = $_POST['customer'];
      $customer['modified'] = $now->format("Y-m-d H:i:s");

      update("customers", $id, $customer);
      header("location: index.php");
    } else {

      global $customer;
      $customer = find("customers", $id);
    } 
  } else {
    header('location: index.php');
  }
}

/**
 *  Atualiza um registro em uma tabela, por ID
 */
function update($table = null, $id = 0, $data = null) {

  $database = open_database();

  $items = null;

  foreach ($data as $key => $value) {
    $items .= trim($key, "'") . "='$value',";
  }

  // remove a ultima virgula
  $items = rtrim($items, ',');

  // $sql  = "UPDATE " . $table;
  // $sql .= " SET $items";
  // $sql .= " WHERE id=" . $id . ";";

  $sql  = "UPDATE $table SET $items WHERE id=$id;";

  try {
    $database->query($sql);

    $_SESSION['message'] = 'Registro atualizado com sucesso.';
    $_SESSION['type'] = 'success';
  
  } catch (Exception $e) { 
  
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
    $_SESSION['type'] = 'danger';
  } 

  close_database($database);
}

?>