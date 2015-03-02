<?php
namespace CBTTool\Model;

use Aura\SqlQuery\QueryFactory;
use Aura\Sql\ExtendedPdo;
use CBTTool\Lib\DBAL;
use CBTTool\Lib\Config;

/**
 * this is really a Database abstraction layer, not a "model" per se.
 */
class Thinkingmistake extends DBAL
{
    public $DB_TYPE = 'sqlite';
    public $DB_TABLE = 'thinking_mistake';

    /**
     * returns a single record by ID
     * @param  int   $id
     * @return array
     */
    public function getById($id)
    {
        $select = $this->makeQueryFactory()->newSelect();
        $select->from($this->DB_TABLE)
            ->cols(array(
                'id',
                'value',
                'label',
                'sort_order',
            ))
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->sendQuery($select);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll($limit = 10, $skip = 0)
    {
        $select = $this->makeQueryFactory()->newSelect();
        $select->from($this->DB_TABLE)
            ->cols(array(
                'id',
                'value',
                'label',
                'sort_order',
            ))
            ->orderBy(array('sort_order ASC'))
            ->limit($limit)
            ->offset($skip);

        $sth = $this->sendQuery($select);

        $rows = array();
        while($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * saving not allowed
     * @param  array  $record_data
     * @return void
     * @throws Exception
     */
    public function save(array $record_data)
    {
        throw new Exception('No saving possible');
    }
}
