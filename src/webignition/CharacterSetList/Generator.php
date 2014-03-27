<?php

namespace webignition\CharacterSetList;

/**
 * Generates list from XML retrieved from
 * http://www.iana.org/assignments/character-sets/character-sets.xml
 */
class Generator {
    
    /**
     *
     * @var \webignition\CharacterSetList\Configuration
     */
    private $configuration;

    
    /**
     *
     * @var \DOMDocument
     */
    private $sourceDom = null;
    
    /**
     *
     * @var array
     */
    private $list = array();
    
    
    public function generate() {
        $records = $this->getSourceDom()->getElementsByTagName('record');
        
        foreach ($records as $record) {
            /* @var $record \DOMElement */
            $this->addValueToList($record->getElementsByTagName('name')->item(0)->nodeValue);
            
            $aliases = $record->getElementsByTagName('alias');
            
            foreach ($aliases as $alias) {
                /* @var $alias \DOMElement */
                $this->addValueToList($alias->nodeValue);
            }
        }
        
        file_put_contents($this->getConfiguration()->getOutputContentPath(), $this->getGenereratedListContent());
    }
    
    
    private function getGenereratedListContent() {
        $templateContent = file_get_contents($this->getConfiguration()->getOutputTemplatePath());
        
        $listValues = array_keys($this->list);
        
        array_walk($listValues, function(&$n) { 
          $n = "'".$n."'"; 
        });
        
        return (str_replace(array(
            'GeneratedListTemplate',
            'array()'
        ), array(
            'GeneratedList',
            'array(' . implode(',', $listValues) . ')'
        ), $templateContent));
    }
    
    
    /**
     * 
     * @return \webignition\CharacterSetList\Configuration
     */
    public function getConfiguration() {
        if (is_null($this->configuration)) {
            $this->configuration = new Configuration();
        }
        
        return $this->configuration;
    }
    
    
    
    /**
     * 
     */
    public function removeOutput() {
        @unlink($this->getConfiguration()->getOutputContentPath());
    }
    
    
    /**
     * 
     * @param string $value
     */
    private function addValueToList($value) {
        if ($this->isValidCharacterSetFormat($value)) {
            $this->list[$value] = true;
        }        
    }
    
    
    /**
     * 
     * @param string $value
     * @return boolean
     */
    private function isValidCharacterSetFormat($value) {
        if (preg_match('/\s/', $value)) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * 
     * @return \DOMDocument
     */
    private function getSourceDom() {
        if (is_null($this->sourceDom)) {
            $this->sourceDom = new \DOMDocument();
            $this->sourceDom->loadXML($this->getRawSourceContent());
        }
        
        return $this->sourceDom;
    }
    
    
    /**
     * 
     * @return string
     */
    private function getRawSourceContent() {
        return file_get_contents($this->getConfiguration()->getRawSourceContentPath());
    }
    
}