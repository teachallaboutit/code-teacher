document.addEventListener('DOMContentLoaded', function () {
    let editor;
    const editorElement = document.getElementById('editor');
    const runButton = document.getElementById('run-code');
    const helpButton = document.getElementById('help-button');
    const hintButton = document.getElementById('hint-button');
    const helperCharacter = document.getElementById('helper-character');
    const speechBubble = document.getElementById('speech-bubble');
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
                    action: 'execute_code', // Ensure that this action matches the one defined in your PHP
                    code: code
                }).toString()
            })
            .then(response => response.json())
            .then(data => {
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

    if (helpButton && helperCharacter && speechBubble) {
        helpButton.addEventListener('click', function () {
            const isVisible = helperCharacter.style.display === 'block';
            helperCharacter.style.display = isVisible ? 'none' : 'block';
            speechBubble.style.display = isVisible ? 'none' : 'block';
            speechBubble.innerText = "Hi, it looks like you need help with your code...";
            helpButton.innerText = isVisible ? 'Help' : 'Hide Help';
        });
    } else {
        console.error('Help button, helper character, or speech bubble not found in the DOM');
    }

    if (hintButton && helperCharacter && speechBubble) {
        hintButton.addEventListener('click', function () {
            const isVisible = helperCharacter.style.display === 'block';
            helperCharacter.style.display = isVisible ? 'none' : 'block';
            speechBubble.style.display = isVisible ? 'none' : 'block';
            speechBubble.innerText = document.getElementById('hint-section').innerText;
            hintButton.innerText = isVisible ? 'Hint' : 'Hide Hint';
        });
    } else {
        console.error('Hint button, helper character, or speech bubble not found in the DOM');
    }
});
