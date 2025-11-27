<?php
session_start();
session_unset();
session_destroy();
?>
<script>
    // Clear only specific key
    localStorage.removeItem("user_name");

    // OR clear all localStorage
    // localStorage.clear();

    // Redirect to login page
    window.location.href = "index.php";
</script>
