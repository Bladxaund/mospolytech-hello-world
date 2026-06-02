<?php include __DIR__ . '/../header.php'; ?>

<h1 style="text-align: center;">📚 Все статьи о путешествиях</h1>

<!-- КНОПКИ ФИЛЬТРОВ -->
<div class="filter-buttons">
    <a href="/posts" class="filter-btn" style="background: <?php echo !isset($currentCategory) ? '#667eea' : '#f0f0f0'; ?>; color: <?php echo !isset($currentCategory) ? 'white' : '#333'; ?>">🌍 Все</a>
    <a href="/posts/filter/europe" class="filter-btn" style="background: <?php echo isset($currentCategory) && $currentCategory === 'europe' ? '#667eea' : '#f0f0f0'; ?>; color: <?php echo isset($currentCategory) && $currentCategory === 'europe' ? 'white' : '#333'; ?>">🇪🇺 Европа</a>
    <a href="/posts/filter/asia" class="filter-btn" style="background: <?php echo isset($currentCategory) && $currentCategory === 'asia' ? '#667eea' : '#f0f0f0'; ?>; color: <?php echo isset($currentCategory) && $currentCategory === 'asia' ? 'white' : '#333'; ?>">🌏 Азия</a>
    <a href="/posts/filter/america" class="filter-btn" style="background: <?php echo isset($currentCategory) && $currentCategory === 'america' ? '#667eea' : '#f0f0f0'; ?>; color: <?php echo isset($currentCategory) && $currentCategory === 'america' ? 'white' : '#333'; ?>">🗽 Америка</a>
</div>

<div class="posts-grid">
    <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <!-- БЛОК С ИЗОБРАЖЕНИЕМ -->
            <div class="post-image">
                <?php 
                    $image = $post->getImage();
                    $hasImage = $image && $image !== 'default.jpg';
                ?>
                <?php if ($hasImage): ?>
                    <img src="<?php echo $image; ?>" alt="<?php echo $post->getTitle(); ?>">
                <?php else: ?>
                    <?php 
                        $icons = ['europe' => '🇪🇺', 'asia' => '🌏', 'america' => '🗽'];
                        echo $icons[$post->getCategory()] ?? '🌍';
                    ?>
                <?php endif; ?>
            </div>
            
            <div class="post-info">
                <h3 class="post-title"><?php echo htmlspecialchars($post->getTitle()); ?></h3>
                <div class="post-meta">
                    <?php 
                        $author = User::getById($post->getUserId());
                    ?>
                    <span class="post-author">👤 <?php echo htmlspecialchars($author->getNickname()); ?></span>
                    <span class="post-category">
                        <?php 
                            $catNames = ['europe' => '🇪🇺 Европа', 'asia' => '🌏 Азия', 'america' => '🗽 Америка'];
                            echo $catNames[$post->getCategory()] ?? '🌍 Другое';
                        ?>
                    </span>
                </div>
                <div class="post-date">📅 <?php echo $post->getCreatedAt(); ?></div>
                <p class="post-excerpt"><?php echo htmlspecialchars(substr($post->getContent(), 0, 150)); ?>...</p>
                <a href="/posts/<?php echo $post->getId(); ?>" class="btn" style="display: inline-block; margin-top: 15px;">Читать →</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php 
                        $currentUser = User::getById($_SESSION['user_id']);
                        $canModify = $currentUser && ($currentUser->isAdmin() || $post->getUserId() == $currentUser->getId());
                    ?>
                    <?php if ($canModify): ?>
                        <div class="post-actions">
                            <a href="/posts/<?php echo $post->getId(); ?>/edit" style="color: #667eea; font-size: 12px; margin-right: 10px;">✏️ Редактировать</a>
                            <a href="/posts/delete/<?php echo $post->getId(); ?>" style="color: #dc3545; font-size: 12px;" onclick="return confirm('Удалить эту статью?')">🗑️ Удалить</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>