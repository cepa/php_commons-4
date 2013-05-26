<?php

use Commons\Entity\Entity;

class Book extends Entity
{
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setCreateTime($createTime)
    {
        $this->create_time = $createTime;
        return $this;
    }
    
    public function getCreateTime()
    {
        return $this->create_time;
    }
    
}