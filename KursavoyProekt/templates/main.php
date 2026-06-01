<?php include __DIR__ . '/header.php'; ?>

<div style="text-align: center; margin-bottom: 40px;">
    <h1 style="font-size: 36px;">Добро пожаловать в мир путешествий!</h1>
    <p style="color: #555;">Интересные истории и полезные советы для путешественников</p>
</div>

<h2 style="margin-bottom: 20px;">📌 Последние статьи</h2>

<div class="posts-grid">
    <?php foreach ($recentPosts as $post): ?>
        <div class="post-card">
            <div class="post-image">
                <?php 
                    $icons = ['europe' => '🇪🇺', 'asia' => '🌏', 'america' => '🗽'];
                    echo $icons[$post->getCategory()] ?? '🌍';
                ?>
            </div>
            <div class="post-info">
                <h3 class="post-title"><?= htmlspecialchars($post->getTitle()) ?></h3>
                <div class="post-date">📅 <?= $post->getCreatedAt() ?></div>
                <p class="post-excerpt"><?= htmlspecialchars(substr($post->getContent(), 0, 120)) ?>...</p>
                <a href="/posts/<?= $post->getId() ?>" class="btn" style="display: inline-block; margin-top: 15px;">Читать →</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>