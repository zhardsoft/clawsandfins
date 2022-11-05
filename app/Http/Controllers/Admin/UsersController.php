<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Distributor;
use App\Models\Investor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        if (session()->has('mail-draft-id')) {
            Session::remove('mail-draft-id');
            Session::remove('userchecked');
            Session::remove('mail-subject');
            Session::remove('mail-message');
        }
        // if(Auth::user() -> hasPermissionTo('view users')) {
            $users = User::latest()->paginate(10);
            return view('admin.users.index', compact('users'));
        // }else{
        //     abort(403);
        // }
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request) 
    {
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $user->create(array_merge($request->validated(), [
            'password' => 'test' 
        ]));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) 
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {
        return view('admin.users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request) 
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }
    
    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) 
    {
        $user->delete();
        
        return redirect()->route('users.index')
        ->withSuccess(__('User deleted successfully.'));
    }

    public function updateUserRole(Request $request) 
    {
        // return $request->input();
        $user = User::find($request->id);

        if($request->status == '-1'){
            $user->status = '-1';
        }else if($request->status == '1'){
            $currentRole = $user->getRoleNames()[0];
            if($currentRole == 'investor candidate'){
                $user->syncRoles(['investor']);
            }else if($currentRole == 'distributor candidate'){
                $user->syncRoles(['distributor']);
            }
            $user->status = '1';
        }
        $user->save();
        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }
}