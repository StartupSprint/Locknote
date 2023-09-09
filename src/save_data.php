<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the key and value from the POST request
    $key = $_POST["key"];
    $value = $_POST["value"];

    // Perform database insertion
    $host = 'localhost'; // Your MySQL server host
    $username = 'root'; // Your MySQL username
    $password = 'admin'; // Your MySQL password
    $database = 'localnotedb'; // Your MySQL database name

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO key_value (key_name, value) VALUES ('$key', '$value')";

    if (mysqli_query($conn, $sql)) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
