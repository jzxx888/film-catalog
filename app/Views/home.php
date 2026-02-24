<h1>Welcome on homepage</h1>

<form action="/" method="POST">
    <div>
        <label for="name">Name</label>
        <input type="text" name="name"id="name">
    </div>
    <div>
        <label for="surname">Surname</label>
        <input type="text" name="surname"id="surname">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" name="password" id="password">
    </div>

    <button type="submit">Send</button>
</form>

<?php

use Core\Validator;

$validator = new Validator($_POST);
$validator->rule('name', 'required');
$validator->rule('password', ['required', 'password']);
dump($validator->validate());
dump($validator->getErrors());
?>