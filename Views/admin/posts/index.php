<h1>Administration des Articles</h1>

<a href="/prof_jatsu_youtube_site/public/admin/posts/create" class="btn btn-success my-3">Creer un nouvel article</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Titre</th>
            <th scope="col">Publié le</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['posts'] as $post) : ?>
            <tr>
                <th scope="row"><?= $post->id ?></th>
                <td><?= $post->title ?></td>
                <td><?= $post->getCreatedAt() ?></td>
                <td>
                    <a href="/Prof_Jatsu_Youtube_Site/public/admin/posts/edit/<?=$post->id?>" class="btn btn-warning">Modifier</a>
                    <form action="/Prof_Jatsu_Youtube_Site/public/admin/posts/delete/<?=$post->id?>" method="post" class="d-inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>