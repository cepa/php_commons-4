<?php

require_once 'bootstrap.php';

use Commons\Entity\Entity;
use Commons\NoSql\Mongo\Connection\Connection;
use Commons\NoSql\Mongo\Connection\ConnectionInterface;
use Commons\NoSql\Mongo\EntityRepository;
use Commons\Utils\RandomUtils;

class Customer extends Entity
{
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }
    
    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
        return $this;
    }
    
    public function getFirstName()
    {
        return $this->first_name;
    }
    
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
        return $this;
    }
    
    public function getLastName()
    {
        return $this->last_name;
    }
    
}

class CustomerRepository extends EntityRepository
{
    
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct($connection);
        $this
            ->setEntityClass('Customer')
            ->setCollectionName('Customer')
            ->setPrimaryKey('uuid');
    }
    
}

/*
 * Connect to Mongo.
 */
$conn = new Connection();
$conn->connect(array(
    'dsn'      => 'mongodb://localhost:27017',
    'database' => 'phpcommons'
));
$repo = new CustomerRepository($conn);

/*
 * Check if customer already exists.
 */
$uuid = RandomUtils::randomUuid();
$customer = $repo->fetch($uuid);
var_dump($customer);

/*
 * Create customer.
 */
$customer = new Customer();
$customer
    ->setUuid($uuid)
    ->setFirstName('Johnny')
    ->setLastName('Walker');
$repo->save($customer);

/*
 * Fetch customer with given UUID.
 */
$customer = $repo->fetch($uuid);
var_dump($customer);

/*
 * Update and re fetch customer.
 */
$customer
    ->setFirstName('Jack')
    ->setLastName('Daniels');
$repo->save($customer);
$customer = $repo->fetch($uuid);
var_dump($customer);

/*
 * Delete customer and check if was deleted.
 */
$repo->delete($customer);
$customer = $repo->fetch($uuid);
var_dump($customer);

$conn->disconnect();
