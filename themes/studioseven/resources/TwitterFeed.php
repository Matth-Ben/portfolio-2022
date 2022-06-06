<?php

require_once('TwitterAPIExchange.php');

class TwitterFeed
{
    // Set your access tokens here - see: https://dev.twitter.com/apps/
    public static $settings = array(
        'oauth_access_token' => '628503721-xQpUobyH0KqqPh7trmrpLFHvnsYe0wQY4UoPZyhG',
        'oauth_access_token_secret' => 'gjnLch6T2hoIN1Rm7Sb4L5iTqqWYx2CJLYhLR7hFIi2oh',
        'consumer_key' => 'roaaZ1ooLcpk6V1F3KgMEzXY2',
        'consumer_secret' => 'xJHnfhA12CFgy3B5ySpkxGBAbvKifpMybyGF1srWmv2ZXPwAY2'
    );

    // Define the twitter name of the account that you wand the data from
    public static $username = 'AnneMOREAU35';

    // Define the number of tweets that you want to retrive
    public static $count = 4;

    public static function getTweets() {

        $uri = get_template_directory_uri();
        $svg = array(
            'favorite' => $uri . '/assets/images/svg/favorite.svg',
            'reply' => $uri . '/assets/images/svg/reply.svg',
            'retweet' => $uri . '/assets/images/svg/retweet.svg',
            'share-tweet' => $uri . '/assets/images/svg/share-tweet.svg',
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

        $requestMethod = 'GET';

        $getFields = '?screen_name=' . TwitterFeed::$username . '&tweet_mode=extended&include_entities=true&count=' . TwitterFeed::$count;

        $twitter = new TwitterAPIExchange(TwitterFeed::$settings);

        $string = json_decode($twitter->setGetfield($getFields)
            ->buildOauth($url, $requestMethod)
            ->performRequest(), $assoc = TRUE);

        if(array_key_exists('errors', $string)) {
            echo '<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>' . $string[errors][0]['message'] . '</em></p>';exit();
        }

        $tweets = [];

        // Return all the data you want to display
        foreach($string as $items)
        {
            $tweet = array (
                'id' => $items['id_str'],
                'url' => 'https://twitter.com/' . $items['user']['screen_name'] . '/status/' . $items['id_str'],
                'content' => $items['full_text'],
                'fullname' => $items['user']['name'],
                'username' => $items['user']['screen_name'],
                'profile_img' => str_replace('_normal', '', $items['user']['profile_image_url_https']),
                'retweet_count' => $items['retweet_count'],
                'favorite_count' => $items['favorite_count'],
                'reply_icon' => $svg['reply'],
                'retweet_icon' => $svg['retweet'],
                'favorite_icon' => $svg['favorite'],
                'share_icon' => $svg['share-tweet'],
            );
            array_push($tweets, $tweet);
        }

        return $tweets;
    }
}
