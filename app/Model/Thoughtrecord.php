<?php
namespace CBTTool\Model;

use Aura\SqlQuery\QueryFactory;

class Thoughtrecord
{
    public static $DB_TYPE = 'sqlite';

    /**
     * creates a Aura\SqlQuery\QueryFactory
     * @return Aura\SqlQuery\QueryFactory
     */
    public function makeQueryFactory()
    {
        return new QueryFactory(self::$DB_TYPE);
    }

    public function getAll($limit = 10, $skip = 0)
    {
        $select = $query_factory->newSelect();
    }


    public function getById($id)
    {
        $select = $query_factory->newSelect();
    }

    public function save(array $record_data)
    {
        $insert = $query_factory->newSelect();
    }

}