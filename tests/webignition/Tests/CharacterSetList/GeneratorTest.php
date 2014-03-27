<?php

namespace webignition\Tests\CharacterSetList;

use webignition\CharacterSetList\Generator;

class GeneratorTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\CharacterSetList\Generator 
     */
    private $generator;
    
    public function setUp() {
        parent::setUp();
        $this->generator = new Generator();      
    }
    
    public function tearDown() {
        parent::tearDown();
        $this->generator->removeOutput();
    }
    
    public function testGenerate() {
        $this->generator->generate();
        
        $this->assertTrue(file_exists($this->generator->getConfiguration()->getOutputContentPath()));        
    }
    
    public function testRemoveOutput() { 
        $this->generator->generate();
        $this->generator->removeOutput();
        
        $this->assertFalse(file_exists($this->generator->getConfiguration()->getOutputContentPath()));
    }    
}