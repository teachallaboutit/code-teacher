document.addEventListener('DOMContentLoaded', function () {
    let editor;
    const editorElement = document.getElementById('editor');
    const runButton = document.getElementById('run-code');
    const helpButton = document.getElementById('help-button');
    const hintButton = document.getElementById('hint-button');
    const helperCharacter = document.getElementById('helper-character');
    const speechBubble = document.getElementById('speech-bubble');
    const hintSection = document.getElementById('hint-section');
    const outputElement = document.getElementById('output');
    const challengeText = document.querySelector('.challenge-text').innerText.replace('Challenge: ', '');

    // List of waiting messages
    const waitingMessages = [
        'Thinking of ways to help, please wait...',
        'Checking my big book of programming languages...',
        'Consulting the big python...',
        'Compiling a great response, please be patient...',
        'Searching through my knowledge banks...',
        'Cracking the code, hang tight...',
        'Running a debug on my thoughts...',
        'Loading knowledge modules...',
        'Trying to avoid an infinite loop of thinking...',
        'De-referencing the correct answer...',
        'Parsing your code... almost there...',
        'Just one more iteration...',
        'Looking up the syntax in my brain library...',
        'Braving the recursion depths for an answer...',
        'Breaking out of my thought loop...',
        'Initializing helpful advice...',
        'Running garbage collection to make room for ideas...',
        'Optimizing solution... please hold...',
        'Opening a pull request on my mind...',
        'Testing the hypothesis... standby...'
    ];

    // Initialize CodeMirror editor
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

    // Help Button Logic
    if (helpButton && editor && speechBubble && helperCharacter) {
        helpButton.addEventListener('click', function () {
            const studentCode = editor.getValue().trim();
            const exampleAnswer = editorElement.dataset.tutorialCode;

            // Hide the hint text if it is currently displayed
            if (hintButton.innerText === 'Hide Hint') {
                hintButton.innerText = 'Hint';
            }

            // Toggle the visibility of the help bubble text
            const isHelpVisible = helpButton.innerText === 'Hide Help';
            if (isHelpVisible) {
                speechBubble.style.display = 'none';
                helperCharacter.style.display = 'none';
                helpButton.innerText = 'Help';
            } else {
                if (!studentCode) {
                    speechBubble.style.display = 'block';
                    speechBubble.innerText = 'Please write some code before asking for help.';
                } else {
                    // Display a random waiting message
                    const randomIndex = Math.floor(Math.random() * waitingMessages.length);
                    speechBubble.style.display = 'block';
                    speechBubble.innerText = waitingMessages[randomIndex];
                    
                    fetch(ajax_object.ajax_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                        },
                        body: new URLSearchParams({
                            action: 'get_chatgpt_help',
                            challenge: challengeText,
                            student_code: studentCode,
                            example_answer: exampleAnswer
                        }).toString()
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            speechBubble.innerText = data.data;
                        } else {
                            speechBubble.innerText = 'Error: ' + (data.data || 'Unable to retrieve help at this moment.');
                        }
                    })
                    .catch(error => {
                        console.error('Error during ChatGPT AJAX request:', error);
                        speechBubble.innerText = 'Error connecting to help service.';
                    });
                }
                helperCharacter.style.display = 'block';
                helpButton.innerText = 'Hide Help';
            }
        });
    }

    // Hint Button Logic
    if (hintButton && helperCharacter && speechBubble) {
        hintButton.addEventListener('click', function () {
            // Hide the help text if it is currently displayed
            if (helpButton.innerText === 'Hide Help') {
                helpButton.innerText = 'Help';
            }

            // Toggle the visibility of the hint bubble text
            const isHintVisible = hintButton.innerText === 'Hide Hint';
            if (isHintVisible) {
                speechBubble.style.display = 'none';
                helperCharacter.style.display = 'none';
                hintButton.innerText = 'Hint';
            } else {
                speechBubble.style.display = 'block';
                speechBubble.innerText = hintSection.innerText;
                helperCharacter.style.display = 'block';
                hintButton.innerText = 'Hide Hint';
            }
        });
    }
});
