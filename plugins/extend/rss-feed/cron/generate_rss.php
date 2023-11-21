<?php

use SunlightExtend\RssFeed\RssFeed;

return function (int $lastRunTime, int $delay) {
    RssFeed::create();
};
