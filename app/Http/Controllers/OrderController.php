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

    // Método para obtener todas las órdenes
    public function index(Request $request)
    {
        // Obtiene todas las órdenes utilizando el DAO
        $orders = $this->orderDAO->getAll();
        // Retorna la colección de órdenes en formato JSON
        return new OrderCollection($orders);
    }

    // Método para almacenar una nueva orden
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $order = $this->orderDAO->create($data);
        return response()->json($order, 201);
    }

    // Método para obtener una orden específica por su ID
    public function show($id)
    {
        $order = $this->orderDAO->getById($id);
        return response()->json($order);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $data = $request->validated();
        $order = $this->orderDAO->update($id, $data);
        // Retorna la orden creada en formato JSON 
        return response()->json($order);
    }

    public function destroy($id)
    {
        $this->orderDAO->delete($id);
        return response()->json(null, 204);
    }

    // Método para almacenar múltiples órdenes de manera masiva
    public function bulkStore(BulkStoreOrderRequest $request)
    {
        // Procesa los datos de la solicitud para eliminar ciertos campos
        $bulk = collect($request->all())->map(function ($arr) {
            return Arr::except($arr, ['supplierId', 'billedDate', 'paidDate']);
        });

        // Almacena las órdenes masivas utilizando el DAO
        $this->orderDAO->bulkCreate($bulk->toArray());

        // Retorna un mensaje de éxito en formato JSON con código de estado 201 (creado)
        return response()->json(['message' => 'Orders created successfully'], 201);
    }
}
