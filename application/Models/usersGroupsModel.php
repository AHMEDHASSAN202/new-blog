<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Models;

use System\Model;

class usersGroupsModel extends Model
{
    /**
     * Table Name
     *
     * @var string
     */
    public $_table = 'users_group';

    /**
     * Permissions Table
     *
     * @var string
     */
    public $_permissionTable = 'users_group_permissions';

    /**
     * Get All Users Groups
     *
     * @param $fetchDefault
     * @return mixed
     */
    public function getGroups($fetchDefault = \PDO::FETCH_ASSOC)
    {
        $groups = $this->getAll($this->_table, '*', $fetchDefault);
        if ($fetchDefault == \PDO::FETCH_ASSOC) {
            array_walk($groups, function(&$group){
                $group['get'] = hasPermission('viewRoles') ? setLink('admin/roles/get/' . $group['id']) : false;
                $group['edit'] = hasPermission('editRoles') ? setLink('admin/roles/save/' . $group['id']) : false;
                $group['delete'] = hasPermission('deleteRoles') ? setLink('admin/roles/delete/' . $group['id']) : false;
            });
        }
        return $groups;
    }

    /**
     * Add New Group
     *
     * @param $group
     * @return bool
     */
    public function add($group)
    {
        if (!$this->db->data(['permission' => $group['name']])->insert($this->_table)->count()) {
            return false;
        }
        $groupID = $this->db->lastInsertId();
        foreach ($group['roles'] AS $roleName => $roleURL) {
                $this->db->data([
                                 'users_group_id' => $groupID,
                                 'name'           => $roleName,
                                 'url'            => $roleURL
                                ])->insert($this->_permissionTable);
        }
        return $this->db->count() ? true : false;
    }

    /**
     * Get Role
     *
     * @param $id
     * @return mixed
     */
    public function getRole($id)
    {
        $role['name'] = $this->db->select('permission')->where('id = ?', $id)->fetch($this->_table, \PDO::FETCH_ASSOC)['permission'];
        if ($role['name']) {
            $role['permissions'] = $this->db->select('name, url')->where('users_group_id = ?', $id)->fetchAll($this->_permissionTable, \PDO::FETCH_ASSOC);
        }
        return $role;
    }

    /**
     * Delete Group
     *
     * @param $id
     * @return bool
     */
    public function deleteGroup($id)
    {
        $this->db->table($this->app->load->model('users')->_table)->data(['users_group_id' => '0'])
                 ->where('users_group_id = ?', $id)->update();
        return $this->delete($this->_table, $id);
    }

    /**
     * Edit Group
     *
     * @param $id
     * @param $group
     * @return mixed
     */
    public function edit($id, $group)
    {
        $this->db->table($this->_table)->data(['permission' => $group['name']])->where('id = ?', $id)->update();
        $this->db->where('users_group_id = ?', $id)->delete($this->_permissionTable);
        foreach ($group['roles'] AS $roleName => $roleURL) {
            $this->db->data([
                'users_group_id' => $id,
                'name'           => $roleName,
                'url'            => $roleURL
            ])->insert($this->_permissionTable);
        }
        return $this->db->count();
    }

}