<?php
/**
 * This package tests the Backbone Helper class.
 *
 * @package Kola\Kola\PotatoOrm\Helper\BackboneTest
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Test;

use Mockery;
use Kola\PotatoOrm\Helper\Backbone;

class BackboneTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Tear down all mock objects
	 */
	public function tearDown()
	{
		Mockery::close();
	}

	/**
	 * Test method checkForTable of class Backbone
	 */
    public function testCheckForTable()
    {
        $dbConnMocked = Mockery::mock('Kola\PotatoOrm\Helper\DbConn');
        $statement = Mockery::mock('\PDOStatement');

        $dbConnMocked->shouldReceive('query')->with('SELECT 1 FROM dogs LIMIT 1')->andReturn($statement);
        $dbConnMocked->shouldReceive('query')->with('SELECT 1 FROM users LIMIT 1')->andReturn(false);

        $this->assertTrue(Backbone::checkForTable('dogs', $dbConnMocked));
        $this->assertFalse(Backbone::checkForTable('users', $dbConnMocked));
    }

	/**
	 * Test method addOrRemoveS of class Backbone
	 */
    public function testAddOrRemoveS()
    {
        $this->assertEquals('dog', Backbone::addOrRemoveS('dogs'));
        $this->assertEquals('dogs', Backbone::addOrRemoveS('dog'));
        $this->assertNotEquals('cats', Backbone::addOrRemoveS('cats'));
    }

	/**
	 * Test method generateUnnamedPlaceholders of class Backbone
	 */
    public function testGenerateUnnamedPlaceholders()
    {
        $this->assertEquals(['?', '?', '?', '?'], Backbone::generateUnnamedPlaceholders(['username', 'password', 'email', 'date_created']));
        $this->assertNotEquals(['?', '?', '?', '?'], Backbone::generateUnnamedPlaceholders(['username', 'password', 'email']));
    }

	/**
	 * Test method Tokenize of class Backbone
	 */
    public function testTokenize()
    {
        $this->assertEquals('username,password,email', Backbone::tokenize('username,password,email', ','));
    }

	/**
	 * Test method joinKeysAndValuesOfArray of class Backbone
	 */
    public function testJoinKeysAndValuesOfArray()
    {
        $this->assertEquals(["token=NULL", "token_expire='today'"], Backbone::joinKeysAndValuesOfArray(['' => '', 'token' => null, 'token_expire' => 'today']));
    }
}
