<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierCollection;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Filters\SupplierFilter;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new SupplierFilter();
        $queryItems = $filter->transform($request);

        $includeOderdes = $request->query('includeOrders');
        $supplier = Supplier::where($queryItems);

        if ($includeOderdes) {
            $supplier = $supplier->with('orders');
        }
        return new SupplierCollection($supplier->paginate()->appends($request->query()));
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
    public function store(StoreSupplierRequest $request)
    {
        // 
        $supplier = new SupplierResource(Supplier::create($request->all()));
        return response()->json(['message' => 'Proveedor creado correctamente', 'data' => new SupplierResource($supplier)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
        $includeOrders = request()->query('includeOrders');
        
        if ($includeOrders) {
            return new SupplierResource($supplier->loadMissing('orders'));
        }
        return new SupplierResource($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //

        $supplier->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
        // Elimina el proveedor
        $supplier->delete();

        // Devuelve una respuesta indicando que el proveedor ha sido eliminado
        return response()->json(['message' => 'Proveedor eliminado correctamente'], 200);
    }
}
