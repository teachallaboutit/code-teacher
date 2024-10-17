document.addEventListener('DOMContentLoaded', function () {
    let editor;
    const editorElement = document.getElementById('editor');
    const runButton = document.getElementById('run-code');
    const saveButton = document.getElementById('save-code');
    const helpButton = document.getElementById('help-button');
    const hintButton = document.getElementById('hint-button');
    const helperCharacter = document.getElementById('helper-character');
    const speechBubble = document.getElementById('speech-bubble');
    const hintSection = document.getElementById('hint-section');
    const outputElement = document.getElementById('output');
    const challengeText = document.querySelector('.challenge-text').innerText.replace('Challenge: ', '');
    const tutorialId = editorElement.dataset.tutorialId; // Correct dataset to represent tutorial ID

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
        const initialCode = editorElement.dataset.tutorialCode || "print('Hello, World!')";
        editor = CodeMirror(editorElement, {
            mode: 'python',
            lineNumbers: true,
            theme: 'default',
            value: initialCode
        });

        // Fetch saved code via an AJAX request if needed
        fetch(ajax_object.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams({
                action: 'load_python_code',
                tutorial_id: tutorialId
            }).toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.code) {
                editor.setValue(data.code);
            } else if (data.data && data.data.code) {
                // Load skeleton code if no saved code found
                editor.setValue(data.data.code);
            } else {
                console.error('Failed to load code:', data);
            }
        })
        .catch(error => {
            console.error('Error during code load:', error);
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
    
            // Save the code silently before executing
            saveCodeSilently(code,tutorialId);
    
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
                if (data.success) {
                    // If code execution is successful, display the output
                    outputElement.innerText = data.data.output;
                } else {
                    // If code execution failed, display the error message
                    outputElement.innerText = `Error: ${data.data}`;
                }
            })
            .catch(error => {
                console.error('Error during AJAX request:', error);
                outputElement.innerText = 'Error executing code. Please try again.';
            });
        });
    }
    

    // Save Code Button Logic
    if (saveButton && editor) {
        saveButton.addEventListener('click', function () {
            const code = editor.getValue().trim();

            if (!code) {
                alert('Please enter some code before you try to save.');
                return;
            }

            // Show "Saving..." message
            speechBubble.style.display = 'block';
            speechBubble.innerText = 'Saving... please wait.';
            helperCharacter.style.display = 'block';

            // Save user progress using AJAX
            fetch(ajax_object.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'save_user_code',
                    tutorial_id: tutorialId,
                    code: code
                }).toString()
            })
            .then(response => {
                // Check if response is valid JSON
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the speech bubble to show that saving was successful
                    speechBubble.innerText = "I've saved your code, so it's safe for next time!";
                } else {
                    console.error('Failed to save progress:', data.data);
                    speechBubble.innerText = 'Failed to save progress. Please try again.';
                }

                // Hide the helper character and speech bubble after 3 seconds
                setTimeout(() => {
                    speechBubble.style.display = 'none';
                    helperCharacter.style.display = 'none';
                }, 3000);
            })
            .catch(error => {
                console.error('Error during save progress request:', error);
                speechBubble.innerText = 'Error saving progress. Please try again.';

                // Hide the helper character and speech bubble after 3 seconds
                setTimeout(() => {
                    speechBubble.style.display = 'none';
                    helperCharacter.style.display = 'none';
                }, 3000);
            });
        });
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
                speechBubble.innerHTML = hintSection.innerHTML + "<p>If you need some help with the code you've written, click the <strong>Help</strong> button.</p>";
                helperCharacter.style.display = 'block';
                hintButton.innerText = 'Hide Hint';
            }
        });
    }
});

function saveCodeSilently(code,tutorialId) {
    if (!code) {
        console.error('No code to save.');
        return;
    }

    // Save user progress using AJAX without showing the "Saving..." message
    fetch(ajax_object.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: new URLSearchParams({
            action: 'save_user_code',
            tutorial_id: tutorialId,
            code: code
        }).toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            console.error('Failed to save progress:', data.data);
        }
    })
    .catch(error => {
        console.error('Error during silent save request:', error);
    });
}



