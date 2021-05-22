<?php

class Db
{

    private static $conn;
    private static $last_result;
    public static $log = [];

    public static function init()
    {
        if (!self::$conn) {
            self::connect(Config::get('db'));
        }
    }

    public static function connect(array $params)
    {
        self::$conn = pg_connect(
            "host={$params['host']} user={$params['user']} password={$params['pwd']} dbname={$params['dbname']}"
        );
    }

    public static function exec($query, array $bindings = [])
    {
        self::init();
        foreach ($bindings as &$value) {
            $value = self::esc($value);
        }
        $query = str_replace(
            array_map(
                function ($k) {
                    return ':' . $k;
                },
                array_keys($bindings)
            ),
            array_values($bindings),
            $query
        );
        self::$last_result = pg_query(self::$conn, $query);
        return self::$last_result;
    }

    public static function query($query, array $bindings = [], $key = 'id')
    {
        $result = self::exec($query, $bindings);
        if (is_bool($result)) {
            return $result;
        }

        $rows = [];
        while ($row = pg_fetch_assoc($result)) {
            if (isset($row[$key])) {
                $rows[$row[$key]] = $row;
            } else {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public static function row($query, array $bindings = [])
    {
        $result = self::query($query, $bindings);
        if (is_array($result)) {
            $result = reset($result);
        }
        return $result;
    }

    public static function insert($table, array $data, $ret = false)
    {
        $cols = $vals = [];
        foreach ($data as $k => $v) {
            $cols[] = '"' . $k . '"';
            $vals[] = self::esc($v);
        }
        $cols = join(',', $cols);
        $vals = join(',', $vals);
        self::exec("INSERT INTO ${table} (${cols}) VALUES (${vals})" . ($ret ? ' RETURNING ' . $ret : ''));
        if ($ret) {
            return pg_fetch_assoc(self::$last_result)['id'];
        }
    }

    public static function update($table, array $data, array $cond)
    {
        return self::exec(
            'UPDATE ' . $table . ' SET ' . join(', ', self::esc($data, false)) . ' WHERE ' . join(
                ' AND ',
                self::esc($cond)
            )
        );
    }

    public static function esc($value, $cond = true)
    {
        self::init();

        if (is_array($value)) {
            $escaped = [];
            foreach ($value as $k => $v) {
                $v = self::esc($v);
                $escaped[] = '"' . $k . '" ' . ($cond && $v === 'NULL' ? 'IS NULL' : '= ' . $v);
            }
            return $escaped;
        }

        if (is_string($value)) {
            $value = pg_escape_literal(self::$conn, $value);
        }

        if (is_bool($value)) {
            $value = $value ? 'TRUE' : 'FALSE';
        }

        if (is_null($value)) {
            $value = 'NULL';
        }

        return $value;
    }

}
