from flask import Flask, request, jsonify
from flask_cors import CORS
from io import StringIO
import sys
import re

app = Flask(__name__)
CORS(app)

code_context = {}
input_pattern = re.compile(r'\binput\s*\(.*\)')

@app.route('/api/execute', methods=['POST'])
def execute_code():
    data = request.get_json()
    code = data.get('code', '')
    user_input = data.get('input', None)
    session_id = data.get('session_id', 'default')

    if session_id not in code_context:
        code_context[session_id] = {
            'lines': code.splitlines(),
            'current_line': 0,
            'globals': {'__builtins__': __builtins__}
        }

    context = code_context[session_id]
    output_stream = StringIO()
    input_stream = StringIO(user_input if user_input else "")

    try:
        sys.stdout = output_stream
        sys.stdin = input_stream

        while context['current_line'] < len(context['lines']):
            line = context['lines'][context['current_line']]
            context['current_line'] += 1

            if input_pattern.search(line):
                code_context[session_id] = context
                return jsonify({
                    'output': output_stream.getvalue(),
                    'needs_input': True,
                    'success': True
                })

            exec(line, context['globals'])

    except EOFError:
        code_context[session_id] = context
        return jsonify({
            'output': output_stream.getvalue(),
            'needs_input': True,
            'success': True
        })

    except Exception as e:
        sys.stdout = sys.__stdout__
        sys.stdin = sys.__stdin__
        return jsonify({
            'output': f'Error: {str(e)}',
            'needs_input': False,
            'success': False
        })

    finally:
        sys.stdout = sys.__stdout__
        sys.stdin = sys.__stdin__

    return jsonify({
        'output': output_stream.getvalue(),
        'needs_input': False,
        'success': True
    })

if __name__ == '__main__':
    app.run()
