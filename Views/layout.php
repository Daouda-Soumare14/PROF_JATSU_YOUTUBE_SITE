<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super site</title>
    <link rel="stylesheet" href="<?= CHEMIN_SCRIPT . 'css' . DIRECTORY_SEPARATOR . 'app.css' ?>">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/Prof_Jatsu_Youtube_Site/public">Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/Prof_Jatsu_Youtube_Site/public">Aceuil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Prof_Jatsu_Youtube_Site/public/posts">Les derniers articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Prof_Jatsu_Youtube_Site/public/admin/posts">Administration Article</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
</body>

</html>