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

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new OrderFilter();
        $queryItems = $filter->transform($request);


        if (count($queryItems) == 0) {
            return new OrderCollection(Order::paginate());
        } else {
            $orders = Order::where($queryItems)->paginate();
            return new OrderCollection($orders->appends($request->query()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    public function bulkStore(BulkStoreOrderRequest $request)
    {
        //
        $bulk = collect($request->all())->map(function ($arr, $key) {
        return Arr::except($arr, ['supplierId','billedDate','paidDate']);    
    });
        Order::insert($bulk->toArray());

    }
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
