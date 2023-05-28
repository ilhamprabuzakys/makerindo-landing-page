<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Kota;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\UsersJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function grid()
    {
        $users = User::with('posts')->orderBy('updated_at', 'desc')->get();
        return view('users.grid', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }

    public function index()
    {
        /* Job */
        // $job = new UsersJob();
        // $this->dispatch($job);
        // $users = User::with('posts.tags')->orderBy('updated_at', 'desc')->get();
        // $client = new Predis\();
        // $client->set('foo', 'bar');
        // $value = $client->get('foo');

        // $users = Cache::remember('users', 60*60*24, function() {
        //     return User::orderBy('updated_at', 'desc')->get();
        // });

        $usersCount = Cache::remember('usersCount', now()->addDays(1), function() {
            return User::count();
        });

        // return Cache::get('users');
        return view('users.list', [
            'title' => 'Users',
        ], compact('usersCount'));
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = Cache::remember('posts', 60*60*24, function() {
                return User::orderBy('updated_at', 'desc')->get();
            });
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit badge badge-soft-success">Edit</a> <a href="#" class="delete badge badge-soft-danger">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // ' . "{{ route('users.edit') }}" .'
        // ' . "{{ route('users.destroy') }}" .'
    }

    public function create()
    {
        $roles = ['admin', 'moderator', 'user'];

        return view('users.create', [
            'title' => 'Tambah User',
        ], compact('roles'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
        ], [
            'kota_id.required' => 'Field kota is required',
            'kecamatan_id.required' => 'Field kecamatan is required',
            'firstname.required' => 'Field name is required'
        ]);
        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Gabungkan firstname dan lastname menjadi satu field name
        if (!empty($validatedData['lastname'])) {
            $name = trim($validatedData['firstname']) . ' ' . trim($validatedData['lastname']);
        } else {
            $name = $validatedData['firstname'];
        }

        $validatedData['name'] = $name;
        $validatedData['username'] = $request->input('username');
        // Enkripsi password dengan bcrypt
        $validatedData['password'] = bcrypt($validatedData['password']);

        // jika field username kosong, maka buat username berdasarkan email
        // dd($validatedData['username']);
        if (empty($validatedData['username'])) {
            $username = explode('@', $validatedData['email'])[0];
        } else {
            $username = $validatedData['username'];
        }
        $validatedData['username'] = $username;
        // dd($validatedData);

        $user = User::create($validatedData);
        Log::create([
            'user_id' => auth()->user()->id,
            'type' => 'success',
            'action' => 'store',
            'on' => 'User',
            'description' => "User data $user->name was successfully stored."
        ]);

        return redirect()->route('users.index')->with('message', "Data User <b>$user->name</b> telah berhasil <b>ditambahkan!</b>");
    }


    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $kotas = Kota::orderBy('updated_at', 'desc')->get();
        $kecamatans = Kecamatan::orderBy('updated_at', 'desc')->get();
        $roles = ['admin', 'moderator', 'user'];

        $fullname = $user->name;
        $lastSpacePos = strrpos($fullname, ' ');
        if ($lastSpacePos === false) {
            // Jika tidak ditemukan spasi, berarti hanya ada 1 kata dalam $fullname
            $lastname = '';
        } else {
            $lastname = substr($fullname, $lastSpacePos + 1);
        }
        // Memotong kata terakhir dari $fullname
        $firstname = trim(substr($fullname, 0, $lastSpacePos));

        if (empty($firstname)) {
            $firstname = $fullname;
        }

        return view('users.edit', [
            'title' => 'Edit User',
        ], compact('kotas', 'kecamatans', 'roles', 'firstname', 'lastname', 'user'), response()->json(['kecamatan_id', $user->kecamatan->id]));
    }

    // public function getKecamatan($kota_id)
    // {
    //     $kecamatan = Kecamatan::where('kota_id', $kota_id)->get();
    //     return response()->json(['data' => $kecamatan]);
    // }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'alamat' => 'required|min:4',
        ], [
            'kota_id.required' => 'Field kota is required',
            'kecamatan_id.required' => 'Field kecamatan is required',
            'firstname.required' => 'Field name is required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Gabungkan firstname dan lastname menjadi satu field name
        if (!empty($validatedData['lastname'])) {
            $name = trim($validatedData['firstname']) . ' ' . trim($validatedData['lastname']);
        } else {
            $name = $validatedData['firstname'];
        }

        $validatedData['name'] = $name;

        // jika field username kosong, maka buat username berdasarkan email
        if (empty($validatedData['username'])) {
            $validatedData['username'] = explode('@', $validatedData['email'])[0];
        }

        // encrypt password
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('message', "Data User <b>$user->name</b> telah berhasil <b>diperbarui!</b>");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $oldTitle = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('message', "Data user <b>$oldTitle</b> telah berhasil <b>dihapus!</b>");
    }
}
