<?php

abstract class Entity implements ArrayAccess, Iterator
{

    protected array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function set($data)
    {
        foreach ($data as $name => $val) {
            if (is_a($this->$name, 'Entity')) {
                $this->$name->set($val);
            } else {
                $this->$name = $val;
            }
        }
        return $this;
    }


    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __set($name, $val)
    {
        $this->data[$name] = $val;
    }

    public function &__get($name)
    {
        return $this->data[$name];
    }

    public function offsetExists($name)
    {
        return isset($this->$name);
    }

    public function offsetGet($name)
    {
        return $this->$name;
    }

    public function offsetSet($name, $val)
    {
        $this->$name = $val;
    }

    public function offsetUnset($name)
    {
        $this->$name = null;
    }

    public function rewind()
    {
        reset($this->data);
    }

    public function current()
    {
        return current($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function next()
    {
        next($this->data);
    }

    public function valid()
    {
        return false;
    }

}
