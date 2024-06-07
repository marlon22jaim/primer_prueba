<?php

namespace App\DAO;

use App\Models\Order;

class OrderDAO
{
    public function getAll()
    {
        return Order::paginate();
    }

    public function getById($id)
    {
        return Order::findOrFail($id);
    }

    public function create($data)
    {
        return Order::create($data);
    }

    public function update($id, $data)
    {
        $order = Order::findOrFail($id);
        $order->fill($data)->save();
        return $order;
    }

    public function delete($id)
    {
        return Order::destroy($id);
    }

    public function bulkCreate($data)
    {
        return Order::insert($data);
    }
}
