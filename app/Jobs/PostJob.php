<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jmlhdata = 10000;
        $title = fake()->sentence(rand(5, 10));
        $slug = Str::slug($title, '-');
        for ($i = 1; $i <= $jmlhdata; $i++) {
            $data = [
                'user_id' => User::inRandomOrder()->first()->id,
                'title' => $title,
                'slug' => $slug,
                'body' => fake()->paragraphs(\rand(3, 6), true),
            ];
            Post::create($data);
        }
    }
}
