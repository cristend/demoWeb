<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/sqlHelp.php";
class Orders extends CRUD
{
    private $table = "orders";
    protected $id = "id";
    protected $user_id = "user_id";
    protected $cart_items_id = "cart_items_id";
    protected $total = "total";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function add(array $array)
    {
        $data = [];
        $data[$this->user_id] = $array["user_id"];
        $data[$this->cart_items_id] = $array["cart_items_id"];
        $data[$this->total] = $array["total"];
        $data = clean_array($data);
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_order_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function find_order($user_id)
    {
        $params = [$user_id];
        $condition = $this->user_id . "=?";
        $orders = $this->read_all($this->table, "*", $condition, $params);
        if ($orders) {
            $orders = $this->fetch_objects($this, $orders);
            if ($orders) {
                return return_success($orders);
            }
        }
        return return_fail();
    }

    public function get_order_by_id($id)
    {
        $condition = $this->id . "=?";
        $params = [$id];
        $order = $this->read_one($this->table, "*", $condition, $params);
        if ($order) {
            $order = $this->fetch_object($this, $order);
            return return_success($order);
        }
        return return_fail();
    }

    public function get_last_order_id()
    {
        $last_id = $this->get_last_id($this->table);
        return $last_id;
    }
}
