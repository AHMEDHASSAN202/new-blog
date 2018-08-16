<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\login;
use System\Controller;


class loginController extends Controller
{
    /**
     * User Information
     *
     * @var \stdClass
     */
    private $_user;

    /**
     * Main Login Page
     *
     * @return mixed
     */
    public function index()
    {
        return $this->view->render('Admin/login/login');
    }

    /**
     * Submit Login Dashboard
     *
     * @return mixed
     * @throws \Exception
     */
    public function submit() {
        $email = cleanInput($this->app->input->post('email'));
        $password = cleanInput($this->app->input->post('password'));
        $rememberMe = cleanInput($this->app->input->post('rememberMe'));
        if (!$this->validate()) {
            //there are errors
            $data['errors'] = $this->app->validation->getErrors();
        }else {
            if (!$this->isValid($email, $password)) {
                $data['errors'] = 'invalid email or password';
            }else {
                $data['success'] = 'success login';
                $data['redirectDashboard'] = setLink('admin/dashboard');
                if (!is_null($rememberMe) && $rememberMe === 'on') {
                    //click remember me button
                    $this->app->cookie->set('login', $this->_user->code);
                }else {
                    $this->app->session->set('login', $this->_user->code);
                }
            }
        }

        return $this->response->json($data);
    }

    /**
     * Validate Data
     *
     * @return mixed
     */
    private function validate()
    {
        $this->app->validation->required('email', 'email address is required')
                              ->email('email', 'invalid email')
                              ->required('password', 'password is required');
        return $this->app->validation->passes();
    }

    /**
     * Check if Data is Valid
     *
     * @param $email
     * @param $password
     * @return bool
     */
    private function isValid($email, $password) {
        $user = $this->db->select('email', 'password', 'users_group_id', 'verified', 'code')
                     ->from('users')
                     ->where('email = ? AND users_group_id != 0 AND verified = 1', $email)
                     ->fetch();
        if (!$user) return false;
        if (password_verify($password, $user->password)) {
            $this->_user = $user;
            return true;
        }
        return false;
    }
}