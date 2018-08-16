<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Models;
use System\App;
use System\Model;

class postsModel extends Model
{
    /**
     * Table Name
     *
     * @var string
     */
    private $_table = 'posts';

    /**
     * Comments Table name
     *
     * @var string
     */
    private $_commentsTable = 'comments';

    /**
     * PostsModel constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);

    }

    /**
     * Get Posts
     *
     * @param $limit
     * @param $offset
     * @param $sort [column, sort]
     * @param int $defaultFetch
     * @param string $select
     * @param array $where
     * @return mixed
     */
    public function posts($select = 'posts.*', $defaultFetch = \PDO::FETCH_OBJ, $limit='', $offset='', $sort = ['id', 'ASC'], $where= ['1 = ?', '1'])
    {
        $select = sprintf('c.categoryName as category, CONCAT(u.first_name," ",u.last_name) as username, %s',$select);;
        $posts = $this->db->select($select)
                        ->join('INNER JOIN categories c ON c.id = posts.category_id')
                        ->join('INNER JOIN users u ON u.id = posts.user_id')
                        ->limit($limit, $offset)
                        ->orderBy($sort[0], $sort[1])
                        ->where($where[0], $where[1])
                        ->fetchAll($this->_table, $defaultFetch);
        array_walk($posts, function(&$post) {
            $post['tags'] = isset($post['tags']) ? unserialize($post['tags']) : null;
            $postsID = isset($post['related_posts']) ? implode(',', unserialize($post['related_posts'])) : null;
            $post['related_posts'] = $this->relatedPosts($postsID);
            $post['view'] = setLink('admin/posts/load/view/' . $post['id']);
            $post['edit'] = hasPermission('editPosts') ? setLink('admin/posts/load/add/' . $post['id']) : false;
            $post['delete'] = hasPermission('deletePosts') ? setLink('admin/posts/delete/' . $post['id']) : false;
        });
        return $posts;
    }

    /**
     * Related posts
     *
     * @param string $postsID
     * @param string $select
     * @return mixed
     */
    public function relatedPosts(string $postsID, $select='id, title')
    {
        return $this->db->select($select.' FROM '.$this->_table.' WHERE id IN ('.$postsID.')')->fetchAll('', \PDO::FETCH_ASSOC);
    }

    /**
     * Get Comments info
     *
     * @param $post_id
     * @return array
     */
    public function commentsInfo($post_id)
    {
        return $this->db->select('comments.*, CONCAT(u.first_name, " ", u.last_name) as username, u.image')
                        ->join('INNER JOIN users u ON u.id = comments.user_id')
                        ->where('comments.post_id = ?', $post_id)->fetchAll($this->_commentsTable, \PDO::FETCH_ASSOC);
    }

    /**
     * Get Post By ID
     *
     * @param $id
     * @param int $defaultFetch
     * @return mixed
     */
    public function post($id, $defaultFetch = \PDO::FETCH_OBJ)
    {
        return $this->app->db->select('c.categoryName as category, CONCAT(u.first_name," ",u.last_name) as username, posts.*')
                             ->join('INNER JOIN categories c ON c.id = posts.category_id')
                             ->join('INNER JOIN users u ON u.id = posts.user_id')
                             ->where('posts.id = ?', $id)->fetch($this->_table, $defaultFetch);
    }

    /**
     * Get Posts
     *
     * @param string $select
     * @param array $where
     * @param int $fetchDefault
     * @return mixed
     */
    public function posts2($select='*', $where=['1 = ?', 1], $fetchDefault=\PDO::FETCH_ASSOC)
    {
        return $this->app->db->select($select)->where($where[0], $where[1])->fetchAll($this->_table, $fetchDefault);
    }

    /**
     * Count Posts
     *
     * @return mixed
     */
    public function count()
    {
        return $this->app->db->select('COUNT(id) as count_posts')
                             ->fetch($this->_table, \PDO::FETCH_OBJ)->count_posts;
    }

    /**
     * Add New Post
     *
     * @param $post
     * @return bool
     */
    public function add($post)
    {
        return $this->db->data($post)->insert($this->_table)->count() ? true : false;
    }

    /**
     * Search of Posts
     *
     * @param $value
     * @return mixed
     */
    public function search($value)
    {
        $posts = $this->db->select('posts.id, posts.title, posts.views, posts.status, c.categoryName as category, CONCAT(u.first_name," ", u.last_name) as username')
                          ->join('INNER JOIN categories c ON c.id = posts.category_id')
                          ->join('INNER JOIN users u ON u.id = posts.user_id')
                          ->where('title LIKE "%'.$value.'%"')->fetchAll($this->_table, \PDO::FETCH_ASSOC);

        return $posts;
    }

    /**
     * Delete Post
     *
     * @param $id
     * @return bool
     */
    public function deletePost($id) {
        return $this->delete($this->_table, $id);
    }

    /**
     * Edit Post
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function edit($id, $data)
    {
        return $this->db->data($data)->where('id = ?', $id)->update($this->_table)->count() ? true : false;
    }
}