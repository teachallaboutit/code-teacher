(function (fn) {
    if (document.readyState !== 'loading') {
        // The DOM is already ready, just call the function directly
        console.log('DOM in use calling function');
        fn();
    } else {
        // Wait for the DOM to be fully loaded
        console.log('DOM not in use - adding EventListener');
        document.addEventListener('DOMContentLoaded', fn);
    }
})(function () {

    let editor;
    const editorElement = document.getElementById('editor');

    const runButton = document.getElementById('run-code');
    const saveButton = document.getElementById('save-code');
    const helpButton = document.getElementById('help-button');
    const hintButton = document.getElementById('hint-button');
    const resetButton = document.getElementById('reset-code');
    const helperCharacter = document.getElementById('helper-character');
    const speechBubble = document.getElementById('speech-bubble');
    const hintSection = document.getElementById('hint-section');
    const outputElement = document.getElementById('output');
    const challengeText = document.querySelector('.challenge-text').innerText.replace('Challenge: ', '');
    const unitTest = document.getElementById('unit-test');
    let tutorialId = null;


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

    
    // Ensure editorElement exists and tutorialId is valid
    if (editorElement) {
        tutorialId = editorElement.dataset.tutorialId; // Correct dataset to represent tutorial ID
        console.log('Tutorial ID:', tutorialId);

        if (!tutorialId) {
            console.error('Tutorial ID is missing or invalid.');
            return;
        }

        const skeletonCode = editorElement.dataset.tutorialCode.replace(/\\n/g, '\n');

        // Initialize CodeMirror editor
        if (typeof CodeMirror !== 'undefined') {
            editor = CodeMirror(editorElement, {
                mode: 'python',
                lineNumbers: true,
                theme: 'default',
                value: skeletonCode
            });

            console.log('Sending AJAX request with tutorial_id:', tutorialId);
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
                if (data.success) {
                    if (typeof data.data.code === 'string' && data.data.code !== "") {
                        editor.setValue(data.data.code.replace(/\\n/g, '\n'));
                    } else {
                        console.log('Saved code is not valid or empty, setting to skeleton.');
                        editor.setValue(skeletonCode);
                    }
                    console.log('Is Complete Field Found:', data.data.is_complete);
                    console.log('Json: ', data);
                    if (data.data.is_complete) {
                        document.getElementById('challenge-completed').style.display = 'block';
                    } else {
                        document.getElementById('challenge-completed').style.display = 'none';
                    }
                } else {
                    console.error('Failed to load code:', data);
                }
            })
            .catch(error => {
                console.error('Error during code load:', error);
            });
        } else {
            console.error('CodeMirror not found. Please make sure CodeMirror is loaded properly.');
            return;
        }
    } else {
        console.error('Editor element not found.');
    }


    if (runButton && editor && outputElement) {
        runButton.addEventListener('click', function () {
            const code = editor.getValue().trim();

            if (!code) {
                outputElement.innerText = 'Please enter some code to execute.';
                return;
            }

            outputElement.innerText = 'Running...';

            if (unitTest.innerText == "AI"){

            // Call the ChatGPT Evaluation API
            fetch(ajax_object.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'evaluate_code',
                    tutorial_id: tutorialId,
                    code: code
                }).toString()
            })
            .then(response => response.json())
            .then(data => {
                console.log('Challenge evaluation considers code as:', data.data.is_complete);
                console.log('Json on run: ', data)
                if (data.success && data.data.is_complete) {
                    // If the challenge is complete, save it with completion status
                    console.log('Challenge is Complete Setting:', tutorialId, 'as true');
                    saveCodeSilently(code, tutorialId, true); // Save code and mark as completed

                    // Show the completed image under the editor
                    document.getElementById('challenge-completed').style.display = 'block';
                    
                } else {
                    // Proceed with code execution & save the code with completed as false
                    saveCodeSilently(code, tutorialId, false);
                    executeCode(code, outputElement,true,tutorialId);
                }
            })
            .catch(error => {
                console.error('Error during ChatGPT evaluation request:', error);
                executeCode(code, outputElement,true,tutorialId); // Fallback to execute code if the evaluation fails
            });
        } else{
            console.log('Evaluating against unit test');
            executeCode(code, outputElement, false,tutorialId); // Execute the code first
            
            

        }
        }, { passive: true });
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
        }, { passive: true });
    }

    if (resetButton && editor) {
        resetButton.addEventListener('click', function () {
            if (confirm('Are you sure you want to reset your progress? This action cannot be undone.')) {
                // Reset user progress using AJAX
                fetch(ajax_object.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    },
                    body: new URLSearchParams({
                        action: 'reset_user_code',
                        tutorial_id: tutorialId
                    }).toString()
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        editor.setValue(skeletonCode);
                        document.getElementById('challenge-completed').style.display = 'none';
                        alert('Your progress has been reset.');
                    } else {
                        console.error('Failed to reset progress:', data.data);
                        alert('Failed to reset progress. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error during reset progress request:', error);
                    alert('Error resetting progress. Please try again.');
                });
            }
        }, { passive: true });
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
                            speechBubble.innerText = "Whoops! It looks like I can't think of any help right now. Please save your code before reloading. If you keep seeing this, please report an error.";
                        }
                    })
                    .catch(error => {
                        console.error('Error during ChatGPT AJAX request:', error);
                        speechBubble.innerText = "Whoops! There's been an error connecting to the help service. Please resport this error if you keep seeing it.";
                    });
                }
                helperCharacter.style.display = 'block';
                helpButton.innerText = 'Hide Help';
            }
        }, { passive: true });
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
        }, { passive: true });
    }
});

