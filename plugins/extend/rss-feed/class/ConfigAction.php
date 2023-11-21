<?php

namespace SunlightExtend\RssFeed;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;

class ConfigAction extends BaseConfigAction
{
    public function getConfigLabel(string $key): string
    {
        return _lang('rss-feed.config.' . $key);
    }
}
