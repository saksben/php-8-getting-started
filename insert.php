<?php 

    require 'config.inc.php';

    // Initial variable declarations
    $name = '';
    $gender = '';
    $color = '';
    $password = '';

    // When a POST request is made with the input button with the 'submit' name:
    if (isset($_POST['submit'])) {
        // echo htmlspecialchars($_POST['searchterm'], ENT_QUOTES); // To secure from using html or js in form

        $ok = true;

        // Validation: if the 'name etc' input is empty or not set, set $ok to false
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $ok = false;
        } else {
            $name = $_POST['name'];
        };
        if (!isset($_POST['password']) || $_POST['password'] === '') {
            $ok = false;
        } else {
            $password = $_POST['password'];
        };
        if (!isset($_POST['gender']) || $_POST['gender'] === '') {
            $ok = false;
        } else {
            $gender = $_POST['gender'];
        };
        if (!isset($_POST['color']) || $_POST['color'] === '') {
            $ok = false;
        } else {
            $color = $_POST['color'];
        };

        // Submit to db when submitted and $ok === true
        if ($ok) {
            // Hash the password for security
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Connect to db
            $db = new mysqli(
                MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE
            );
            // Data commands for db
            $sql = sprintf(
                "INSERT INTO users (name, gender, color, hash) VALUES (
                '%s', '%s', '%s', '%s')",
                $db->real_escape_string($name),
                $db->real_escape_string($gender),
                $db->real_escape_string($color),
                $db->real_escape_string($hash)
            );
            // Submit data commands to db
            $db->query($sql);
            // Show that user has been added and data sent
            echo '<p>User added.</p>';
            // Close db
            $db->close();
        };
        
    }
?>

<form 
    action="" 
    method="post">
    User name: 
    <input type="text" name="name" value="<?php
        echo htmlspecialchars($name, ENT_QUOTES); // So the value remains even if submitted while validation fails
    ?>"><br>
    Password: 
    <input type="text" name="password" value="<?php $password ?>"><br>
    Gender: 
    <input type="radio" name="gender" value="f"<?php 
        if ($gender === 'f') {
            echo ' checked';
        }
    ?>> female
    <input type="radio" name="gender" value="m"<?php 
        if ($gender === 'm') {
            echo ' checked';
        }
    ?>> male
    <input type="radio" name="gender" value="o"<?php 
        if ($gender === 'o') {
            echo ' checked';
        }
    ?>> other <br />
    Favorite color:
    <select name="color">
        <option value="">Please select</option>
        <option value="#f00"<?php 
            if ($color === '#f00') {
                echo ' selected';
            }
        ?>>red</option>
        <option value="#0f0"<?php 
            if ($color === '#0f0') {
                echo ' selected';
            }
        ?>>green</option>
        <option value="#00f"<?php 
            if ($color === '#00f') {
                echo ' selected';
            }
        ?>>blue</option>
    </select>
    <input type="submit" name="submit" value="Register">
</form>

<!-- Read (add) HTML footer from file footer.tmpl.html-->
<!-- <?php
    readfile('footer.tmpl.html');
?> -->