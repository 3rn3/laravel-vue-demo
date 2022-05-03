<?php

namespace App\Services\Product\Implementation\Services\Product;

class Services
{
    protected ?Store $store = null;
    protected ?Update $update = null;
    protected ?Search $search = null;

    public function store(): Store
    {
        if (! $this->store instanceof Store) {
            $this->store = resolve(Store::class);
        }

        return $this->store;
    }

    public function update(): Update
    {
        if (! $this->update instanceof Update) {
            $this->update = resolve(Update::class);
        }

        return $this->update;
    }

    public function search(): Search
    {
        if (! $this->search instanceof Search) {
            $this->search = resolve(Search::class);
        }

        return $this->search;
    }
}
