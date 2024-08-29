<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'l\'employée a été créer avec succès 🎉🥳
🎉.');
    }

    public function edit(User $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
        ]);

        $employee->update($request->only('name', 'email'));

        return redirect()->route('admin.employees.index')->with('success', 'Employee modifier avec succès 💪⬆💪.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'empoyée supprimer avec succès 🗑🚮🗑');
    }
}
