<?php

return function(array $args) {
    $args['output'] .= "\n<link rel=\"alternate\" type=\"application/rss+xml\" href=\"" . Sunlight\Router::path("rss", ['absolute' => true]) . "\" title=\"" . _lang('rss-feed.generate.title') . "\">";
};
