from flask import Flask, render_template, request, jsonify
from mesin import diagnosa

app = Flask(__name__, template_folder='ui', static_folder='static')

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/proses-diagnosa', methods=['POST'])
def proses_diagnosa():
    data = request.json
    gejala_user = data.get('gejala', {})
    
    if not gejala_user:
        return jsonify({'error': 'Pilih minimal 1 gejala'}), 400
    
    hasil = diagnosa(gejala_user)
    
    if not hasil:
        return jsonify({'error': 'Tidak ada hasil diagnosa'}), 400
    
    return jsonify(hasil)

if __name__ == '__main__':
    app.run(debug=True, port=5000)
