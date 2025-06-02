<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $modelName = $_POST['modelName'];
    $vehicleType = $_POST['vehicleType'];
    $manufacturer = $_POST['manufacturer'];
    $fuelType = $_POST['fuelType'];
    $engineCapacity = $_POST['engineCapacity'];
    $dimensions = $_POST['dimensions'];
    $weight = $_POST['weight'];
    $compatibleParts = $_POST['compatibleParts'];
    $notes = $_POST['notes'];

    // Handle file upload
    $targetDir = "uploads/";
    $modelImage = $targetDir . basename($_FILES["modelImage"]["name"]);
    move_uploaded_file($_FILES["modelImage"]["tmp_name"], $modelImage);

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "vehicle_app");
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into table
    $stmt = $conn->prepare("INSERT INTO vehicle_models (model_name, vehicle_type, manufacturer, fuel_type, engine_capacity, dimensions, weight, compatible_parts, notes, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("sssssssdss", $modelName, $vehicleType, $manufacturer, $fuelType, $engineCapacity, $dimensions, $weight, $compatibleParts, $notes, $modelImage);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: model_submitted.html");
}
?>