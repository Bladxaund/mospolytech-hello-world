<?php include __DIR__ . '/../header.php'; ?>

<h1>✈️ Новая статья о путешествиях</h1>

<?php if (isset($error)): ?>
    <div class="alert alert-error"><?= $error ?></div>
<?php endif; ?>

<form method="post" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    <div class="form-group">
        <label>Заголовок:</label>
        <input type="text" name="title" required>
    </div>
    
    <div class="form-group">
        <label>Категория:</label>
        <select name="category" required>
            <option value="europe">🇪🇺 Европа</option>
            <option value="asia">🌏 Азия</option>
            <option value="america">🗽 Америка</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Содержание:</label>
        <textarea name="content" rows="10" required></textarea>
    </div>
    
    <div class="form-group">
        <label>Ссылка на изображение (URL):</label>
        <input type="text" name="image_url" placeholder="https://example.com/photo.jpg">
        <small style="color: #999;">Вставьте ссылку на фото из интернета (Pexels, Unsplash и т.д.)</small>
    </div>
    
    <button type="submit" class="btn">📝 Опубликовать</button>
    <a href="/posts" style="margin-left: 10px;">Отмена</a>
</form>

<?php include __DIR__ . '/../footer.php'; ?>