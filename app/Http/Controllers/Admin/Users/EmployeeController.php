<?php
namespace App\Http\Controllers\Admin\Users;

use App\Common\CommonAdminView;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Users\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->paginate(20);
        return view(CommonAdminView::getEmployeeListView(), compact('employees'));
    }

    public function create()
    {
        return view(CommonAdminView::getEmployeeEditOrCreateView());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'user.name' => 'required_without:user_id|string|max:255',
            'user.email' => 'required_without:user_id|email|unique:users,email',
            'user.password' => 'required_without:user_id|string|min:6|confirmed',

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            if (isset($data['user_id'])) {
                $user = User::findOrFail($data['user_id']);
                if ($user->role !== RoleEnum::EMPLOYEE->value) {
                    $user->role = RoleEnum::EMPLOYEE->value;
                    $user->save();
                }
            } else {
                $ud = $request->input('user');
                $user = User::create([
                    'name' => $ud['name'],
                    'email' => $ud['email'],
                    'password' => Hash::make($ud['password']),
                    'role' => RoleEnum::EMPLOYEE->value,
                ]);
            }

            $employee = Employee::create(array_merge($request->only(['first_name','last_name','phone','position']), ['user_id' => $user->id]));
            DB::commit();
            return redirect()->route('admin.users.employees.index')->with('success', 'Employee créé avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'employee : ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        return view(CommonAdminView::getEmployeeShowView(), compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
        ]);

        try {
            $employee->update($data);
            return redirect()->route('admin.users.employees.index')->with('success', 'Employee mis à jour avec succès.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'employee : ' . $e->getMessage());
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('admin.users.employees.index')->with('success', 'Employee supprimé avec succès.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'employee : ' . $e->getMessage());
        }
    }
}
