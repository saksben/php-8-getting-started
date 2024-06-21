<?php 
    // Initial variable declarations
    $name = '';
    $password = '';
    $gender = '';
    $color = '';
    $languages = [];
    $comments = '';
    $tc = '';

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
        if (!isset($_POST['languages']) || !is_array($_POST['languages']) 
            || count($_POST['languages']) === 0) {
            $ok = false;
        } else {
            $languages = $_POST['languages'];
        };
        if (!isset($_POST['comments']) || $_POST['comments'] === '') {
            $ok = false;
        } else {
            $comments = $_POST['comments'];
        };
        if (!isset($_POST['tc']) || $_POST['tc'] === '') {
            $ok = false;
        } else {
            $tc = $_POST['tc'];
        };

        // Submit to db when submitted and $ok === true
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
                'localhost',
                'user',
                'password',
                'php'
            );
            // Data commands for db
            $sql = sprintf(
                "INSERT INTO users (name, gender, color) VALUES (
                '%s', '%s', '%s')",
                $db->real_escape_string($name),
                $db->real_escape_string($gender),
                $db->real_escape_string($color)
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
    Password: <input type="password" name="password"><br>
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
    </select><br>
    Languages spoken:
    <select name="languages[]" multiple size="3">
        <option value="en"<?php 
            if (in_array('en', $languages)) {
                echo ' selected';
            }
        ?>>English</option>
        <option value="fr"<?php 
            if (in_array('fr', $languages)) {
                echo ' selected';
            }
        ?>>French</option>
        <option value="it"<?php 
            if (in_array('it', $languages)) {
                echo ' selected';
            }
        ?>>Italian</option>
    </select><br>
    Comments: <textarea name="comments"><?php
        echo htmlspecialchars($comments, ENT_QUOTES);
    ?></textarea><br>
    <input type="checkbox" name="tc" value="ok"<?php 
        if ($tc === 'ok') {
            echo ' checked';
        }
    ?>>
    I accept the T&amp;C<br>
    <input type="submit" name="submit" value="Register">
</form>