<?

/** @var string $content */

?>
<!DOCTYPE html>
<html lang="<?= Config::get('default_lang') ?>">
<head>
    <title><?= View::getTitle() ?></title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>
<body>

<? if ($_GET['status'] === 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Готово!</strong> Ваше действие выполнено успешно.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<? endif; ?>


<div class="container">

    <nav class="navbar navbar-dark bg-primary justify-content-md-end">
        <? if (User::$id): ?>
            <a href="/user/signout" class="navbar-brand">Выйти</a>
        <? else: ?>
            <a href="/user/signin" class="navbar-brand">Авторизация</a>
        <? endif ?>
    </nav>

    <?= $content ?>

</div>

</body>
</html>
