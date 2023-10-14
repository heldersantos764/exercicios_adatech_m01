<?php

header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');

$conection = new PDO("mysql:host=localhost;dbname=db_adatech;charset=utf8", "root", "");
$conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$method = $_SERVER['REQUEST_METHOD'];

//verify request method
if ($method === 'POST') {

    $sql = "INSERT INTO person (name, age, email, gender) VALUES (:name, :age, :email, :gender)";

    $statement = $conection->prepare($sql);

    $statement->execute([
        ':name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS),
        ':age' => filter_input(INPUT_POST, 'age', FILTER_SANITIZE_SPECIAL_CHARS),
        ':email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
        ':gender' => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS),
    ]);

    $lastId = $conection->lastInsertId();

    if ($lastId) {
        $response = [
            'status' => '200',
            'message' => 'Usuário cadastrado com sucesso.'
        ];

        echo json_encode($response);
    } else {
        $response = [
            'status' => '500',
            'message' => 'Erro ao cadastrar usuário.'
        ];

        echo json_encode($response);
    }

} else {
    $sql = $conection->query('SELECT * FROM person');

    $response = [
        'status' => '500',
        'message' => 'Erro ao cadastrar usuário.',
        'data' => $sql->fetchAll()
    ];

    echo json_encode($response);
}
