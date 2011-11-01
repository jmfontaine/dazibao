<?php
namespace Dazibao\Repository;

use Dazibao\Repository;
use Dazibao\Entity\Project;

class ProjectRepository Extends AbstractRepository
{
    protected function getListQuery()
    {
        $sql = 'SELECT id, name, path, slug
                FROM projects';

        return $sql;
    }

    public function findAll()
    {
        $sql  = $this->getListQuery() . ' ORDER BY name';
        $data = $this->getDb()->fetchAll($sql);

        return $this->createEntitiesFromArray($data);
    }

    public function findBySlug($slug)
    {
        $sql  = $this->getListQuery() . ' WHERE slug = ? LIMIT 1';
        $data = $this->getDb()->fetchAssoc($sql, array($slug));

        return $this->createEntityFromArray($data);
    }

    public function getTableName()
    {
        return 'projects';
    }
}