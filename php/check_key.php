    <?php
    $serverName = " sqldatabaselocknote.database.windows.net";
    $databaseName = "locknotedb";
    $username = "devkiraa";
    $password = "Kiraa@M1670529";

    try {
        $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get the encryption key from the POST request
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->encryptionKey)) {
            $encryptionKey = $data->encryptionKey;

            // Prepare and execute a query to check if the key exists in the database
            $sql = "SELECT * FROM keylist WHERE [key] = :encryptionKey";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':encryptionKey', $encryptionKey, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $response = array('exists' => true);
                echo json_encode($response);
            } else {
                $response = array('exists' => false);
                echo json_encode($response);
            }
        } else {
            $response = array('exists' => false);
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        die("Error connecting to SQL Server: " . $e->getMessage());
    }
    ?>
