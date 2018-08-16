<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\posts;
use System\App;
use System\Controller;

class postsController extends Controller
{
    /**
     * Table Name
     *
     * @var string
     */
    private $_model;

    /**
     * Posts
     *
     * @var array
     */
    private $_posts;

    /**
     * PostsController constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        //default pre page
        if (!isset($this->app->cookie->pre_page_post)) {
            $this->app->cookie->pre_page_post = 10;
        }
        $this->_model = $app->load->model('posts');
    }

    /**
     * View Content Page
     *
     * @return mixed
     */
    public function index() {
        $data['title'] = 'POSTS';
        $data['postsView'] = $this->loadPostsView(0);
        $data['addLink'] = setLink('admin/posts/load/add/0');
        $data['viewLink'] = setLink('admin/posts/load/view/0');
        $view = $this->view->render('Admin/posts/posts', $data);
        return $this->app->adminLayouts->render($view, [], [
            "https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=o8efys6t8njfxy9szzj1506gdxyydksm7wrct33e377eocr9",
        ]);
    }

    /**
     * Load Posts Table
     *
     * @param $id
     * @return mixed
     */
    private function loadPostsView($id)
    {
        //load all posts view
        if ($id == 0) {
            $data['pre_page'] = $this->app->cookie->pre_page_post;
            $data['count_pages'] = ceil($this->_model->count() / $data['pre_page']);
            $data['current_page'] = $this->app->load->controller('Admin/pagination/pagination')->currentPage();
            $data['posts'] = $this->_posts = $this->_model->posts("posts.*",\PDO::FETCH_ASSOC, $this->app->cookie->pre_page_post, 0, ['id', 'ASC']);
            $data['searchUrl'] = setLink('admin/search/posts');
            $data['paginationUrl'] = setLink('admin/pagination/posts');
            return $this->view->render('Admin/posts/view-content', $data);
        }else {
            //view one post
            $data['post'] = $this->_model->post($id);
            $data['post']->related_posts = $this->_model->relatedPosts(implode(', ', unserialize($data['post']->related_posts)), 'id, title, image, created');
            $data['post']->comments = $this->_model->commentsInfo($id);
            $data['backBTN'] = setLink('admin/posts/load/view/0');
            return $this->view->render('Admin/posts/view-post', $data);
        }
    }

    /**
     * Load Add Posts Form
     *
     * @param $id
     * @return mixed
     */
    private function loadAddView($id)
    {
        $data['categories'] = $this->app->load->model('categories')->getCategories('id, categoryName', false);
        $data['posts'] = $this->_model->posts2('id, title');
        if ($id != 0) {
            //edit
            if (($data['post'] = $this->_model->post($id))) {
                $data['action'] = setLink('admin/posts/edit/'.$id);
                $data['backBTN'] = setLink('admin/posts/load/view/0');
            }
        }else {
            //add
            $data['action'] = setLink('admin/posts/add');
        }
        return $this->view->render('Admin/posts/add-content', $data);
    }

    /**
     * Check if Param is add || view
     *
     * @param $component
     * @param $id
     * @return mixed
     */
    public function load($component, $id)
    {
        if (!is_numeric($id)) {
            return show_404();
        }
        switch ($component) {
            case 'add' :
                return $this->loadAddView($id);
            case 'view' :
                return $this->loadPostsView($id);
            default :
                return show_404();
        }
    }

    /**
     * Get Posts Count
     *
     * @return mixed
     */
    public function countPosts()
    {
        return $this->_model->count();
    }

    /**
     * Validate Form
     *
     * @param $action
     * @return mixed
     */
    private function validateData($action)
    {

        $this->app->validation->required('title', 'Please Insert Title Post')
                              ->required('category', 'Please Choose Category')
                              ->required('editor', 'Please Write Your Post')
                              ->isImage('image', 'Image Post is Not Valid');

        $posts = $this->app->input->post('posts');
        if (!empty($posts)) {
            foreach ($posts as $post) {
                if (!is_numeric($post)) {
                    $this->app->validation->addError('related_posts', 'Related Posts invalid');
                }
            }
        }
//        if ($this->app->input->post('editor')) {
//            $this->app->validation->addError('post', 'Please Write Your Post');
//        }
        return $this->app->validation->passes();
    }

    /**
     * Add Post
     *
     * @return mixed
     */
    public function add()
    {
        if (!$this->validateData('add')) {
            $json['errors'] = showErrors($this->app->validation->getErrors());
        }else {
            //add new post
            $image = $this->app->input->file('image');
            if ($image->uploaded()) {
                $folderPostsImages = 'posts/';
                if (!$image->move(imagesPath($folderPostsImages))) {
                    return $this->json(['errors'=>'invalid upload image']);
                }
                $imagePath = $folderPostsImages.$image->nameAfterMoved();
            }else {
                $imagePath = '';
            }
            $formElements = $this->app->input->postArray();
            $tags = isset($formElements['tags']) ? cleanInput($formElements['tags']) : '';

            $post = [
                'category_id'   => cleanInput($this->input->post('category')),
                'user_id'       => $this->app->load->model('users')->getUser()->id,
                'title'         => cleanInput($formElements['title']),
                'details'       => escape_tags_html($formElements['editor']),
                'image'         => $imagePath,
                'tags'          => serialize($tags),
                'related_posts'  => serialize($formElements['posts']),
                'created'       => time(),
                'status'        => isset($formElements['status']) ? 1 : 0,
            ];
            if (!$this->_model->add($post)) {
                return $this->json(['errors'=> 'Oops! invalid add']);
            }
            $json['success'] = 'Done!';
        }

        return $this->json($json);
    }

    /**
     * Edit Post
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if (!$this->validateData('edit')) {
            $data['errors'] = showErrors($this->app->validation->getErrors());
        }else {
            $formElements = $this->app->input->postArray();
            $tags = isset($formElements['tags']) ? cleanInput($formElements['tags']) : '';
            $editPost = [
                'category_id'   => cleanInput($formElements['category']),
                'title'         => cleanInput($formElements['title']),
                'details'       => escape_tags_html($formElements['editor']),
                'tags'          => serialize($tags),
                'related_posts'  => serialize($formElements['posts']),
                'status'        => isset($formElements['status']) ? 1 : 0,
            ];
            $image = $this->app->input->file('image');
            if ($image->uploaded()) {
                //uploaded new image
                $this->app->file->remove(imagesPath($this->_model->posts2('image', ['id = ?', $id])[0]['image']));
                if ($image->move(imagesPath('posts/'))) {
                    $editPost['image'] = 'posts/' . $image->nameAfterMoved();
                }
            }
            if ($this->_model->edit($id, $editPost)) {
                $data['success'] = 'Done!';
                $data['redirect'] = setLink('admin/posts/load/view/0');
            }else {
                $data['errors'] = 'Oops! invalid edit post';
            }
        }
        return $this->json($data);
    }

    /**
     * Delete Post
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!is_numeric($id)) {
            $data['errors'] = 'This User Not Found';
        }else {
            if ($this->_model->deletePost($id)) {
                $data['success'] = 'Done!';
                $data['pre_page'] = $this->app->cookie->pre_page_post;
                $data['count_pages'] = ceil($this->_model->count() / $data['pre_page']);
                $data['current_page'] = $this->app->load->controller('Admin/pagination/pagination')->currentPage();
                $data['items'] = $this->_posts = $this->_model->posts("posts.*",\PDO::FETCH_ASSOC, $this->app->cookie->pre_page_post, 0, ['id', 'ASC']);
            }else {
                $data['errors'] = 'Invalid delete';
            }
        }
        return $this->json($data);
    }
}