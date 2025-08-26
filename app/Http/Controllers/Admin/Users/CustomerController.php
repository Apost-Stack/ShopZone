<?php
namespace App\Http\Controllers\Admin\Users;

use App\Common\CommonAdminView;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Users\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum as EnumRule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')->paginate(20);
        return view(CommonAdminView::getCustomerListView(), compact('customers'));
    }

    public function create()
    {
        return view(CommonAdminView::getCustomerEditOrCreateView());
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
        ]);

        DB::beginTransaction();
        try {
            if (isset($data['user_id'])) {
                $user = User::findOrFail($data['user_id']);
                if ($user->role !== RoleEnum::CUSTOMER->value) {
                    $user->role = RoleEnum::CUSTOMER->value;
                    $user->save();
                }
            } else {
                $userData = $request->input('user');
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role' => RoleEnum::CUSTOMER->value,
                ]);
            }

            $customer = Customer::create(array_merge($request->only(['first_name', 'last_name', 'phone']), ['user_id' => $user->id]));
            DB::commit();
            return redirect()->route('admin.customers.index')->with('success', 'Customer créé avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la création du customer: ' . $e->getMessage()]);
        }
    }

    public function show(Customer $customer)
    {
        return view(CommonAdminView::getCustomerShowView(), compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        try {
            $customer->update($data);
            return redirect()->route('admin.customers.index')->with('success', 'Customer mis à jour avec succès.');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la mise à jour du customer: ' . $e->getMessage()]);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('admin.customers.index')->with('success', 'Customer supprimé avec succès.');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression du customer: ' . $e->getMessage()]);
        }
    }
}
