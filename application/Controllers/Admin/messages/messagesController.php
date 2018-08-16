<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\messages;
use System\App;
use System\Controller;

class messagesController extends Controller
{
    /**
     * Model Object
     *
     * @var object
     */
    private $_model;

    /**
     * MessagesController constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_model = $this->app->load->model('messages');
    }

    /**
     * Load index view
     *
     * @return mixed
     */
    public function index() {
        $data['title'] = 'Messages';
        $data['messages'] = $this->_model->messages();
        $view = $this->app->view->render('Admin/messages/index', $data);
        return $this->app->adminLayouts->render($view);
    }

    /**
     * Delete Message
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!is_numeric($id)) {
            $data['errors'] = 'This Message Not Found';
        }else {
            if ($this->_model->deleteMsg($id)) {
                $data['success'] = 'Done!';
                $data['messages'] = $this->_model->messages();
            }else {
                $data['errors'] = 'Oops! invalid delete message';
            }
        }
        return $this->json($data);
    }

    /**
     * View Message
     *
     * @param $id
     * @return bool
     */
    public function view($id)
    {
        if(!is_numeric($id)) {
            return false;
        }

        $data['message'] = $message = $this->_model->message(['contacts.id = ?', $id])[0];
        if ($this->app->input->get('reply') == 'true') {
            $data['title'] = 'Reply Message';
            $data['action'] = 'reply';
            $data['actionForm'] = setLink('admin/messages/reply/'.$data['message']['id']);
        }else {
            $data['title'] = 'View Message';
            $data['action'] = 'view';
        }
        return $this->view->render('admin/messages/message', $data);
    }

    /**
     * Reply Message
     *
     * @param $id
     * @return mixed
     */
    public function reply($id)
    {
        $validation = $this->app->validation;
        $validation->required('reply', 'Replied is Required');
        if (!is_numeric($id)) {
            $validation->addError('id', 'Sorry! Not Found this Message');
        }
        if (!$validation->passes()) {
            $data['errors'] = showErrors($this->app->validation->getErrors());
        }else {
            $reply = escape_tags_html($this->app->input->post('reply'));
            if ($this->_model->reply($id, $reply)) {
                $data['messages'] = $this->_model->messages();
                $data['success'] = 'Done!';
            }else {
                $data['errors'] = 'Oops! invalid replied';
            }
        }

        return $this->json($data);
    }
}