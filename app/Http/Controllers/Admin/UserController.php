<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

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
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::where('role', '!=', 'ADMIN')->get())
                ->addIndexColumn()
                ->editColumn('salary_number', function($row) {
                    return $row->salary_number ?? '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="' . route('admin.user.show', $row) . '" class="btn btn-sm btn-success">Show</a>
                            <a href="' . route('admin.user.edit', $row) . '" class="btn btn-sm btn-primary">Edit</a>
                            <form action="' . route('admin.user.destroy', $row) . '" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <a href="#" class="btn btn-sm btn-danger ' . ( $row->role != 'SERVICEMAN' ? 'disabled' : '') . '" onclick="event.preventDefault(); deleteConfirm(this)">Delete</a>
                            </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.user.index', [
            'title' => 'Users',
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
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
            return redirect()->route('admin.user.index')->with('error', $exception->getMessage());
        }
    }
}
