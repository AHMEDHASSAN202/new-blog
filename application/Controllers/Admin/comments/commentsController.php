<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\comments;
use System\Controller;

class commentsController extends Controller
{
    /**
     * Table Name
     *
     * @var string
     */
    private $_table = 'comments';

    /**
     * Get Comments Count
     *
     * @return int
     */
    public function countComments()
    {
        return $this->app->db->select('COUNT(id) as count_comments')
                             ->fetch($this->_table)->count_comments;
    }
}