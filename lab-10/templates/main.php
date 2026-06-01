<?php include __DIR__ . '/header.php'; ?>

<h1>Статьи блога</h1>
<p><a href="/articles/add">➕ Добавить статью</a></p>

<?php if (empty($articles)): ?>
    <p>Нет статей</p>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <h2>
            <a href="/articles/<?= $article->getId() ?>">
                <?= htmlspecialchars($article->getName()) ?>
            </a>
        </h2>
        <p><?= nl2br(htmlspecialchars($article->getText())) ?></p>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>