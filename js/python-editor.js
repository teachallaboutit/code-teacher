document.addEventListener('DOMContentLoaded', function () {
    let editor;
    const editorElement = document.getElementById('editor');
    const runButton = document.getElementById('run-code');
    const outputElement = document.getElementById('output');

    if (editorElement && typeof CodeMirror !== 'undefined') {
        editor = CodeMirror(editorElement, {
            mode: 'python',
            lineNumbers: true,
            theme: 'default',
            value: editorElement.dataset.tutorialCode || "print('Hello, World!')"
        });
    } else if (editorElement) {
        console.error('CodeMirror not found. Please make sure CodeMirror is loaded properly.');
        return;
    }

    if (runButton && editor && outputElement) {
        runButton.addEventListener('click', function () {
            const code = editor.getValue().trim();

            // Debugging log to inspect the code before sending
            console.log("Code before sending:", code);

            if (!code) {
                outputElement.innerText = 'Please enter some code to execute.';
                return;
            }

            outputElement.innerText = 'Running...';

            fetch(ajax_object.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'execute_code',
                    code: code
                }).toString()
            })
            .then(response => response.json())
            .then(data => {
                // Corrected to handle nested 'data' structure
                if (data.success && data.data && data.data.success) {
                    outputElement.innerText = data.data.output;
                } else {
                    outputElement.innerText = 'Error: ' + (data.data?.output || 'Unknown error.');
                }
            })
            .catch(error => {
                console.error('Error during AJAX request:', error);
                outputElement.innerText = 'Error executing code.';
            });
        });
    } else {
        console.error('Run button or output element not found in the DOM');
    }
});
