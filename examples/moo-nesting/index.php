<?php

require_once '../bootstrap.php';
defined('ROOT_DIR') || define('ROOT_DIR', dirname(__FILE__));

use Commons\Http\StatusCode;
use Commons\Moo\Moo;

$moo = new Moo();
$moo

    /**
     * Init moo.
     */
    ->init(function(Moo $moo){
        $moo->getResponse()->setHeader('Content-Type', 'text/plain');
    })

    /**
     * Catch all exceptions.
     */
    ->error(function(Moo $moo, \Exception $e){
        $moo->getResponse()->setStatus(StatusCode::HTTP_NOT_FOUND);
        $moo->print('error');
    })

    /**
     * Create a print plugin.
     */
    ->plugin('print', function(Moo $moo, $message){
        echo "{$message}\n";
        return $moo;
    })

    /**
     * GET /
     * Dummy index.
     */
    ->get('/', function(Moo $moo){
        $moo->print('index');
    })

    /**
     * Nested routing.
     */
    ->route('/news(.*)', function(Moo $moo){
        return $moo

            ->get('/news', function(Moo $moo){
                $moo->print("news list");
            })

            ->post('/news', function(Moo $moo){
                $moo->print("post news");
            })

            ->route('/news/(.*)', function(Moo $moo, $id){
                return $moo

                    ->get('/news/(.*)', function(Moo $moo, $id){
                        $moo->print("get news {$id}");
                    })

                    ->put('/news/(.*)', function(Moo $moo, $id){
                        $moo->print("put news {$id}");
                    })

                    ->delete('/news/(.*)', function(Moo $moo, $id){
                        $moo->print("delete news {$id}");
                    })

                    ->moo();
            })

            ->moo();
    })

    ;

$response = $moo->moo();
$response->send();
