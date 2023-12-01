<?php

use Sunlight\Router;

return function(array $args) {
    $args['output'] .= "\n<link rel=\"alternate\" type=\"application/rss+xml\" href=\"" . _e(Router::path("rss", ['absolute' => true])) . "\" title=\"" . _lang('rss-feed.generate.title') . "\">";
};
