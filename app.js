// Function to check the database connection status
function checkDatabaseConnection() {
    fetch('check_connection.php')
    .then(response => response.text())
    .then(data => {
        const connectionStatus = document.getElementById('connection-status');
        if (data === 'success') {
            connectionStatus.textContent = 'Database Connection: Connected';
        } else {
            connectionStatus.textContent = 'Database Connection: Disconnected';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Check the database connection status when the page loads
checkDatabaseConnection();

document.getElementById('save-button').addEventListener('click', function () {
    const code = document.getElementById('code').value;
    const note = document.getElementById('note').value;

    // Send the data to the PHP script for saving
    const formData = new FormData();
    formData.append('code', code);
    formData.append('note', note);

    fetch('save_note.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            alert('Note saved successfully!');
        } else {
            alert('Error saving note.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Implement code to retrieve and display the note when the code is entered.
