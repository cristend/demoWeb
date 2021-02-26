<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
class Carts extends CRUD
{
    private $table = "carts";
    protected $id = "id";
    protected $user_id = "user_id";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function add($user_id)
    {
        $data = [];
        $data[$this->user_id] = $user_id;
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_cart_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function edit($id, array $array)
    {
        $data[$this->products_id] = $array['products_id'];
        $condition = $this->id . "=?";
        $params = [$id];
        $this->update($this->table, $data, $condition, $params);
    }

    public function get_cart($user_id)
    {
        $connection = $this->user_id . "=?";
        $params = [$user_id];
        $cart = $this->read_one($this->table, "*", $connection, $params);
        if ($cart) {
            $cart = $this->fetch_object($this, $cart);
            return return_success($cart);
        }
        return return_fail();
    }

    public function get_last_cart_id()
    {
        $last_id = $this->get_last_id($this->table);
        return $last_id;
    }
}
