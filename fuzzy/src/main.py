from flask import Flask, jsonify, request, abort
import sys

sys.path.insert(1, '/usr/src/app/src/Domain')
from FuzzyService import FuzzyService

app = Flask(__name__)

service = FuzzyService()

@app.route('/api/calculate', methods=['POST'])
def index():
    if not request.json or not 'difficulty' in request.json or not 'time' in request.json:
        abort(400)

    data = request.json

    print(request.json)

    result = service.calculate(data['difficulty'], data['time'])

    return jsonify({'result' : result}), 200

if __name__ == '__main__':
    app.run(debug=True)