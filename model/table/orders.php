<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/sqlHelp.php";
class Orders extends CRUD
{
    private $table = "orders";
    protected $id = "id";
    protected $cart_items_id = "cart_item_id";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function add(array $array)
    {
        $data = [];
        $data[$this->id] = $array["id"];
        $data[$this->cart_items_id] = $array["cart_items_id"];
        $data = clean_array($data);
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_order_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function get_last_order_id()
    {
        $last_id = $this->get_last_id($this->table);
        return $last_id;
    }
}