function saveCodeSilently(code,tutorialId,is_complete) {
    if (!code) {
        console.error('No code to save.');
        return;
    }

    // Save user progress using AJAX without showing the "Saving..." message
    console.log('Challenge is Complete Setting:'+ tutorialId + " as " + is_complete);

    fetch(ajax_object.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: new URLSearchParams({
            action: 'save_user_code',
            tutorial_id: tutorialId,
            code: code,
            is_complete: is_complete ? 1 : 0

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


function executeCode(code, outputElement, isTested, tutorialId) {
    outputElement.innerText = 'Running...';

    // Replace all literal `\n` strings with actual newline characters to preserve formatting
    const formattedCode = normalizeCodeForExecution(code);

    console.log("Formatted Code Before Sending:", formattedCode);
    
    fetch(ajax_object.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: new URLSearchParams({
            action: 'execute_code',
            code: formattedCode
        }).toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // If code execution is successful, display the output
            outputElement.innerText = data.data.output;

            // Now that we have the output, perform the unit test comparison
            if (!isTested) {
                const unitTest = document.getElementById('unit-test');
                const challengeCompletedElement = document.getElementById('challenge-completed');

                if (unitTest && normalizeString(unitTest.innerText) === normalizeString(outputElement.innerText)) {
                    console.log('Challenge is Complete Setting:', tutorialId, 'as true');
                    saveCodeSilently(code, tutorialId, true); // Save code and mark as completed
                    // Show the completed image under the editor
                    if (challengeCompletedElement) {
                        console.log('Showing completed image...');
                        // Force a repaint to ensure visibility
                        challengeCompletedElement.style.display = 'none'; 
                        setTimeout(() => {
                            challengeCompletedElement.style.display = 'block';
                            const completedImage = challengeCompletedElement.querySelector('img');
                            if (completedImage) {
                                completedImage.style.display = 'block';
                            }
                        }, 10);
                    }
                    
                } else {
                    console.log('Challenge is Incomplete Setting:', tutorialId, 'as false');
                    console.log('Unit test is:', normalizeString(unitTest.innerText), 'output is:', normalizeString(outputElement.innerText));
                    saveCodeSilently(code, tutorialId, false); // Save code and mark as not completed
                    // Hide the completed image if the challenge is not complete
                    if (challengeCompletedElement) {
                        console.log('Hiding completed image...');
                        challengeCompletedElement.style.display = 'none';
                    }
                }
            }
        } else {
            // If code execution failed, display the error message
            outputElement.innerText = `Error: ${data.data}`;
        }
    })
    .catch(error => {
        console.error('Error during AJAX request:', error);
        outputElement.innerText = 'Error executing code. Please try again.';
    });
}


function normalizeString(str) {
    return str
        .replace(/\\n/g, '\n')  // Replace literal \n with actual newline character
        .replace(/\r?\n|\r/g, '\n')  // Standardize all line breaks to \n
        .trim();  // Remove any leading or trailing whitespace
}

function normalizeCodeForExecution(code) {
    return code
        .replace(/\t/g, '    ')  // Replace tabs with four spaces
        .replace(/\r?\n|\r/g, '\n')  // Normalize all line endings to '\n'
        .replace(/[^\S\r\n]+/g, ' ')  // Replace non-visible spaces with a single space
        .trim();  // Remove any leading or trailing whitespace
}


