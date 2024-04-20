Explaination of oninput="this.value = this.value.replace(/\s/g, '') property

The property oninput="this.value = this.value.replace(/\s/g, '')" is an event handler in HTML that is triggered whenever the input value of an element changes. Let's break it down:
oninput: This is an event handler attribute in HTML. It specifies a script to run when an <input>, <select>, or <textarea> element gets user input. In this case, the script specified will run whenever the user inputs something into an input field.
this.value: this refers to the element that triggered the event, and .value refers to the current value of that element. So, this.value represents the current value of the input field where the event is happening.
this.value.replace(/\s/g, ''): This is a JavaScript method call that replaces all whitespace characters (\s) in the input value with an empty string (''). Here's a breakdown of the replace() method:
/.../g: This is a regular expression pattern. /.../ denotes the beginning and end of a regular expression pattern, and g is a flag indicating global search, meaning it will replace all occurrences of the pattern in the string.
Putting it all together, this property ensures that whenever the user inputs something into the input field, any whitespace characters they enter will be automatically removed from the value of that input field. This is often used to enforce specific formatting rules or to prevent certain types of input. In this case, it seems to be used to remove spaces from the input fields.

GENERATE EMPTY STRING
1. echo -n "" | sha1sum in the terminal window
2. $input = 'example_string'; // Your input string here
$hash = hash('sha1', $input);
echo $hash; // Output the generated hash value  (in PHP file)  

II. ADD PRODUCT
onkeypress="if(this.value.length == 10) return false;": This JavaScript event handler limits the maximum number of characters that can be entered into the input field to 10. If the length of the input exceeds 10 characters, further key presses are blocked.

