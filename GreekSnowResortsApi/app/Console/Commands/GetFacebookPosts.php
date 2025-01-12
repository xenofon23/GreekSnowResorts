<?php

namespace App\Console\Commands;
use App\Models\Post;
use App\Models\SnowResorts;
use HeadlessChromium\BrowserFactory;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class GetFacebookPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-facebook-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $snowResortData = SnowResorts::select('id', 'facebook_name')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'facebook_name' => $item->facebook_name,
                ];
            })
            ->filter(function ($item) {
                return !is_null($item['facebook_name']);
            })
            ->values()
            ->toArray();

        $browserFactory = new BrowserFactory('chromium-browser');
        $browserFactory->setOptions([
            'args' => ['--no-sandbox'] // Disable sandboxing when running as root
        ]);
        $posts=[];
        $browser = $browserFactory->createBrowser();
        foreach ($snowResortData as $item) {
            $facebookName = $item['facebook_name'];
            $page = $browser->createPage();

            $page->navigate("https://www.facebook.com/$facebookName")->waitForNavigation();

            $postContent  = $page->evaluate("
            (() => {
                const post = document.querySelector('[data-ad-preview=\"message\"]');
                return post ? post.innerText : null;
            })()
            ")->getReturnValue();
            $postIdentifier = md5($postContent);
            $posts[] = [
                "content" => $postContent,
                "snow_resort_id" => $item['id'],
                "post_identifier" => $postIdentifier,
            ];
            $page->close();

        }
        $this->savePosts($posts);
    }

    public function savePosts($posts)
    {
        foreach ($posts as $post)
        {
            if($post['content']==null)
            {
                continue;
            }
            $existingPost=Post::where('post_identifier', $post['post_identifier'])->first();
            if (!$existingPost) {
                Post::create($post);
            }
        }
    }

}
