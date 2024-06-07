<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Filters\OrderFilter;
use App\Http\Requests\BulkStoreOrderRequest;
use Illuminate\Support\Arr;



use App\DAO\OrderDAO;


class OrderController extends Controller
{
    protected $orderDAO;

    public function __construct(OrderDAO $orderDAO)
    {
        $this->orderDAO = $orderDAO;
    }

    public function index(Request $request)
    {
        $orders = $this->orderDAO->getAll();
        return new OrderCollection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $order = $this->orderDAO->create($data);
        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = $this->orderDAO->getById($id);
        return response()->json($order);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $data = $request->validated();
        $order = $this->orderDAO->update($id, $data);
        return response()->json($order);
    }

    public function destroy($id)
    {
        $this->orderDAO->delete($id);
        return response()->json(null, 204);
    }

    public function bulkStore(BulkStoreOrderRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr) {
            return Arr::except($arr, ['supplierId', 'billedDate', 'paidDate']);
        });

        $this->orderDAO->bulkCreate($bulk->toArray());

        return response()->json(['message' => 'Orders created successfully'], 201);
    }
}
