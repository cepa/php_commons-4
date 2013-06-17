<?php

/**
 *
 * In order to run this example:
 * 
 * 1) Create phpcommons keyspace.
 * 
 * # run ./bin/cassandra-cli
 * create keyspace phpcommons with placement_strategy = 'SimpleStrategy' and strategy_options = {replication_factor:1};
 * 
 * 2) Create column family Test.
 * 
 * # run ./bin/cassandra-cli
 * use phpcommons;
 * create column family Customer with comparator=UTF8Type and default_validation_class=UTF8Type and key_validation_class=UTF8Type;
 * 
 */

require_once 'bootstrap.php';

use phpcassa\Connection\ConnectionPool;
use Commons\Entity\Entity;
use Commons\NoSql\Cassandra\EntityRepository;
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
    
    public function __construct(ConnectionPool $connection)
    {
        parent::__construct($connection);
        $this
            ->setEntityClass('Customer')
            ->setColumnFamilyName('Customer')
            ->setPrimaryKey('uuid');
    }
    
}

/*
 * Connect to Apache Cassandra.
 */
$conn = new ConnectionPool('phpcommons', array('localhost:9160'));
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

$conn->close();
