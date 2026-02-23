<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?= loadCss(STYLE); ?>
    <?= loadCss($css); ?>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <?= $this->content; ?>
        </div>
    </div>
</body>
</html>