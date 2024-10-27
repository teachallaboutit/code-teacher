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
        'title' => 'Using If Statements',
        'challenge' => '<p>Create a variable called <code>number</code> that stores any integer value.</p><p>Write an <code>if</code> statement that checks if <code>number</code> is greater than 5 and prints "Greater than 5" if the condition is true.</p>',
        'skeleton_code' => 'number = \nif number > 5:\n    print()',
        'example_answer' => 'number = 8\nif number > 5:\n    print("Greater than 5")',
        'hint' => '<p>Use the greater than symbol (<code>></code>) to compare the variable <code>number</code> to 5.</p>',
        'unit_test' => "Greater than 5"
    ),
    array(
        'title' => 'Using If Statements With Strings',
        'challenge' => '<p>Create a variable called <code>colour</code> that stores a string representing a colour.</p><p>Write an <code>if</code> statement that checks if the colour is "red". If it is, print "Stop!".</p>',
        'skeleton_code' => 'colour = ""\nif colour == "red":\n    print()',
        'example_answer' => 'colour = "red"\nif colour == "red":\n    print("Stop!")',
        'hint' => '<p>Use double quotes to assign a string value to <code>colour</code> and use <code>==</code> to compare it.</p>',
        'unit_test' => "Stop!"
    ),
    array(
        'title' => 'Using If-Else Statements',
        'challenge' => '<p>Create a variable called <code>score</code> that stores the integer value 41.</p><p>Write an <code>if</code> statement that checks if the <code>score</code> is at least 50.</p><p>If it is, print "You passed!". Otherwise, print "You failed!".</p>',
        'skeleton_code' => 'score = \nif score >= 50:\n    print()\nelse:\n    print()',
        'example_answer' => 'score = 40\nif score >= 50:\n    print("You passed!")\nelse:\n    print("You failed!")',
        'hint' => '<p>Use the greater than or equal to symbol (<code>>=</code>) to check if the score is at least 50.</p>',
        'unit_test' => "You failed!"
    ),
    array(
        'title' => 'Using If-Else Statements With Strings',
        'challenge' => '<p>Create a variable called <code>day</code> that stores the name of a day of the week and set this to "Monday".</p><p>Write an <code>if-else</code> statement that prints "Weekend!" if <code>day</code> is either "Saturday" or "Sunday". Otherwise, print "Weekday!".</p>',
        'skeleton_code' => 'day = ""\nif day == "Saturday" or day == "Sunday":\n    print()\nelse:\n    print()',
        'example_answer' => 'day = "Monday"\nif day == "Saturday" or day == "Sunday":\n    print("Weekend!")\nelse:\n    print("Weekday!")',
        'hint' => '<p>Use <code>or</code> to combine multiple conditions in the <code>if</code> statement.</p>',
        'unit_test' => "Weekday!"
    ),
    array(
        'title' => 'Using a For Loop',
        'challenge' => '<p>Create a loop that prints the numbers from 1 to 5, each on a new line.</p><p>Use a <code>for</code> loop to iterate through these numbers and print them out to the screen.</p>',
        'skeleton_code' => 'for i in range():\n    print()',
        'example_answer' => 'for i in range(1, 6):\n    print(i)',
        'hint' => '<p>In Python, you can use the <code>range()</code> function to create a sequence of numbers. For example, <code>range(1, 6)</code> will generate numbers from 1 to 5.</p>Remember that <code>range()</code> starts at the first number and stops just before the second number you provide.</p>',
        'unit_test' => "1\n2\n3\n4\n5\n"
    ),
    array(
        'title' => 'Introduction to While Loops',
        'challenge' => '<p>Create a <code>while</code> loop that prints the numbers from 1 to 5, each on a new line. <i>This should have the same output as the FOR loop code challenge, but uses a different code statement.</i></p><p>Use the <code>while</code> loop to keep printing until the condition is no longer met.</p>',
        'skeleton_code' => 'i = 1\nwhile:\n    print()\n    i += 1',
        'example_answer' => 'i = 1\nwhile i <= 5:\n    print(i)\n    i += 1',
        'hint' => '<p>In a <code>while</code> loop, you need to set an initial value and define a condition that keeps the loop running.</p><p>For example, start with <code>i = 1</code>, and use <code>while i <= 5</code> to keep printing until <code>i</code> becomes greater than 5. Don’t forget to increase <code>i</code> each time!</p>',
        'unit_test' => "1\n2\n3\n4\n5\n"
    ),
    array(
        'title' => 'For Loops with Other Statements',
        'challenge' => '<p>Create a <code>for</code> loop that iterates through numbers from 1 to 10.</p><p>For each number, use an <code>if</code> statement to check if the number is even. If it is even, print "<code>number</code> is even", otherwise print "<code>number</code> is odd".</p>',
        'skeleton_code' => 'for i in range(1, 11):\n    if i % 2 == 0:\n        print()\n    else:\n        print()',
        'example_answer' => 'for i in range(1, 11):\n    if i % 2 == 0:\n        print(f"{i} is even")\n    else:\n        print(f"{i} is odd")',
        'hint' => '<p>Use the modulus operator (<code>%</code>) to check if a number is divisible by 2 with no remainder.</p>',
        'unit_test' => "1 is odd\n2 is even\n3 is odd\n4 is even\n5 is odd\n6 is even\n7 is odd\n8 is even\n9 is odd\n10 is even"
    ),
    array(
        'title' => 'While Loop with Other Statements',
        'challenge' => '<p>Create a <code>while</code> loop that starts at 10 and counts down to 1.</p><p>For each number, use an <code>if</code> statement to print "<code>number</code> is high" if the number is greater than 5, otherwise print "<code>number</code> is low".</p>',
        'skeleton_code' => 'i = 10\nwhile i > 0:\n    if i > 5:\n        print()\n    else:\n        print()\n    i -= 1',
        'example_answer' => 'i = 10\nwhile i > 0:\n    if i > 5:\n        print(f"{i} is high")\n    else:\n        print(f"{i} is low")\n    i -= 1',
        'hint' => '<p>Make sure to decrease <code>i</code> by 1 each time to prevent an infinite loop.</p>',
        'unit_test' => "10 is high\n9 is high\n8 is high\n7 is high\n6 is high\n5 is low\n4 is low\n3 is low\n2 is low\n1 is low"
    ),
    array(
        'title' => 'Nested For Loops',
        'challenge' => '<p>Create a nested <code>for</code> loop to display a 3x3 grid of stars.</p><p>The outer loop should iterate 3 times, and for each iteration, the inner loop should also iterate 3 times to print a line of 3 stars.</p><p><i>Hint: Using <code>end = " "</code> will stop the print from putting a new line at the end of a print (usually, print will put a new line automatically).</i></p>',
        'skeleton_code' => 'for i in range():\n    for j in range():\n        print("*", end=" ")\n    print()',
        'example_answer' => 'for i in range(3):\n    for j in range(3):\n        print("*", end=" ")\n    print()',
        'hint' => '<p>Use <code>end=" "</code> to prevent each star from printing on a new line. Use <code>print()</code> after the inner loop to move to the next line.</p>',
        'unit_test' => "* * * \n* * * \n* * * \n"
    ),
    array(
        'title' => 'Nested While Loops',
        'challenge' => '<p>Create a nested <code>while</code> loop to display a 4x4 grid of numbers with the numbers 1,2,3,4 in each row.</p><p>The outer loop should iterate 4 times, and for each iteration, the inner loop should also iterate 4 times to print numbers from 1 to 4.</p>',
        'skeleton_code' => 'i = 0\nwhile i < 4:\n    j = 1\n    while j <= 4:\n        print(j, end=" ")\n        j += 1\n    print()\n    i += 1',
        'example_answer' => 'i = 0\nwhile i < 4:\n    j = 1\n    while j <= 4:\n        print(j, end=" ")\n        j += 1\n    print()\n    i += 1',
        'hint' => '<p>Use two variables <code>i</code> and <code>j</code> to control the outer and inner loops respectively. Remember to reset <code>j</code> each time the outer loop runs.</p>',
        'unit_test' => "1 2 3 4 \n1 2 3 4 \n1 2 3 4 \n1 2 3 4 \n"
    ),
    array(
        'title' => 'Making If Statements More Complex',
        'challenge' => '<p>Create a variable called <code>age</code> and set it to the number 30.</p><p>Write an <code>if</code> statement that checks if <code>age</code> is greater than or equal to 18 <strong>and</strong> less than 65.</p><p>If the condition is true, print "You are of working age". Otherwise, print "Not working age".</p>',
        'skeleton_code' => 'age = \nif age >= 18 and age < 65:\n    print()\nelse:\n    print()',
        'example_answer' => 'age = 25\nif age >= 18 and age < 65:\n    print("You are of working age")\nelse:\n    print("Not working age")',
        'hint' => '<p>Use the logical <code>and</code> operator to combine two conditions that both must be true.</p>',
        'unit_test' => "You are of working age"
    ),
    array(
        'title' => 'What If Either Condition is True?',
        'challenge' => '<p>Create a variable called <code>weather</code> and set it to the string "rainy".</p><p>Write an <code>if</code> statement that prints "Take an umbrella" if the <code>weather</code> is "rainy" or "cloudy". Otherwise, print "No umbrella needed".</p>',
        'skeleton_code' => 'weather = ""\nif weather == "rainy" or weather == "cloudy":\n    print()\nelse:\n    print()',
        'example_answer' => 'weather = "rainy"\nif weather == "rainy" or weather == "cloudy":\n    print("Take an umbrella")\nelse:\n    print("No umbrella needed")',
        'hint' => '<p>Use the logical <code>or</code> operator to combine two conditions where either condition can be true.</p>',
        'unit_test' => "Take an umbrella"
    ),
    array(
        'title' => 'Using The Modulus Operator (%)',
        'challenge' => '<p>Create a variable called <code>number</code> and set it to the number 9.</p><p>Write an <code>if</code> statement that checks if <code>number</code> is divisible by 3.</p><p>If it is, print "<code>number</code> is divisible by 3". Otherwise, print "<code>number</code> is not divisible by 3".</p>',
        'skeleton_code' => 'number = \nif number % 3 == 0:\n    print()\nelse:\n    print()',
        'example_answer' => 'number = 9\nif number % 3 == 0:\n    print(f"{number} is divisible by 3")\nelse:\n    print(f"{number} is not divisible by 3")',
        'hint' => '<p>Use the modulus operator (<code>%</code>) to check if the remainder is 0, which means the number is divisible.</p>',
        'unit_test' => "9 is divisible by 3"
    ),
    array(
        'title' => 'Using Floor Division in a Loop',
        'challenge' => '<p>Create a variable called <code>total</code> and set it to 50.</p><p>Use a <code>while</code> loop to repeatedly divide <code>total</code> by 2 (using floor division) until <code>total</code> is less than or equal to 1.</p><p>Print the value of <code>total</code> after each division.</p>',
        'skeleton_code' => 'total = 50\nwhile total > 1:\n    total //= 2\n    print()',
        'example_answer' => 'total = 50\nwhile total > 1:\n    total //= 2\n    print(total)',
        'hint' => '<p>Use <code>//=</code> to perform floor division and assign the result back to <code>total</code>.</p>',
        'unit_test' => "25\n12\n6\n3\n1"
    ),
    array(
        'title' => 'While Loops Where Two Conditions Are True',
        'challenge' => '<p>Create two variables called <code>x</code> and <code>y</code> and set them both to 0.</p><p>Use a <code>while</code> loop that continues as long as <code>x</code> is less than 5 <strong>and</strong> <code>y</code> is less than 3.</p><p>Inside the loop, print "x is <code>x</code>, y is <code>y</code>" and increment both <code>x</code> and <code>y</code> by 1.</p>',
        'skeleton_code' => 'x = 0\ny = 0\nwhile x < 5 and y < 3:\n    print()\n    x += 1\n    y += 1',
        'example_answer' => 'x = 0\ny = 0\nwhile x < 5 and y < 3:\n    print(f"x is {x}, y is {y}")\n    x += 1\n    y += 1',
        'hint' => '<p>Use the logical <code>and</code> operator to ensure both conditions must be true for the loop to continue.</p>',
        'unit_test' => "x is 0, y is 0\nx is 1, y is 1\nx is 2, y is 2"
    ),
    array(
        'title' => 'A Nested Loop Looking For Odd Numbers',
        'challenge' => '<p>Use a nested <code>for</code> loop to iterate through numbers from 1 to 3 for the outer loop, and 1 to 5 for the inner loop.</p><p>For each iteration of the inner loop, use an <code>if</code> statement to print "<code>i</code>, <code>j</code> are both odd" if both <code>i</code> and <code>j</code> are odd numbers.</p>',
        'skeleton_code' => 'for i in range(1, 4):\n    for j in range(1, 6):\n        if i % 2 == 1 and j % 2 == 1:\n            print()',
        'example_answer' => 'for i in range(1, 4):\n    for j in range(1, 6):\n        if i % 2 == 1 and j % 2 == 1:\n            print(f"{i}, {j} are both odd")',
        'hint' => '<p>Use the modulus operator (<code>%</code>) to check if both <code>i</code> and <code>j</code> are odd. The <code>%</code> operator returns the remainder of division.</p>',
        'unit_test' => "1, 1 are both odd\n1, 3 are both odd\n1, 5 are both odd\n3, 1 are both odd\n3, 3 are both odd\n3, 5 are both odd"
    ),
    array(
        'title' => 'Using ASCII and Plain Text in Python',
        'challenge' => '<p>Create a variable called <code>character</code> that stores the single character "A" (it is important that this is a capital!).</p><p>Use the <code>ord()</code> function to get the ASCII value of the character and print it.</p><p>Then, use the <code>chr()</code> function to convert the ASCII value back to the character and print the result.</p>',
        'skeleton_code' => 'character = ""\nascii_value = ord(character)\nprint()\noriginal_character = chr(ascii_value)\nprint()',
        'example_answer' => 'character = "A"\nascii_value = ord(character)\nprint(ascii_value)\noriginal_character = chr(ascii_value)\nprint(original_character)',
        'hint' => '<p>Use <code>ord()</code> to convert a character to its ASCII value, and <code>chr()</code> to convert an ASCII value back to a character.</p>',
        'unit_test' => "65\nA"
    ),
    array(
        'title' => 'Using ASCII to Check Letters',
        'challenge' => '<p>Create a variable called <code>letter</code> that stores any single character.</p><p>Write an <code>if</code> statement that checks if the character is a letter between <code>a-z</code> or <code>A-Z</code> using ASCII values.</p><p>If it is, print "<code>letter</code> is a letter". Otherwise, print "<code>letter</code> is not a letter".</p>',
        'skeleton_code' => 'letter = ""\nascii_value = ord()\nif (ascii_value >= ord("a") and ascii_value <= "z") or (ascii_value >= ord() and ascii_value <= "Z"):\n    print()\nelse:\n    print()',
        'example_answer' => 'letter = "G"\nascii_value = ord(letter)\nif (ascii_value >= ord("a") and ascii_value <= ord("z")) or (ascii_value >= ord("A") and ascii_value <= ord("Z")):\n    print(f"{letter} is a letter")\nelse:\n    print(f"{letter} is not a letter")',
        'hint' => '<p>Use <code>ord()</code> to compare the ASCII value of <code>letter</code> to the ranges for lowercase and uppercase letters.</p>',
        'unit_test' => "G is a letter"
    ),
    array(
        'title' => 'Calculating File Size in Bits and Bytes',
        'challenge' => '<p>Create a variable called <code>file_size_bytes</code> that stores the size of a file in bytes.</p><p>Calculate the size of the file in bits by multiplying <code>file_size_bytes</code> by 8, and print both values.</p>',
        'skeleton_code' => 'file_size_bytes = \nfile_size_bits = file_size_bytes\nprint("File size in bytes:")\nprint("File size in bits:")',
        'example_answer' => 'file_size_bytes = 512\nfile_size_bits = file_size_bytes * 8\nprint("File size in bytes:", file_size_bytes)\nprint("File size in bits:", file_size_bits)',
        'hint' => '<p>Remember that 1 byte equals 8 bits. Multiply the number of bytes by 8 to calculate the size in bits.</p>',
        'unit_test' => "File size in bytes: 512\nFile size in bits: 4096"
    ),
    array(
        'title' => 'Calculating File Size in Mebibytes and Beyond',
        'challenge' => '<p>Create a variable called <code>file_size_bytes</code> that stores the size of a file in bytes.</p><p>Calculate and print the size of the file in bytes, kibibytes, and mebibytes.</p><p>Note: 1 kibibyte = 1024 bytes, 1 mebibyte = 1024 kibibytes.</p>',
        'skeleton_code' => 'file_size_bytes = \nfile_size_kibibytes = file_size_bytes \nfile_size_mebibytes = file_size_kibibytes \nprint("File size in bytes:")\nprint("File size in kibibytes:")\nprint("File size in mebibytes:")',
        'example_answer' => 'file_size_bytes = 1048576\nfile_size_kibibytes = file_size_bytes / 1024\nfile_size_mebibytes = file_size_kibibytes / 1024\nprint("File size in bytes:", file_size_bytes)\nprint("File size in kibibytes:", file_size_kibibytes)\nprint("File size in mebibytes:", file_size_mebibytes)',
        'hint' => '<p>Use division by 1024 to convert bytes to kibibytes, and kibibytes to mebibytes.</p>',
        'unit_test' => "File size in bytes: 1048576\nFile size in kibibytes: 1024.0\nFile size in mebibytes: 1.0"
    ),
    array(
        'title' => 'Adding Numbers in a Loop',
        'challenge' => '<p>Use a <code>for</code> loop to iterate through numbers from 1 to 5.</p><p>Calculate the sum of all these numbers and print the result.</p>',
        'skeleton_code' => 'total = 0\nfor i in range(1, 6):\n    total += i\nprint()',
        'example_answer' => 'total = 0\nfor i in range(1, 6):\n    total += i\nprint(total)',
        'hint' => '<p>Use <code>+=</code> to add the current value of <code>i</code> to <code>total</code> on each loop iteration.</p>',
        'unit_test' => "15"
    ),
    array(
        'title' => 'Subtracting Numbers Using A Loop',
        'challenge' => '<p>Create a variable called <code>start</code> and set it to 20.</p><p>Use a <code>while</code> loop to subtract 3 from <code>start</code> each time until <code>start</code> is less than or equal to 2. Print <code>start</code> each time after subtracting.</p>',
        'skeleton_code' => 'start = 20\nwhile start > 2:\n    start -= 3\n    print()',
        'example_answer' => 'start = 20\nwhile start > 2:\n    start -= 3\n    print(start)',
        'hint' => '<p>Use <code>-=</code> to subtract 3 from <code>start</code> each time through the loop.</p>',
        'unit_test' => "17\n14\n11\n8\n5\n2"
    ),
    array(
        'title' => 'Multiplying Numbers',
        'challenge' => '<p>Create a variable called <code>number</code> and set it to 4.</p><p>Write an <code>if</code> statement that multiplies <code>number</code> by 5 if <code>number</code> is greater than 3. Print the result.</p>',
        'skeleton_code' => 'number = 4\nif number > 3:\n    number *= 5\nprint()',
        'example_answer' => 'number = 4\nif number > 3:\n    number *= 5\nprint(number)',
        'hint' => '<p>Use <code>*=</code> to multiply the value of <code>number</code> by 5.</p>',
        'unit_test' => "20"
    ),
    array(
        'title' => 'Dividing Values in a For Loop with Rounding',
        'challenge' => '<p>Use a <code>for</code> loop to iterate from 1 to 4 (inclusive).</p><p>Start with a variable called <code>result</code> set to 100. On each iteration, divide <code>result</code> by the current value of the loop variable, round the result to 1 decimal place, and print it.</p>',
        'skeleton_code' => 'result = 100\nfor i in range():\n    result /= i\n    result = round()\n    print()',
        'example_answer' => 'result = 100\nfor i in range(1, 5):\n    result /= i\n    result = round(result, 1)\n    print(result)',
        'hint' => '<p>Use <code>round(value, 1)</code> to round <code>result</code> to one decimal place after each division.</p>',
        'unit_test' => "100.0\n50.0\n16.7\n4.2"
    ),
    array(
        'title' => 'Reading from a 1D Array',
        'challenge' => '<p>Create an array called <code>numbers</code> with values [2, 4, 6, 8, 10].</p><p>Use a <code>for</code> loop to print each value in the array.</p>',
        'skeleton_code' => 'numbers = [2, 4, 6, 8, 10]\nfor num in numbers:\n    ',
        'example_answer' => 'numbers = [2, 4, 6, 8, 10]\nfor num in numbers:\n    print(num)',
        'hint' => '<p>Use a <code>for</code> loop to iterate through each element in the array and print it.</p>',
        'unit_test' => "2\n4\n6\n8\n10"
    ),
    array(
        'title' => 'Writing to a 1D Array',
        'challenge' => '<p>Create an empty array called <code>names</code>.</p><p>Use a loop to add three names to the array and then print the entire array.</p>',
        'skeleton_code' => 'names = []\nfor i in range(3):\n    ',
        'example_answer' => 'names = []\nfor i in range(3):\n    name = input("Enter a name: ")\n    names.append(name)\nprint(names)',
        'hint' => '<p>Use the <code>append()</code> method to add a new name to the array.</p>',
        'unit_test' => "AI"
    ),
    array(
        'title' => 'Linear Search in a 1D Array',
        'challenge' => '<p>Create an array called <code>numbers</code> with values [3, 7, 2, 9, 5].</p><p>Write a <code>linear search algorithm</code> to check if the value 9 is in the array. If it is, print "Found!". If not, print "Not Found!".</p>',
        'skeleton_code' => 'numbers = []\nfound = False\nfor num in numbers:\n    ',
        'example_answer' => 'numbers = [3, 7, 2, 9, 5]\nfound = False\nfor num in numbers:\n    if num == 9:\n        found = True\n        break\nif found:\n    print("Found!")\nelse:\n    print("Not Found!")',
        'hint' => '<p>Use a boolean variable to track whether the value was found during the iteration.</p>',
        'unit_test' => "Found!"
    ),
    array(
        'title' => 'Bubble Sort in a 1D Array',
        'challenge' => '<p>Create an array called <code>numbers</code> with values [5, 1, 4, 2, 8].</p><p>Write a <code>bubble sort algorithm</code> to sort the array in ascending order and print the sorted array.</p>',
        'skeleton_code' => 'numbers = []\nn = len(numbers)\nfor i in range(n):\n    ',
        'example_answer' => 'numbers = [5, 1, 4, 2, 8]\nn = len(numbers)\nfor i in range(n):\n    for j in range(n - i - 1):\n        if numbers[j] > numbers[j + 1]:\n            numbers[j], numbers[j + 1] = numbers[j + 1], numbers[j]\nprint(numbers)',
        'hint' => '<p>Swap the values if the current value is greater than the next value during each iteration of the inner loop.</p>',
        'unit_test' => "[1, 2, 4, 5, 8]"
    ),
    array(
        'title' => 'Reading from a 2D Array',
        'challenge' => '<p>Create a 2D array called <code>matrix</code> with values [[1, 2], [3, 4], [5, 6]].</p><p>Print each row of the matrix using a loop.</p>',
        'skeleton_code' => 'matrix = [[1, 2], [3, 4], [5, 6]]\nfor row in matrix:\n    ',
        'example_answer' => 'matrix = [[1, 2], [3, 4], [5, 6]]\nfor row in matrix:\n    print(row)',
        'hint' => '<p>Use a <code>for</code> loop to iterate through each row of the matrix and print it.</p>',
        'unit_test' => "[1, 2]\n[3, 4]\n[5, 6]"
    ),
    array(
        'title' => 'Writing to a 2D Array',
        'challenge' => '<p>Create a 2D array called <code>data</code> with the following data:.</p><ul><li><strong>Row 1: </strong> 1,6,9</li><li><strong>Row 2: </strong> 2,5,3</li></ul><p>Create an empty 2D array called <code>grid</code>.</p><p>Write a nested loop to add values from data to make a 2x3 grid and print the entire new grid.</p>',
        'skeleton_code' => 'data = []\ngrid = []\nfor i in range(2):\n    ',
        'example_answer' => 'data = [[1,6,9],[2,5,3]]\ngrid = []\nfor i in range(0,2):\n    row = []\n    for j in range(0,3):\n        value = data[i][j]\n        row.append(value)\n    grid.append(row)\nprint(grid)',
        'hint' => '<p>Use a nested loop to create each row and then add that row to the 2D array.</p>',
        'unit_test' => "[[1,6,9],[2,5,3]]"
    ),
    array(
        'title' => 'Summing Elements in a 2D Array',
        'challenge' => '<p>Create a 2D array called <code>matrix</code> with values [[1, 2], [3, 4], [5, 6]].</p><p>Write code to calculate and print the sum of all the elements in the 2D array.</p>',
        'skeleton_code' => 'matrix = []\ntotal_sum = 0\ntotal_sum =\nprint()',
        'example_answer' => 'matrix = [[1, 2], [3, 4], [5, 6]]\ntotal_sum = 0\nfor row in matrix:\n    for num in row:\n        total_sum += num\nprint(total_sum)',
        'hint' => '<p>Use a nested loop to iterate through each element in the matrix and add it to the total sum.</p>',
        'unit_test' => '21'
    ),
    array(
        'title' => 'Finding the Maximum in a 2D Array',
        'challenge' => '<p>Create a 2D array called <code>matrix</code> with values [[7, 3], [2, 9], [4, 6]].</p><p>Write code to find and print the largest number in the 2D array.</p>',
        'skeleton_code' => 'matrix = [[7, 3], [2, 9], [4, 6]]\nmax_value = \n\nprint()',
        'example_answer' => 'matrix = [[7, 3], [2, 9], [4, 6]]\nmax_value = matrix[0][0]\nfor row in matrix:\n    for num in row:\n        if num > max_value:\n            max_value = num\nprint(max_value)',
        'hint' => '<p>Start by setting the maximum value to the first element, then compare each number in the 2D array.</p>',
        'unit_test' => '9'
    ),
    array(
        'title' => 'Creating a Multiplication Table',
        'challenge' => '<p>Create a 2D array that represents a multiplication table for numbers 1 to 3. The first row should contain the products of 1, the second row should contain the products of 2, and the third row should contain the products of 3.</p><p>Print the entire multiplication table.</p>',
        'skeleton_code' => 'table = []',
        'example_answer' => 'table = []\nfor i in range(1, 4):\n    row = []\n    for j in range(1, 4):\n        row.append(i * j)\n    table.append(row)\nprint(table)',
        'hint' => '<p>Use a nested loop where the outer loop represents the rows and the inner loop calculates the products for each row.</p>',
        'unit_test' => '[[1, 2, 3], [2, 4, 6], [3, 6, 9]]'
    ),
    array(
        'title' => 'Transposing a 2D Array',
        'challenge' => '<p>Create a 2D array called <code>matrix</code> with values [[1, 2, 3], [4, 5, 6]].</p><p>Write code to transpose the matrix (swap rows and columns) and print the result.</p>',
        'skeleton_code' => 'matrix = [[1, 2, 3], [4, 5, 6]]\ntranspose = []\n',
        'example_answer' => 'matrix = [[1, 2, 3], [4, 5, 6]]\ntranspose = []\nfor i in range(3):\n    row = []\n    for j in range(2):\n        row.append(matrix[j][i])\n    transpose.append(row)\nprint(transpose)',
        'hint' => '<p>Use nested loops to swap the rows and columns of the original matrix.</p>',
        'unit_test' => '[[1, 4], [2, 5], [3, 6]]'
    ),
    array(
        'title' => 'Calculating Total Sales for Shops',
        'challenge' => '<p>Create a 2D array called <code>sales</code> that stores the sales data for three stores over four days. The rows represent each store, and the columns represent the sales for each day. Create a 1D array called <code>totals</code> to store the total sales for each store. Write code to calculate the total sales for each store and store it in the <code>totals</code> array, then print it.</p>',
        'skeleton_code' => 'sales = [[100, 200, 150, 300], [80, 90, 160, 170], [200, 250, 230, 300]]\ntotals = []',
        'example_answer' => 'sales = [[100, 200, 150, 300], [80, 90, 160, 170], [200, 250, 230, 300]]\ntotals = []\nfor store in sales:\n    total_sales = 0\n    for sale in store:\n        total_sales += sale\n    totals.append(total_sales)\nprint(totals)',
        'hint' => '<p>Use a nested loop to iterate through the sales for each store and calculate the total sales.</p>',
        'unit_test' => '[750, 500, 980]'
    ),
    array(
        'title' => 'Matching Students with Their Grades',
        'challenge' => '<p>Create a 2D array called <code>grades</code> that stores test scores for five students, where each row represents a student’s scores in three subjects. Create a 1D array called <code>students</code> that contains the names of the students. Write code to print each student’s name alongside their test scores.</p>',
        'skeleton_code' => 'grades = [[85, 90, 88], [78, 82, 85], [92, 88, 91], [70, 75, 80], [88, 86, 84]]\nstudents = ["Alice", "Bob", "Charlie", "Daisy", "Ethan"]\nfor i in range(0,len(students)):\n    print()',
        'example_answer' => 'grades = [[85, 90, 88], [78, 82, 85], [92, 88, 91], [70, 75, 80], [88, 86, 84]]\nstudents = ["Alice", "Bob", "Charlie", "Daisy", "Ethan"]\nfor i in range(len(students)):\n    print(f"{students[i]}\'s scores: {grades[i]}")',
        'hint' => '<p>Use the <code>range()</code> function to iterate through both arrays and match each student with their corresponding grades.</p>',
        'unit_test' => "Alice's scores: [85, 90, 88]\nBob's scores: [78, 82, 85]\nCharlie's scores: [92, 88, 91]\nDaisy's scores: [70, 75, 80]\nEthan's scores: [88, 86, 84]"
    ),
    array(
        'title' => 'Tracking Inventory and Prices Using a Function',
        'challenge' => '<p>Create a 2D array called <code>inventory</code> that stores the quantities of three products across four different shops. Create a 1D array called <code>prices</code> that stores the prices of these products. Write a function called <code>calculate_total_value</code> that takes two parameters: <code>inventory</code> and <code>prices</code>. The function should return a 1D array that contains the total value of each product in all shops (quantity * price). Print the resulting array.</p>',
        'skeleton_code' => 'inventory = [[10, 15, 20, 25], [8, 12, 10, 20], [5, 10, 15, 25]]\nprices = [2.5, 3.0, 4.0]\n\ndef calculate_total_value(inventory, prices):\n    values = [] return values\n\n# Call the function and print the result\nresult = calculate_total_value(inventory, prices)\nprint(result)',
        'example_answer' => 'inventory = [[10, 15, 20, 25], [8, 12, 10, 20], [5, 10, 15, 25]]\nprices = [2.5, 3.0, 4.0]\n\ndef calculate_total_value(inventory, prices):\n    values = []\n    for i in range(len(inventory)):\n        total_value = 0\n        for j in range(len(inventory[i])):\n            total_value += inventory[i][j] * prices[i]\n        values.append(total_value)\n    return values\n\n# Call the function and print the result\nresult = calculate_total_value(inventory, prices)\nprint(result)',
        'hint' => '<p>Define the <code>calculate_total_value</code> function with two parameters. Inside the function, use a nested loop to calculate the total value of each product by multiplying the quantities by the corresponding price. Return the final values array.</p>',
        'unit_test' => '[175.0, 150.0, 220.0]'
    ),
    array(
        'title' => 'Programming Challenge 11',
        'challenge' => '<p>The names of products in a shop are stored in a one-dimensional (1D) array <code>ProductName</code> of type string. A separate two-dimensional (2D) array <code>ProductSales</code> stores the sales data for each product over the past 5 months.</p>
    <p>The sales data already contains the data for sales in GBP (pounds).</p>
    <p>Write a procedure, using pseudocode or program code, that meets the following requirements:</p>
    <ul>
    <li>Find the highest and lowest sale for each month.</li>
    <li>Find the product with the highest sales over the 5 months.</li>
    <li>Find the product with the lowest sales over the 5 months.</li>
    <li>Output any product that did not meet the minimum sales threshold and specify which month it occurred.</li>
    <li>Output the total overall sales.</li>
    <li>Output all data in a user-friendly format.</li>
    </ul><br/><p>The data for the two arrays has been created for you below:</p>',
        'skeleton_code' => 'ProductName = ["Strawberry aPhone 10", "Choir Universe", "Search Bitmap 5", "PlusOne Basic", "Aqua Experience"]\nProductSales = [\n    [120, 130, 140, 150, 160],\n    [170, 180, 190, 200, 210],\n    [220, 230, 240, 250, 260],\n    [270, 280, 290, 300, 310],\n    [320, 330, 340, 350, 360]\n]',
        'example_answer' => 'ProductName = ["Strawberry aPhone 10", "Choir Universe", "Search Bitmap 5", "PlusOne Basic", "Aqua Experience"]\nProductSales = [\n    [120, 130, 140, 150, 160],\n    [170, 180, 190, 200, 210],\n    [220, 230, 240, 250, 260],\n    [270, 280, 290, 300, 310],\n    [320, 330, 340, 350, 360]\n]\n\n# Calculate the highest and lowest sales for each month\nfor month in range(5):\n    month_sales = [ProductSales[prod][month] for prod in range(len(ProductName))]\n    highest = max(month_sales)\n    lowest = min(month_sales)\n    print(f"Month {month+1}: Highest = {highest}, Lowest = {lowest}")\n\n# Calculate the total sales for each product over 5 months\ntotal_sales = [sum(ProductSales[i]) for i in range(len(ProductSales))]\n\n# Find the product with the highest and lowest total sales\nmax_product = ProductName[total_sales.index(max(total_sales))]\nmin_product = ProductName[total_sales.index(min(total_sales))]\nprint(f"Product with highest sales: {max_product}")\nprint(f"Product with lowest sales: {min_product}")\n\n# Output products that didn\'t meet the threshold\nthreshold = 150\nfor i in range(len(ProductName)):\n    for j in range(5):\n        if ProductSales[i][j] < threshold:\n            print(f"{ProductName[i]} didn\'t meet the threshold in month {j+1}")\n\n# Calculate total overall sales\noverall_sales = sum(total_sales)\nprint(f"Total overall sales: {overall_sales}")',
        'hint' => '<p>Use a nested loop to find the highest and lowest sales per month, and to check which products did not meet the threshold.</p>',
        'unit_test' => 'AI'
    ),
    array(
        'title' => 'Simple Logic Gate Simulator',
        'challenge' => '<p>Create a simple logic gate simulator. The simulator should simulate three logic gates: AND, OR, and NOT.</p>
    <p>The inputs and outputs for the logic gates must be stored in variables or arrays. The task is to:</p>
    <ul>
    <li>Store two input values (0 or 1) for the AND and OR gates in a 1D array called <code>inputs</code>.</li>
    <li>Calculate the output for the AND gate and store it in a variable <code>and_output</code>.</li>
    <li>Calculate the output for the OR gate and store it in a variable <code>or_output</code>.</li>
    <li>Calculate the output for the NOT gate using the first input value and store it in a variable <code>not_output</code>.</li>
    <li>Finally, print the results of all three logic gates.</li>
    </ul><br/><p>For example: "<i>AND gate output: 0</i>"',
        'skeleton_code' => 'inputs = [1, 0]\nand_output = None\nor_output = None\nnot_output = None\n\n# Your logic gate simulator code goes here\n\nprint(f"AND gate output: {and_output}")\nprint(f"OR gate output: {or_output}")\nprint(f"NOT gate output: {not_output}")',
        'example_answer' => 'inputs = [1, 0]\nand_output = inputs[0] and inputs[1]\nor_output = inputs[0] or inputs[1]\nnot_output = not inputs[0]\n\nprint(f"AND gate output: {and_output}")\nprint(f"OR gate output: {or_output}")\nprint(f"NOT gate output: {not_output}")',
        'hint' => '<p>Use Python\'s logical operators <code>and</code>, <code>or</code>, and <code>not</code> to simulate the gates. The AND gate returns true only if both inputs are 1, the OR gate returns true if at least one input is 1, and the NOT gate flips the input value.</p>',
        'unit_test' => "AND gate output: 0\nOR gate output: 1\nNOT gate output: False"
    ),
    array(
        'title' => 'Determine the Logic Gate from a Truth Table',
        'challenge' => '<p>You are given a 2D array that represents the truth table for different logic gates: AND, OR, XOR, NOR, and NAND.</p>
    <p>Your task is to write a function that takes in a 2D array representing a truth table and determines which logic gate the table represents.</p>
    <p>Each row in the table contains the inputs and the expected output for a gate. The logic gates have the following truth tables:</p>
    <ul>
    <li><strong>AND Gate</strong></li>
    <li><strong>OR Gate</strong></li>
    <li><strong>XOR Gate</strong></li>
    <li><strong>NOR Gate</strong></li>
    <li><strong>NAND Gate</strong></li>
    </ul>
    <p>Use the provided "selected_table" (XOR gate) to test the function and print which gate the table represents.</p>',
        'skeleton_code' => 'AND_table = [[0, 0, 0], [0, 1, 0], [1, 0, 0], [1, 1, 1]]\nOR_table = [[0, 0, 0], [0, 1, 1], [1, 0, 1], [1, 1, 1]]\nXOR_table = [[0, 0, 0], [0, 1, 1], [1, 0, 1], [1, 1, 0]]\nNOR_table = [[0, 0, 1], [0, 1, 0], [1, 0, 0], [1, 1, 0]]\nNAND_table = [[0, 0, 1], [0, 1, 1], [1, 0, 1], [1, 1, 0]]\n\nselected_table = XOR_table\n\ndef determine_gate(truth_table):\ngate_type = determine_gate(selected_table)\nprint(gate_type)',
        'example_answer' => 'AND_table = [[0, 0, 0], [0, 1, 0], [1, 0, 0], [1, 1, 1]]\nOR_table = [[0, 0, 0], [0, 1, 1], [1, 0, 1], [1, 1, 1]]\nXOR_table = [[0, 0, 0], [0, 1, 1], [1, 0, 1], [1, 1, 0]]\nNOR_table = [[0, 0, 1], [0, 1, 0], [1, 0, 0], [1, 1, 0]]\nNAND_table = [[0, 0, 1], [0, 1, 1], [1, 0, 1], [1, 1, 0]]\n\nselected_table = XOR_table\n\ndef determine_gate(truth_table):\n    if truth_table == AND_table:\n        return "AND Gate"\n    elif truth_table == OR_table:\n        return "OR Gate"\n    elif truth_table == XOR_table:\n        return "XOR Gate"\n    elif truth_table == NOR_table:\n        return "NOR Gate"\n    elif truth_table == NAND_table:\n        return "NAND Gate"\n    else:\n        return "Unknown Gate"\n\n# Call the function and print the result\ngate_type = determine_gate(selected_table)\nprint(gate_type)',
        'hint' => '<p>Use <code>if</code> and <code>elif</code> statements to compare the given truth table with each predefined table and return the name of the matching gate.</p>',
        'unit_test' => 'AI'
    ),
    array(
        'title' => 'Simulating a Simple Table with Arrays',
        'challenge' => '<p>In databases, tables consist of columns and rows. Each row contains records of data, and each column represents an attribute.</p>
    <p>Simulate a simple table where each row represents a student’s record, and each column contains their details (Name, Age, and Grade). This data is stored in separate arrays.</p>
    <p>Your task is to:</p>
    <ul>
    <li>Create three arrays: <code>names</code>, <code>ages</code>, and <code>grades</code>, to represent each student’s name, age, and grade respectively.</li>
    <li>Write code to print each student’s record in a user-friendly format.</li>
    </ul>',
        'skeleton_code' => 'names = ["Alice", "Bob", "Charlie"]\nages = [16, 17, 16]\ngrades = ["A", "B", "A"]\n\n# Your code to print the table-like data\n',
        'example_answer' => 'names = ["Alice", "Bob", "Charlie"]\nages = [16, 17, 16]\ngrades = ["A", "B", "A"]\n\nfor i in range(len(names)):\n    print("Name: " + names[i] + ", Age: " + str(ages[i]) + ", Grade: " + grades[i])',
        'hint' => '<p>Use a <code>for</code> loop to iterate through each student’s data and print it.</p>',
        'unit_test' => 'AI'
    ),
    array(
        'title' => 'Using Dictionaries to Simulate Records',
        'challenge' => '<p>In databases, each row is often referred to as a record, and each column is an attribute (or field).</p>
    <p>Simulate a database record using a Python dictionary, where each key represents an attribute (e.g., Name, Age, Grade) and the corresponding value represents the data.</p>
    <p>Your task is to:</p>
    <ul>
    <li>Create a dictionary for each student with keys <code>"Name"</code>, <code>"Age"</code>, and <code>"Grade"</code>.</li>
    <li>Store three student dictionaries in a list and write code to print each student’s record.</li>
    </ul>',
        'skeleton_code' => 'student1 = {"Name": "Alice", "Age": 16, "Grade": "A"}\nstudent2 = {"Name": "Bob", "Age": 17, "Grade": "B"}\nstudent3 = {"Name": "Charlie", "Age": 16, "Grade": "A"}\nstudents = [student1, student2, student3]\n\n# Your code to print each student\'s record\n',
        'example_answer' => 'student1 = {"Name": "Alice", "Age": 16, "Grade": "A"}\nstudent2 = {"Name": "Bob", "Age": 17, "Grade": "B"}\nstudent3 = {"Name": "Charlie", "Age": 16, "Grade": "A"}\nstudents = [student1, student2, student3]\n\nfor student in students:\n    print("Name: " + student["Name"] + ", Age: " + str(student["Age"]) + ", Grade: " + student["Grade"])',
        'hint' => '<p>Use a <code>for</code> loop to iterate through the list of dictionaries and print each student\'s record.</p>',
        'unit_test' => 'AI'
    ),
    array(
        'title' => 'Simulating a Query on a "Database"',
        'challenge' => '<p>In databases, queries are used to retrieve specific information. For example, a query might ask for all students with a grade of "A".</p>
    <p>Simulate a query by filtering through a list of dictionaries that represent student records. Your task is to:</p>
    <ul>
    <li>Create a list of dictionaries where each dictionary represents a student (as in the previous challenge).</li>
    <li>Write a function called <code>find_A_students</code> that returns only the students who have a grade of "A".</li>
    <li>Print the names of all students who got an "A" grade.</li>
    </ul>',
        'skeleton_code' => 'students = [\n    {"Name": "Alice", "Age": 16, "Grade": "A"},\n    {"Name": "Bob", "Age": 17, "Grade": "B"},\n    {"Name": "Charlie", "Age": 16, "Grade": "A"}\n]\n\ndef find_A_students(students):\n    # Your code to filter students by grade\n\n# Call the function and print the result\n',
        'example_answer' => 'students = [\n    {"Name": "Alice", "Age": 16, "Grade": "A"},\n    {"Name": "Bob", "Age": 17, "Grade": "B"},\n    {"Name": "Charlie", "Age": 16, "Grade": "A"}\n]\n\ndef find_A_students(students):\n    A_students = []\n    for student in students:\n        if student["Grade"] == "A":\n            A_students.append(student["Name"])\n    return A_students\n\n# Call the function and print the result\nA_students = find_A_students(students)\nprint(A_students)',
        'hint' => '<p>Use a <code>for</code> loop to check each student\'s grade and append their name to a list if they have an "A".</p>',
        'unit_test' => 'AI'
    ),
    array(
        'title' => 'Check Digit Validator',
        'challenge' => '<p>In databases, check digits are used to ensure data integrity. The check digit is calculated from the first seven digits and is used to verify the correctness of the entire number.</p>
    <p>Your task is to:</p>
    <ul>
    <li>Create a function called <code>calculate_check_digit</code> that calculates the check digit from the first 7 digits of a given 8-digit number.</li>
    <li>Compare the calculated check digit with the 8th digit of the given number and determine if the number is valid or invalid.</li>
    <li>Print "valid" if the number is correct, otherwise print "invalid".</li>
    </ul>
    <p><strong>Note:</strong> For this challenge, the check digit will be calculated by summing the first 7 digits and taking the result modulo 10.</p>',
        'skeleton_code' => 'number = "12345678"  # Given 8-digit number\n\n# Function to calculate check digit\ndef calculate_check_digit(number):\n # Your code to check if the number is valid or invalid\n',
        'example_answer' => 'number = "12345678"  # Given 8-digit number\n\n# Function to calculate check digit\ndef calculate_check_digit(number):\n    # Extract the first 7 digits\n    digits = number[:7]\n    total_sum = 0\n    for digit in digits:\n        total_sum += int(digit)\n    # Calculate check digit\n    check_digit = total_sum % 10\n    return check_digit\n\n# Compare the calculated check digit with the 8th digit\ncalculated_check_digit = calculate_check_digit(number)\nactual_check_digit = int(number[7])\n\nif calculated_check_digit == actual_check_digit:\n    print("valid")\nelse:\n    print("invalid")',
        'hint' => '<p>Use slicing to extract the first 7 digits of the string. Loop through the digits to calculate the sum, then take the result modulo 10 to get the check digit.</p>',
        'unit_test' => 'valid'
    ),
    array(
        'title' => 'Simulating Automatic Repeat reQuest (ARQ)',
        'challenge' => '<p>Automatic Repeat reQuest (ARQ) is a protocol used to ensure reliable data transmission. If a data frame is lost or corrupted during transmission, the receiver requests that the sender retransmit the frame. This process continues until the frame is received correctly.</p>
    <p>In this challenge, you will simulate ARQ using arrays to represent data frames and their acknowledgments.</p>
    <p>Your task is to:</p>
    <ul>
    <li>Create a function called <code>simulate_arq</code> that takes in two arrays: <code>frames</code> (the data frames) and <code>acknowledgments</code> (the responses).</li>
    <li>For each frame in <code>frames</code>, check if the corresponding acknowledgment in <code>acknowledgments</code> is <code>ACK</code> (acknowledged) or <code>NACK</code> (not acknowledged).</li>
    <li>If a frame is not acknowledged, simulate retransmission by printing "Retransmitting frame X" where X is the frame number.</li>
    <li>Once all frames are acknowledged, print "All frames received successfully".</li>
    </ul>',
        'skeleton_code' => 'frames = [1, 2, 3, 4, 5]  # Data frames to be sent\nacknowledgments = ["ACK", "NACK", "ACK", "NACK", "ACK"]  # ACK or NACK for each frame\n\n# Function to simulate ARQ\ndef simulate_arq(frames, acknowledgments):',
        'example_answer' => 'frames = [1, 2, 3, 4, 5]\nacknowledgments = ["ACK", "NACK", "ACK", "NACK", "ACK"]\n\ndef simulate_arq(frames, acknowledgments):\n    for i in range(len(frames)):\n        if acknowledgments[i] == "ACK":\n            print("Frame", frames[i], "received successfully")\n        else:\n            print("Retransmitting frame", frames[i])\n    print("All frames received successfully")\n\nsimulate_arq(frames, acknowledgments)',
        'hint' => '<p>Use a <code>for</code> loop to iterate through the frames and check their corresponding acknowledgment. If the acknowledgment is <code>NACK</code>, print the retransmission message.</p>',
        'unit_test' => 'AI'
    ),
    array(
        'title' => 'Simulating a Local Football League (with Linear Search)',
        'challenge' => '<p>You are simulating a local football league with a total of 5 football clubs. Each club has played a number of matches, and the league keeps track of the matches won, drawn, and lost by each club.</p>
    <p>Your task is to:</p>
    <ul>
    <li>Create a 1D array called <code>clubs</code> that stores the names of the football clubs.</li>
    <li>Create a 2D array called <code>statistics</code> that stores the number of matches won, drawn, and lost for each club.</li>
    <li>Calculate the total points for each club using the formula: 3 points for a win, 1 point for a draw, and 0 points for a loss. Store these values in a 1D array called <code>points</code>.</li>
    <li>Write a function called <code>find_club_points</code> that takes the name of a club as input and uses a linear search to find and return the number of points for that club.</li>
    <li>Print the club’s name, the number of wins, and the total points awarded.</li>
    </ul>',
        'skeleton_code' => 'clubs = ["Tigers", "Lions", "Eagles", "Sharks", "Wolves"]\nstatistics = [[6, 4, 2], [5, 6, 1], [4, 5, 3], [3, 3, 6], [2, 7, 3]]\npoints = []\n\n',
        'example_answer' => 'clubs = ["Tigers", "Lions", "Eagles", "Sharks", "Wolves"]\nstatistics = [[6, 4, 2], [5, 6, 1], [4, 5, 3], [3, 3, 6], [2, 7, 3]]\npoints = []\n\n# Calculate total points for each club\nfor i in range(len(clubs)):\n    wins = statistics[i][0]\n    draws = statistics[i][1]\n    total_points = wins * 3 + draws * 1\n    points.append(total_points)\n\n# Linear search to find points for a given club\ndef find_club_points(club_name):\n    for i in range(len(clubs)):\n        if clubs[i] == club_name:\n            return points[i]\n    return "Club not found"\n\n# Example: Find points for "Lions"\nclub_name = "Lions"\nclub_points = find_club_points(club_name)\nprint(club_name + " has " + str(club_points) + " points.")',
        'hint' => '<p>Use a loop to calculate the points based on the number of wins and draws. Then, use a linear search to find the points for the given club.</p>',
        'unit_test' => 'Lions has 21 points.'
    ),
    array(
        'title' => 'Basic Set Operations',
        'challenge' => '<p>Create a class that performs basic set operations. Your task is to:</p>
    <ul>
    <li>Create an empty set called <code>data</code>.</li>
    <li>Write a function <code>add_element</code> that adds an element to the set.</li>
    <li>Write a function <code>remove_element</code> that removes an element from the set.</li>
    <li>Write a function <code>union</code> that returns the union of two sets.</li>
    </ul>',
        'skeleton_code' => 'class SetOperations:\n    def __init__(self):\n        self.data = set()\n\n    def add_element(self, element):\n        # Add element to the set\n        pass\n\n    def remove_element(self, element):\n        # Remove element from the set\n        pass\n\n    def union(self, other_set):\n        # Return the union of two sets\n        pass',
        'example_answer' => 'class SetOperations:\n    def __init__(self):\n        self.data = set()\n\n    def add_element(self, element):\n        self.data.add(element)\n\n    def remove_element(self, element):\n        self.data.remove(element)\n\n    def union(self, other_set):\n        return self.data.union(other_set)',
        'hint' => '<p>Use Python\'s built-in set methods for adding, removing, and finding the union of sets.</p>',
        'unit_test' => '{1, 2, 3}'
    ),
    array(
        'title' => 'Intersection and Difference in Sets',
        'challenge' => '<p>Given two sets, implement methods to find the intersection and difference. Your task is to:</p>
    <ul>
    <li>Create a function <code>intersection</code> that returns the intersection of two sets.</li>
    <li>Create a function <code>difference</code> that returns the difference between two sets (elements in set1 but not in set2).</li>
    </ul>',
        'skeleton_code' => 'class SetOperations:\n    def __init__(self, set1, set2):\n        self.set1 = set1\n        self.set2 = set2\n\n    def intersection(self):\n        # Return the intersection of two sets\n        pass\n\n    def difference(self):\n        # Return the difference of set1 and set2\n        pass',
        'example_answer' => 'class SetOperations:\n    def __init__(self, set1, set2):\n        self.set1 = set1\n        self.set2 = set2\n\n    def intersection(self):\n        return self.set1.intersection(self.set2)\n\n    def difference(self):\n        return self.set1.difference(self.set2)',
        'hint' => '<p>Use Python\'s built-in set methods <code>intersection</code> and <code>difference</code>.</p>',
        'unit_test' => '{2, 3}\n{1}'
    ),
    array(
        'title' => 'Standard Queue',
        'challenge' => '<p>Implement a standard queue using a list. Your task is to:</p>
    <ul>
    <li>Create an empty list called <code>queue</code>.</li>
    <li>Write a function <code>enqueue</code> to add an element to the queue.</li>
    <li>Write a function <code>dequeue</code> to remove an element from the queue.</li>
    <li>Write a function <code>is_empty</code> to check if the queue is empty.</li>
    </ul>',
        'skeleton_code' => 'class StandardQueue:\n    def __init__(self):\n        self.queue = []\n\n    def enqueue(self, element):\n        # Add element to the queue\n        pass\n\n    def dequeue(self):\n        # Remove the front element from the queue\n        pass\n\n    def is_empty(self):\n        # Check if the queue is empty\n        pass',
        'example_answer' => 'class StandardQueue:\n    def __init__(self):\n        self.queue = []\n\n    def enqueue(self, element):\n        self.queue.append(element)\n\n    def dequeue(self):\n        if not self.is_empty():\n            return self.queue.pop(0)\n        return None\n\n    def is_empty(self):\n        return len(self.queue) == 0',
        'hint' => '<p>Use Python\'s list append method for <code>enqueue</code> and pop with an index for <code>dequeue</code>.</p>',
        'unit_test' => '1\nFalse'
    ),
    array(
        'title' => 'Circular Queue',
        'challenge' => '<p>Implement a circular queue with a fixed size. Your task is to:</p>
    <ul>
    <li>Create an array called <code>queue</code> initialized with <code>None</code> values.</li>
    <li>Write a function <code>enqueue</code> to add an element to the queue.</li>
    <li>Write a function <code>dequeue</code> to remove an element from the queue.</li>
    <li>Write functions <code>is_empty</code> and <code>is_full</code> to check the state of the queue.</li>
    </ul>',
        'skeleton_code' => 'class CircularQueue:\n    def __init__(self, size):\n        self.queue = [None] * size\n        self.front = self.rear = -1\n        self.size = size\n\n    def enqueue(self, element):\n        # Add element to the queue\n        pass\n\n    def dequeue(self):\n        # Remove element from the queue\n        pass\n\n    def is_empty(self):\n        # Check if the queue is empty\n        pass\n\n    def is_full(self):\n        # Check if the queue is full\n        pass',
        'example_answer' => 'class CircularQueue:\n    def __init__(self, size):\n        self.queue = [None] * size\n        self.front = self.rear = -1\n        self.size = size\n\n    def enqueue(self, element):\n        if not self.is_full():\n            if self.front == -1:\n                self.front = 0\n            self.rear = (self.rear + 1) % self.size\n            self.queue[self.rear] = element\n\n    def dequeue(self):\n        if not self.is_empty():\n            element = self.queue[self.front]\n            if self.front == self.rear:\n                self.front = self.rear = -1\n            else:\n                self.front = (self.front + 1) % self.size\n            return element\n        return None\n\n    def is_empty(self):\n        return self.front == -1\n\n    def is_full(self):\n        return (self.rear + 1) % self.size == self.front',
        'hint' => '<p>Use modulo (%) to manage the circular behavior of the queue.</p>',
        'unit_test' => '1\nFalse'
    ),
    array(
        'title' => 'Shuffle Queue',
        'challenge' => '<p>Implement a queue that allows elements to be shuffled to the front after enqueuing a certain number of elements. Your task is to:</p>
    <ul>
    <li>Create a list called <code>queue</code>.</li>
    <li>Write a function <code>enqueue</code> to add an element to the queue.</li>
    <li>Write a function <code>dequeue</code> to remove an element from the queue.</li>
    <li>Write a function <code>shuffle</code> to shuffle the elements in the queue.</li>
    </ul>',
        'skeleton_code' => 'import random\n\nclass ShufflingQueue:\n    def __init__(self):\n        self.queue = []\n\n    def enqueue(self, element):\n        # Add element to the queue\n        pass\n\n    def dequeue(self):\n        # Remove the front element from the queue\n        pass\n\n    def shuffle(self):\n        # Shuffle the queue\n        pass',
        'example_answer' => 'import random\n\nclass ShufflingQueue:\n    def __init__(self):\n        self.queue = []\n\n    def enqueue(self, element):\n        self.queue.append(element)\n\n    def dequeue(self):\n        if not self.is_empty():\n            return self.queue.pop(0)\n        return None\n\n    def is_empty(self):\n        return len(self.queue) == 0\n\n    def shuffle(self):\n        random.shuffle(self.queue)',
        'hint' => '<p>Use Python\'s <code>random.shuffle</code> method to shuffle the elements in the queue.</p>',
        'unit_test' => '[3, 2, 1]\n[1, 2, 3] or other shuffled results'
    ),
    array(
        'title' => 'Stack Implementation',
        'challenge' => '<p>Implement a stack using a list. Your task is to:</p>
    <ul>
    <li>Create an empty list called <code>stack</code>.</li>
    <li>Write a function <code>push</code> to add an element to the stack.</li>
    <li>Write a function <code>pop</code> to remove the top element from the stack.</li>
    <li>Write a function <code>peek</code> to view the top element without removing it.</li>
    </ul>',
        'skeleton_code' => 'class Stack:\n    def __init__(self):\n        self.stack = []\n\n    def push(self, element):\n        # Add element to the stack\n        pass\n\n    def pop(self):\n        # Remove the top element from the stack\n        pass\n\n    def peek(self):\n        # View the top element without removing it\n        pass',
        'example_answer' => 'class Stack:\n    def __init__(self):\n        self.stack = []\n\n    def push(self, element):\n        self.stack.append(element)\n\n    def pop(self):\n        if not self.is_empty():\n            return self.stack.pop()\n        return None\n\n    def peek(self):\n        if not self.is_empty():\n            return self.stack[-1]\n        return None\n\n    def is_empty(self):\n        return len(self.stack) == 0',
        'hint' => '<p>Use Python\'s list append method for <code>push</code> and pop for <code>pop</code>.</p>',
        'unit_test' => '2\n2'
    ),
    array(
        'title' => 'Balanced Parentheses Using Stack',
        'challenge' => '<p>Write a function that checks if a string of parentheses is balanced using a stack. Your task is to:</p>
    <ul>
    <li>Create a function <code>is_balanced</code> that returns whether a given string has balanced parentheses.</li>
    <li>Use a stack to keep track of the opening parentheses.</li>
    </ul>',
        'skeleton_code' => 'class BalancedParentheses:\n    def __init__(self, expression):\n        self.expression = expression\n\n    def is_balanced(self):\n        # Check if the parentheses are balanced\n        pass',
        'example_answer' => 'class BalancedParentheses:\n    def __init__(self, expression):\n        self.expression = expression\n\n    def is_balanced(self):\n        stack = []\n        for char in self.expression:\n            if char == "(": stack.append(char)\n            elif char == ")":\n                if not stack:\n                    return False\n                stack.pop()\n        return not stack',
        'hint' => '<p>Push opening parentheses to the stack and pop for each closing parenthesis.</p>',
        'unit_test' => 'True\nFalse'
    ),
    array(
        'title' => 'Queue Reversal',
        'challenge' => '<p>Write a function that reverses the order of elements in a queue. Your task is to:</p>
    <ul>
    <li>Create a function <code>reverse_queue</code> to reverse the queue.</li>
    <li>Use a stack to assist with the reversal process.</li>
    </ul>',
        'skeleton_code' => 'class QueueReversal:\n    def __init__(self, queue):\n        self.queue = queue\n\n    def reverse_queue(self):\n        # Reverse the order of elements in the queue\n        pass',
        'example_answer' => 'class QueueReversal:\n    def __init__(self, queue):\n        self.queue = queue\n\n    def reverse_queue(self):\n        stack = []\n        while self.queue:\n            stack.append(self.queue.pop(0))\n        while stack:\n            self.queue.append(stack.pop())',
        'hint' => '<p>Use a stack to reverse the order of elements in the queue.</p>',
        'unit_test' => '[5, 4, 3, 2, 1]'
    ),    
    array(
        'title' => 'Stack-Based Infix to Postfix Conversion',
        'challenge' => '<p>Convert an infix expression to postfix notation using a stack. Your task is to:</p>
    <ul>
    <li>Create a function <code>convert</code> that converts an infix expression to postfix.</li>
    <li>Use a stack to manage operators.</li>
    </ul>',
        'skeleton_code' => 'class InfixToPostfix:\n    def __init__(self, expression):\n        self.expression = expression\n\n    def convert(self):\n        # Convert infix to postfix\n        pass',
        'example_answer' => 'class InfixToPostfix:\n    def __init__(self, expression):\n        self.expression = expression\n\n    def convert(self):\n        precedence = {"*": 2, "/": 2, "+": 1, "-": 1}\n        stack = []\n        output = ""\n        for char in self.expression:\n            if char.isalnum():\n                output += char\n            elif char in precedence:\n                while stack and precedence.get(stack[-1], 0) >= precedence[char]:\n                    output += stack.pop()\n                stack.append(char)\n        while stack:\n            output += stack.pop()\n        return output',
        'hint' => '<p>Use operator precedence to determine when to pop the stack.</p>',
        'unit_test' => 'abc*+'
    ),
    array(
        'title' => 'Priority Queue',
        'challenge' => '<p>Implement a priority queue where elements with higher priority are dequeued first. Your task is to:</p>
    <ul>
    <li>Create a list called <code>queue</code> to store the elements along with their priorities.</li>
    <li>Write a function <code>enqueue</code> that adds an element along with its priority.</li>
    <li>Write a function <code>dequeue</code> that removes the element with the highest priority.</li>
    </ul>',
        'skeleton_code' => 'class PriorityQueue:\n    def __init__(self):\n        self.queue = []\n\n    def enqueue(self, element, priority):\n        # Add element to the queue with a priority\n        pass\n\n    def dequeue(self):\n        # Remove the element with the highest priority\n        pass',
        'example_answer' => 'class PriorityQueue:\n    def __init__(self):\n        self.queue = []\n\n    def enqueue(self, element, priority):\n        self.queue.append((element, priority))\n        self.queue.sort(key=lambda x: x[1], reverse=True)\n\n    def dequeue(self):\n        if self.queue:\n            return self.queue.pop(0)\n        return None',
        'hint' => '<p>Use a list of tuples where each tuple contains the element and its priority. Sort the queue by priority.</p>',
        'unit_test' => '("C", 3)'
    ),
    array(
        'title' => 'Linear Search Through a 2D Array',
        'challenge' => '<p>Perform a linear search on a 2D array, searching for a value located at index 2 of each row. Your task is to:</p>
    <ul>
    <li>Create a 2D array with multiple rows where each row contains three elements.</li>
    <li>Write a function <code>linear_search</code> that searches for a target value at index 2 of each row and returns the row number if found.</li>
    <li>If the value is not found, return -1.</li>
    </ul>',
        'skeleton_code' => 'class LinearSearch2D:\n    def __init__(self, array):\n        self.array = array\n\n    def linear_search(self, target):\n        # Search for target in index 2 of each row\n        pass',
        'example_answer' => 'class LinearSearch2D:\n    def __init__(self, array):\n        self.array = array\n\n    def linear_search(self, target):\n        for i, row in enumerate(self.array):\n            if row[2] == target:\n                return i\n        return -1',
        'hint' => '<p>Use a loop to check the value at index 2 of each row and compare it with the target.</p>',
        'unit_test' => '1\n-1'
    ),
    array(
        'title' => 'Bubble Sort on Letters',
        'challenge' => '<p>Sort a list of letters using the ASCII values of the characters with bubble sort. Your task is to:</p>
    <ul>
    <li>Create a list of lowercase letters.</li>
    <li>Write a function <code>bubble_sort_ascii</code> that uses bubble sort to sort the letters based on their ASCII values.</li>
    <li>Return the sorted list of letters.</li>
    </ul>',
        'skeleton_code' => 'class BubbleSortASCII:\n    def __init__(self, letters):\n        self.letters = letters\n\n    def bubble_sort_ascii(self):\n        # Sort letters using ASCII values with bubble sort\n        pass',
        'example_answer' => 'class BubbleSortASCII:\n    def __init__(self, letters):\n        self.letters = letters\n\n    def bubble_sort_ascii(self):\n        n = len(self.letters)\n        for i in range(n):\n            for j in range(0, n-i-1):\n                if ord(self.letters[j]) > ord(self.letters[j+1]):\n                    self.letters[j], self.letters[j+1] = self.letters[j+1], self.letters[j]\n        return self.letters',
        'hint' => '<p>Use the <code>ord()</code> function to get the ASCII value of each character for comparison.</p>',
        'unit_test' => '[a, b, c]\n[g, m, z]'
    ),
    array(
        'title' => 'Insertion Sort with Iterations',
        'challenge' => '<p>Perform insertion sort on an array and print the array at each iteration of the algorithm. Your task is to:</p>
    <ul>
    <li>Create a list of numbers.</li>
    <li>Write a function <code>insertion_sort</code> that sorts the array using insertion sort and prints the array at each iteration.</li>
    <li>Return the final sorted array.</li>
    </ul>',
        'skeleton_code' => 'class InsertionSort:\n    def __init__(self, array):\n        self.array = array\n\n    def insertion_sort(self):\n        # Sort the array using insertion sort and print it at each iteration\n        pass',
        'example_answer' => 'class InsertionSort:\n    def __init__(self, array):\n        self.array = array\n\n    def insertion_sort(self):\n        for i in range(1, len(self.array)):\n            key = self.array[i]\n            j = i - 1\n            while j >= 0 and key < self.array[j]:\n                self.array[j + 1] = self.array[j]\n                j -= 1\n            self.array[j + 1] = key\n            print(self.array)\n        return self.array',
        'hint' => '<p>Use a nested loop to sort the array, moving elements to their correct position and printing the array after each iteration.</p>',
        'unit_test' => '[5, 3, 4, 1, 2]\n[3, 5, 4, 1, 2]\n[3, 4, 5, 1, 2]\n[1, 3, 4, 5, 2]\n[1, 2, 3, 4, 5]'
    ),
    array(
        'title' => 'Calculate Discounted Price',
        'challenge' => '<p>In this challenge, you will calculate the price of an item after applying a discount percentage. The result should be rounded to two decimal places.</p>
    <p>Your task is to:</p>
    <ul>
    <li>Create two variables: <code>price</code> to store the original price of the item and <code>discount_percentage</code> to store the discount percentage.</li>
    <li>Write a function called <code>calculate_discounted_price</code> that takes in both the price and the discount percentage as parameters and returns the new price after applying the discount, rounded to two decimal places.</li>
    <li>Output the following, each on a new line and matching this format:</li>
    <ul>
    <li>The original price in the format: <code>Original price: £X.X</code></li>
    <li>The discount percentage in the format: <code>Discount percentage: Y%</code></li>
    <li>The new price after the discount in the format: <code>New price after discount: £Z.Z</code></li>
    </ul>
    </ul>',
        'skeleton_code' => 'price = 100.00  # Example price\ndiscount_percentage = 10  # Example discount percentage\n\n# Define the function to calculate discounted price\n',
        'example_answer' => 'price = 100.00  # Example price\n\ndef calculate_discounted_price(price, discount_percentage):\n    discount = price * (discount_percentage / 100)\n    new_price = price - discount\n    return round(new_price, 2)\n\n# Calculate and print the discounted price\nnew_price = calculate_discounted_price(price, discount_percentage)\nprint("Original price: £" + str(price))\nprint("Discount percentage: " + str(discount_percentage) + "%")\nprint("New price after discount: £" + str(new_price))',
        'hint' => '<p>To calculate the new price, multiply the price by the discount percentage (divided by 100), subtract it from the original price, and round the result to two decimal places.</p><p>Remember to format the output exactly as specified in the challenge instructions.</p>',
        'unit_test' => 'Original price: £100.0\nDiscount percentage: 10%\nNew price after discount: £90.0'
    ),
    array(
        'title' => 'Linear Search on an Array of Objects',
        'challenge' => '<p>Create a class that performs a linear search on an array of objects. Each object should have properties for <code>name</code> and <code>age</code>. Your task is to:</p>
    <ul>
    <li>Create an array of objects, where each object has a <code>name</code> and <code>age</code> property.</li>
    <li>Write a function <code>search_by_name</code> that searches for an object by its <code>name</code> property and returns the <code>age</code> of the found object.</li>
    <li>If the name is not found, return -1.</li>
    </ul>',
        'skeleton_code' => 'names = ["Alice", "Bob", "Charlie"]\nages=[30,25,35]\n\nclass Person:\n    def __init__(self, name, age):\n        self.name = name\n        self.age = age\n\nclass LinearSearchObjects:\n    def __init__(self, people):\n        self.people = people\n\n    def search_by_name(self, target_name):\n        # Search for an object by name\n        pass',
        'example_answer' => 'class Person:\n    def __init__(self, name, age):\n        self.name = name\n        self.age = age\n\nclass LinearSearchObjects:\n    def __init__(self, people):\n        self.people = people\n\n    def search_by_name(self, target_name):\n        for person in self.people:\n            if person.name == target_name:\n                return person.age\n        return -1\n\n# Example data\npeople = [Person("Alice", 30), Person("Bob", 25), Person("Charlie", 35)]\nsearch = LinearSearchObjects(people)\nprint(search.search_by_name("Bob"))  # Expected output: 25',
        'hint' => '<p>Use a loop to iterate through each object in the array and compare the <code>name</code> property to the target name.</p>',
        'unit_test' => '25\n-1'
    )

);
?>
