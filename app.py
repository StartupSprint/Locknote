from flask import Flask, request, jsonify

app = Flask(__name__)

# A simple in-memory storage for notes (replace with your database integration)
notes = {}

@app.route('/api/save', methods=['POST'])
def save_note():
    data = request.get_json()
    note_id = data.get('id')
    note_content = data.get('content')

    # Save the note (you should encrypt it here before saving)
    notes[note_id] = note_content

    return jsonify({'message': 'Note saved successfully'})

@app.route('/api/retrieve/<note_id>', methods=['GET'])
def retrieve_note(note_id):
    # Retrieve the note (you should decrypt it here after retrieving)
    note_content = notes.get(note_id)

    if note_content is not None:
        return jsonify({'content': note_content})
    else:
        return jsonify({'error': 'Note not found'}), 404

if __name__ == '__main__':
    app.run(debug=True)
