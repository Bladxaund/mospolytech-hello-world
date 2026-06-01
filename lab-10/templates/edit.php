<?php include __DIR__ . '/header.php'; ?>

<h1>Редактирование статьи</h1>

<form method="post">
    <div class="form-group">
        <label>Название:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($article->getName()) ?>" required>
    </div>
    
    <div class="form-group">
        <label>Текст:</label>
        <textarea name="text" rows="10" required><?= htmlspecialchars($article->getText()) ?></textarea>
    </div>
    
    <button type="submit">💾 Сохранить</button>
    <a href="/articles/<?= $article->getId() ?>">Отмена</a>
</form>

<?php include __DIR__ . '/footer.php'; ?>