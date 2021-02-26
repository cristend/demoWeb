<?php
// include_once('./model/CRUD.php');
include_once "$_SERVER[DOCUMENT_ROOT]/model/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
class Users extends CRUD
{
    private $table = "users";
    protected $id = "id";
    protected $name = "name";
    protected $email = "email";
    protected $pass = "pass";
    protected $permission = "permission";
    protected $bio = "bio";
    protected $sex = "sex";
    protected $phone = "phone";
    protected $birth = "birth";
    protected $image = "image";
    protected $address = "address";
    protected $connection;

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function login(array $array)
    {
        $email = $array['email'];
        $password = $array['pass'];
        $condition = $this->email . "=?";
        $params = [$email];
        $user = $this->get_one($condition, $params);
        if ($user['msg'] == 'success') {
            $user = $user['data'];
            $pass = $user[$this->pass];
            if (password_verify($password, $pass)) {
                return return_success($user);
            } else {
                return return_fail();
            }
        }
    }

    public function add(array $array)
    {
        $data = [];
        $data[$this->name] = $array['name'];
        $data[$this->email] = $array['email'];
        $data[$this->bio] = $array['bio'];
        $data[$this->sex] = $array['sex'];
        $data[$this->pass] = password_hash($array['pass'], PASSWORD_DEFAULT);
        // $data[$this->phone] = $array['phone'];
        $data[$this->birth] = $array['birth'];
        // $data[$this->cart] = $array['cart'];
        // $data[$this->image] = $array['image'];
        // $data[$this->address] = $array['address'];
        $data = clean_array($data);
        // 
        $condition = $this->email . "=?";
        $params = [$array['email']];
        $first_or_fail = $this->get_first_or_fail($this->table, $condition, $params);
        if ($first_or_fail) {
            $error = "Email already exist";
            return return_error("", $error, ERROR_TYPE_EXIST);
        }
        // 
        $this->create_one($this->table, $data);
        $last_id = $this->get_last_user_id();
        if ($last_id) {
            return return_success($last_id);
        }
        return return_fail();
    }

    public function edit($id, array $array)
    {
        $data = [];
        $data[$this->name] = $array['name'];
        $data[$this->bio] = $array['bio'];
        $data[$this->sex] = $array['sex'];
        $data[$this->phone] = $array['phone'];
        $data[$this->pass] = $array['pass'];
        $data[$this->birth] = $array['birth'];
        $data[$this->address] = $array['address'];
        $data = clean_array($data);
        // 
        $condition = $this->id . "=?";
        $params = [$id];
        $this->update($this->table, $data, $condition, $params);
    }

    public function edit_image()
    {
        # code...
    }
    public function remove()
    {
        # code...
    }
    public function get_user($id)
    {
        $condition = $this->id . "=?";
        $params = [$id];
        $user = $this->read_one($this->table, "*", $condition, $params);
        if ($user) {
            $user = $this->fetch_object($this, $user);
            if ($user) {
                return return_success($user);
            }
        }
        return return_fail();
    }
    public function get_one($condition, $params)
    {
        $user = $this->get_first_or_fail($this->table, $condition, $params);
        $user = $this->fetch_object($this, $user);
        if ($user) {
            return return_success($user);
        }
        return return_fail();
    }
    public function get_last_user_id()
    {
        return $this->get_last_id($this->table);
    }
    public function construct_user()
    {
        return [
            "name" => "",
            "bio" => "",
            "sex" => "",
            "phone" => "",
            "pass" => "",
            "birth" => "",
            "address" => "",
            "cart_id" => ""
        ];
    }
}
