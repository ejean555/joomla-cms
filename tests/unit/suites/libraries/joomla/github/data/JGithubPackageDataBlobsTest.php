<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-30 at 01:40:55.
 */
class JGithubPackageDataBlobsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  11.4
	 */
	protected $options;

	/**
	 * @var    JGithubHttp  Mock client object.
	 * @since  11.4
	 */
	protected $client;

	/**
	 * @var    JHttpResponse  Mock response object.
	 * @since  12.3
	 */
	protected $response;

	/**
	 * @var JGithubPackageDataBlobs
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  12.3
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  12.3
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options = new JRegistry;
		$this->client = $this->getMock('JGithubHttp', array('get', 'post', 'delete', 'patch', 'put'));
		$this->response = $this->getMock('JHttpResponse');

		$this->object = new JGithubPackageDataBlobs($this->options, $this->client);
	}

	/**
	 * @covers JGithubPackageDataBlobs::get
	 *
	 * GET /repos/:owner/:repo/git/blobs/:sha
	 *
	 * Response
	 *
	 * Status: 200 OK
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 *
	 * {
	 * "content": "Content of the blob",
	 * "encoding": "utf-8",
	 * "sha": "3a0f86fb8db8eea7ccbb9a95f325ddbedfb25e15",
	 * "size": 100
	 * }
	 */
	public function testGet()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
		             ->method('get')
		             ->with('/repos/joomla/joomla-platform/git/blobs/12345', 0, 0)
		             ->will($this->returnValue($this->response))
		;

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', '12345'),
			$this->equalTo(json_decode($this->response->body))
		)
		;
	}

	/**
	 * @covers JGithubPackageDataBlobs::create
	 *
	 * POST /repos/:owner/:repo/git/blobs
	 *
	 * Input
	 *
	 * {
	 * "content": "Content of the blob",
	 * "encoding": "utf-8"
	 * }
	 *
	 * Response
	 *
	 * Status: 201 Created
	 * Location: https://api.github.com/git/:owner/:repo/blob/:sha
	 * X-RateLimit-Limit: 5000
	 * X-RateLimit-Remaining: 4999
	 *
	 * {
	 * "sha": "3a0f86fb8db8eea7ccbb9a95f325ddbedfb25e15"
	 * }
	 */
	public function testCreate()
	{
		$this->response->code = 201;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
		             ->method('post')
		             ->with('/repos/joomla/joomla-platform/git/blobs', '{"content":"Hello w\u00f6rld","encoding":"utf-8"}', 0, 0)
		             ->will($this->returnValue($this->response))
		;

		$this->assertThat(
			$this->object->create('joomla', 'joomla-platform', 'Hello wörld'),
			$this->equalTo(json_decode($this->response->body))
		)
		;
	}
}
