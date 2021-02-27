<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
class CartItems extends CRUD
{
    private $table = "cart_items";
    protected $id = "id";
    protected $cart_id = "cart_id";
    protected $product_id = "product_id";
    protected $quantity = "quantity";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function add(array $array)
    {
        $data = [];
        $data[$this->cart_id] = $array["cart_id"];
        $data[$this->product_id] = $array["product_id"];
        $data[$this->quantity] = $array["quantity"];
        $data = clean_array($data);
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_cart_item_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function edit(array $array, $product_id)
    {
        $data = [];
        $data[$this->quantity] = $array["quantity"];
        $condition = $this->product_id . "=?";
        $params = [$product_id];
        $this->update($this->table, $data, $condition, $params);
    }

    public function count_item()
    {
        $selects = "COUNT(DISTINCT " . $this->product_id . ")";
        $count = $this->read_one($this->table, $selects);
        if ($count) {
            $count = $count[0];
            return $count;
        }
    }

    public function get_last_cart_item_id()
    {
        $last_id = $this->get_last_id($this->table);
        return $last_id;
    }

    public function get_cart_item_or_fail($product_id)
    {
        $condition = $this->product_id . "=?";
        $params = [$product_id];
        $cart_item = $this->get_first_or_fail($this->table, $condition, $params);
        if ($cart_item) {
            $cart_item = $this->fetch_object($this, $cart_item);
            return $cart_item;
        }
        return false;
    }
}
