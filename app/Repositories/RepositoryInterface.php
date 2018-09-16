<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function builder();

    public function all($columns = ['*']);

    public function first($columns = ['*']);

    public function paginate(int $limit, int $page, $columns = ['*']);

    public function find(int $id, $columns = ['*']);

    public function findBy(string $field, $value, $columns = ['*']);

    public function findWhere(string $field, string $comparator, $value, $columns = ['*']);

    public function findWhereIn(string $field, array $values, $columns = ['*']);

    public function findWhereNotIn(string $field, array $values, $columns = ['*']);

    public function orderBy(string $column, $direction = 'asc');

    public function with(array $relationships);

    public function has(string $relation);

    public function whereHas(string $relation, closure $closure);

    public function get($columns = ['*']);
}
