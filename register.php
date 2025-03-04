<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $room = $_POST["room"];
    $profilePicture = $_FILES["profile_picture"];

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    
    if (strlen($password) != 8 || preg_match('/[^a-z0-9_]/', $password) || preg_match('/[A-Z]/', $password)) {
        die("Password must be exactly 8 characters, only lowercase letters, numbers, and underscore.");
    }

    
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    
    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    if (!in_array($profilePicture["type"], $allowedTypes)) {
        die("Invalid profile picture format. Only JPG, PNG, and GIF allowed.");
    }

    move_uploaded_file($profilePicture["tmp_name"], "uploads/" . $profilePicture["name"]);

    
    $userData = "$email,$password,$room\n";
    file_put_contents("users.txt", $userData, FILE_APPEND);

    echo "Registration successful! <a href='login.php'>Login here</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <select name="room">
                <option value="Application1">Application1</option>
                <option value="Application2">Application2</option>
                <option value="Cloud">Cloud</option>
            </select><br>
            <input type="file" name="profile_picture" required><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
