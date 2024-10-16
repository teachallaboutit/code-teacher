<?php
$tutorials = array(
    array(
        'title' => 'Welcome To Programming!',
        'challenge' => 'Show the words "Hello, World!" on the screen.',
        'skeleton_code' => "print('')",
        'example_answer' => "print('Hello, World!')",
        'hint' => 'The print function is used to display text. Text is surrounded by "double quotes".'
    ),
    array(
        'title' => 'Words, Variables, and Strings',
        'challenge' => 'Create a variable that stores your name.\nOutput this to the screen with a friendly welcome message.\nEg. "Hello Holly!"',
        'skeleton_code' => 'name=""',
        'example_answer' => "name = \"Holly\"\nprint(\"Hello\", name, \"!\")",
        'hint' => 'Joining strings (text) together in a print statement uses either a comma or + between each string.'
    ),
    array(
        'title' => 'Variables with Numbers',
        'challenge' => 'Create a variable called number that stores the number 10.\nOutput the original number to the screen, then output the same number reduced by 5.',
        'skeleton_code' => "print(number)\n\nprint(number)",
        'example_answer' => "number = 10\nprint(number)\nprint(number - 5)",
        'hint' => "When you store a variable in python that's a number, you can add the calculation to the variable.\nMake the computer so the hard work for you!" 
    )
);
?>
