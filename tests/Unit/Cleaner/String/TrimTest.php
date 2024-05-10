<?php

declare(strict_types=1);

use ScraperDash\Actor\Cleaner\String\Trim;

describe(Trim::class, function () {
    $cleaner = new Trim();

    it('Trims the content when a string is cleaned', function () use ($cleaner) {
        expect($cleaner->clean([], ' This is a test '))
            ->toBeString()
            ->toContain('This is a test');
    });

    it('Throws an exception when something other than a String is passed', function () use ($cleaner) {
        expect($cleaner->clean([], []));
    })->throws(InvalidArgumentException::class);
});
