<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\contacts;
use System\Controller;

class contactsController extends Controller
{
    /**
     * Table Name
     *
     * @var string
     */
    private $_table = 'contacts';

    /**
     * Get Messages Count
     *
     * @return mixed
     */
    public function countMessages()
    {
        return $this->app->db->select('COUNT(id) as count_messages')
                             ->fetch($this->_table)->count_messages;
    }
}