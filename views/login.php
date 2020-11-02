<?php
?>

<h2>Login</h2><br>
<!-- I think that it will send the data to login function in AuthController and we can access it from there -->
<!-- The data will be accessed with getBody method that uses $_POST inside -->
<form action="" method="post">
    <label>Email</label><br>
    <input type="email" name="email"><br>
    <label>Password</label><br>
    <input type="password" name="password"><br>
    <button type="submit">Submit</button>
</form>