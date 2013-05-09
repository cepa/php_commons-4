<?php

require_once 'bootstrap.php';

use Commons\Sql\Connection\SingleConnection;
use Commons\Sql\Driver\PdoDriver;

/*
 * Connect to database.
 */
$conn = new SingleConnection(new PdoDriver());
$conn->connect(array(
    'driver'   => 'mysql',
    'host'     => DATABASE_HOST,
    'port'     => DATABASE_PORT,
    'username' => DATABASE_USERNAME,
    'password' => DATABASE_PASSWORD,
    'database' => DATABASE_NAME
));

/*
 * Fetch all records from identity table.
 */
$collection = $conn->createQuery()
    ->select('*')
    ->from('identity')
    ->orderBy('first_name')
    ->execute()
    ->fetchCollection();
foreach ($collection as $entity) {
    echo "{$entity->first_name} {$entity->last_name}\n";
}
echo "\n";

/*
 * Fetch a single entity (record).
 */
$entity = $conn->createQuery()
    ->select('*')
    ->from('identity')
    ->orderBy('RAND()')
    ->limit(1)
    ->execute()
    ->fetch();
echo "random identity: {$entity->first_name} {$entity->last_name}\n\n";

