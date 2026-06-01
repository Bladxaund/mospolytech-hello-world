<?php include __DIR__ . '/../header.php'; ?>

<div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    <div style="font-size: 48px; text-align: center; margin-bottom: 20px;">
        <?php 
            $icons = ['europe' => '🇪🇺', 'asia' => '🌏', 'america' => '🗽'];
            echo $icons[$post->getCategory()] ?? '🌍';
        ?>
    </div>
    <h1 style="font-size: 32px; margin-bottom: 15px; color: #333; text-align: center;"><?= htmlspecialchars($post->getTitle()) ?></h1>
    <div style="text-align: center; color: #999; margin-bottom: 20px;">
        📅 <?= $post->getCreatedAt() ?> | <?= $post->getCategoryName() ?>
    </div>
    <div style="line-height: 1.8; color: #555;"><?= nl2br(htmlspecialchars($post->getContent())) ?></div>
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <?php $user = User::getById($_SESSION['user_id']); ?>
    <?php if ($user && $user->isAdmin()): ?>
        <div style="margin: 20px 0; text-align: center;">
            <a href="/posts/<?= $post->getId() ?>/edit" class="btn btn-secondary">✏️ Редактировать</a>
            <a href="/posts/delete/<?= $post->getId() ?>" class="btn btn-danger" style="margin-left: 10px;" onclick="return confirm('Удалить?')">🗑️ Удалить</a>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="comments-section">
    <h3 style="color: #333; margin-bottom: 20px;">💬 Отзывы</h3>
    
    <?php if ($isLoggedIn): ?>
        <form method="post" action="/comments/add" style="margin-bottom: 30px;">
            <input type="hidden" name="post_id" value="<?= $post->getId() ?>">
            <textarea name="text" rows="4" style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px;" placeholder="Поделитесь впечатлениями..."></textarea>
            <button type="submit" class="btn" style="margin-top: 15px;">💬 Оставить отзыв</button>
        </form>
    <?php else: ?>
        <p><a href="/auth/login" style="color: #667eea;">Войдите</a>, чтобы оставить комментарий</p>
    <?php endif; ?>
    
    <?php if (empty($comments)): ?>
        <p>Пока нет отзывов. Будьте первым!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <?php $author = $comment->getUser(); ?>
            <div class="comment">
                <div class="comment-author">
                    👤 <?= htmlspecialchars($author->getNickname()) ?>
                    <span class="comment-date"><?= $comment->getCreatedAt() ?></span>
                </div>
                <div class="comment-text"><?= nl2br(htmlspecialchars($comment->getText())) ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>