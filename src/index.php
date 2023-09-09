<!DOCTYPE html>
<html>
<head>
    <title>Key-Value Storage</title>
</head>
<body>
    <h1>Key-Value Storage</h1>
    <label for="keyInput">Enter Key:</label>
    <input type="text" id="keyInput">
    <label for="valueInput">Enter Value:</label>
    <input type="text" id="valueInput">
    <button onclick="saveKeyValue()">Save</button>

    <h2>Stored Data:</h2>
    <table id="dataTable" border="1">
        <tr>
            <th>Key</th>
            <th>Value</th>
        </tr>
        <?php
        // PHP code to retrieve and display data from the database
        $host = 'localhost'; // Your MySQL server host
        $username = 'root'; // Your MySQL username
        $password = 'admin'; // Your MySQL password
        $database = 'localnotedb'; // Your MySQL database name

        $conn = mysqli_connect($host, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM key_value";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row["key_name"] . "</td><td>" . $row["value"] . "</td></tr>";
            }
        }

        mysqli_close($conn);
        ?>
    </table>

    <script>
        function saveKeyValue() {
            var key = document.getElementById("keyInput").value;
            var value = document.getElementById("valueInput").value;

            // Check if the key already exists in the table
            var table = document.getElementById("dataTable");
            for (var i = 1; i < table.rows.length; i++) {
                var existingKey = table.rows[i].cells[0].innerText;
                if (existingKey === key) {
                    // Key already exists, show related note
                    alert("Key already exists. Related Note: " + table.rows[i].cells[1].innerText);
                    return;
                }
            }

            // Add a new row to the table
            var newRow = table.insertRow(-1);
            var keyCell = newRow.insertCell(0);
            var valueCell = newRow.insertCell(1);
            keyCell.innerText = key;
            valueCell.innerText = value;

            // You can send the key-value pair to your PHP script here for database insertion
            // Use AJAX or a form submission to send data to PHP
            // Example AJAX call: $.post("your_php_script.php", { key: key, value: value });

            // Clear input fields
            document.getElementById("keyInput").value = "";
            document.getElementById("valueInput").value = "";
        }
    </script>
</body>
</html>
