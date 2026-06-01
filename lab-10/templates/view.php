<?php include __DIR__ . '/header.php'; ?>

<h1><?= htmlspecialchars($article->getName()) ?></h1>

<p class="author">
    <strong>Автор:</strong> <?= $article->getAuthor()->getNickname() ?>
</p>
<p><strong>Дата создания:</strong> <?= $article->getCreatedAt() ?></p>

<hr>

<p><?= nl2br(htmlspecialchars($article->getText())) ?></p>

<p>
    <a href="/articles/<?= $article->getId() ?>/edit">✏️ Редактировать</a>
    |
    <a href="/">← Назад ко всем статьям</a>
</p>

<?php include __DIR__ . '/footer.php'; ?>