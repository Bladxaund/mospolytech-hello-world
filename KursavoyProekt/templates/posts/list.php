<?php include __DIR__ . '/../header.php'; ?>

<h1 style="text-align: center;">📚 Все статьи о путешествиях</h1>

<!-- КНОПКИ ФИЛЬТРОВ -->
<div style="display: flex; gap: 15px; justify-content: center; margin: 30px 0; flex-wrap: wrap;">
    <a href="/posts" class="filter-btn" style="padding: 10px 25px; background: <?= !isset($currentCategory) ? '#667eea' : '#f0f0f0'; ?>; color: <?= !isset($currentCategory) ? 'white' : '#333'; ?>; border-radius: 30px; text-decoration: none;">🌍 Все</a>
    <a href="/posts/filter/europe" class="filter-btn" style="padding: 10px 25px; background: <?= isset($currentCategory) && $currentCategory === 'europe' ? '#667eea' : '#f0f0f0'; ?>; color: <?= isset($currentCategory) && $currentCategory === 'europe' ? 'white' : '#333'; ?>; border-radius: 30px; text-decoration: none;">🇪🇺 Европа</a>
    <a href="/posts/filter/asia" class="filter-btn" style="padding: 10px 25px; background: <?= isset($currentCategory) && $currentCategory === 'asia' ? '#667eea' : '#f0f0f0'; ?>; color: <?= isset($currentCategory) && $currentCategory === 'asia' ? 'white' : '#333'; ?>; border-radius: 30px; text-decoration: none;">🌏 Азия</a>
    <a href="/posts/filter/america" class="filter-btn" style="padding: 10px 25px; background: <?= isset($currentCategory) && $currentCategory === 'america' ? '#667eea' : '#f0f0f0'; ?>; color: <?= isset($currentCategory) && $currentCategory === 'america' ? 'white' : '#333'; ?>; border-radius: 30px; text-decoration: none;">🗽 Америка</a>
</div>

<div class="posts-grid">
    <?php foreach ($posts as $post): ?>
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
                <div class="post-category" style="margin-bottom: 10px;"><?= $post->getCategoryName() ?></div>
                <p class="post-excerpt"><?= htmlspecialchars(substr($post->getContent(), 0, 120)) ?>...</p>
                <a href="/posts/<?= $post->getId() ?>" class="btn" style="display: inline-block; margin-top: 15px;">Читать →</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php $user = User::getById($_SESSION['user_id']); ?>
                    <?php if ($user && $user->isAdmin()): ?>
                        <div style="margin-top: 15px;">
                            <a href="/posts/<?= $post->getId() ?>/edit" style="color: #667eea; font-size: 12px; margin-right: 10px;">✏️ Редактировать</a>
                            <a href="/posts/delete/<?= $post->getId() ?>" style="color: #dc3545; font-size: 12px;" onclick="return confirm('Удалить эту статью?')">🗑️ Удалить</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>