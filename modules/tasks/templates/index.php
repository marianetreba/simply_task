<?

/**
 * @var Task $tasks
 * @var array $links
 */


View::$title = 'Задачи'

?>
<h1><?= View::$title ?></h1>
<div class="actions d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-primary" href="/tasks/add">Новая задача</a>
</div>
<? View::includePartial('global/paging', ['paging' => $tasks['paging']]) ?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th><a href="<?= $links['name'] ?>">Имя пользователя</a></th>
            <th><a href="<?= $links['email'] ?>">E-mail</a></th>
            <th>Текст задачи</th>
            <th><a href="<?= $links['complete'] ?>">Статус</a></th>
            <th>Отредактировано администратором</th>
            <?
            if (User::$id): ?>
                <th></th>
            <?
            endif ?>
        </tr>
        </thead>
        <tbody>

        <?
        foreach ($tasks['data'] ?? [] as $task): ?>
            <tr>
                <td><?= $task['id'] ?></td>
                <td><?= Str::htmlSpecialChars($task['name']) ?></td>
                <td><?= Str::htmlSpecialChars($task['email']) ?></td>
                <td><?= Str::htmlSpecialChars($task['text']) ?></td>
                <td><?= $task['complete'] === "t" ? 'Выполнено' : 'Новая' ?></td>
                <td><?= $task['edit_by_admin'] === "t" ? 'Да' : 'Нет' ?></td>
                <? if (User::$id): ?>
                    <th><a href="/tasks/<?= $task['id'] ?>">Редактировать</a></th>
                <? endif ?>
            </tr>
        <?
        endforeach ?>
        </tbody>
    </table>
</div>
