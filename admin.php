<!-- admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="admin_login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>
        <a href="index.php">home_page</a>
    </div>
</body>
</html>
