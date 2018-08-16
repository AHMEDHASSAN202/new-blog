<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\search;
use System\App;
use System\Controller;

class searchController extends Controller
{
    /**
     * Users Model Name
     *
     * @var string
     */
    private $_usersModel;

    /**
     * Posts Model
     *
     * @var object
     */
    private $_postsModel;

    /**
     * search constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_usersModel = $app->load->model('users');
        $this->_postsModel = $app->load->model('posts');
    }


    /**
     * Search Users
     *
     * @return json
     */
    public function users()
    {
        $value = cleanInput($this->app->input->get('value'));
        $users = $this->_usersModel->searchUsers($value);
        array_map(function($user){
            $user->edit = hasPermission('editUser') ? setLink('admin/users/edit/'.$user->id) : false;
            $user->view = hasPermission('viewUser') ? setLink('admin/users/view/'.$user->id) : false;
            $user->delete = hasPermission('deleteUser') ? setLink('admin/users/delete/'.$user->id) : false;
        }, $users);
        return $this->response->json(['items'=>$users, 'page'=>'users']);
    }

    public function posts()
    {
        $value = cleanInput($this->app->input->get('value'));
        $posts = $this->_postsModel->search($value);
        return $this->json(['items'=>$posts, 'page'=>'posts']);
    }
}