<?php

namespace App\Http\Controllers;

use App\Events\WebsocketDemoEvent;
use App\Models\Company;
use App\Models\Coordinate;
use App\Models\Karyawan;
use App\Models\Log;
use App\Models\Loker;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Jikan\MyAnimeList\MalClient;
use Jikan\Request\Manga\MangaRequest;

class HomeController extends Controller
{
    public function index()
    {
        $competencies = ['Web Programming', 'Desktop Programing', 'Machine Learning', 'Internet of Things', 'Embedded System', 'Design UI/UX', 'Design 2D & 3D', 'Mobile Programming'];
        $lokers = Loker::orderBy('updated_at', 'desc')->get();
        $company = Company::first();

        return view('home.index', [
            'title' => 'Makerindo',
        ], compact('lokers', 'company'));
    }

    public function show_loker(Loker $loker)
    {
        $company = Company::first();
        return view('home.loker.show', [
            'title' => "$loker->title"
        ], compact('loker', 'company'));
    }

    public function message()
    {
        return view('home.message', [
            'title' => 'Pesan untuk perusahaan'
        ]);
    }

    public function dashboard()
    {
        $postsCount = Cache::remember('postsCount', now()->addDays(1), function () {
            return Post::count();
        });

        $usersCount = Cache::remember('usersCount', now()->addDays(1), function () {
            return User::count();
        });
        
        $karyawanCount = Cache::remember('karyawanCount', now()->addDays(1), function () {
            return Karyawan::count();
        });
        
        $markerCount = Cache::remember('markerCount', now()->addDays(1), function () {
            return Coordinate::count();
        });
        
        return view('dashboard.index', [
            'title' => 'Dashboard',
        ], compact('usersCount', 'postsCount', 'karyawanCount', 'markerCount'));
    }
    
   
    public function logs_list()
    {
        $logs = Log::with('user')->where('id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        return view('logs.list', [
            'title' => 'Log List',
        ], compact('logs'));
    }

    public function data_mal()
    {
        $jikan = new MalClient;
        $anime = $jikan->getAnime(new \Jikan\Request\Anime\AnimeRequest(22));
        $manga = $jikan->getManga(
            (new MangaRequest(11))
        );
        dd($manga, $anime);
    }
}
