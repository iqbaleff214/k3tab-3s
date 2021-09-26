<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    private $form = [
        'salary_number' => 'text',
        'name' => 'text',
        'email' => 'email',
        'address' => 'text',
        'phone_number' => 'text',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('pages.admin.user.index', [
            'title' => 'Users',
            'items' => User::where('role', 'MECHANIC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('pages.admin.user.create', [
            'title' => 'Add User',
            'forms' => $this->form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email:dns', 'unique:users,email'],
            'name' => ['required'],
            'salary_number' => ['required', 'unique:users,salary_number'],
            'password' => 'required'
        ]);

        try {
            $data = $request->input();
            $data['password'] = Hash::make($request->input('password'));
            User::create($data);
            return redirect()->route('admin.user.index')->with('success', 'Successfully added service man!');
        } catch (\Exception $exception) {
            return redirect()->route('admin.user.create')->with('error', $exception->getMessage());
        }
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xls,xlsx,ods', 'max:2048']
        ]);

        try {
            Excel::import(new UsersImport(), \request()->file('file'));
            return redirect()->route('admin.user.index')->with('success', 'Successfully imported service men!');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Renderable
     */
    public function show(User $user): Renderable
    {
        return view('pages.admin.user.show', [
            'title' => 'Show User',
            'forms' => $this->form,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user): Renderable
    {
        unset($this->form['email']);
        return view('pages.admin.user.edit', [
            'title' => 'Edit User',
            'forms' => $this->form,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'salary_number' => ['required', Rule::unique('users')->ignore($user)],
            'name' => ['required'],
        ]);

        try {
            $user->update($request->input());
            return back()->with('success', 'Successfully edited the service man!');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'Successfully deleted the serviceman!');
        } catch (\Exception $exception) {
            return redirect()->route('admin.user.index')->with('error', $exception->getMessage());
        }
    }
}
