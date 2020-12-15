from flask import Flask, jsonify, request, abort
import sys, os

sys.path.insert(1, '/usr/src/app/src/Domain')
from FuzzyService import FuzzyService

app = Flask(__name__)

service = FuzzyService()

@app.route('/api/calculate', methods=['POST'])
def index():
    data = request.json

    if not data or not 'difficulty' in data or not 'time' in data:
        abort(400)

    try:
        result = service.calculate(data['difficulty'], data['time'])

        return jsonify({'result' : result}), 200
    except ValueError:
        return '', 409
    except:
        return '', 500


if __name__ == '__main__':
    app.run(
        debug=os.environ.get('DEBUG') == '1',
        host='0.0.0.0',
        port=os.environ.get('PORT')
    )