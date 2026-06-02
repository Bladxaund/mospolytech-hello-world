<?php include __DIR__ . '/../header.php'; ?>

<div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    
    <!-- Заголовок -->
    <h1 style="font-size: 32px; margin-bottom: 15px; color: #333; text-align: center;"><?= htmlspecialchars($post->getTitle()) ?></h1>
    
    <!-- Мета-информация -->
    <div style="text-align: center; color: #999; margin-bottom: 20px;">
        <?php 
            $author = User::getById($post->getUserId());
            $categoryNames = ['europe' => '🇪🇺 Европа', 'asia' => '🌏 Азия', 'america' => '🗽 Америка'];
        ?>
        📅 <?= $post->getCreatedAt() ?> | 
        👤 <?= htmlspecialchars($author->getNickname()) ?> | 
        <?= $categoryNames[$post->getCategory()] ?? '🌍 Другое' ?>
    </div>
    
    <!-- ИЗОБРАЖЕНИЕ СТАТЬИ (по ссылке) -->
    <?php 
        $image = $post->getImage();
        $hasImage = $image && $image !== 'default.jpg';
    ?>
    
    <?php if ($hasImage): ?>
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($post->getTitle()) ?>" style="max-width: 100%; max-height: 500px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
        </div>
    <?php else: ?>
        <div style="text-align: center; margin-bottom: 30px; padding: 40px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 15px;">
            <span style="font-size: 64px;">📷</span>
            <p style="color: white; margin-top: 10px;">Нет изображения</p>
        </div>
    <?php endif; ?>
    
    <!-- Содержание статьи -->
    <div style="line-height: 1.8; color: #555; font-size: 16px;">
        <?= nl2br(htmlspecialchars($post->getContent())) ?>
    </div>
</div>

<!-- Кнопки для админа или автора статьи -->
<?php if (isset($canModify) && $canModify): ?>
    <div style="margin: 20px 0; text-align: center;">
        <a href="/posts/<?= $post->getId() ?>/edit" class="btn btn-secondary" style="margin-right: 10px;">✏️ Редактировать</a>
        <a href="/posts/delete/<?= $post->getId() ?>" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту статью?')">🗑️ Удалить</a>
    </div>
<?php endif; ?>

<!-- Комментарии -->
<div class="comments-section">
    <h3 style="color: #333; margin-bottom: 20px;">💬 Комментарии</h3>
    
    <?php if ($isLoggedIn): ?>
        <form method="post" action="/comments/add" style="margin-bottom: 30px;">
            <input type="hidden" name="post_id" value="<?= $post->getId() ?>">
            <textarea name="text" rows="4" style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 14px;" placeholder="Поделитесь впечатлениями..." required></textarea>
            <button type="submit" class="btn" style="margin-top: 15px;">💬 Оставить комментарий</button>
        </form>
    <?php else: ?>
        <p style="margin-bottom: 20px;">
            <a href="/auth/login" style="color: #667eea;">Войдите</a>, чтобы оставить комментарий
        </p>
    <?php endif; ?>
    
    <?php if (empty($comments)): ?>
        <p style="color: #999;">Пока нет комментариев. Будьте первым!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <?php $commentAuthor = $comment->getUser(); ?>
            <div class="comment">
                <div class="comment-author">
                    👤 <?= htmlspecialchars($commentAuthor->getNickname()) ?>
                    <span class="comment-date"><?= $comment->getCreatedAt() ?></span>
                </div>
                <div class="comment-text" style="margin-top: 8px; color: #555;">
                    <?= nl2br(htmlspecialchars($comment->getText())) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>