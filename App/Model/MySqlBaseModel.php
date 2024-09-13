<?php

namespace App\Model;

use App\Model\Contract\BaseModel;
use Medoo\Medoo;
use PDO;


class MySqlBaseModel extends BaseModel
{
    protected $orm;
    public function __construct()
    {
        try {
            $this->connection = new Medoo([
                // [required]
                'type' => 'mysql',
                'host' => $_ENV['SERVERNAME'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['PASSWORD'],

                // [optional]
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'port' => 3306,

                // [optional] The table prefix. All table names will be prefixed as PREFIX_table.
                'prefix' => '',

                // [optional] To enable logging. It is disabled by default for better performance.
                'logging' => true,

                // [optional]
                // Error mode
                // Error handling strategies when the error has occurred.
                // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
                // Read more from https://www.php.net/manual/en/pdo.error-handling.php.
                'error' => PDO::ERRMODE_EXCEPTION,


                // [optional] Medoo will execute those commands after the database is connected.
                'command' => [
                    'SET SQL_MODE=ANSI_QUOTES'
                ]
            ]);
        } catch(\Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }

    public function create(array $data): array
    {
        $this->connection->insert($this->table, $data);
        return $this->find($this->connection->id())->getAttributes();
    }

    public function update(array $data, array $where): int
    {
        return (int)$this->connection->update($this->table, $data, $where);
    }

    public function find($id): object
    {
        $records = (object)$this->connection->get($this->table,'*',['id' => $id]);
        foreach ($records as $key => $record) {
            $this->attributes[$key] = $record;
        }

        return $this;
    }

    public function getAll()
    {
        return (object)$this->connection->select($this->table,'*');
    }

    public function get(array $columns, array $where=[]): array
    {
        return $this->connection->select($this->table,$columns,$where);
    }

    public function delete(array $where): int
    {
        return (int)$this->connection->delete($this->table,$where);
    }

    public function remove():int
    {
        $record_id = $this->{$this->primaryKey};
        return $this->delete(['id' => $record_id]);
    }

    public function change(array $data):int
    {
        $record_id = $this->{$this->primaryKey};
        return $this->update($data,['id' => $record_id]);
    }
}