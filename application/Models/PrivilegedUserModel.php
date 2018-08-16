<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Models;
use System\App;
use System\Model;

class PrivilegedUserModel extends Model
{
    /**
     * Roles Table
     *
     * @var string
     */
    private $_rolesTable = 'users_group';

    /**
     * Permissions Table
     *
     * @var string
     */
    public $_permissionsTable = 'users_group_permissions';

    /**
     * Current User Permissions [name and url]
     *
     * @var array
     */
    private $_userPermissions;

    /**
     * PrivilegedUserModel constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    /**
     * Get Roles
     *
     * @return mixed
     */
    public function getRoles()
    {
        return $this->getAll($this->_rolesTable, '*');
    }

    /**
     * Check if user has a specific privilege
     *
     * @param $value
     * @param $column  [name|url]
     * @return boolean
     */
    public function hasPrivilege($value, string $column)
    {
        $users_group_id = $this->load->model('users')->getUser()->users_group_id;
        $this->_userPermissions = $this->db->select('url, name')->from($this->_permissionsTable)->where('users_group_id = ?', $users_group_id)->fetchAll();
        if ($column == 'url') {
            $permissions = array_column($this->_userPermissions, 'url');
            if (!$this->isMatch($this->ignorePages(), $value)) {
                return $this->isMatch($permissions, $value);
            }
            return true;
        }elseif ($column == 'name') {
            $names = array_column($this->_userPermissions, 'name');
            return in_array($value, $names);
        }
    }


    /**
     * Ignore Pages For Permissions
     *
     * @return array
     */
    public function ignorePages()
    {
        return [
            setLink('admin/logout'),
            setLink('admin/dashboard'),
            setLink('admin/profile'),
        ];
    }

    /**
     * Check if user permissions is match current url
     *
     * @param $URLs
     * @param $currentUrl
     * @return bool
     */
    function isMatch($URLs, $currentUrl)
    {
        foreach($URLs AS $url) {
            $url = $this->app->route->getPattern($url);
            if (preg_match($url, $currentUrl)) {
                return true;
            }
        }
        return false;
    }

}