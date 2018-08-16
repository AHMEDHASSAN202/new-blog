<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */
namespace Application\Models;
use System\App;
use System\Model;

class usersModel extends Model
{

    /**
     * Table Name
     *
     * @var string
     */
    public $_table = 'users';

    /**
     * Permissions Table
     *
     * @var string
     */
    private $_permissionsTable;

    /**
     * User Info
     *
     * @var null
     */
    private $_user = null;

    /**
     * UsersModel constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_permissionsTable = $this->app->load->model('privilegedUser')->_permissionsTable;
    }

    /**
     * Get Users
     *
     * @param $limit
     * @param $offset
     * @param $orderColumn
     * @param $orderSort
     * @param $where
     * @return mixed
     */
    public function getUsers($limit, $offset, $orderColumn, $orderSort, $where = 'true')
    {
        $users = $this->app->db->select('users.id AS userID, users_group.permission, users.users_group_id, CONCAT(users.first_name, " ", users.last_name) as name, users.email, from_unixtime(users.created, "%b %d, %Y, %h:%i %p") AS createdDate')
                        ->join('INNER JOIN users_group ON users.users_group_id = users_group.id')
                        ->limit($limit, $offset)
                        ->orderBy($orderColumn, $orderSort)
                        ->where($where)
                        ->fetchAll($this->_table);
        array_map(function($stdClass) {
            $stdClass->view = hasPermission('viewUser') ? setLink('admin/users/view/'.$stdClass->userID) : false;
            $stdClass->edit = hasPermission('editUser') ? setLink('admin/users/modal/'.$stdClass->userID) : false;
            $stdClass->delete = hasPermission('deleteUser') ? setLink('admin/users/delete/'.$stdClass->userID) : false;
        }, $users);
        return $users;
    }

    /**
     * Auth User
     *
     * @param $code
     * @return bool
     */
    public function authUser($code)
    {
        $user = $this->db->select(
                    'id', 'users_group_id',
                    'first_name', 'last_name',
                    'email', 'image', 'verified' )
                    ->from($this->_table)
                    ->where('code = ? AND users_group_id != 0 AND verified = 1 AND status = 1', $code)
                    ->fetch();
        if ($user) {
            $this->_user = $user;
            return true;
        }
        return false;
    }

    /**
     * Get User Info
     *
     * @return null
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Get Count Users
     *
     * @param $where
     * @return int
     */
    public function countUsers($where='true')
    {
        return $this->app->db->select('COUNT(id) as count_users')
                             ->where($where)
                             ->fetch($this->_table)->count_users;
    }

    /**
     * Search Users
     *
     * @param $value
     * @return mixed
     */
    public function searchUsers($value)
    {
        return $this->db->select('users.id, users_group.permission, CONCAT(users.first_name, " ", users.last_name) AS name, users.email, from_unixtime(users.created, "%b %d, %Y, %h:%i %p") AS createdDate')
                        ->join('INNER JOIN users_group ON users.users_group_id = users_group.id')
                        ->where('CONCAT(users.first_name, " ", users.last_name) LIKE "%'.$value.'%"')->fetchAll($this->_table);
    }

    /**
     * Add New User
     *
     * @param $data
     * @return bool
     */
    public function add($data)
    {
        return $this->db->table($this->_table)->data($data)->insert()->count() ? true : false;
    }

    /**
     * Edit User
     *
     * @param $data
     * @param $id
     * @return bool
     */
    public function edit($data, $id)
    {
        return $this->db->table($this->_table)->data($data)->where('id = ?', $id)->update()->count() ? true : false;
    }

}