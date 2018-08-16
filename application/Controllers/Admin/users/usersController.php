<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\users;
use System\App;
use System\Controller;

class usersController extends Controller
{

    /**
     * Users Model
     *
     * @var object
     */
    private $_model;

    /**
     * usersController constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_model = $app->load->model('users');
    }

    /**
     * Load Users View
     *
     * @return mixed
     */
    public function index()
    {
        $data['title'] = 'users';
        //default pre page
        if (!isset($this->app->cookie->pre_page_user)) {
            $this->app->cookie->pre_page_user = 10;
        }
        $data['pre_page'] = $this->app->cookie->pre_page_user;
        $view = $this->app->view->render('Admin/users/users', $data);
        return $this->app->adminLayouts->render($view);
    }

    /**
     * Get Count Users
     *
     * @return int
     */
    public function countUsers()
    {
        return $this->_model->countUsers();
    }

    /**
     * Pagination Users
     *
     * @param $type   admins || users
     * @return json
     */
    public function pagination($type)
    {
        if (!($type === 'users' || $type === 'admins'))  return;
        $prePageOptions = [10, 20, 50, 70, 100];
        $pre_page = $this->app->input->get('pagination');
        if (in_array($pre_page, $prePageOptions)) {
            $this->app->cookie->set('pre_page', $pre_page);
            if ($type === 'users') {
                $users = $this->_model->getUsers($pre_page, 0, 'users.id', 'ASC');
            }else {
                $users = $this->_model->getUsers($pre_page, 0, 'users.id', 'ASC', 'users_group_id != 0');
            }
            return $this->app->response->json($users);
        }

        return show_404();
    }

    /**
     * Load Modal
     *
     * @param $profile
     * @param $id
     * @return mixed
     */
    public function loadModal($id, $profile = 'false')
    {
        $data['usersGroups'] = $this->app->load->model('usersGroups')->getGroups(\PDO::FETCH_OBJ);
        if ($id == 0) { //add new user
            $data['actionForm'] = setLink('admin/users/add');
            $data['titleModal'] = 'ADD USER';
        }else {  //edit user
            $data['user'] = $this->_model->get($this->_model->_table, $id, '*, from_unixtime(birthday, "%Y-%m-%d") AS birthday');
            if ($profile == 'true') {
                $data['titleModal'] = 'Profile';
                $data['imageName'] = 'Change Image';
                $data['deleteProfile'] = setLink('admin/users/delete/0?profile=true');
            }else {
                $data['titleModal'] = 'EDIT USER';
            }
            $data['passwordName'] = 'New Password';
            $data['actionForm'] = setLink('admin/users/edit/'.$id);
        }
        return $this->view->render('Admin/users/usersModal', $data);
    }

    /**
     * Add New User
     *
     * @return mixed
     */
    public function add()
    {
        if ($this->validateData('add')) {
            $userPathImages = 'users/';
            if ($this->app->input->file('image')->uploaded()) {
                if ($this->app->input->file('image')->move(imagesPath($userPathImages))) {
                    $imagePath = $userPathImages . $this->input->file('image')->nameAfterMoved();
                }else {
                    $this->app->validation->addError('image', 'field download your image');
                }
            }else {
                $imagePath = $userPathImages . 'default avatar.png';
            }
            $newUser = [
                'users_group_id'    => cleanInput($this->input->post('users_group')),
                'first_name'        => cleanInput($this->input->post('first_name')),
                'last_name'         => cleanInput($this->input->post('last_name')),
                'email'             => cleanInput($this->input->post('email')),
                'password'          => password_hash(cleanInput($this->input->post('password')), PASSWORD_DEFAULT),
                'birthday'          => strtotime(cleanInput($this->input->post('birthday'))),
                'gender'            => cleanInput($this->input->post('gender')),
                'status'            => 1,
                'created'           => time(),
                'ip'                => $this->app->request->getIP(),
                'code'              => time() . uniqid() .bin2hex(openssl_random_pseudo_bytes(16)),
                'image'             => $imagePath,
                'confirm_id'        => 1,
                'verified'          => 1,
            ];
            if ($this->_model->add($newUser)) {
                $data['success'] = 'Done!';
            }else {
                $data['errors']= 'Oops! there is error';
            }
        }else {
            $data['errors'] = implode('<br>', $this->app->validation->getErrors());
        }
        return $this->app->response->json($data);
    }

