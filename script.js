// Initialize variables to store user input and notes section visibility.
let encryptionKey = '';
let notesSectionVisible = false;

// Function to show/hide the notes section.
function toggleNotesSection() {
    const notesSection = document.getElementById('notesSection');
    notesSection.style.display = notesSectionVisible ? 'block' : 'none';
}

document.getElementById('enterButton').addEventListener('click', function () {
    // Get the encryption key from the input field
    encryptionKey = document.getElementById('encryptionKey').value.trim();

    if (encryptionKey === '') {
        alert('Please enter a valid encryption key.');
    } else {
        // Send the encryption key to the backend for checking
        checkEncryptionKey(encryptionKey);
    }
});

document.getElementById('saveButton').addEventListener('click', function () {
    // Get the note text from the textarea
    const noteText = document.getElementById('noteText').value.trim();

    if (noteText === '') {
        alert('Please enter a note to save.');
    } else {
        // Send the note text to the backend for saving
        saveNoteText(encryptionKey, noteText);
    }
});

document.getElementById('clearButton').addEventListener('click', function () {
    // Clear the input fields and display a message
    document.getElementById('noteText').value = '';
    document.getElementById('message').textContent = '';
});

// Initial visibility setup (notes section hidden).
toggleNotesSection();

// Function to check the encryption key with the backend
function checkEncryptionKey(key) {
    fetch("php/check_key.php", { // Updated path
        method: "POST",
        body: JSON.stringify({ encryptionKey: key }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.exists) {
                // Key exists, show notes section
                notesSectionVisible = true;
                toggleNotesSection();
                // Retrieve and display the note in the textarea
                retrieveNoteText(key);
            } else {
                // Key doesn't exist, create a new row in the database
                createNewKeyRow(key);
            }
        })
        .catch((error) => {
            console.error(error);
            alert('Error checking encryption key.');
        });
}

// Function to create a new row in the database for the encryption key
function createNewKeyRow(key) {
    fetch("php/create_key.php", { // Updated path
        method: "POST",
        body: JSON.stringify({ encryptionKey: key }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // New row created, show notes section
                notesSectionVisible = true;
                toggleNotesSection();
                // Ask the user to add their note
                alert('Please add your note.');
            } else {
                alert('Error creating a new row for the encryption key.');
            }
        })
        .catch((error) => {
            console.error(error);
            alert('Error creating a new row for the encryption key.');
        });
}

// Function to save the note text in the backend
function saveNoteText(key, noteText) {
    fetch("php/save_note.php", { // Updated path
        method: "POST",
        body: JSON.stringify({ encryptionKey: key, noteText: noteText }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById('message').textContent = data.message;
        })
        .catch((error) => {
            console.error(error);
            alert('Error saving note.');
        });
}

// Function to retrieve the note text from the backend and display it in the textarea
function retrieveNoteText(key) {
    fetch("php/retrieve_note.php", {
        method: "POST",
        body: JSON.stringify({ encryptionKey: key }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log("Received data from backend:", data); // Add this line for debugging

            const noteTextArea = document.getElementById('noteText'); // Get the textarea element
            noteTextArea.value = data.note || ''; // Set the note in the textarea
        })
        .catch((error) => {
            console.error(error);
            alert('Error retrieving note.');
        });
}



document.getElementById('refreshButton').addEventListener('click', function () {
    // Send a request to the backend to retrieve the note for the encryption key
    retrieveNoteText(encryptionKey);
});