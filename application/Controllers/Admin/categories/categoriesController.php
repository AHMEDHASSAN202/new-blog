<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\categories;
use System\App;
use System\Controller;

class categoriesController extends Controller
{

    /**
     * Model name
     *
     * @var string
     */
    private $_model = 'categories';

    /**
     * CategoriesController constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->_model = $this->app->load->model($this->_model);
    }

    /**
     * Categories View
     *
     * @return mixed
     */
    public function index()
    {
        $data['title'] = 'CATEGORIES';
        $data['action'] = setLink('admin/categories/save/0');
        $data['categories'] = $this->_model->getCategories();
        $view = $this->app->view->render('Admin/categories/categories', $data);
        return $this->app->adminLayouts->render($view);
    }

    /**
     * Save data [add, edit]
     *
     * @param $id
     * @return mixed
     */
    public function save($id)
    {
        if ($id == 0) {
            //add new category
            if (!$this->validateData('add')) {
                $data['errors'] = implode('<br>', $this->app->validation->getErrors());
            }else {
                if ($this->app->input->file('cat_img')->uploaded()) {
                    $folder = 'categories/';
                    $this->app->input->file('cat_img')->move(imagesPath($folder));
                    $image = $folder . $this->app->input->file('cat_img')->nameAfterMoved();
                }else {
                    $image = '';
                }
                $status = cleanInput($this->app->input->post('status')) ?: 0;
                $category = [
                    'parent_id'     => cleanInput($this->app->input->post('parent_id')),
                    'categoryName' => cleanInput($this->app->input->post('category_name')),
                    'image'         => $image,
                    'desc'          => trim(cleanInput($this->app->input->post('description'))),
                    'status'        => $status
                ];
                if ($this->_model->add($category)) {
                    $data['success'] = 'Done!';
                    $data['categories'] = $this->_model->getCategories();
                }else {
                    $data['errors'] = 'invalid add new category';
                }
            }
        }else {
            if (!$this->validateData('edit') || !is_numeric($id)) {
                $data['errors'] = implode('<br>', $this->app->validation->getErrors());
            }else {
                //edit category
                $category = $this->_model->getCategory($id, 'categoryName, image');
                $categoryImage = $category->image;
                if ($this->app->input->file('cat_img')->uploaded()) {
                    $this->file->remove(imagesPath($categoryImage));
                    $this->input->file('cat_img')->move(imagesPath('categories/'));
                    $categoryImage = 'categories/'.$this->input->file('cat_img')->nameAfterMoved();
                }
                $status = cleanInput($this->app->input->post('status')) ?: 0;
                $editCategoryData = [
                    'parent_id'     => cleanInput($this->app->input->post('parent_id')),
                    'categoryName' => cleanInput($this->app->input->post('category_name')),
                    'image'         => $categoryImage,
                    'desc'          => trim(cleanInput($this->app->input->post('description'))),
                    'status'        => $status
                ];
                if (!$this->_model->update($id, $editCategoryData)) {
                    $data['errors'] = 'invalid edit ' . $category->categoryName . ' Category';
                }
                $data['success'] = 'Dine!';
                $data['categories'] = $this->_model->getCategories();
            }
            $data['edit'] = true;
        }
        return $this->app->response->json($data);
    }

    /**
     * Validate data in edit and add actions
     *
     * @param $action
     * @return mixed
     */
    private function validateData($action)
    {
        $this->app->validation->required('category_name', 'Category Name is Required')
                              ->specialName('category_name', 'Please add another name')
                              ->required('parent_category', 'Parent Category is Required')
                              ->isImage('cat_img');
        if ($this->app->input->post('description')) {
            $this->app->validation->specialName('description');
        }

//        if ($action == 'edit') {
//
//        }elseif ($action == 'add') {
//
//        }
        return $this->validation->passes();
    }

    /**
     * Delete Action
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $category = $this->_model->getCategory($id, 'parent_id, image, categoryName');
        if ($category) {
            if ($category->parent_id == 0) {
                //this category is parent so we will delete has child Categories
                $this->_model->removeCategoriesByParentIDCategory($id);
            }
            if ($this->_model->deleteCategory($id)) {
                $category->image ? $this->app->file->remove(imagesPath($category->image)) : null;
                $data['success'] = 'Done! '. $category->categoryName . ' category is deleted';
                $data['categories'] = $this->_model->getCategories();
            }else {
                $data['errors'] = 'error in delete '. $category->categoryName .' category';
            }
            return $this->app->response->json($data);
        }
    }

    /**
     * Load Edit View
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $data['category'] = $this->_model->getCategory($id);
            $data['titleModal'] = sprintf('Edit %s Category', $data['category']->categoryName);
            $data['action'] = setLink('admin/categories/save/'.$id);
            return $this->view->render('Admin/categories/editModal', $data);
        }
    }
}