<?php
View::$title = 'Страница не найдена';
?>

<h1><?= View::$title ?></h1>
На этом сайте нет страницы <code><?= Str::htmlSpecialChars(rawurldecode($_SERVER['REQUEST_URI'])) ?></code>
