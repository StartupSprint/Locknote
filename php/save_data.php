<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the key and value from the POST request
    $key = $_POST["key"];
    $value = $_POST["value"];

    // Azure SQL Database connection details
    $serverName = "sql211.infinityfree.com";
    $databaseName = "if0_35085005_locknote";
    $username = "if0_35085005";
    $password = "z93UAb75vWW";

    try {
        // Establish a connection to Azure SQL Database
        $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute a query to insert the key-value pair
        $sql = "INSERT INTO key_value (key_name, value) VALUES (:key, :value)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':key', $key, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->execute();

        echo "Data saved successfully.";
    } catch (PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
    }
}
?>
