<?php 
use application\assets\DemoJavascriptAsset;
use ItForFree\SimpleMVC\Router\WebRouter;

DemoJavascriptAsset::add();
?>

<h1><?= $homepageTitle ?></h1>

<?php if (!empty($articles)): ?>
    <ul id="headlines">
    <?php foreach ($articles as $article): ?>
        <li>
            <h2>
                <a href="<?= WebRouter::link('note/view&id=' . $article->id) ?>">
                    <?= htmlspecialchars($article->title) ?>
                </a>
            </h2>
            <p class="pubDate"><?= date('j F Y', strtotime($article->publicationDate)) ?></p>
            <p class="summary"><?= htmlspecialchars(substr($article->content, 0, 200)) ?>...</p>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Статей пока нет.</p>
<?php endif; ?>