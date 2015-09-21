<?php

namespace spec\WindwardRail\FastMigrations;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WindwardRail\FastMigrations\IlluminateFileDriver;

class DatabaseTransactorSpec extends ObjectBehavior {
    protected $db_path = '/foo/path/';
    protected $db_suffix = '_db';
    protected $target_db = 'target';

    public function let(IlluminateFileDriver $fileDriver) {
        $this->beConstructedWith($this->db_path, $this->db_suffix, $this->target_db, $fileDriver);
    }

    public function it_is_initializable() {
        $this->shouldHaveType('WindwardRail\FastMigrations\DatabaseTransactor');
    }

    public function it_should_migrate_the_database(IlluminateFileDriver $fileDriver) {
        $this->beConstructedWith($this->db_path, $this->db_suffix, $this->target_db, $fileDriver);

        $suite = 'foo_suite';
        $expected_path = $this->db_path . $suite . $this->db_suffix . '.sqlite';
        $expected_target = $this->db_path . $this->target_db . '.sqlite';

        $fileDriver->exists($expected_path)->shouldBeCalled();
        $fileDriver->exists($expected_path)->willReturn(true);
        $fileDriver->copy($expected_path, $expected_target)->shouldBeCalled();

        $this->migrate($suite);
    }
}
