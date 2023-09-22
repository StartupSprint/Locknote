let encryptionKey = '';
let notesSectionVisible = false;

function toggleNotesSection() {
    const notesSection = document.getElementById('notesSection');
    notesSection.style.display = notesSectionVisible ? 'block' : 'none';
}

document.getElementById('enterButton').addEventListener('click', function () {
    encryptionKey = document.getElementById('encryptionKey').value.trim();

    if (encryptionKey === '') {
        alert('Please enter a valid encryption key.');
    } else {
        checkEncryptionKey(encryptionKey);
    }
});

document.getElementById('saveButton').addEventListener('click', function () {
    const noteText = document.getElementById('noteText').value.trim();

    if (noteText === '') {
        alert('Please enter a note to save.');
    } else {
        saveNoteText(encryptionKey, noteText);
    }
});

document.getElementById('clearButton').addEventListener('click', function () {
    document.getElementById('noteText').value = '';
    document.getElementById('message').textContent = '';
});

toggleNotesSection();

function checkEncryptionKey(key) {
    fetch("php/check_key.php", {
        method: "POST",
        body: JSON.stringify({ encryptionKey: key }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.exists) {
                notesSectionVisible = true;
                toggleNotesSection();
                retrieveNoteText(key);
            } else {
                createNewKeyRow(key);
            }
        })
        .catch((error) => {
            console.error(error);
            alert('Error checking encryption key.');
        });
}

function createNewKeyRow(key) {
    fetch("php/create_key.php", {
        method: "POST",
        body: JSON.stringify({ encryptionKey: key }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                notesSectionVisible = true;
                toggleNotesSection();
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

function saveNoteText(key, noteText) {
    fetch("php/save_note.php", {
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
            const noteTextArea = document.getElementById('noteText');
            noteTextArea.value = data.note || '';
        })
        .catch((error) => {
            console.error(error);
            alert('Error retrieving note.');
        });
}

document.getElementById('refreshButton').addEventListener('click', function () {
    retrieveNoteText(encryptionKey);
});
