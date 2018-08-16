<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;

//$currentPage = $this->app->pagination->getCurrentPage();
//$itemsPerPage = 3;
//$this->app->pagination->setItemsPerPage($itemsPerPage);
//$limit = $this->app->pagination->getItemsPerpage();
//$offset = $limit * ($currentPage - 1);
//$totalItems = $this->app->db->select('COUNT(id) AS `total`')->from($this->_table)->fetch()->total;
//if ($totalItems) {$this->app->pagination->setTotalItems($totalItems);}
class Pagination
{
    /**
     * Application Instance
     *
     * @var $_app object
     */
    private $_app;

    /**
     * The total number of items [total records]
     *
     * @var int
     */
    private $_totalItems;

    /**
     * The number of items per page.
     *
     * @var int
     */
    private $_itemsPerPage = 10;

    /**
     * The current page number
     *
     * @var int
     */
    private $_currentPage;

    /**
     * Pagination constructor.
     *
     * @param App
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
        $this->setCurrentPage();
    }

    /**
     * Set the current page number
     *
     * @return void
     */
    public function setCurrentPage()
    {
        // url?page=1
        // url?page=10
        // url?page=20
        $page = $this->_app->input->get('page');
        if (!$page || !is_numeric($page) || $page < 1) {
            $page = 1;
        }

        $this->_currentPage = 1;
    }

    /**
     * Get the current page number
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    /**
     * Set the total number of items
     *
     * @param $items
     */
    public function setTotalItems($items)
    {
        $this->_totalItems = $items;
    }

    /**
     * Get the total number of items
     *
     * @return int
     */
    public function getTotalItems()
    {
        return $this->_totalItems;
    }

    /**
     * Set the number of items per page
     *
     * @param $items
     */
    public function setItemsPerPage($items)
    {
        $this->_itemsPerPage = $items;
    }

    /**
     * Get the number of items per page
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->_itemsPerPage;
    }

    /**
     * Get the last number page
     *
     * @return int
     */
    public function getLastPage()
    {
        return ceil($this->_totalItems / $this->_itemsPerPage);
    }

    /**
     * Paginate Method
     *
     * @return $this
     */
    public function paginate()
    {
        $this->setLastPage();
        return $this;
    }
}