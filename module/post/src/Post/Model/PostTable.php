<?php

namespace Post\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Sql\Expression,
    Zend\Db\Sql\Select;

use Post\Model\Post;

class PostTable extends AbstractTableGateway {
    
    protected $table = 'posts';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Post());
        $this->initialize();
    }
    
    public function fetchAll() {   
        $select = new Select($this->table);
        $resultSet = $this->executeSelect($select);
        return $resultSet;
    }
    
    public function savePost(Post $post) {
        $data = array(
            'title' => $post->title,
            'text' => $post->text,
        );
        $id = (int)$post->id;
        
        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->fetchById($id)) {
            $this->update(
                $data,
                array(
                    'id' => $id,
                )
            );
        } else {
            throw new \Exception('Form id does not exist');
        }        
    }
    
    public function deletePost($id) {
        $this->delete(array('id' => $id));
    }
    
    public function fetchById($id) {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
}