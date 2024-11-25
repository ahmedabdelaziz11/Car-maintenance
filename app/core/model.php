<?php


namespace MVC\core;

class model
{
    protected $connection;
    protected $sql;
    protected $table;

    public function __construct()
    {
        $this->connection = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
    }

    private function escapeColumns($columns)
    {
        return implode(', ', array_map(fn($col) => "`" . mysqli_real_escape_string($this->connection, $col) . "`", $columns));
    }

    private function escapeValues($values)
    {
        return implode(', ', array_map(fn($val) => "'" . mysqli_real_escape_string($this->connection, $val) . "'", $values));
    }

    public function select(array $columns = [])
    {
        $columnsList = empty($columns) ? '*' : implode(', ', array_map(fn($col) => $col === '*' ? $col : "" . mysqli_real_escape_string($this->connection, $col) . "", $columns));
        $this->sql = "SELECT $columnsList FROM `$this->table`";
        return $this;
    }

    public function delete($id)
    {
        $this->sql = "DELETE FROM `$this->table` WHERE `id` = '" . mysqli_real_escape_string($this->connection, $id) . "'";
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $escapedColumn = "" . mysqli_real_escape_string($this->connection, $column) . "";
        $escapedValue = "'" . mysqli_real_escape_string($this->connection, (string) $value) . "'";
        if (strpos((string)$this->sql, 'WHERE') !== false) {
            $this->sql .= " AND $escapedColumn $operator $escapedValue";
        } else {
            $this->sql .= " WHERE $escapedColumn $operator $escapedValue";
        }
        return $this;
    }

    public function whereIn($column, $values)
    {
        $escapedColumn = "" . mysqli_real_escape_string($this->connection, $column) . "";

        $escapedValues = array_map(function($value) {
            return "'" . mysqli_real_escape_string($this->connection, $value) . "'";
        }, $values);

        $escapedValuesStr = implode(',', $escapedValues);

        if (strpos($this->sql, 'WHERE') !== false) {
            $this->sql .= " AND $escapedColumn IN ($escapedValuesStr)";
        } else {
            $this->sql .= " WHERE $escapedColumn IN ($escapedValuesStr)";
        }

        return $this;
    }

    public function row()
    {
        $query = mysqli_query($this->connection, $this->sql);
        if ($query) {
            return mysqli_fetch_assoc($query);
        }
        return null;
    }

    public function insert($data)
    {
        $columns = array_keys($data);
        $values = array_values($data);
        $this->sql = "INSERT INTO `$this->table` (" . $this->escapeColumns($columns) . ") VALUES (" . $this->escapeValues($values) . ")";
        return $this;
    }

    public function execute()
    {
        mysqli_query($this->connection, $this->sql);

        if (strpos($this->sql, 'INSERT') !== false) {
            return mysqli_insert_id($this->connection);
        }
    
        return mysqli_affected_rows($this->connection);
    }

    public function all()
    {
        $query = mysqli_query($this->connection, $this->sql);
        if ($query) {
            return mysqli_fetch_all($query, MYSQLI_ASSOC);
        }
        return [];
    }

    public function join($table, $condition)
    {
        $this->sql .= " INNER JOIN $table ON $condition";
        return $this;
    } 
    
    public function leftJoin($table, $condition)
    {
        $this->sql .= " LEFT JOIN $table ON $condition";
        return $this;
    }   

    public function orderBy($columns, $direction = 'ASC')
    {
        if (is_array($columns)) {
            $columnsList = $this->escapeColumns($columns);
        } else {
            $columnsList = "`" . mysqli_real_escape_string($this->connection, $columns) . "`";
        }

        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->sql .= " ORDER BY $columnsList $direction";
        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $limit = intval($limit);
        $offset = intval($offset);
        $this->sql .= " LIMIT $limit OFFSET $offset";
        return $this;
    }

    public function update($data)
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "`" . mysqli_real_escape_string($this->connection, $column) . "` = '" . mysqli_real_escape_string($this->connection, $value) . "'";
        }
        $this->sql = "UPDATE `$this->table` SET " . implode(', ', $set);
        return $this;
    }
}
