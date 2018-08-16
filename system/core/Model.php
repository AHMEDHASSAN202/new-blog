<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


abstract class Model
{

    /**
     * Instance of Application Class
     *
     * @var App
     */
    protected $app;

    /**
     * Model constructor.
     *
     * @param $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Check if record is exists
     *
     * @param $table
     * @param $id
     * @return mixed
     */
    public function isExists($table, $id)
    {
        return $this->db->select('COUNT(id) AS count')->where('id = ?', $id)->fetch($table)->count;
    }

    /**
     * Get User by ID
     *
     * @param $id
     * @param $table
     * @param $select
     * @param $defaultFetch
     * @return mixed
     */
    public function get($table, $id, $select = '*', $defaultFetch = \PDO::FETCH_OBJ)
    {
        return $this->db->select($select)->where('id = ?', $id)->fetch($table, $defaultFetch);
    }

    /**
     * Get All records
     *
     * @param $table
     * @param string $select
     * @param $fetchDefault
     * @return mixed
     */
    public function getAll($table, $select = '*', $fetchDefault = \PDO::FETCH_OBJ)
    {
        return $this->db->select($select)->fetchAll($table, $fetchDefault);
    }

    /**
     * Delete Record
     *
     * @param $table
     * @param $id
     * @return bool
     */
    public function delete($table, $id)
    {
        return $this->db->table($table)->where('id = ?', $id)->delete()->count() ? true : false;
    }

    /**
     * Get Property from Application class
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->app->$property;
    }
}