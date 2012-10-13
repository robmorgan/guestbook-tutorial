<?php

class Application_Model_PostMapper
{
    protected $_dbTable;
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }

        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }

        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Post');
        }

        return $this->_dbTable;
    }

    public function save(Application_Model_Post $post)
    {
        $data = array(
            'title'            => $post->getTitle(),
            'body'             => $post->getBody(),
            'created'          => $post->getCreated()
        );

        if (null === ($id = $post->getId())) {
            unset($data['id']);
            $data['created']  = date('Y-m-d H:i:s');
            $post->setId($this->getDbTable()->insert($data));
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Post $post)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        self::mapObjectToModel($row, $post);
    }
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return self::mapEntriesToModels($resultSet);
    }
    
    public static function mapEntriesToModels(Zend_Db_Table_Rowset_Abstract $rows)
    {       
        $entries = array();
        foreach ($rows as $row) {
            $entries[] = self::mapObjectToModel($row);
        }
        return $entries;
    }
    
    public static function mapObjectToModel(Zend_Db_Table_Row_Abstract $row, Application_Model_Post $post = null)
    {
        if (null === $post) {
            $post = new Application_Model_Post();
        }

        $post->setId($row->id)
              ->setTitle($row->title)
             ->setBody($row->body)
             ->setCreated($row->created);
        
        return $post;
    }
}