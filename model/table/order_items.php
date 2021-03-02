<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/sqlHelp.php";
class OrderItems extends CRUD
{
    private $table = "order_items";
    protected $order_id = "order_id";
    protected $product_id = "product_id";
    protected $quantity = "quantity";
    protected $color = "color";
    protected $size = "size";
    protected $sub_total = "sub_total";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function add(array $array)
    {
        $data = [];
        $data[$this->order_id] = $array["order_id"];
        $data[$this->product_id] = $array["product_id"];
        $data[$this->quantity] = $array["quantity"];
        $data[$this->color] = $array["color"];
        $data[$this->size] = $array["size"];
        $data[$this->sub_total] = $array["sub_total"];
        $data = clean_array($data);
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_order_item_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function get_last_order_item_id()
    {
        $last_id = $this->get_last_id($this->table);
        return $last_id;
    }
}
