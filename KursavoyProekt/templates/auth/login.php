<?php include __DIR__ . '/../header.php'; ?>

<div style="max-width: 400px; margin: 0 auto;">
    <h1 style="text-align: center;">🔑 Вход в аккаунт</h1>
    
    <?php if (isset($error)): ?>
        <div style="background: rgba(220,53,69,0.1); border: 1px solid #dc3545; padding: 10px; border-radius: 5px; margin-bottom: 20px; color: #dc3545;">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form method="post" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Пароль:</label>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit" class="btn" style="width: 100%;">Войти</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        Нет аккаунта? <a href="/auth/register" style="color: #667eea;">Зарегистрироваться</a>
    </p>
</div>

<?php include __DIR__ . '/../footer.php'; ?>