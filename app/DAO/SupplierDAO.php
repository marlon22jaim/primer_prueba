<?php

namespace App\DAO;

use App\Models\Supplier;

class SupplierDAO
{
    public function obtenerTodos()
    {
        return Supplier::all();
    }

    public function obtenerPorId($id)
    {
        return Supplier::find($id);
    }

    public function crear($datos)
    {
        return Supplier::create($datos);
    }

    public function actualizar($id, $datos)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->fill($datos)->save();
        return $supplier;
    }

    public function eliminar($id)
    {
        return Supplier::destroy($id);
    }
}
