<?php

class Application_Model_Post
{
    /**
     * @var int
     */
    protected $_id;
    
    /**
     * @var string
     */
    protected $_title;
    
    /**
     * @var string
     */
    protected $_body;
    
    /**
     * @var string
     */
    protected $_created;
    
    /**
     * @var string
     */
    protected $_updated;

    /**
     * @var Application_Model_PostMapper
     */
    protected $_mapper;
    
    /**
     * Class Constructor.
     * 
     * @param array $options
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
    
    public function getTitle()
    {
        return $this->_title;
    }
    
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }
    
    public function getBody()
    {
        return $this->_body;
    }
    
    public function setCreated($ts)
    {
        $this->_created = $ts;
        return $this;
    }

    public function getCreated()
    {
        return $this->_created;
    }
    
    /**
     * Set data mapper.
     * 
     * @param  mixed $mapper 
     * @return Application_Model_Post
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Get data mapper.
     *
     * Lazy loads Application_Model_PostMapper instance if no mapper
     * registered.
     * 
     * @return Application_Model_PostMapper
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_PostMapper());
        }
        return $this->_mapper;
    }
    
    /**
     * Save the current post.
     * 
     * @return void
     */
    public function save()
    {
        $this->getMapper()->save($this);
    }

    /**
     * Find a post.
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Application_Model_Post
     */
    public function find($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }
    
    /**
      * Fetch all posts.
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
}