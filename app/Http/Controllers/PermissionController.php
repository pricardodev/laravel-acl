<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
 
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $permission = Permission::where('id',$id)-first();
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::where('id',$id)-first();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index');
    }

    public function destroy($id)
    {
        $permission = Permission::where('id',$id)-first();
        $permission->delete();

        return redirect()->route('permission.index');
    }
}
