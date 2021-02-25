<?php
// include_once('./model/CRUD.php');
include_once "$_SERVER[DOCUMENT_ROOT]/model/CRUD.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
class Users extends CRUD
{
    private $table = "users";
    private $id = "id";
    private $name = "name";
    private $email = "email";
    private $pass = "pass";
    private $permission = "permission";
    private $bio = "bio";
    private $sex = "sex";
    private $phone = "phone";
    private $birth = "birth";
    private $image = "image";
    private $address = "address";
    protected $connection;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function login(array $array)
    {
        $email = $array['email'];
        $password = $array['pass'];
        $condition = $this->email . "=?";
        $params = [$email];
        $user = $this->get_one($condition, $params);
        if ($user) {
            $pass = $user[$this->pass];
            if (password_verify($password, $pass)) {
                return return_success();
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
        return return_success();
    }

    public function edit($id, array $array)
    {
        $data = [];
        $data[$this->id] = $array['id'];
        $data[$this->user_id] = $array['user_id'];
        $data[$this->name] = $array['name'];
        $data[$this->bio] = $array['bio'];
        $data[$this->sex] = $array['sex'];
        $data[$this->phone] = $array['phone'];
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
    public function get_users()
    {
        # code...
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
}
