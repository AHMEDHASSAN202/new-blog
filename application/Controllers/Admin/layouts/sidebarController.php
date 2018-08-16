<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\layouts;
use System\Controller;

class sidebarController extends Controller
{
    public function render()
    {
        $data['user'] = $this->app->load->model('users')->getUser();
        $data['pages'] = [
            [
                'url'       => setLink('admin/dashboard'),
                'iconClass' => 'fas fa-tachometer-alt',
                'name'      => 'dashboard'
            ],
            [
                'url'       => setLink('admin/messages'),
                'iconClass' => 'fas fa-envelope',
                'name'      => 'messages'
            ],
            [
                'url'       => setLink('admin/users'),
                'iconClass' => 'fa fa-user',
                'name'      => 'users'
            ],
            [
                'url'       => setLink('admin/roles'),
                'iconClass' => 'fas fa-hand-paper',
                'name'      => 'roles'
            ],
            [
                'url'       => setLink('admin/categories'),
                'iconClass' => 'fa fa-puzzle-piece',
                'name'      => 'categories'
            ],
            [
                'url'       => setLink('admin/posts'),
                'iconClass' => 'fas fa-pen',
                'name'      => 'posts'
            ],
            [
                'url'       => setLink('admin/settings'),
                'iconClass' => 'fas fa-cog',
                'name'      => 'settings'
            ],

        ];
        return $this->app->view->render('Admin/layouts/sidebar', $data);
    }
}