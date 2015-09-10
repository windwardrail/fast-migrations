<?php

namespace spec\WindwardRail\FastMigrations;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WindwardRail\FastMigrations\MigratableTrait;

class MigratableTraitSpec extends ObjectBehavior {
    function let() {
        $this->beAnInstanceOf('spec\WindwardRail\FastMigrations\FooTest');
    }

    function it_is_initializable() {
        $this->shouldHaveType('spec\WindwardRail\FastMigrations\FooTest');
    }

    function it_migrates_the_test_db_suite() {
        $this->migrate();
    }
}

class FooTest {
    use MigratableTrait;

    protected $suite = 'foo';
}
