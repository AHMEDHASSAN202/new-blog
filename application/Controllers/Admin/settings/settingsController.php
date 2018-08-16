<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\settings;
use System\App;
use System\Controller;

class settingsController extends Controller
{
    private $_model;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_model = $app->load->model('settings');
    }

    public function index()
    {
        $data['title']  = 'Settings';
        $data['actionForm']  = setLink('admin/settings/save');
        $data['settings']  = $this->_model->settings();
        $view = $this->app->view->render('Admin/settings/index', $data);
        return $this->app->adminLayouts->render($view);
    }

    public function save()
    {
        if (!$this->validateData()) {
            $json['errors'] = showErrors($this->app->validation->getErrors());
        }else {
            $form =$this->app->input->postArray();
            $logo = $this->app->input->file('logo');
            $oldLogo = $this->_model->setting('site_logo')->value;
            $this->file->remove(imagesPath('icons/'.$oldLogo));
            $logo->move(imagesPath('icons/'), 'logo_site');
            $newNameLogo = $logo->nameAfterMoved();
            $status = isset($form['status']) ? cleanInput($form['status']) : 0;
            $data = [
                'site_name'           => cleanInput($form['name']),
                'site_email'          => cleanInput($form['email']),
                'site_status'         => $status,
                'site_close_msg'      => cleanInput($form['siteCloseMsg']),
                'site_logo'           => $newNameLogo,
                'site_copyright'      => cleanInput($form['copyright']),
            ];
            if ($this->_model->save($data)) {
                $json['success'] = 'Done!';
                $json['settings'] = $this->_model->settings();
            }else {
                $json['errors'] = 'invalid save data';
            }
        }
        return $this->json($json);
    }

    /**
     * Validation Data
     *
     * @return mixed
     */
    private function validateData()
    {
        $validation = $this->app->validation;
        $validation->required('name', 'Site name is Required')
                     ->required('email', 'Site email is Required')
                     ->required('copyright', 'Site Copyright is Required')
                     ->required('siteCloseMsg', 'Site Close Message is Required')
                     ->requiredFile('logo', 'Site Logo is Required')
                     ->email('email', 'Email invalid')
                     ->isImage('logo');
        return $validation->passes();
    }
}