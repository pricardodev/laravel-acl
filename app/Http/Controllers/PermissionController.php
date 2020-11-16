<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
 
    public function index()
    {
        $permissions = $this->permission->select('id', 'name')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $permission = $this->permission;
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
        $permission = $this->permission->where('id',$id)->first();
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permission->where('id',$id)->first();
        $permission->name = $request->name;
        $permission->update();

        return redirect()->route('permission.index');
    }

    public function destroy($id)
    {
        $permission = $this->permission->where('id',$id)->first();
        $permission->delete();

        return redirect()->route('permission.index');
    }
}
