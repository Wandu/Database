<?php
namespace Wandu\Database\Schema\Expression;

use Wandu\Database\Schema\ExpressionInterface;
use Wandu\Database\Schema\RawExpression;
use Wandu\Database\Support\Attributes;

/**
 * @see http://dev.mysql.com/doc/refman/5.7/en/create-table.html
 * 
 * CREATE TABLE [IF NOT EXISTS] $table
 *     (create_definition,...)
 *     [table_options]
 * 
 * create_definition:
 *     ColumnExpression
 *   | ConstraintExpression
 * 
 * table_option:
 *     ENGINE [=] engine_name
 *   | [DEFAULT] CHARACTER SET [=] charset_name
 *   | [DEFAULT] COLLATE [=] collation_name
 *
 * @method \Wandu\Database\Schema\Expression\CreateExpression ifNotExists()
 * @method \Wandu\Database\Schema\Expression\CreateExpression engine(string $engine)
 * @method \Wandu\Database\Schema\Expression\CreateExpression charset(string $charset)
 * @method \Wandu\Database\Schema\Expression\CreateExpression collation(string $collation)
 */
class CreateExpression implements ExpressionInterface
{
    use Attributes;
    
    /** @var string */
    protected $table;
    
    /** @var array|\Wandu\Database\Schema\ExpressionInterface[] */
    protected $columns = [];

    /** @var  array|\Wandu\Database\Schema\ExpressionInterface[] */
    protected $constraints = [];
    
    /** @var array */
    protected $options;

