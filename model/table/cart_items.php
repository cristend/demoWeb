<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/sqlHelp.php";
class CartItems extends CRUD
{
    private $table = "cart_items";
    protected $id = "id";
    protected $cart_id = "cart_id";
    protected $product_id = "product_id";
    protected $quantity = "quantity";
    protected $color = "color";
    protected $size = "size";
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
        $data[$this->color] = $array["color"];
        $data[$this->size] = $array["size"];
        $data = clean_array($data);
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_cart_item_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function edit_quantity(array $array, $id)
    {
        $data[$this->quantity] = $array["quantity"];
        $condition = $this->id . "=?";
        $params = [$id];
        $this->update($this->table, $data, $condition, $params);
    }

    public function get_cart_items($cart_id)
    {
        $condition = $this->cart_id . "=?";
        $params = [$cart_id];
        $cart_items = $this->read_all($this->table, "*", $condition, $params);
        if ($cart_items) {
            $cart_items = $this->fetch_objects($this, $cart_items);
            if ($cart_items) {
                return return_success($cart_items);
            }
        }
        return return_fail();
    }

    public function get_cart_item($id)
    {
        $condition = $this->id . "=?";
        $params = [$id];
        $cart_item = $this->read_one($this->table, "*", $condition, $params);
        if ($cart_item) {
            $cart_item = $this->fetch_object($this, $cart_item);
            if ($cart_item) {
                return return_success($cart_item);
            }
        }
        return return_fail();
    }

    public function remove($id)
    {
        $condition = $this->id . "=?";
        $params = [$id];
        $this->delete($this->table, $condition, $params);
    }

    public function count_item($cart_id)
    {
        $selects = "count(*)";
        $condition = $this->cart_id . "=?";
        $params = [$cart_id];
        $count = $this->read_one($this->table, $selects, $condition, $params);
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

    public function get_cart_item_or_fail($product_id, $cart_id, array $array)
    {
        $conditions = [
            $this->product_id . "=?",
            $this->cart_id . "=?",
            $this->color . "=?",
            $this->size . "=?"
        ];
        $condition = add_and_condition("", $conditions);
        $params = [$product_id, $cart_id, $array['color'], $array['size']];
        $cart_item = $this->get_first_or_fail($this->table, $condition, $params);
        if ($cart_item) {
            $cart_item = $this->fetch_object($this, $cart_item);
            return $cart_item;
        }
        return false;
    }
}
