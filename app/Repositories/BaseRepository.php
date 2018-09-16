<?php

namespace App\Repositories;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Transformers\DefaultTransformer;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class BaseRepository
{
    /**
     * Transformer Manager.
     *
     * @var \League\Fractal\Manager
     */
    public $manager;

    /**
     * Transformer instance.
     *
     * @var League\Fractal\TransformerAbstract
     */
    public $transformer;

    /**
     * BaseRepository contructor.
     */
    public function __construct()
    {
        $this->manager = new Manager();
        $this->transformer = $this->transformer();
    }

    /**
     * Return a fractal transformer.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function transformer()
    {
        return new DefaultTransformer;
    }

    /**
     * Set transformer instance.
     *
     * @param League\Fractal\TransformerAbstract
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
        return $this;
    }

    /**
     * Transform collection or item to array.
     *
     * @param  mixed
     * @return array
     */
    public function transform($resource)
    {
        $data = $resource instanceof EloquentCollection
                ? $this->transformCollection($resource)
                : $this->transformItem($resource);

        return $this->manager->createData($data)->toArray();
    }

    /**
     * Transform eloquent collection to fractal collection.
     *
     * @param  \Illuminate\Database\Eloquent\Collection
     * @return \League\Fractal\Resource\Collection
     */
    private function transformCollection($collection)
    {
        return new Collection($collection, $this->transformer);
    }

    /**
     * Transform eloquent model to fractal item.
     *
     * @param  \Illuminate\Database\Eloquent\Model
     * @return \League\Fractal\Resource\Item
     */
    private function transformItem($item)
    {
        return new Item($item, $this->transformer);
    }
}
