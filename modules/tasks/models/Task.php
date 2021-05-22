<?php

/**
 * Class Task
 * @property string $id [integer]
 * @property string $name [varchar(50)]
 * @property string $email [varchar(320)]
 * @property string $text [text]
 * @property bool $complete [boolean]
 * @property bool $edit_by_admin [boolean]
 */
class Task extends DataBaseObject {

  const TABLE = 'tasks';

}
