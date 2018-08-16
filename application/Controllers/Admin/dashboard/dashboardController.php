<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\dashboard;
use System\Controller;

class dashboardController extends Controller
{
    /**
     * Load Dashboard View
     *
     * @return mixed
     */
    public function index()
    {
        $data['title']  = 'dashboard';
        $data['countUsers'] = $this->app->load->controller('Admin/users/users')->countUsers();
        $data['countComments'] = $this->app->load->controller('Admin/comments/comments')->countComments();
        $data['countPosts'] = $this->app->load->controller('Admin/posts/posts')->countPosts();
        $data['countMessages'] = $this->app->load->controller('Admin/contacts/contacts')->countMessages();
        $data['users'] = $this->app->load->model('users')->getUsers(10, 0, 'users.id', 'DESC');
        $data['messages'] = $this->app->load->model('messages')->messages([5,0], ['contacts.id', 'DESC']);
        $view = $this->app->view->render('Admin/dashboard/dashboard', $data);
        return $this->app->adminLayouts->render($view);
    }
}