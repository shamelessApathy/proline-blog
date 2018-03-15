<?php

class Attribution_Analytics_Test extends WP_UnitTestCase {
	protected $object;

	public function setUp() {
		parent::setUp();
		$this->object = Attribution_Analytics::get_instance();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_attribution_instance() {
		$this->assertClassHasStaticAttribute( 'instance', 'Attribution_Analytics' );
	}

	/**
	 * @covers Attribution_Analytics::setup_constants
	 */
	public function test_constants() {

		// Plugin File Path
		$path = str_replace( "/tests", '', dirname( __FILE__ ) );
		$this->assertSame( ATTR_FILE_PATH, $path );

		// Plugin Folder
		$path = str_replace( "/tests", '', dirname( plugin_basename( __FILE__ ) ) );
		$this->assertSame( ATTR_FOLDER, $path );

		// Plugin Root File
		$path = str_replace( "/tests", '', plugins_url( '', __FILE__ ) );
		$this->assertSame( ATTR_URL, $path );

	}

}

