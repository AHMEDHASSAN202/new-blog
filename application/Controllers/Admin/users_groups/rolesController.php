<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\users_groups;
use System\App;
use System\Controller;

class rolesController extends Controller
{
    /**
     * Model Class
     *
     * @var object
     */
    private $_model;


    /**
     * Roles Controller constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_model = $this->app->load->model('usersGroups');
    }

    /**
     * Index View
     *
     * @return mixed
     */
    public function index()
    {
        $data['title'] = 'Users Groups';
        $data['action'] = setLink('admin/roles/save/0');
        $data['groups'] = $this->_model->getGroups();
        $view = $this->app->view->render('Admin/users_groups/index',$data);
        return $this->adminLayouts->render($view);
    }

    /**
     * Add New Group
     *
     * @return mixed
     */
    public function add() {
        if (!$this->validateData()) {
            $data['errors'] = implode('<br>', $this->validation->getErrors());
        }else {
            $roles = (!empty($this->input->post('roles'))) ? cleanInput($this->input->post('roles')) : [];
            $group = [
                'name'  => cleanInput($this->input->post('groupName')),
                'roles' => $roles
            ];
            if ($this->_model->add($group)) {
                $data['success'] = 'Done!';
                $data['groups'] = $this->_model->getGroups();
            }else {
                $data['errors'] = 'Oops! invalid add Group';
            }
        }
        return $this->app->response->json($data);
    }

    /**
     * Edit Role
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if (!$this->validateData($id) || !is_numeric($id)) {
            $data['errors'] = implode('<br>', $this->validation->getErrors()) ?? 'invalid edit';
        }else {
            $roles = (!empty($this->input->post('roles'))) ? cleanInput($this->input->post('roles')) : [];
            $group = [
                'name'      => cleanInput($this->input->post('groupName')),
                'roles'     => $roles
            ];
            if (!$this->_model->edit($id, $group)) {
                $data['errors'] = 'invalid edit group';
            }else {
                $data['success'] = 'Done!';
                $data['groups'] = $this->_model->getGroups();
            }
        }
        return $this->json($data);
    }

    /**
     * Get Role
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->json($this->_model->getRole($id));
    }

    /**
     * Delete Group
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if ($id != 0) {
            if (!$this->_model->deleteGroup($id)) {
                $data['errors'] = 'Oops! invalid delete';
            }else {
                $data['success'] = 'Done!';
                $data['groups'] = $this->_model->getGroups();
            }
            return $this->app->response->json($data);
        }
        show_404();
    }

    /**
     * Validate data
     *
     * @param $id
     * @return mixed
     */
    public function validateData($id = null)
    {
        $this->app->validation->required('groupName', 'Group name is required')
                              ->specialName('groupName', 'invalid group name')
                              ->required('roles');

        if (is_null($id)) {
            $this->app->validation->unique('groupName', [$this->_model->_table, 'permission'], 'Group name already exists');
        }else {
            $this->app->validation->unique('groupName', [$this->_model->_table, 'permission', 'id', $id], 'Group name already exists');
        }

        $roles = (!empty($this->app->input->post('roles'))) ? $this->app->input->post('roles') : [];

        foreach ($roles as $name => $role) {
            if (!ctype_alnum($name) || !preg_match('/^[a-zA-Z0-9-'. preg_quote('%:.&/','/') .']+$/', $role)) {
                $this->app->validation->addError('permissions', 'invalid permission data');
                break;
            }
        }
        return $this->validation->passes();
    }
}