    /**
     * Edit User
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if ($this->validateData('edit', $id)) {
            $user = $this->_model->get($this->_model->_table, $id, 'password, image');
            if ($this->app->input->post('password')){
                $password = password_hash($this->app->input->post('password'), PASSWORD_DEFAULT);
            }else {
                $password = $user->password;
            }
            if ($this->app->input->file('image')->uploaded()) {
                $userPathImages = 'users/';
                $this->file->remove(imagesPath($user->image)); //remove old image
                if ($this->app->input->file('image')->move(imagesPath($userPathImages))) {
                    $imagePath = $userPathImages . $this->input->file('image')->nameAfterMoved();
                }else {
                    return $this->app->response->json(['errors'], 'field download your image');
                }
            }else {
                $imagePath = $user->image;
            }
            $user = [
                'users_group_id'    => cleanInput($this->input->post('users_group')),
                'first_name'        => cleanInput($this->input->post('first_name')),
                'last_name'         => cleanInput($this->input->post('last_name')),
                'email'             => cleanInput($this->input->post('email')),
                'password'          => $password,
                'birthday'          => strtotime(cleanInput($this->input->post('birthday'))),
                'gender'            => cleanInput($this->input->post('gender')),
                'image'             => $imagePath,
            ];
            $this->_model->edit($user, $id) ? $data['success'] = 'Done!' : $data['errors'] = 'Oops! invalid edit data';
        }else {
            $data['errors'] = implode('<br>', $this->app->validation->getErrors());
        }
        return $this->app->response->json($data);
    }

    /**
     * Validate Form data
     *
     * @param $action add || edit
     * @param $id
     * @return mixed
     */
    private function validateData($action, $id =null)
    {
        $this->app->validation->required('first_name', 'First Name is Required')->name('first_name')
                              ->required('last_name', 'Last Name is Required')->name('last_name')
                              ->required('email', 'Email is Required')->email('email', 'Email is not valid');

        if ($action === 'add') {
            $this->app->validation->required('password')->password('password')->unique('email', [$this->_model->_table, 'email']);
        }elseif($action === 'edit') {
            if ($this->app->input->post('password') !== '') {
                $this->app->validation->password('password')->unique('email', [$this->_model->_table, 'email', 'id' , $id], 'Email already exists');
            }
            if (!$this->_model->isExists($this->_model->_table, $id)) {
                $this->app->validation->addError('not exists', 'This User is Not Exists');
            }

        }

        if ($this->app->input->post("gender") == 'false' || $this->app->input->post("gender", false) === false) $this->app->validation->addError('gender', 'Gender is required');
        if ($this->app->input->post("users_group") == 'false'|| $this->app->input->post("users_group", false) === false) $this->app->validation->addError('users_group', 'Users Group is required');

        $this->app->validation->isOneOrZero('gender')->int('users_group')->required('birthday');

        if ($this->app->input->file('image')->uploaded()) {
            $this->app->validation->isImage('image');
        }

        return $this->app->validation->passes();
    }

    /**
     * Delete user
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $profile = $this->app->input->get('profile') ?? '';
        if ($profile=='true') {
            $id = $this->_model->getUser()->id;
        }
        $userImage = $this->_model->get($this->_model->_table, $id, 'image')->image;
        if ($this->_model->delete($this->_model->_table, $id)) {
            $this->file->remove(imagesPath($userImage));
            if ($profile=='true'){
                $data['redirect'] = setLink('admin/logout');
            }
            $data['success'] = 'Done!';
        }else {
            $data['errors'] = 'invalid delete user';
        }
        return $this->app->response->json($data);
    }

    /**
     * View user Information
     *
     * @param $id
     * @return mixed
     */
    public function view($id)
    {
        $data['user'] = $this->_model->get($this->_model->_table, $id);
        return $this->view->render('Admin/users/viewInfoUser', $data);
    }

    /**
     * User Profile
     *
     * @return mixed
     */
    public function profile()
    {
        return $this->loadModal($this->_model->getUser()->id, 'true');
    }
}