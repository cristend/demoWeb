<?php
class CRUD
{
    private $connection;
    public function __construct($db)
    {
        $this->connection = $db;
    }
    public function create(string $table, array $data = array())
    {
        $params = [];
        $query = "";
        $create_query = "INSERT INTO " . $table . " (";
        $value_query = ") VALUES (";
        foreach ($data as $col => $value) {
            $create_query = $create_query . $col . ", ";
            array_push($params, $value);
            $value_query = $value_query . "?, ";
        }
        $create_query = rtrim($create_query, ", ");
        $value_query = rtrim($value_query, ", ") . ")";
        $query = $create_query . $value_query;
        $stmt = $this->bind_execute($query, $params);
        return $stmt;
    }

    public function create_one(string $table, array $data = array())
    {
        $this->create($table, $data);
        $this->commit();
    }

    public function create_list(string $table, array $data = array())
    {
        foreach ($data as $value) {
            $this->create($table, $value);
        }
        $this->commit();
    }

    private function read(
        string $table,
        string $selects,
        string $condition,
        array $params,
        array $order_by,
        string $sort_by,
        string $limit,
        string $offset
    ) {
        $query = "";
        $select_query = "SELECT " . $selects;
        $from_query = " FROM " . $table;
        $query = $query . $select_query . $from_query;
        if ($condition) {
            $query = $query . " WHERE " . $condition;
        }
        if ($order_by) {
            $order_col = "";
            foreach ($order_by as $col) {
                $order_col = $order_col . $col . ", ";
            }
            $order_col = rtrim($order_col, ", ");
            $query = $query . " ORDER BY " . $order_col . " " . $sort_by;
        }
        if ($limit) {
            $query = $query . " LIMIT ? ";
            array_push($params, $limit);
        }
        if ($offset) {
            $query = $query . " OFFSET ? ";
            array_push($params, $offset);
        }
        $stmt = $this->bind_execute($query, $params);
        if ($stmt) {
            return $stmt->get_result();
        }
        return null;
    }

    public function read_one(
        string $table,
        string $selects = "*",
        string $condition = "",
        array $params = [],
        array $order_by = [],
        string $sort_by = "ASC",
        string $limit = "",
        string $offset = ""
    ) {
        $result = $this->read($table, $selects, $condition, $params, $order_by, $sort_by, $limit, $offset);
        if ($result) {
            return $result->fetch_row();
        }
        return null;
    }

    public function read_all(
        string $table,
        string $selects = "*",
        string $condition = "",
        array $params = [],
        array $order_by = [],
        string $sort_by = "ASC",
        string $limit = "",
        string $offset = ""
    ) {
        $result = $this->read($table, $selects, $condition, $params, $order_by, $sort_by, $limit, $offset);
        if ($result) {
            return $result->fetch_all();
        }
        return null;
    }

    public function update(string $table, array $data = [], string $condition = "", array $con_params = [])
    {
        $set_params = [];
        $query = "";
        $update_query = "UPDATE " . $table;
        $set_query = " SET ";
        foreach ($data as $col => $value) {
            $set_query = $set_query . $col . "= ?, ";
            array_push($set_params, $value);
        }
        $set_query = rtrim($set_query, ", ");
        $query = $query . $update_query . $set_query;
        if ($condition) {
            $query = $query . " WHERE " . $condition;
        }
        $params = array_merge($set_params, $con_params);
        $stmt = $this->bind_execute($query, $params);
        if ($stmt) {
            $this->connection->commit();
            return true;
        }
    }

    public function delete(string $table, $condition, $params)
    {
        $query = "DELETE FROM " . $table . " WHERE ";
        if ($condition) {
            $query = $query . $condition;
        }
        $stmt = $this->bind_execute($query, $params);
        if ($stmt) {
            $this->connection->commit();
            return true;
        }
    }

    public function bind_execute(string $query, array $params)
    {
        try {
            $stmt = $this->connection->prepare($query);
        } catch (mysqli_sql_exception $e) {
            logError($e . "\n" . $query);
            $stmt = false;
        }
        if ($stmt) {
            if ($params) {
                $len_params = count($params);
                $format = str_repeat("s", $len_params);

                try {
                    $stmt->bind_param($format, ...$params);
                } catch (\Throwable $th) {
                    logError($th . "\n" . $query);
                }
            }

            try {
                $stmt->execute();
            } catch (\Throwable $th) {
                $this->connection->rollback();
                logError($th . "\n" . $query);
            }
            return $stmt;
        }

        return null;
    }

    public function execute($query)
    {
        try {
            $result = $this->connection->query($query);
        } catch (\Throwable $th) {
            $this->connection->rollback();
            $error = "execute error \n" . $th;
            logError($error);
        }
        if ($result) {
            $this->commit();
            return $result;
        }
        return $result;
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function close()
    {
        $this->connection->close();
    }
}
