<?php

use Sunlight\Plugin\PluginRouterMatch;
use Sunlight\Util\Response;
use Sunlight\WebState;
use SunlightExtend\RssFeed\RssFeed;

return function (WebState $index, PluginRouterMatch $match) {
    RssFeed::show();
    exit;
};
