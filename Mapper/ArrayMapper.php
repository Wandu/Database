<?php
namespace Wandu\Database\Mapper;

use Wandu\Database\Contracts\MapperInterface;

class ArrayMapper implements MapperInterface 
{
    /** @var array|string[] */
    private $map;

    /**
     * @param array|string[] $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * {@inheritdoc}
     */
    public function map($name)
    {
        return isset($this->map[$name]) ? $this->map[$name] : $name;
    }
}
