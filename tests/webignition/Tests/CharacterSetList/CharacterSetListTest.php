<?php

namespace webignition\Tests\CharacterSetList;

use webignition\CharacterSetList\CharacterSetList;

class CharacterSetListTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\CharacterSetList\CharacterSetList
     */
    private $characterSetList;
    
    public function setUp() {
        parent::setUp();
        $this->characterSetList = new CharacterSetList();      
    }
    
    public function testListSizeIsGreaterThanZero() {
        $this->assertGreaterThan(0, count($this->characterSetList->get()));
    }
    
    public function testContainsLowercase() {
        $this->assertTrue($this->characterSetList->contains('utf-8'));
    }
    
    public function testContainsUppercase() {
        $this->assertTrue($this->characterSetList->contains('UTF-8'));
    }    
    
    public function testDoesNotContainLowercase() {
        $this->assertFalse($this->characterSetList->contains('foo'));
    }
    
    public function testDoesNotContainUppercase() {
        $this->assertFalse($this->characterSetList->contains('FOO'));
    }
}