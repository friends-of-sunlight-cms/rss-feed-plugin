<?php

namespace SunlightExtend\RssFeed;

use Sunlight\Core;
use Sunlight\Template;
use Sunlight\Router;
use Sunlight\Database\Database as DB;

class RssFeed
{
    private static function getDir()
    {
        return SL_ROOT . Core::$pluginManager->getPlugins()->getExtend('rss-feed')->getWebPath() . "/public/";
    }
    
    public static function create()
    {
        $limit = Core::$pluginManager->getPlugins()->getExtend('rss-feed')->getConfig()['limit'];
        $title = Template::siteTitle() . " - " . _lang('rss-feed.generate.title');
        
        $items = DB::query("SELECT id,time,title,perex FROM `" . DB::table('article') . "` WHERE confirmed=1 AND time<=" . time() . " AND public=1 ORDER BY time DESC LIMIT " . $limit);
        while ($item = DB::row($items)) {
            $feeditems[] = array($item['title'], Router::article($item['id'], null, null, ['absolute' => true]), strip_tags($item['perex']), $item['time']);
        }
        
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $content .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\" xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\">\n";
        $content .= "<channel>\n";
        $content .= "<title>" . $title . "</title>\n";
        $content .= "<atom:link href=\"" . _e(Router::path("rss", ['absolute' => true])) . "\" rel=\"self\" type=\"application/rss+xml\" />\n";
        $content .= "<link>" . Template::siteUrl() . "</link>\n";
        $content .= "<description>" . Template::siteDescription() . "</description>\n";
        $content .= "<language>" . _e(Core::$langPlugin->getIsoCode()) . "</language>\n";
        $content .= "<sy:updatePeriod>hourly</sy:updatePeriod>\n";
        $content .= "<sy:updateFrequency>1</sy:updateFrequency>\n";
        $content .= "<image>\n";
        $content .= "<title>" . $title . "</title>\n";
        $content .= "<url>" . _e(Router::file(self::getDir() . "images/rss-logo.gif", ['absolute' => true])) . "</url>\n";
        $content .= "<link>" .  Template::siteUrl() . "</link>\n";
        $content .= "<width>60</width>\n";
        $content .= "<height>60</height>\n";
        $content .= "</image>\n";

        foreach ($feeditems as $feeditem) {
            $content .= "<item>\n";
            $content .= "<title>" . $feeditem[0] . "</title>\n";
            $content .= "<link>" . $feeditem[1] . "</link>\n";
            $content .= "<pubDate>" . date('r', $feeditem[3]) . "</pubDate>\n";
            $content .= "<description><![CDATA[" . $feeditem[2] . "]]></description>\n";
            $content .= "<guid isPermaLink=\"true\">" . $feeditem[1] . "</guid>\n"; 
            $content .= "</item>\n";
        }

        $content .= "</channel>\n";
        $content .= "</rss>\n";

        $file = fopen(self::getDir() . "rss.xml", "w") or die("Unable to open file!");
        fwrite($file, $content);
        fclose($file);
    }
    
    public static function show()
    {
        header("Content-Type: application/xml; charset=UTF-8");
        readfile(self::getDir() . "rss.xml");
    }
}
