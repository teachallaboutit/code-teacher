<?php
$tutorials = array(
    array(
        'title' => 'Your Online Code Helper!',
        'challenge' => '<img src="https://taabi-tutor-notes.b-cdn.net/Images/Alex_Chat_Bot_2.png" width="200" align="right"/><p>Welcome to the TeachAllAboutIt Python Code Teacher! This is a short tutorial to show you how to use the different features when you see a programming challenge.</p><p>Each code screen is set up with a programming challenge for you to try. Let\'s try this and test out each feature as we go!</p><br/><ul><li>Start by creating a basic Python program that outputs the words "I\'m learning Python" to the screen.</li><li>Press the "Run" button to see your code running</li><li>Check the Code Output screen to see your code run</li><li>If you\'re not sure where to start with a challenge, click the Hint button. I\'ll pop up with some help!</li><li>If you get stuck, or need some help with the code you\'ve written, click the "Help" button (<i>you can use this as many times as you need to get new help</i>)</li><li>If you want to take a break or you\'ve finished your code, click the "Save Progress" button</li><li>Try this now & refresh this page to check that your work is still there :)</li>',
        'skeleton_code' => 'print("")',
        'example_answer' => 'print("Hello, World!")',
        'hint' => '<p>The print function is used to display text.</p><p>Text is surrounded by "double quotes".</p>',
        'unit_test' => "I'm learning Python"
    ),
    array(
        'title' => 'Words, Variables, and Strings',
        'challenge' => '<p>Create a variable that stores your name.</p><p>Output this to the screen with a friendly welcome message.</p><p>Eg. "Hello Holly!" or something similar.</p>',
        'skeleton_code' => 'name=""',
        'example_answer' => "name = \"Holly\"\nprint(\"Hello\", name, \"!\")",
        'hint' => '<p>Joining strings (text) together in a print statement uses either a comma or + between each string.</p>',
        'unit_test' => "AI"
    ),
    array(
        'title' => 'Variables with Numbers',
        'challenge' => '<p>Create a variable called number that stores the number 10.</p><p>Output the original number to the screen, then output the same number reduced by 5.</p>',
        'skeleton_code' => 'print(number)\n\nprint(number)',
        'example_answer' => 'number = 10\nprint(number)\nprint(number - 5)',
        'hint' => '<p>When you store a variable in python that\'s a number, you can add the calculation to the variable.</p>Make the computer so the hard work for you!</p>',
        'unit_test' => "10\n5\n" 
    ),
    array(
        'title' => 'Using a For Loop',
        'challenge' => '<p>Create a loop that prints the numbers from 1 to 5, each on a new line.</p><p>Use a <code>for</code> loop to iterate through these numbers and print them out to the screen.</p>',
        'skeleton_code' => 'for i in range():\n    print()',
        'example_answer' => 'for i in range(1, 6):\n    print(i)',
        'hint' => '<p>In Python, you can use the <code>range()</code> function to create a sequence of numbers. For example, <code>range(1, 6)</code> will generate numbers from 1 to 5.</p>Remember that <code>range()</code> starts at the first number and stops just before the second number you provide.</p>',
        'unit_test' => "1\n2\n3\n4\n5\n"
    )
);
?>
