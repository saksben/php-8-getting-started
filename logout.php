<?php
    session_start();

    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
    }
    
    if (isset($_SESSION['isAdmin'])) {
        unset($_SESSION['isAdmin']);
    }
    
    echo 'User logged out.';
?>