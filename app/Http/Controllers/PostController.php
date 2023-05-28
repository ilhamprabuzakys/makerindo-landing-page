<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('posts', now()->addDays(1), function () {
            return Post::orderBy('updated_at', 'desc')->get();
        });

        $users = Cache::remember('users', now()->addDays(1), function () {
            return User::orderBy('updated_at', 'desc')->get();
        });

        $postsCount = Cache::remember('postsCount', now()->addDays(1), function () {
            return Post::count();
        });

        $usersCount = Cache::remember('usersCount', now()->addDays(1), function () {
            return User::count();
        });

        return view('posts.index', [
            'title' => 'All Post'
        ], compact('posts', 'postsCount', 'users'));
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = Cache::remember('posts', now()->addDays(7), function () {
                return Post::orderBy('updated_at', 'desc')->get();
            });
            // $data = Post::orderBy('updated_at', 'desc')->get();
            return DataTablesDataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit badge badge-soft-success">Edit</a> <a href="javascript:void(0)" class="delete badge badge-soft-danger">Delete</a>';
                    return $actionBtn;
                })
                // ->addColumn('user_id', function ($row) {
                //     $users = User::orderBy('updated_at', 'desc')->get();
                //     if ($row->user_id) {
                //         foreach ($users as $user) {
                //             if ($row->user_id == $user->id) {
                //                 return "$user->name";
                //             }
                //         }
                //     } else {
                //         return '???';
                //     }
                // })
                // ->filter(function ($instance) use ($request) {
                //     $usersCount = Cache::remember('usersCount', now()->addDays(1), function () {
                //         return User::count();
                //     });
                //     if ($request->get('user_id') == 0) {
                //         $instance->orderBy('updated_at', 'desc')->get();
                //     } else {
                //         $instance->where('user_id', $request->get('user_id'));
                //     }
                //     // for ($i=1; $i <= $usersCount; $i++) { 
                //     //     if ($request->get('user_id') == $i) {
                //     //         $instance->where('user_id', $request->get('user_id'));
                //     //     }
                //     // }
                //     // if (!empty($request->get('search'))) {
                //     //     $instance->where(function ($w) use ($request) {
                //     //         $search = $request->get('search');
                //     //         $w->orWhere('name', 'LIKE', "%$search%")
                //     //             ->orWhere('email', 'LIKE', "%$search%");
                //     //     });
                //     // }
                // })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}
