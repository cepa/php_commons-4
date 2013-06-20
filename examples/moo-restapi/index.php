<?php

require_once '../bootstrap.php';
defined('ROOT_DIR') || define('ROOT_DIR', dirname(__FILE__));

use Commons\Config\XmlConfig;
use Commons\Container\TraversableContainer;
use Commons\Http\StatusCode;
use Commons\Json\Decoder as JsonDecoder;
use Commons\Light\View\JsonView;
use Commons\Moo\Moo;
use Commons\Sql\Connection\Connection;
use Commons\Sql\Driver\PdoDriver;

$moo = new Moo();
$moo

    /**
     * Init moo.
     */
    ->init(function(Moo $moo){
        $moo->getResponse()->setHeader('Content-Type', 'application/json');
    })
    
    /**
     * Catch all exceptions.
     */
    ->error(function(Moo $moo, \Exception $e){
        $moo->getResponse()->setStatus(StatusCode::HTTP_NOT_FOUND);
        return new JsonView(array(
            'error' => $e->getMessage()
        ));
    })
    
    /**
     * GET /
     * Dummy index.
     */
    ->get('/', function(Moo $moo){
        return new JsonView();
    })
    
    /**
     * GET /books
     * Fetch list of all books in plain json format.
     */
    ->get('/books', function(Moo $moo){
        $books = $moo->getBookRepository()->fetchCollection();
        return new JsonView($books->toArray());
    })
    
    /**
     * POST /books
     * Create a new book.
     * Requires a json sent in post body.
     * Returns json with newly created book.
     */
    ->post('/books', function(Moo $moo){
        $json = $moo->decodeJsonPost();
        $book = new Book();
        $book
            ->setTitle((string) $json->title)
            ->setDescription((string) $json->description)
            ->setCreateTime(time());
        $moo->getBookRepository()->save($book);
        $moo->getResponse()->setStatus(StatusCode::HTTP_CREATED);
        return new JsonView($book->toArray());
    })
    
    /**
     * GET /books/id
     * Get a book by ID.
     * Returns json with a book.
     */
    ->get('/books/([0-9]+)', function(Moo $moo, $id){
        return new JsonView($moo->getBook($id)->toArray());
    })
    
    /**
     * PUT /books/id
     * Update a book with given ID.
     * Return json with a book.
     */
    ->put('/books/([0-9]+)', function(Moo $moo, $id){
        $json = $moo->decodeJsonPost();
        $book = $moo->getBook($id);
        $book
            ->setTitle((string) $json->title)
            ->setDescription((string) $json->description);
        $moo->getBookRepository()->save($book);
        $moo->getResponse()->setStatus(StatusCode::HTTP_ACCEPTED);
        return new JsonView($book->toArray());
    })
    
    /**
     * DELETE /books/id
     * Delete a book with given ID.
     */
    ->delete('/books/([0-9]+)', function(Moo $moo, $id){
        $book = $moo->getBook($id);
        $moo->getBookRepository()->delete($book);
        $moo->getResponse()->setStatus(StatusCode::HTTP_ACCEPTED);
        return new JsonView();
    })
    
    /**
     * Get book by id.
     */
    ->closure('getBook', function(Moo $moo, $id){
        $book = $moo->getBookRepository()->fetch($id);
        if (!$book) {
            throw new \Exception("There is no book with id '{$id}'");
        }
        return $book;
    })
    
    /**
     * Get book repository instance.
     */
    ->closure('getBookRepository', function(Moo $moo){
        return $moo->getSqlConnection()->getRepository('BookRepository');
    })
    
    /**
     * Decode http request body to json traversable object.
     */
    ->closure('decodeJsonPost', function(Moo $moo){
        $body = $moo->getRequest()->getBody();
        $decoder = new JsonDecoder();
        return new TraversableContainer($decoder->decode($body));
    })
    
    /**
     * Get or load config.
     */
    ->closure('getConfig', function(Moo $moo){
        static $config;
        if (!isset($config)) {
            $config = new XmlConfig();
            $config->loadFromFile(ROOT_DIR.'/config.xml');
        }
        return $config;
    })
    
    /**
     * Get or create SQL connection instance.
     */
    ->closure('getSqlConnection', function(Moo $moo){
        static $connection;
        if (!isset($connection)) {
            $config = $moo->getConfig();
            $connection = new Connection(new PdoDriver());
            $connection->connect(array(
                'driver'   => $config->database->driver,
                'host'     => $config->database->host,
                'port'     => $config->database->port,
                'database' => $config->database->database,
                'username' => $config->database->username,
                'password' => $config->database->password
            ));
        }
        return $connection;
    })
    
    ->moo();
