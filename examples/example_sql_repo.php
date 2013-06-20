<?php

require_once 'bootstrap.php';

use Commons\Entity\Entity;
use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\Connection\Connection;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\EntityRepository;

/*
 * Identity model.
 */
class Identity extends Entity
{
    
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

/*
 * Identity repository model.
 */
class IdentityRepository extends EntityRepository
{
    
    public function __construct(ConnectionInterface $connection = null)
    {
        parent::__construct($connection);
        $this
            ->setEntityClass('Identity')
            ->setTableName('identity')
            ->setPrimaryKey('id');
    }

}

/*
 * Connect to database.
 */
$conn = new Connection(new PdoDriver());
$conn->connect(array(
    'driver'   => 'mysql',
    'host'     => DATABASE_HOST,
    'port'     => DATABASE_PORT,
    'username' => DATABASE_USERNAME,
    'password' => DATABASE_PASSWORD,
    'database' => DATABASE_NAME
));

/*
 * Get or create a single repository instance assigned to a connection.
 */
$repo = $conn->getRepository('IdentityRepository');

/*
 * Fetch single entity with id = 1.
 */
$identity = $repo->fetch(1);
var_dump($identity);
echo "--------------------------------------------------------------------\n\n";

/*
 * Fetch all entities.
 */
$identites = $repo->fetchCollection();
foreach ($identites as $identity) {
    var_dump($identity);
}
echo "--------------------------------------------------------------------\n\n";

/*
 * Fetch entities with given criteria.
 */
$identites = $repo->fetchCollection(array(
    'orderBy' => 'RAND()',
    'limit' => 2
));
foreach ($identites as $identity) {
    var_dump($identity);
}
echo "--------------------------------------------------------------------\n\n";

/*
 * Create and save a new entity.
 */
$identity = new Identity();
$identity
    ->setFirstName('hello')
    ->setLastName('world');
$repo->save($identity);
var_dump($identity);
echo "--------------------------------------------------------------------\n\n";

/*
 * Find the entity by key value.
 */
$identity = $repo->findBy('first_name', 'hello');
var_dump($identity);
echo "--------------------------------------------------------------------\n\n";

/*
 * Update the entity.
 */
$identity->setLastName('foo foo');
$repo->save($identity);

/*
 * Fetch the entity again.
 */
$identity = $repo->findBy('first_name', 'hello');
var_dump($identity);
echo "--------------------------------------------------------------------\n\n";

/*
 * Delete the entity.
 */
$repo->delete($identity);

/*
 * Try to fetch the entity again.
*/
$identity = $repo->findBy('first_name', 'hello');
var_dump($identity);
echo "--------------------------------------------------------------------\n\n";
