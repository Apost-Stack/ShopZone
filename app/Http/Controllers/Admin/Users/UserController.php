<?php
namespace App\Http\Controllers\Admin\Users;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['customer', 'employee'])->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', new EnumRule(RoleEnum::class)],

            'customer.first_name' => 'required_if:role,' . RoleEnum::CUSTOMER->value . '|string|max:255',
            'customer.last_name' => 'required_if:role,' . RoleEnum::CUSTOMER->value . '|string|max:255',
            'customer.phone' => 'nullable|string|max:50',
            'employee.first_name' => 'required_if:role,' . RoleEnum::EMPLOYEE->value . '|string|max:255',
            'employee.last_name' => 'required_if:role,' . RoleEnum::EMPLOYEE->value . '|string|max:255',
            'employee.phone' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            if ($data['role'] === RoleEnum::CUSTOMER->value) {
                $user->customer()->create(array_merge($request->input('customer', []), ['user_id' => $user->id, 'status_id' => 1]));
            } elseif ($data['role'] === RoleEnum::EMPLOYEE->value) {
                $user->employee()->create(array_merge($request->input('employee', []), ['user_id' => $user->id]));
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }


    public function createUsersCustomer(): View
    {
        return view('admin.users.create_customer');
    }

    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            // Champs User
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',

            // Champs Customer
            'customer.first_name' => 'required|string|max:255',
            'customer.last_name'  => 'required|string|max:255',
            'customer.phone'      => 'nullable|string|max:50',
            'customer.birthday'   => 'nullable|date',
            'customer.civility'   => 'nullable|string|max:50',
            'customer.province_id'=> 'nullable|exists:provinces,id',
            'customer.address'    => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => RoleEnum::CUSTOMER->value,
            ]);

            $user->customer()->create(array_merge(
                $request->input('customer', []),
                [
                    'user_id'   => $user->id,
                    'status_id' => 1
                ]
            ));

            DB::commit();
            return redirect()->route('Auth.login')->with('success', 'Compte crée avec succès. Vous pouvez maintenant vous connecter.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du customer : ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => ['sometimes', 'required', new EnumRule(RoleEnum::class)],

            'customer.first_name' => 'required_if:role,' . RoleEnum::CUSTOMER->value . '|string|max:255',
            'customer.last_name' => 'required_if:role,' . RoleEnum::CUSTOMER->value . '|string|max:255',
            'employee.first_name' => 'required_if:role,' . RoleEnum::EMPLOYEE->value . '|string|max:255',
            'employee.last_name' => 'required_if:role,' . RoleEnum::EMPLOYEE->value . '|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            if (isset($data['name'])) $user->name = $data['name'];
            if (isset($data['email'])) $user->email = $data['email'];
            if (!empty($data['password'])) $user->password = Hash::make($data['password']);
            if (isset($data['role'])) $user->role = $data['role'];
            $user->save();

            if ($user->role === RoleEnum::CUSTOMER->value) {
                $cust = $request->input('customer', []);
                $user->customer()->updateOrCreate(['user_id' => $user->id], $cust);
                if ($user->employee) $user->employee()->delete();
            } elseif ($user->role === RoleEnum::EMPLOYEE->value) {
                $emp = $request->input('employee', []);
                $user->employee()->updateOrCreate(['user_id' => $user->id], $emp);
                if ($user->customer) $user->customer()->delete();
            } else {
                $user->customer?->delete();
                $user->employee?->delete();
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->customer?->delete();
            $user->employee?->delete();
            $user->delete();
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
