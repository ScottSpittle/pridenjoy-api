<?php

namespace App\Repositories;

use Exception;

abstract class EloquentRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * Return an elqouent model instance for query building.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function builder()
    {
        if (! $this->model()) {
            throw new Exception("No model defined for repository ". get_class($this));
        }

        return $this->model();
    }

    /**
     * Return an elqouent model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model()
    {
        return null;
    }

    /**
     * Return all items of a model databse.
     *
     * @param  array $columns
     * @return array
     */
    public function all($columns = ['*'])
    {
        return $this->get($columns);
    }

    /**
     * Return the first item of a model database.
     *
     * @param  array $columns
     * @return array
     */
    public function first($columns = ['*'])
    {
        return $this->transform(collect(
            $this->builder()->first($columns)
        ));
    }

    /**
     * Return a paginated collection of a model database.
     *
     * @param  int   $limit
     * @param  int   $page
     * @param  array $columns
     * @return array
     */
    public function paginate(int $limit, $page = null, $columns = ['*'])
    {
        return $this->transform(
            $this->builder()->paginate($limit, $columns, 'page', $page)
        );
    }

    /**
     * Return an item of a model database by id.
     *
     * @param  int   $id
     * @param  array $columns
     * @return array
     */
    public function find(int $id, $columns = ['*'])
    {
        return $this->transform(collect(
            $this->builder()->find($id, $columns)
        ));
    }

    /**
     * Return an item of a model database with matched field and value.
     *
     * @param  string $field
     * @param  mixed  $value
     * @param  array  $columns
     * @return array
     */
    public function findBy(string $field, $value, $columns = ['*'])
    {
        return $this->transform(collect(
            $this->builder()->select($columns)
                            ->where($field, '=', $value)
                            ->first()
        ));
    }

    /**
     * Return collection of items of a model database with matched field and value.
     *
     * @param  string $field
     * @param  string $comparator
     * @param  mixed  $value
     * @param  array  $columns
     * @return array
     */
    public function findWhere(string $field, string $comparator, $value, $columns = ['*'])
    {
        return $this->transform(
            $this->builder()->select($columns)
                            ->where($field, $comparator, $value)
                            ->get()
        );
    }

    /**
     * Return collection of items of a model database with matched field and values.
     *
     * @param  string $field
     * @param  array  $values
     * @param  array  $columns
     * @return array
     */
    public function findWhereIn(string $field, array $values, $columns = ['*'])
    {
        return $this->transform(
            $this->builder()->select($columns)
                            ->whereIn($field, $values)
                            ->get()
        );
    }

    /**
     * Return collection of items of a model database without the matched field and values.
     *
     * @param  string $field
     * @param  array  $values
     * @param  array  $columns
     * @return array
     */
    public function findWhereNotIn(string $field, array $values, $columns = ['*'])
    {
        return $this->transform(
            $this->builder()->select($columns)
                            ->whereNotIn($field, $values)
                            ->get()
        );
    }

    /**
     * Return a query builder of model with order by clause.
     *
     * @param  string $column
     * @param  string $direction
     * @return array
     */
    public function orderBy(string $column, $direction = 'asc')
    {
        return $this->builder()->orderBy($column, $direction);
    }

    /**
     * Return a query builder of model with relationships clause.
     *
     * @param  array $relationships
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function with(array $relationships)
    {
        return $this->builder()->with($relationships);
    }

    /**
     * Return a query builder of model with relation has clause.
     *
     * @param  string $relation
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function has(string $relation)
    {
        return $this->builder()->has($relation);
    }

    /**
     * Return a query builder of model with where relationship clause.
     *
     * @param  string  $relation
     * @param  closure $closure
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function whereHas(string $relation, closure $closure)
    {
        return $this->builder()->whereHas($relation, $closure);
    }

    /**
     * Return all items of a model databse after a previous query builder.
     *
     * @param  array $columns
     * @return array
     */
    public function get($columns = ['*'])
    {
        return $this->transform(
            $this->builder()->get($columns)
        );
    }
}
