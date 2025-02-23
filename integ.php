<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "profile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["firstname"]) && !empty($data["lastname"]) && !empty($data["age"]) && !empty($data["address"]) && !empty($data["sex"])) {
    $firstname = $conn->real_escape_string($data["firstname"]);
    $lastname = $conn->real_escape_string($data["lastname"]);
    $age = $conn->real_escape_string($data["age"]);
    $sex = $conn->real_escape_string($data["sex"]);
    $address = $conn->real_escape_string($data["address"]);

    $sql = "INSERT INTO profile (firstname, lastname, age, sex, address) VALUES ('$firstname', '$lastname', '$age', '$sex', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "sensor data added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
}

$conn->close();

?>
