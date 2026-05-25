<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="css/style.css?v=11">
</head>

<body>

<div class="edit-profile-overlay">

    <?php if (isset($_SESSION['message'])): ?>
        <div class="toast-message">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="profile-success">
            Данные успешно сохранены
        </div>
    <?php endif; ?>

    <div class="edit-profile-card">

        <a href="profile.php" class="close-edit-profile">✕</a>

        <h2>Редактирование профиля</h2>

        <div class="edit-tabs">
            <button type="button" class="edit-tab active" data-tab="profileData">Данные</button>
            <button type="button" class="edit-tab" data-tab="passwordData">Пароль</button>
            <button type="button" class="edit-tab" data-tab="deleteData">Удаление</button>
        </div>

        <div class="edit-tab-content active" id="profileData">

            <form action="php/update_profile.php" method="POST" enctype="multipart/form-data" class="edit-profile-form">

                <div class="avatar-edit">
                    <img src="<?php echo htmlspecialchars($user['avatar'] ?? 'img/user.jpg'); ?>" alt="avatar">

                    <label class="avatar-upload-label">
                        Изменить аватарку
                        <input 
                            type="file" 
                            name="avatar" 
                            accept="image/*"
                            id="avatarInput"
                        >
                    </label>

                    <div class="avatar-selected" id="avatarSelected">
                        Фото не выбрано
                    </div>
                </div>

                <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit">Сохранить</button>

            </form>

        </div>

        <div class="edit-tab-content" id="passwordData">

            <form action="php/update_password.php" method="POST" class="edit-profile-form">
                <input type="password" name="old_password" placeholder="Старый пароль" required>
                <input type="password" name="new_password" placeholder="Новый пароль" required>
                <input type="password" name="new_password_repeat" placeholder="Повторите новый пароль" required>

                <button type="submit">Изменить пароль</button>
            </form>

        </div>

        <div class="edit-tab-content" id="deleteData">

            <form action="php/delete_profile.php" method="POST" class="edit-profile-form" onsubmit="return confirm('Удалить профиль навсегда?');">
                <button type="submit" class="delete-profile-btn">Удалить профиль</button>
            </form>

        </div>

    </div>

</div>

<script>
const editTabs = document.querySelectorAll('.edit-tab');
const editContents = document.querySelectorAll('.edit-tab-content');

editTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        editTabs.forEach(t => t.classList.remove('active'));
        editContents.forEach(c => c.classList.remove('active'));

        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
    });
});

const avatarInput = document.getElementById('avatarInput');
const avatarSelected = document.getElementById('avatarSelected');

if (avatarInput) {
    avatarInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            avatarSelected.innerHTML = '✓ Фото выбрано: ' + this.files[0].name;
            avatarSelected.classList.add('active');
        } else {
            avatarSelected.innerHTML = 'Фото не выбрано';
            avatarSelected.classList.remove('active');
        }
    });
}
</script>

</body>
</html>