<?php

class CreditCardTest extends PHPUnit_Framework_TestCase {

	function testValidNumber() {
		$credit_card = new \Recruiting\Test\CreditCard();
		$this->assertTrue($credit_card->setNumber('4444333322221111'));
	}

	function testInvalidNumberShouldReturError() {
		$credit_card = new \Recruiting\Test\CreditCard();
		$this->assertEquals( 'ERROR_INVALID_LENGTH', $credit_card->setNumber('3333555522221111') );
	}

	function testValidNumberShouldSetAndGet() {
		$credit_card = new \Recruiting\Test\CreditCard();
		$credit_card->setNumber('4444333322221111');
		$this->assertEquals('4444333322221111',$credit_card->getNumber());
	}
}
