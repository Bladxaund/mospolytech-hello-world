<?php include __DIR__ . '/../header.php'; ?>

<h1>✏️ Редактирование: <?= htmlspecialchars($post->getTitle()) ?></h1>

<form method="post" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    <div class="form-group">
        <label>Заголовок:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post->getTitle()) ?>" required>
    </div>
    
    <div class="form-group">
        <label>Категория:</label>
        <select name="category" required>
            <option value="europe" <?= $post->getCategory() === 'europe' ? 'selected' : '' ?>>🇪🇺 Европа</option>
            <option value="asia" <?= $post->getCategory() === 'asia' ? 'selected' : '' ?>>🌏 Азия</option>
            <option value="america" <?= $post->getCategory() === 'america' ? 'selected' : '' ?>>🗽 Америка</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Содержание:</label>
        <textarea name="content" rows="10" required><?= htmlspecialchars($post->getContent()) ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Изображение:</label>
        <input type="text" name="image" value="<?= htmlspecialchars($post->getImage()) ?>">
    </div>
    
    <button type="submit" class="btn">💾 Сохранить</button>
    <a href="/posts/<?= $post->getId() ?>" style="margin-left: 10px;">Отмена</a>
</form>

<?php include __DIR__ . '/../footer.php'; ?>