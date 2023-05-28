<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\UsersJob;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\ArrayToXml\ArrayToXml;

class UserController extends Controller
{
    public function indexredis()
    {
        // $users = User::orderBy('updated_at', 'desc')->get();
        // $job = new UsersJob();
        // $this->dispatch($job);
        $users = Cache::remember('users', now()->addDays(2), function() {
            return User::with('posts.tags')->orderBy('updated_at', 'desc')->get();
        });
        
        return response()->json([
        'data' => UserResource::collection($users),
        'message' => 'Fetch all Data user',
            'success' => true
        ]);
    }
    
    public function index()
    {
        $users = User::with('posts.tags')->orderBy('updated_at', 'desc')->get();
        return response()->json([
        'data' => UserResource::collection($users),
        'message' => 'Fetch all Data user',
            'success' => true
        ]);
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $user = User::create($validatedData);

        return response()->json([
            'data' => new UserResource($user),
            'message' => "User dengan nama: $user->name berhasil ditambahkan.",
            'success' => true
        ]);

        // return new UserResource(true, "user $user->name berhasil ditambahkan.", $user);

    }

    public function show(user $user)
    {
        if ($user) {
            return response()->json([
                'data' => new UserResource($user),
                'message' => "Data user dengan id $user->id berhasil ditemukan.",
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Data tidak ditemukan.',
                'success' => false
            ], 404);
        }
    }

    public function update(Request $request, user $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => '',
            'email' => 'unique:users,email,' . $user->id,
            'username' => 'unique:users,username,' . $user->id,
            'password' => '',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json([
                'data' => $validator->fails(),
                'message' => "Something went wrong",
                'success' => \false
            ], 500);
        }

        $validatedData = $validator->validated();

        $user->update($validatedData);

        return response()->json([
            'data' => new UserResource($user),
            'message' => "User $user->name berhasil diupdate.",
            'success' => true
        ]);
    }

    public function destroy(user $user)
    {
        $oldTitle = $user->name;
        $user->delete();

        // return response()->json(null, 204);
        return response()->json([
            'data' => [],
            'message' => "User dengan nama: $oldTitle telah dihapus.",
            'success' => true
        ]);
    }

    /* public function index()
    {
        // $data = [
        //     'status' => 'success',
        //     'message' => 'Fetch all Data user',
        //     'data' => [
        //         [
        //             'first_name' => 'John',
        //             'last_name' => 'Smith',
        //         ],
        //         [
                    
        //         ]
        //     ]
        // ];
        // $data = ArrayToXml::convert(['data' => $users->toArray()]);
        // return response($data, 200)->header('Content-Type', 'application/xml');
        // return response()->xml($users);
    } */
}
