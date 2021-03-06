<?php
/**
 * Tests Protein Model class
 * Test are made at xModel level.
 * @package unittests
 */
class ProteinModelTest extends protviewPHPUnit_Framework_TestCase {

	function test_proteinModel_get_allFieldsAreReturned() {
		$ret = xModel::load('protein', array())->get(0);		
		$this->assertTrue(array_key_exists('id', $ret));
	}
}
?>