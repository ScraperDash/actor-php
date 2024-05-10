<?php

declare(strict_types=1);

use ScraperDash\Actor\Validator\Rule\NotEmpty;

describe(NotEmpty::class, function () {
    $rule = new NotEmpty();

    it('Returns false for null', function () use ($rule) {
        expect($rule->validate([], null))->toBeFalse();
    });

    it('Returns false for empty string', function () use ($rule) {
        expect($rule->validate([], ''))->toBeFalse();
    });

    it('Returns false for int zero', function () use ($rule) {
        expect($rule->validate([], 0))->toBeFalse();
    });

    it('Returns false for float zero', function () use ($rule) {
        expect($rule->validate([], 0.00))->toBeFalse();
    });

    it('Returns true for string', function () use ($rule) {
        expect($rule->validate([], 'a'))->toBeTrue();
    });

    it('Returns true for non-zero int', function () use ($rule) {
        expect($rule->validate([], 1))->toBeTrue();
    });

    it('Returns true for non-zero float', function () use ($rule) {
        expect($rule->validate([], 0.01))->toBeTrue();
    });

    it('Returns false for empty array', function () use ($rule) {
        expect($rule->validate([], []))->toBeFalse();
    });

    it('Returns true for non-empty array', function () use ($rule) {
        expect($rule->validate([], [
            'test' => 'yes',
        ]))->toBeTrue();
    });
});
