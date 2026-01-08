<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Models\Import;

use Maatwebsite\Excel\Facades\Excel;


use Inertia\Inertia;

class ProductImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx'
        ]);
        $import = Import::create([
            'type' => 'products',
            'status' => 'pending',
        ]);

        Excel::queueImport(
            new ProductsImport($import->import_id),
            $request->file('file')
        );


        return response()->json([
            'message' => 'Products import started successfully'
        ]);
    }
    public function index()
    {
        $imports = Import::latest()->paginate(10);

        return Inertia::render('Admin/Imports', [
            'imports' => $imports,
        ]);
    }
}
