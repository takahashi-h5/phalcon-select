<?php
declare(strict_types=1);

error_reporting(E_ALL);
// ローダー
$loader = new Phalcon\Loader();
$loader->registerNamespaces(
    [
        'App\Models' => __DIR__ . '/models/',
    ]
);
$loader->register();

// DB接続情報
$container = new Phalcon\Di\FactoryDefault();
$container->set(
    'db',
    function () {
        return new Phalcon\Db\Adapter\Pdo\Postgresql(
            [
                'host'        => 'localhost',
                'port'        => 5432,
                'username'    => 'postgres',
                'password'    => 'confrage',
                'dbname'      => 'postgres'
            ]
        );
    }
);

$app = new \Phalcon\Mvc\Micro($container); // DB情報を引数で渡す必要がある
$app->get(
    '/api/v2/getRecord/{id}',
    function ($id) use ($app) {
    $record = $app
        ->modelsManager
        ->executeQuery(
            'SELECT * FROM App\Models\Empuser WHERE id = :idx: ',
            [
                'idx' => $id
            ]
            );
        $response = new Phalcon\Http\Response();
        if ($record === false) {
            $response->setJsonContent(
                [
                    'status' => 'NOT-FOUND'
                ]
            );
        } else {
            $response->setJsonContent(
                [
                    'status' => 'FOUND',
                    'data'   => [
                        'id'   => $record[0]->id,
                        'firstname' => $record[0]->firstname,
                        'lastname' => $record[0]->lastname,
                        'age' => $record[0]->age
                    ]
                ]
            );
        }
        return $response;
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);