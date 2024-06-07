<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierCollection;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Filters\SupplierFilter;
use Illuminate\Http\Request;




use App\DAO\SupplierDAO;


class SupplierController extends Controller
{
    protected $supplierDAO;

    public function __construct(SupplierDAO $supplierDAO)
    {
        $this->supplierDAO = $supplierDAO;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return new SupplierCollection($this->supplierDAO->obtenerTodos());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $supplier = $this->supplierDAO->crear($request->all());
        return response()->json(['message' => 'Proveedor creado correctamente', 'data' => new SupplierResource($supplier)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //
        $includeOrders = request()->query('includeOrders');
        $supplier = $this->supplierDAO->obtenerPorId($id);
        if ($includeOrders) {
            return new SupplierResource($supplier->loadMissing('orders'));
        }


        //



        if (!$supplier) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = $this->supplierDAO->obtenerPorId($id);
        if (!$supplier) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }
        $supplier = $this->supplierDAO->actualizar($id, $request->all());
        return new SupplierResource($supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = $this->supplierDAO->obtenerPorId($id);
        if (!$supplier) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }
        $this->supplierDAO->eliminar($id);
        return response()->json(['message' => 'Proveedor eliminado correctamente'], 200);
    }
}
