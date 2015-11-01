<?php
/**
 * This package tests the Model class.
 *
 * @package Kola\Kola\PotatoOrm\Test\ModelTest
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\PotatoOrm\Test;

use Kola\PotatoOrm\Helper\DbConn;
use Mockery;
use Kola\PotatoOrm\Test\Stub\Comment;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    protected $dbConnMocked;
    protected $statement;

    /**
     * Set up required mock objects
     */
    public function setUp()
    {
        $this->dbConnMocked = Mockery::mock('Kola\PotatoOrm\Helper\DbConn');
        $this->statement = Mockery::mock('\PDOStatement');

        $this->dbConnMocked->shouldReceive('query')->with('SELECT 1 FROM comment LIMIT 1')->andReturn(false);
        $this->dbConnMocked->shouldReceive('query')->with('SELECT 1 FROM comments LIMIT 1')->andReturn($this->statement);
    }

    /**
     * Tear down all mock objects
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * Instantiate Comment stub
     *
     * @return Comment
     */
    public function instantiateStub()
    {
        return new Comment;
    }

    /**
     * Test method getRecord of Model class
     */
    public function testGetRecord()
    {
        $comment = $this->instantiateStub();
        $comment->user_id = 3;
        $comment->text = 'Get up on your feet';

        $this->assertArrayHasKey('user_id', $comment->getRecord());
        $this->assertArrayHasKey('text', $comment->getRecord());
        $this->assertArrayNotHasKey('date_created', $comment->getRecord());
    }

    /**
     * Test method where of Model class
     */
    public function testWhere()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments WHERE user_id = ?')->andReturn($this->statement);
        $this->statement->shouldReceive('execute')->with([5]);
        $this->statement->shouldReceive('rowCount')->andReturn(1);
        $this->statement->shouldReceive('fetch')->with(DbConn::FETCH_ASSOC)->andReturn(['id' => 3, 'user_id' => 5, 'text' => 'Get up on your feet']);

        $this->assertInstanceOf('Kola\PotatoOrm\Test\Stub\Comment', Comment::where('user_id', 5, $this->dbConnMocked));
    }

    /**
     * Test method where of Model class for throwing of exception
     */
    public function testWhereForThrowingOfException()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments WHERE user_id = ?')->andReturn($this->statement);
        $this->statement->shouldReceive('execute')->with([6]);
        $this->statement->shouldReceive('rowCount')->andReturn(0);
        $this->setExpectedException('Kola\PotatoOrm\Exception\RecordNotFoundException');

        Comment::where('user_id', 6, $this->dbConnMocked);
    }

    /**
     * Test method find of Model class
     */
    public function testFind()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments WHERE id = ?')->andReturn($this->statement);
        $this->statement->shouldReceive('execute')->with([5]);
        $this->statement->shouldReceive('rowCount')->andReturn(1);
        $this->statement->shouldReceive('fetch')->with(DbConn::FETCH_ASSOC)->andReturn(['id' => 5, 'user_id' => 8, 'text' => 'Get up on your feet']);

        $this->assertInstanceOf('Kola\PotatoOrm\Test\Stub\Comment', Comment::find(5, $this->dbConnMocked));
    }

    /**
     * Test method find of Model class for throwing of exception
     */
    public function testFindForThrowingOfException()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments WHERE id = ?')->andReturn($this->statement);
        $this->statement->shouldReceive('execute')->with([6]);
        $this->statement->shouldReceive('rowCount')->andReturn(0);
        $this->setExpectedException('Kola\PotatoOrm\Exception\RecordNotFoundException');

        Comment::find(6, $this->dbConnMocked);
    }

    /**
     * Test method destroy of Model class
     */
    public function testDestroy()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('DELETE FROM comments WHERE id= 7')->andReturn($this->statement);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('rowCount')->andReturn(1);

        $this->assertEquals(1, Comment::destroy(7, $this->dbConnMocked));
    }

    /**
     * Test method destroy of Model class for throwing of exception
     */
    public function testDestroyForThrowingOfException()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('DELETE FROM comments WHERE id= 4')->andReturn($this->statement);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('rowCount');
        $this->setExpectedException('Kola\PotatoOrm\Exception\RecordNotFoundException');

        Comment::destroy(4, $this->dbConnMocked);
    }

    /**
     * Test method getAll of Model class
     */
    public function testGetAll()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments')->andReturn($this->statement);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('rowCount')->andReturn(4);
        $this->statement->shouldReceive('fetchAll')->with(DbConn::FETCH_ASSOC)->andReturn([['id' => 3, 'user_id' => 5, 'text' => 'Get up on your feet'], ['id' => 4, 'user_id' => 1, 'text' => 'Get up'], ['id' => 5, 'user_id' => 2, 'text' => 'Quick'], ['id' => 6, 'user_id' => 2, 'text' => 'Run']]);

        $this->assertCount(4, Comment::getAll($this->dbConnMocked));
    }

    /**
     * Test method getAll of Model class for throwing of exception
     */
    public function testGetAllForThrowingOfException()
    {
        $this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments')->andReturn($this->statement);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('rowCount')->andReturn(0);
        $this->setExpectedException('Kola\PotatoOrm\Exception\EmptyTableException');

        Comment::getAll($this->dbConnMocked);
    }

	/**
	 * Test method save of Model class for a new record creation
	 */
    public function testSaveForNewRecordCreation()
    {
		$comment = $this->instantiateStub();
		$comment->user_id = 3;
		$comment->text = 'Get up on your feet';

		$this->dbConnMocked->shouldReceive('prepare')->with('INSERT INTO comments (user_id,text) VALUES (?,?)')->andReturn($this->statement);
		$this->statement->shouldReceive('execute')->with([3,'Get up on your feet']);
		$this->statement->shouldReceive('rowCount')->andReturn(1);

		$this->assertEquals(1, $comment->save($this->dbConnMocked));
    }

	/**
	 * Test method save of Model class for update of old records
	 */
	public function testSaveForOldRecordUpdate()
	{
		$this->dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM comments WHERE id = ?')->andReturn($this->statement);
		$this->statement->shouldReceive('execute')->with([5]);
		$this->statement->shouldReceive('rowCount')->andReturn(1);
		$this->statement->shouldReceive('fetch')->with(DbConn::FETCH_ASSOC)->andReturn(['id' => 5, 'user_id' => 8, 'text' => 'Get up on your feet']);

		$comment = Comment::find(5, $this->dbConnMocked);
		$comment->text = 'Leave! Now!';

		$this->dbConnMocked->shouldReceive('prepare')->with("UPDATE comments SET text='Leave! Now!' WHERE id=5")->andReturn($this->statement);
		$this->statement->shouldReceive('execute');
		$this->statement->shouldReceive('rowCount')->andReturn(1);

		$this->assertEquals(1, $comment->save($this->dbConnMocked));
	}

	public function testSimpleMock() {
		$mock = Mockery::mock('simplemock');
		$mock->shouldReceive('foo')->with(5)->once()->andReturn(10);

		$this->assertEquals(10, $mock->foo(5));
	}
}
