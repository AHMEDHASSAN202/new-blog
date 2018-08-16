<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\pagination;
use System\App;
use System\Controller;

class paginationController extends Controller
{
    private $_usersModel;
    private $_postsModel;
    private $_currentPage = 1;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_usersModel = $app->load->model('users');
        $this->_postsModel = $app->load->model('posts');
        $this->_currentPage = $this->app->input->get('page') ?? 1;
    }

    public function index($page)
    {
        $prePageOptions = [10, 20, 50, 70, 100];
        if ($this->app->input->get('pagination', false)) {
            $pre_page = $this->app->input->get('pagination');
        }elseif (isset($this->app->cookie->pre_page_user)) {
            $pre_page = $this->app->cookie->pre_page_user;
        }elseif (isset($this->app->cookie->pre_page_post)) {
            $pre_page = $this->app->cookie->pre_page_post;
        }else {
            $pre_page = 10;
        }
        $offset = $pre_page * ($this->_currentPage - 1);
        if (in_array($pre_page, $prePageOptions)) {
            switch ($page) {
                case 'users':
                    $this->app->cookie->set('pre_page_user', $pre_page);
                    $count_page = ceil($this->_usersModel->countUsers() / $pre_page);
                    $result = $this->_usersModel->getUsers($pre_page, $offset, 'users.id', 'ASC');
                    break;
                case 'admins':
                    $this->app->cookie->set('pre_page_user', $pre_page);
                    $count_page = ceil($this->_usersModel->countUsers('users_group_id != 0') / $pre_page);
                    $result = $this->_usersModel->getUsers($pre_page, $offset, 'users.id', 'ASC', 'users_group_id != 0');
                    break;
                case 'posts':
                    $this->app->cookie->set('pre_page_post', $pre_page);
                    $count_page = ceil($this->_postsModel->count() / $pre_page);
                    $result = $this->_postsModel->posts('posts.*', \PDO::FETCH_ASSOC, $pre_page, $offset);
                    break;
                default:
                    $result = false;
            }
            if ($result) {
                $data['items'] = $result;
                $data['count_pages'] = $count_page;
                $data['current_page'] = $this->_currentPage;
                return $this->json($data);
            }
        }
    }

    public function currentPage()
    {
        return $this->_currentPage;
    }
}