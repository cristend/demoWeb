<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
class Products extends CRUD
{
    protected $table = "products";
    protected $id = "id";
    protected $title = "title";
    protected $price = "price";
    protected $variable = "variable";
    protected $quantity = "quantity";
    protected $detail = "detail";
    protected $image = "image";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }
    public function add(array $array)
    {
        $data = [];
        $data[$this->title] = $array['title'];
        $data[$this->price] = $array['price'];
        $data[$this->variable] = $array['variable'];
        $data[$this->quantity] = $array['quantity'];
        $data[$this->detail] = $array['detail'];
        $data[$this->image] = $array['image'];

        $data = clean_array($data);

        $this->create_one($this->table, $data);
        return return_success();
    }
    public function edit()
    {
    }
    public function remove()
    {
    }
    public function get_detail($id)
    {
        $connection = $this->id . "=?";
        $params = [$id];
        $product = $this->get_first_or_fail($this->table, $connection, $params);
        if ($product) {
            $product = $this->fetch_object($this, $product);
            return return_success($product);
        }
        return return_fail();
    }
    public function get_products()
    {
        $products = $this->read_all($this->table);
        if ($products) {
            $products = $this->fetch_objects($this, $products);
            return return_success($products);
        }
        return return_fail();
    }
    public function get_page($limit, $offset = 0)
    {
        $pages = $this->read_page($this->table, $limit, $offset);
        if ($pages) {
            $pages = $this->fetch_objects($this, $pages);
            return return_success($pages);
        }
        return return_fail();
    }
    public function count_products()
    {
        return $this->count($this->table);
    }
}
