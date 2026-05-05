<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
 

<?php if (isset($_SESSION['message'])): ?>
    <div class="toast-message">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']);
        ?>
    </div>
<?php endif; ?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="login-page">
        <div class="login-card">

            <h2>Редактирование профиля</h2>

            <form action="php/update_profile.php" method="POST">

                <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

                <button type="submit">Сохранить</button>
            </form>

        </div>
    </div>

</body>

</html>