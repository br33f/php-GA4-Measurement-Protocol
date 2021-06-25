<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 14:49
 */

namespace Tests\Common;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected $faker;

    /**
     * BaseTestCase constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
    }
}