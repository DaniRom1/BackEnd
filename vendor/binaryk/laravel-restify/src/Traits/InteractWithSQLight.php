<?php

namespace Binaryk\LaravelRestify\Traits;

use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Support\Str;

/**
 * @author Caleb Porzio https://github.com/calebporzio/sushi/blob/master/src/Sushi.php
 */
trait InteractWithSQLight
{
    protected static $sushiConnection;

    public static function resolveConnection($connection = null)
    {
        return static::$sushiConnection;
    }

    public static function bootSushi()
    {
        $instance = (new static());
        $cacheFileName = 'sushi-'.Str::kebab(str_replace('\\', '', static::class)).'.sqlite';
        $cacheDirectory = realpath(config('sushi.cache-path', storage_path('framework/cache')));
        $cachePath = $cacheDirectory.'/'.$cacheFileName;
        $modelPath = (new \ReflectionClass(static::class))->getFileName();

        $states = [
            'cache-file-found-and-up-to-date' => function () use ($cachePath) {
                static::setSqliteConnection($cachePath);
            },
            'cache-file-not-found-or-stale' => function () use ($cachePath, $modelPath, $instance) {
                file_put_contents($cachePath, '');

                static::setSqliteConnection($cachePath);

                $instance->migrate();

                touch($cachePath, filemtime($modelPath));
            },
            'no-caching-capabilities' => function () use ($instance) {
                static::setSqliteConnection(':memory:');

                $instance->migrate();
            },
        ];

        switch (true) {
            case file_exists($cachePath) && filemtime($modelPath) === filemtime($cachePath):
                $states['cache-file-found-and-up-to-date']();

                break;

            case file_exists($cacheDirectory) && is_writable($cacheDirectory):
                $states['cache-file-not-found-or-stale']();

                break;

            default:
                $states['no-caching-capabilities']();

                break;
        }
    }

    protected static function setSqliteConnection($database)
    {
        static::$sushiConnection = app(ConnectionFactory::class)->make([
            'driver' => 'sqlite',
            'database' => $database,
        ]);
    }

    public function migrate()
    {
        $rows = $this->rows;
        $firstRow = $rows[0];
        $tableName = $this->getTable();

        throw_unless($rows, new \Exception('Sushi: $rows property not found on model: '.get_class($this)));

        static::resolveConnection()->getSchemaBuilder()->create($tableName, function ($table) use ($firstRow) {
            foreach ($firstRow as $column => $value) {
                if ($column === 'id') {
                    $table->increments('id');

                    continue;
                }

                $type = is_numeric($value) ? 'integer' : 'string';

                $table->{$type}($column);
            }
        });

        static::insert($rows);
    }
}
