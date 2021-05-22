<?php

/** @var Task $task */

$id = (int)$_GET['id'];
if ($id) {
    if (User::$id) {
        $task = Task::getOneById($id);
        Response::forward_404_unless($task);
    } else {
        Response::redirect('/user/signin');
    }
}

if (Request::isMethod('POST')) {
    $data = $_POST;

    $taskData = [
        'text' => $data['text'],
        'complete' => $data['complete'],
    ];
    if (!$task) {
        $task = new Task();
        $taskNewData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];
    } elseif($data['text'] != $task->text) {
        $taskNewData['edit_by_admin'] = "1";
    }

    $_data = array_merge($taskData, $taskNewData ?? []);

    try {
        $task->set($_data)->save();
    } catch (Exception $e) {
        Response::send_json(['errors' => $e->getMessage()]);
    }

    Response::redirect('/tasks?status=success');
}
