<?php
session_start();

if (isset($_SESSION['email'])) {
    header("Location: welcome.php");
    exit();
}

if (isset($_POST['register'])) {
    $conn = mysqli_connect("localhost", "171.61.130.244", "password");
  

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "CREATE DATABASE database";
    if ($conn->query($sql) === TRUE) {
     	echo "Database created successfully";
} 
   else {
   	 echo "Error creating database: " . $conn->error;
}

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already exists!";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}

if (isset($_POST['login'])) {
    $conn = mysqli_connect("localhost", "your_username", "your_password", "your_database");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Invalid email or password!";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Login and Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" name="register" value="Register">
    </form>

    <h2>Login</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" name="login">
</form>
</body>
</html>
