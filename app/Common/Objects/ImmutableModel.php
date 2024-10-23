<?php

namespace App\Common\Objects;

use Illuminate\Database\Eloquent\Model;

/** 
 * @template T of Model */
class ImmutableModel {

    /**
     * @var T $model */
    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;

    }

    public function __get($name) {
        $value = $this->model->$name;
        return $value;
    }

    public static function from(Model $model): ImmutableModel {
        return new ImmutableModel($model);
    }
}

/** TypeHint Example
 * @param ImmutableModel<Customer> $customer
 * @param ImmutableModel<Store> $store
 * @param ImmutableModel<AgentSales> $storeManager 
 * public function __construct(ImmutableModel $customer, ImmutableModel $store, ImmutableModel $storeManager) {}
 *  */