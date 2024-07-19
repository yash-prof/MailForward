from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/', methods=['POST'])
def home():
    print("Home hit")
    # Process the email data as needed
    return jsonify({'status': 'success', "Message": "It Hittttt99t"}), 200

@app.route('/receive-email', methods=['POST'])
def receive_email():
    data = request.form.to_dict()
    
    # Extract attachments if any
    attachments = []
    for i in range(1, int(data.get('attachment-count', 0)) + 1):
        attachment = {
            'filename': data.get(f'attachment-{i}-filename'),
            'content-type': data.get(f'attachment-{i}-content-type'),
            'size': data.get(f'attachment-{i}-size'),
            'url': data.get(f'attachment-{i}-url')
        }
        attachments.append(attachment)
    
    email_data = {
        'from': data.get('sender'),
        'to': data.get('recipient'),
        'subject': data.get('subject'),
        'body': data.get('stripped-text', ''),
        'attachments': attachments
    }
    
    print(email_data)  # Process the email data as needed
    print("Email Recived")
    return jsonify({'status': 'success'}), 200

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
