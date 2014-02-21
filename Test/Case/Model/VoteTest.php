<?php
App::uses('Vote', 'Vote.Model');

/**
 * Vote Test Case
 *
 */
class VoteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.vote.vote',
		'plugin.vote.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Vote = ClassRegistry::init('Vote.Vote');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Vote);

		parent::tearDown();
	}

}
