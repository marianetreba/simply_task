<?php

$page = (int)$_GET['page'] ?: 1;
$sortBy = $_GET['sortBy'];
$sortDirection = $_GET['sortDirection'];

$sortAbleFields = ['name', 'email', 'complete'];
if ($sortBy && !in_array($sortBy, $sortAbleFields)) die;

$tasks = Task::getAll([], $sortBy, $sortDirection, $page, 3);
$links = LinkGenerate::sortLinks($sortAbleFields);
