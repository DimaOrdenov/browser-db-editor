<?php

require_once 'config.php';

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'edit':
			edit();
			break;
		case 'add':
			add();
			break;
		case 'del':
			del();
			break;
	}
}

function edit() {
	$json = array();
	header('Content-Type: application/json');
	$DB_CONN = $GLOBALS['DB_CONN'];

	$values = $_POST;

	$conn = new mysqli($DB_CONN['server'], $DB_CONN['username'], $DB_CONN['password'], $DB_CONN['db']);

	if ($conn->connect_error) {
	    $json['error'][] = "Connection failed: " . $conn->connect_error;
	    echo json_encode($json);
	    return;
	} 

	$conn->set_charset("utf8");

	$sql = "UPDATE table_modify SET product_name = '" . $values['product'] . "', category_id = '" . $values['category_id'] . "', price = '" . $values['price'] . "' WHERE id = '" . $values['product_id'] . "'";

	if (!$conn->query($sql)) {
		$json['error'][] = "UPDATE failed: " . $conn->error;
		echo json_encode($json);
		return;
	}

	$conn->close();

	echo json_encode($json);
}

function del() {
	$json = array();
	header('Content-Type: application/json');
	$DB_CONN = $GLOBALS['DB_CONN'];

	$values = $_POST;

	$conn = new mysqli($DB_CONN['server'], $DB_CONN['username'], $DB_CONN['password'], $DB_CONN['db']);

	if ($conn->connect_error) {
	    $json['error'][] = "Connection failed: " . $conn->connect_error;
	    echo json_encode($json);
	    return;
	} 

	$conn->set_charset("utf8");

	$sql = "DELETE FROM table_modify WHERE id = '" . $values['product_id'] . "'";

	if (!$conn->query($sql)) {
		$json['error'][] = "DELETE failed: " . $conn->error;
		echo json_encode($json);
		return;
	}

	$conn->close();

	echo json_encode($json);
}

function add() {
	$json = array();
	header('Content-Type: application/json');
	$DB_CONN = $GLOBALS['DB_CONN'];

	$values = $_POST['add'];

	$conn = new mysqli($DB_CONN['server'], $DB_CONN['username'], $DB_CONN['password'], $DB_CONN['db']);

	if ($conn->connect_error) {
		$json['error'][] = "Connection failed: " . $conn->connect_error;
	    echo json_encode($json);
	    return;
	} 

	$conn->set_charset("utf8");

	$sql = "INSERT INTO table_modify (product_name, category_id, price) VALUES ('" . $values['product'] . "', '" . $values['category'] . "', '" . $values['price'] . "')";

	if (!$conn->query($sql)) {
		$json['error'][] = "INSERT failed: " . $conn->error;
		echo json_encode($json);
		return;
	}

	$sql = "SELECT MAX(id) as id FROM table_modify";
	$result = $conn->query($sql);
	$json['product_id'] = $result->fetch_assoc()['id'];

	$conn->close();

	echo json_encode($json);
}