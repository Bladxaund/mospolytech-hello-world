<?php include __DIR__ . '/header.php'; ?>

<h1><?= htmlspecialchars($article->getName()) ?></h1>

<p><strong>Автор:</strong> <?= htmlspecialchars($author->getNickname()) ?></p>
<p><strong>Дата создания:</strong> <?= $article->getCreatedAt() ?></p>

<hr>

<p><?= nl2br(htmlspecialchars($article->getText())) ?></p>

<p><a href="/">← Назад ко всем статьям</a></p>

<?php include __DIR__ . '/footer.php'; ?>