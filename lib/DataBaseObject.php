<?php

abstract class DataBaseObject extends Entity
{

    protected array $modified = [];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    protected function _pre_save()
    {
        return $this->data;
    }

    /**
     * @param $id
     * @return DataBaseObject
     */
    public static function getOneById($id)
    {
        $row = Db::row('SELECT * FROM ' . static::TABLE . ' WHERE id=:id', ['id' => $id]);
        return $row ? new static($row) : null;
    }

    /**
     * @return int
     */
    public static function getTotalEntries()
    {
        return Db::row('SELECT COUNT(*) FROM ' . static::TABLE)['count'];
    }


    /**
     * @param array $filters
     * @param string $sortBy
     * @param string $sortDirection
     * @param int $page
     * @param int $limit
     * @return array|bool
     */
    public static function getAll(array $filters = [], $sortBy, $sortDirection = 'asc', $page = 1, $limit = 10)
    {
        if ($page < 1) {
            return false;
        }

        if ($sortDirection && !in_array($sortDirection, ['asc', 'desc'])) {
            return false;
        }

        $cond = self::filtersToConditions($filters);

        $params['limit'] = (int)$limit;
        $params['offset'] = (int)($page - 1) * $limit;

        $count = self::getTotalEntries();

        $data = Db::query(
            'SELECT * FROM '
            . static::TABLE . ($cond ? ' WHERE ' . $cond : '')
            . ($sortBy ? ' ORDER BY ' . $sortBy . ' ' . $sortDirection : '')
            . ' LIMIT :limit'
            . ' OFFSET :offset',
            $params
        );

        $paging = [
            'total_entries' => $count,
            'total_pages' => ceil($count / $limit),
            'page_number' => $page
        ];

        return ['data' => $data, 'paging' => $paging];
    }

    protected static function filtersToConditions(array $params)
    {
        $cond = [];
        foreach ($params as $fname => $val) {
            if (is_array($val)) {
                $cond[] = "$fname IN (" . join(',', array_map(fn($item) => Db::esc($item), $val)) . ')';
            } else {
                $cond[] = "$fname = :$fname";
            }
        }
        return join(' AND ', $cond);
    }

    public function save()
    {
        $data = $this->_pre_save();
        if ($this->id) {
            $data = array_intersect_key($data, $this->modified);
            if (count($data) > 0) {
                return Db::update(static::TABLE, $data, ['id' => $this->id]);
            } else {
                return true;
            }
        } else {
            $this->data['id'] = Db::insert(static::TABLE, $data, 'id');
            return true;
        }
    }

    public function &__get($name) {
        return parent::__get($name);
    }

    public function __set($name, $val) {
        if ($this->data[$name] != $val) {
            $this->modified[$name] = true;
        }
        parent::__set($name, $val);
    }

}
