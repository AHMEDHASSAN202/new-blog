<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Models;
use System\Model;

class categoriesModel extends Model
{
    /**
     * Table Name
     *
     * @var string
     */
    private $_table = 'categories';

    /**
     * Get all Categories
     * @param $select
     * @param $action
     * @return mixed
     */
    public function getCategories($select = '*', $action = true)
    {
        $categories = $this->getAll($this->_table, $select, \PDO::FETCH_ASSOC);
        if ($action) {
            array_walk($categories, function(&$category) {
                $category['edit'] = hasPermission('editCategories') ? setLink('admin/categories/edit/'.$category['id']) : false;
                $category['delete'] = hasPermission('deleteCategories') ? setLink('admin/categories/delete/'.$category['id']) : false;
                if ($category['parent_id'] != 0) {
                    $category['parent_cat'] = $this->db->select('categoryName')->where('id = ?', $category['parent_id'])->fetch($this->_table, \PDO::FETCH_ASSOC)['categoryName'];
                }
                return $category;
            });
        }
        return $categories;
    }

    /**
     * Get Parent Categories
     *
     * @return mixed
     */
    public function getParentCategories()
    {
        return $this->getAll($this->_table, ['parent_id != ?', '0']);
    }

    /**
     * Add new Category
     *
     * @param $category
     * @return bool
     */
    public function add($category)
    {
        return $this->app->db->data($category)->insert($this->_table)->count() ? true : false;
    }

    /**
     * Get Category
     *
     * @param $id
     * @param string $select
     * @return mixed
     */
    public function getCategory($id, $select = '*')
    {
        return $this->get($this->_table, $id, $select);
    }

    /**
     * Get Sub Categories
     *
     * @param $parent_id
     * @return mixed
     */
    public function getSubcategories($parent_id)
    {
        return $this->getAll($this->_table, ['parent_id = ?', $parent_id]);
    }

    /**
     * Delete Child Category by Parent Category
     *
     * @param $id
     * @return mixed
     */
    public function removeCategoriesByParentIDCategory($id)
    {
        $childCategoriesImages = $this->db->select('image')->from($this->_table)->where('parent_id = ?', $id)->fetchAll();
        foreach ($childCategoriesImages as $categoryImage) {
            $this->app->file->remove(imagesPath($categoryImage->image));
        }
        return $this->db->from($this->_table)->where('parent_id = ?', $id)->delete();
    }

    /**
     * Delete Category
     *
     * @param $id
     * @return bool
     */
    public function deleteCategory($id)
    {
        return $this->delete($this->_table, $id);
    }

    /**
     * Update Data
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db->data($data)->where('id = ?', $id)->update($this->_table)->count() ? true : false;
    }
}