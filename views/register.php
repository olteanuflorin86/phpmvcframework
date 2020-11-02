<?php
?>

<h2>Register</h2><br>
<!-- I think that it will send the data to register function in AuthController and we can access it from there -->
<!-- The data will be accessed with getBody method that uses $_POST inside -->
<form action="" method="post">
    <label>First Name</label><br>
    <input type="text" name="firstName"><br>
    <label>Last Name</label><br>
    <input type="text" name="lastName"><br>
    <label>Email</label><br>
    <input type="email" name="email"><br>
    <label>Password</label><br>
    <input type="password" name="password"><br>
    <label>Confirm Password</label><br>
    <input type="password" name="confirmPassword"><br>
    <button type="submit">Submit</button>
</form>