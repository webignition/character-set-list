<?php

namespace webignition\CharacterSetList;

/**
 * List of official names for character sets as sourced from
 * http://www.iana.org/assignments/character-sets/character-sets.xhtml
 */
class CharacterSetList {
    
    
    /**
     *
     * @var array
     */
    private $list = null;
    
    
    /**
     *
     * @var array
     */
    private $index = null;
    
    
    /**
     *
     * @var \webignition\CharacterSetList\Generator
     */
    private $generator = null;
    
    
    /**
     * 
     * @return \webignition\CharacterSetList\Configuration
     */
    public function getConfiguration() {
        return $this->getGenerator()->getConfiguration();
    }
    
    
    /**
     * 
     * @return array
     */
    public function get() {
        if (is_null($this->list)) {
            $this->loadList();            
        }
        
        return $this->list;
    }
    
    
    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function contains($name) {
        return array_key_exists(strtolower($name), $this->getIndex());
    }
    
    
    /**
     * 
     * @return boolean
     */
    private function hasSourceFile() {
        return file_exists($this->getConfiguration()->getOutputContentPath());
    }
    
    
    private function loadList() {
        if (!$this->hasSourceFile()) {
            $this->getGenerator()->generate();
        }

        $this->list = json_decode(file_get_contents($this->getConfiguration()->getOutputContentPath()));        
    }
    
    
    /**
     * 
     * @return \webignition\CharacterSetList\Generator
     */
    public function getGenerator() {
        if (is_null($this->generator)) {
            $this->generator = new Generator();
        }
        
        return $this->generator;
    }
    
    
    /**
     * 
     * @return array
     */
    private function getIndex() {
        if (is_null($this->index)) {
            $this->buildIndex();
        }
        
        return $this->index;
    }
    
    
    private function buildIndex() {
        $this->index = array();
        
        foreach ($this->get() as $name) {
            $this->index[strtolower($name)] = true;
        }
    }
    
}