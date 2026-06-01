<?php include __DIR__ . '/header.php'; ?>

<h1>Новая статья</h1>

<form method="post">
    <div class="form-group">
        <label>Название:</label>
        <input type="text" name="name" required>
    </div>
    
    <div class="form-group">
        <label>Текст:</label>
        <textarea name="text" rows="10" required></textarea>
    </div>
    
    <button type="submit">➕ Добавить</button>
    <a href="/">Отмена</a>
</form>

<?php include __DIR__ . '/footer.php'; ?>