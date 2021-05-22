<?
/** @var Task $task */

/** @var form $form */

View::$title = !$task ? 'Новая задача' : 'Редактировать задачу' ?>
<h1><?= View::$title ?></h1>
<form class="autoprocess" action="/tasks/<?= $task ? $task->id : 'add' ?>" method="post">
    <fieldset>
        <legend>Пользователь:</legend>
        <div class="c req"><label>Имя</label>
            <input class="form-control" name="name" value="<?= $task->name ?? '' ?>" <?= $task->name ? 'disabled' : '' ?> required></div>
        <div class="c req">
            <label>E-mail</label>
            <input class="form-control" name="email" value="<?= $task->email ?? '' ?>" <?= $task->email ? 'disabled' : '' ?> required
                   type="email">
        </div>
    </fieldset>
    <fieldset>
        <legend>Задача:</legend>
        <div class="c req">
            <label>Текст задачи</label>
            <textarea class="form-control" name="text" required><?= $task->text ?? '' ?></textarea>
        </div>
        <?
        if ($task): ?>
            <div class="c"><label>Выполнено</label>
                <label class="inline checkbox" title="">
                    <input type="checkbox" name="complete" value="1" <?= $task->complete === 't' ? 'checked' : '' ?>>
                </label>
            </div>
        <?
        endif ?>
    </fieldset>
    <div class="actions d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary" type="submit"><?= !$task ? 'Добавить' : 'Сохранить' ?></button>
    </div>
</form>
