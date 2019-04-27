<?php

namespace ByRobots\WriteDown\Database;

use Doctrine\ORM\QueryBuilder;
use ByRobots\WriteDown\Database\Interfaces\FilterInterface;

class Filter implements FilterInterface
{
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    private $query;

    /**
     * @inheritDoc
     */
    public function build(QueryBuilder $query, array $filters):QueryBuilder
    {
        $this->query = $query;

        foreach ($filters as $filter => $values) {
            switch ($filter) {
                case 'pagination':
                case 'orderBy':
                case 'where':
                    $this->$filter($values);
                    break;
                default:
                    throw new \Exception('Unknown filter: ' . $filter);
            }
        }

        return $this->query;
    }

    /**
     * Add order statements.
     *
     * @param array $statements
     *
     * @return void
     */
    private function orderBy(array $statements)
    {
        foreach ($statements as $column => $direction) {
            $this->query->orderBy($column, $direction);
        }
    }

    /**
     * Add where statements.
     *
     * @param array $statements
     *
     * @return void
     */
    private function where(array $statements)
    {
        $first = true;

        foreach ($statements as $statement => $parameters) {
            switch ($first) {
                case true:
                    $this->query->where($statement);
                    $first = false;
                    break;
                default:
                    // Subsequent where statements needs to be andWhere or we'll
                    // get errors about the wrong number of parameters.
                    $this->query->andWhere($statement);
            }

            foreach ($parameters as $parameter => $value) {
                $this->query->setParameter($parameter, $value);
            }
        }
    }

    /**
     * Apply pagination.
     *
     * @param array $paginations
     *
     * @return void
     */
    private function pagination($paginations)
    {
        if (empty($paginations)) {
            return;
        }

        $this->query
            ->setFirstResult($paginations['per_page'] * ($paginations['current_page'] - 1))
            ->setMaxResults($paginations['per_page']);
    }
}
