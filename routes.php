<?php

return [
    'GET,POST /tasks/(\d+)' => 'tasks/form?id=$1',
    'GET,POST /tasks/add' => 'tasks/form',
    'GET,POST /(sign(in|out))' => 'user/$1',
];
