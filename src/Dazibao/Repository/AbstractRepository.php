<?php
namespace Dazibao\Repository;

use Doctrine\DBAL\Connection;

abstract class AbstractRepository
{
    private $db;

    protected function createEntitiesFromArray(array $data)
    {
        $entities = array();
        foreach ($data as $row) {
            $entities[] = $this->createEntityFromArray($row);
        }

        return $entities;
    }

    protected function createEntityFromArray(array $data)
    {
        $entityClassName = '\\Dazibao\\Entity\\' . $this->getEntityClass();

        $entity = new $entityClassName();
        foreach ($data as $property => $value) {
            $methodName = 'set' . ucfirst($property);
            $entity->$methodName($value);
        }

        return $entity;
    }

    protected function getDb()
    {
        return $this->db;
    }

    protected function getEntityClass()
    {
        $parts = explode('\\', get_class($this));

        return substr(array_pop($parts), 0, -10);
    }

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function delete(array $identifier)
    {
        return $this->getDb()->delete($this->getTableName(), $identifier);
    }

    public function findById($id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE id = ? LIMIT 1', $this->getTableName());
        return $this->getDb()->fetchAssoc($sql, array($id));
    }

    abstract public function getTableName();

    public function insert(array $data)
    {
        return $this->getDb()->insert($this->getTableName(), $data);
    }

    public function update(array $data, array $identifier)
    {
        return $this->getDb()->update($this->getTableName(), $data, $identifier);
    }
}