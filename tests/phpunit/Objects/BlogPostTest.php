<?php
/**
 * Test the blog post object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Objects
 *
 * @todo Add tests for date functions
 */

class BlogPostTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		require_once("../../application/common/objects/BlogPost.php");
		require_once("../../application/common/models/BlogPostsModel.php");
		$this->object = new BlogPost();
	}
	
	public function testSetContent () {
		$this->assertTrue($this->object->setContent("Hello, World!"));
		$this->assertSame($this->object->postContent, "Hello, World!");
	}
	
	public function testSetName () {
		$this->assertTrue($this->object->setName("Hello, World!"));
		$this->assertFalse($this->object->setName(""));
		$this->assertSame($this->object->postName, "Hello, World!");
	}
	
	public function testSetSlug () {
		$this->assertTrue($this->object->setSlug("a-test-slug-for-phpunit"));
		$this->assertFalse($this->object->setSlug(""));
		$this->assertSame($this->object->postSlug, "a-test-slug-for-phpunit");
	}
	
	public function testSetStatus () {
		$this->assertTrue($this->object->setStatus("Draft"));
		$this->assertFalse($this->object->setStatus("Invalid Status"));
		$this->assertSame($this->object->postStatus, "Draft");
	}

}
