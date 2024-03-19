<h1><?= $params['post']->title ?></h1>
<div>
    <?php foreach ($params['post']->getTags() as $tag) : ?>
        <span class="badge badge-info"><?= $tag->name ?></span>
    <?php endforeach ?>
</div>
<small><?= $params['post']->created_at ?></small>
<p><?= $params['post']->content ?></p>
<a href="/Prof_Jatsu_Youtube_Site/public/posts" class="btn btn-secondary">Retourner en arrière</a>