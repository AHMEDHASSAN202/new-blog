<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Models;
use System\App;
use System\Model;

class messagesModel extends Model
{
    /**
     * Table Name
     *
     * @var string
     */
    private $_table ='contacts';

    /**
     * MessagesModel Constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->app->load->helper('string');
    }

    /**
     * Get All Messages
     *
     * @param $limit
     * @param $order_by
     * @param $select
     * @param int $fetch_default
     * @return mixed
     */
    public function messages($limit = [1000000, 0],$order_by = ['contacts.id', 'ASC'], $select = null, $fetch_default = \PDO::FETCH_ASSOC)
    {
        $select = !is_null($select) ? $select : 'contacts.*, CONCAT(u.first_name, " ", u.last_name) as replied_by';
        $messages = $this->app->db->select($select)
                             ->join('INNER JOIN users u ON contacts.replied_by = u.id')
                             ->limit($limit[0], $limit[1])
                             ->orderBy($order_by[0], $order_by[1])
                             ->fetchAll($this->_table, $fetch_default);
        array_walk($messages, function(&$message) {
            $message['subject'] = cut_text(5, $message['subject']);
            $message['message'] = cut_text(10, $message['message']);
            $message['view'] = hasPermission('viewMessages') ? setLink('admin/messages/view/'.$message['id']) : false;
            $message['reply'] = hasPermission('replyMessages') ? setLink('admin/messages/reply/'.$message['id']) : false;
            $message['delete'] = hasPermission('deleteMessages') ? setLink('admin/messages/delete/'.$message['id']) : false;
            $message['created'] = diff_date($message['created']) . ' ago';
        });
        return $messages;
    }

    /**
     * Get Message
     *
     * @param $where
     * @param $select
     * @param int $fetch_default
     * @return mixed
     */
    public function message($where = [], $select = null, $fetch_default = \PDO::FETCH_ASSOC)
    {
        $select = !is_null($select) ? $select : 'contacts.*, CONCAT(u.first_name, " ", u.last_name) as replied_by';
        $messages = $this->app->db->select($select)
            ->join('INNER JOIN users u ON contacts.replied_by = u.id')
            ->where($where[0], $where[1])
            ->fetchAll($this->_table, $fetch_default);
        return $messages;
    }

    /**
     * Delete Message
     *
     * @param $id
     * @return bool
     */
    public function deleteMsg($id)
    {
        return $this->delete($this->_table, $id);
    }

    /**
     * Replied Messages
     *
     * @param $id
     * @param $reply
     * @return bool
     */
    public function reply($id, $reply)
    {
        $userID = $this->app->load->model('users')->getUser()->id;
        $data = [
            'reply'         => $reply,
            'replied_by'    => $userID,
            'replied_at'    => time()
        ];
        return $this->app->db->data($data)->where('id = ?', $id)->update($this->_table)->count() ? true : false;
    }
}