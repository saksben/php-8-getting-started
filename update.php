<?php 

    require 'config.inc.php';

    // Get id from url params, to edit that user's id
    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header('Location: select.php');
    }

    // Initial variable declarations
    $name = '';
    $gender = '';
    $color = '';

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

        // Submit to db when submitted and $ok === true, else display that user and their info
        if ($ok) {
            // printf('User name: %s
            //     <br>Password: %s
            //     <br>Gender: %s
            //     <br>Color: %s
            //     <br>Language(s): %s
            //     <br>Comments: %s
            //     <br>T&amp;C: %s',
            //     htmlspecialchars($name, ENT_QUOTES),
            //     htmlspecialchars($password, ENT_QUOTES),
            //     htmlspecialchars($gender, ENT_QUOTES),
            //     htmlspecialchars($color, ENT_QUOTES),
            //     htmlspecialchars(implode(' ', $languages), ENT_QUOTES),
            //     htmlspecialchars($comments, ENT_QUOTES),
            //     htmlspecialchars($tc, ENT_QUOTES));
            // Connect to db
            $db = new mysqli(
                MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE
            );
            // Data commands for db
            $sql = sprintf(
                "UPDATE users SET name='%s', gender='%s', color='%s' 
                WHERE id=%s",
                $db->real_escape_string($name),
                $db->real_escape_string($gender),
                $db->real_escape_string($color),
                $id
            );
            // Submit data commands to db
            $db->query($sql);
            // Show that user has been added and data sent
            echo '<p>User Updated.</p>';
            // Close db
            $db->close();
        };
        
    } else {
        $db = new mysqli(
            'localhost',
            'root',
            'NightwingSpider1!',
            'php'
        );
        $sql = "SELECT * FROM users WHERE id=$id"; // To prevent sql injection
        $result = $db->query($sql);
        foreach ($result as $row) {
            $name = $row['name'];
            $gender = $row['gender'];
            $color = $row['color'];
        }
        $db->close();
    }
?>

<!-- Form to update user -->
<form 
    action="" 
    method="post">
    User name: 
    <input type="text" name="name" value="<?php
        echo htmlspecialchars($name, ENT_QUOTES); // So the value remains even if submitted while validation fails
    ?>"><br>
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
    <input type="submit" name="submit" value="Update">
</form>