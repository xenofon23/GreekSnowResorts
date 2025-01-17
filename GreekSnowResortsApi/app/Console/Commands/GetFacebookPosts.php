<?php

namespace App\Console\Commands;
use App\Models\Post;
use App\Models\SnowResorts;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Page;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;

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

        $posts=[];

        foreach ($snowResortData as $item) {
            $browserFactory = new BrowserFactory('chromium-browser');

            $browser = $browserFactory->createBrowser([ 'noSandbox' => true]);

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
            $posts= [
                "content" => $postContent,
                "snow_resort_id" => $item['id'],
                "post_identifier" => $postIdentifier,
            ];
            echo $postContent;
            $page->close();
            $this->savePosts($posts);

        }
    }

    public function savePosts($posts)
    {

            if($posts['content']!==null)
            {
                Post::create($posts);
            }


    }

}