    /**
     * @param string $table
     * @param callable $defineHandler
     * @param array $options
     */
    public function __construct($table, callable $defineHandler = null, array $options = [])
    {
        $this->table = $table;
        call_user_func($defineHandler, $this);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function bit($name, $length = 1)
    {
        return $this->addColumn($name, 'bit', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function tinyInteger($name, $length = 4)
    {
        return $this->addColumn($name, 'tinyint', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function smallInteger($name, $length = 6)
    {
        return $this->addColumn($name, 'smallint', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function mediumInteger($name, $length = 9)
    {
        return $this->addColumn($name, 'mediumint', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function integer($name, $length = 11)
    {
        return $this->addColumn($name, 'int', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function bigInteger($name, $length = 20)
    {
        return $this->addColumn($name, 'bigint', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @param int $decimal
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function double($name, $length = null, $decimal = null)
    {
        return $this->addColumn($name, 'real', [
            'length' => $length,
            'decimal' => $decimal,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @param int $decimal
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function float($name, $length = null, $decimal = null)
    {
        return $this->addColumn($name, 'real', [
            'length' => $length,
            'decimal' => $decimal,
        ]);
    }

    /**
     * @param string $name
     * @param int $fsp
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function date($name, $fsp = null)
    {
        return $this->addColumn($name, 'date', [
            'fsp' => $fsp,
        ]);
    }

    /**
     * @param string $name
     * @param int $fsp
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function time($name, $fsp = null)
    {
        return $this->addColumn($name, 'time', [
            'fsp' => $fsp,
        ]);
    }

    /**
     * @param string $name
     * @param int $fsp
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function timestamp($name, $fsp = null)
    {
        return $this->addColumn($name, 'timestamp', [
            'fsp' => $fsp,
        ]);
    }

    /**
     * @param string $name
     * @param int $fsp
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function datetime($name, $fsp = null)
    {
        return $this->addColumn($name, 'datetime', [
            'fsp' => $fsp,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function string($name, $length = 255)
    {
        return $this->addColumn($name, 'varchar', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function char($name, $length = 1)
    {
        return $this->addColumn($name, 'char', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function varchar($name, $length)
    {
        return $this->addColumn($name, 'varchar', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function binary($name, $length = 1)
    {
        return $this->addColumn($name, 'binary', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @param int $length
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function varbinary($name, $length)
    {
        return $this->addColumn($name, 'varbinary', [
            'length' => $length,
        ]);
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function tinyBlob($name)
    {
        return $this->addColumn($name, 'tinyblob');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function blob($name)
    {
        return $this->addColumn($name, 'blob');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function mediumBlob($name)
    {
        return $this->addColumn($name, 'mediumblob');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function longBlob($name)
    {
        return $this->addColumn($name, 'longblob');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function tinyText($name)
    {
        return $this->addColumn($name, 'tinytext');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function text($name)
    {
        return $this->addColumn($name, 'text');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function mediumText($name)
    {
        return $this->addColumn($name, 'mediumtext');
    }

    /**
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function longText($name)
    {
        return $this->addColumn($name, 'longText');
    }

    /**
     * @param string $name
     * @param array $values
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function enum($name, array $values = [])
    {
        return $this->addColumn($name, 'enum', [
            'values' => $values,
        ]);
    }

    /**
     * @param string $name
     * @param array $values
     * @return \Wandu\Database\Schema\Expression\ColumnExpression
     */
    public function set($name, array $values = [])
    {
        return $this->addColumn($name, 'set', [
            'values' => $values,
        ]);
    }

    /**
     * @param string|\Wandu\Database\Schema\ExpressionInterface $name
     * @param string $type
     * @param array $attributes
     * @return \Wandu\Database\Schema\Expression\ColumnExpression|\Wandu\Database\Schema\ExpressionInterface
     */
    public function addColumn($name, $type = null, array $attributes = [])
    {
        if ($name instanceof ExpressionInterface) {
            return $this->columns[] = $name;
        }
        return $this->columns[] = new ColumnExpression($name, $type, $attributes);
    }

    /**
     * @param array|string $column
     * @return \Wandu\Database\Schema\Expression\ConstraintExpression
     */
    public function primaryKey($column)
    {
        return $this->addConstraint($column, null, [
            'key_type' => ConstraintExpression::KEY_TYPE_PRIMARY,
        ]);
    }

    /**
     * @param array|string $column
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ConstraintExpression
     */
    public function uniqueKey($column, $name = null)
    {
        return $this->addConstraint($column, $name, [
            'key_type' => ConstraintExpression::KEY_TYPE_UNIQUE,
        ]);
    }

    /**
     * @param array|string $column
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ConstraintExpression
     */
    public function foreignKey($column, $name = null)
    {
        return $this->addConstraint($column, $name, [
            'key_type' => ConstraintExpression::KEY_TYPE_FOREIGN,
        ]);
    }
    
    /**
     * @param array|string $column
     * @param string $name
     * @return \Wandu\Database\Schema\Expression\ConstraintExpression
     */
    public function index($column, $name = null)
    {
        return $this->addConstraint($column, $name);
    }
    
    /**
     * @param array|string|\Wandu\Database\Schema\ExpressionInterface $column
     * @param string $name
     * @param array $attributes
     * @return \Wandu\Database\Schema\Expression\ConstraintExpression|\Wandu\Database\Schema\ExpressionInterface
     */
    public function addConstraint($column, $name = null, array $attributes = [])
    {
        if ($column instanceof ExpressionInterface) {
            return $this->constraints[] = $column;
        }
        return $this->constraints[] = new ConstraintExpression(
            is_array($column) ? $column : [$column],
            $name,
            $attributes
        );
    }
    
    public function __toString()
    {
        $sql = "CREATE TABLE";
        if (isset($this->attributes['if_not_exists'])) {
            $sql .= ' IF NOT EXISTS';
        }
        $sql .= " `{$this->table}` (\n  ";
        $sql .= implode(",\n  ", array_reduce(array_merge($this->columns, $this->constraints), function ($carry, ExpressionInterface $definition) {
            $definitionAsString = $definition->__toString();
            if ($definitionAsString) {
                $carry[] = $definitionAsString;
            }
            return $carry;
        }, []));
        $sql .= "\n)";
        if (isset($this->attributes['engine'])) {
            $sql .= " ENGINE={$this->attributes['engine']}";
        }
        if (isset($this->attributes['charset'])) {
            $sql .= " CHARSET={$this->attributes['charset']}";
        }
        if (isset($this->attributes['collation'])) {
            $sql .= " COLLATE={$this->attributes['collation']}";
        }
        return $sql;
    }
}
