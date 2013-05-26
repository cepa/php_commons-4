<?php

use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\EntityRepository;

class BookRepository extends EntityRepository
{
    
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct($connection);
        $this
            ->setEntityClass('Book')
            ->setTableName('book')
            ->setPrimaryKey('id');
    }
    
}