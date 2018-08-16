<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Models;
use System\Model;

class settingsModel extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    private $_table = 'settings';

    /**
     * Get Settings Records
     *
     * @return mixed
     */
    public function settings()
    {
        $settings = $this->getAll($this->_table, '*', \PDO::FETCH_ASSOC);
        $filterSettings = [];
        array_walk($settings, function(&$setting) use (&$filterSettings) {
            $filterSettings[$setting['key']] = $setting['value'];
        });
        return $filterSettings;
    }

    /**
     * Get Setting Value by key
     *
     * @param $key
     * @return string
     */
    public function setting($key)
    {
        return $this->db->select('settings.value')->from($this->_table)->where('settings.key = ?', $key)->fetch();
    }

    public function save($data)
    {
        $this->db->query("TRUNCATE TABLE `settings`");
        foreach ($data as $key=>$value) {
            $this->db->data(['key'=>$key, 'value'=>$value])->insert($this->_table);
        }
        return $this->db->lastInsertId();
    }
}