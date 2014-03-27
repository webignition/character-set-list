<?php

namespace webignition\CharacterSetList;

class Configuration {
    
    const SOURCE_RELATIVE_PATH = '/raw-source.xml';
    const OUTPUT_RELATIVE_PATH = '/GeneratedList.php';
    const OUTPUT_TEMPLATE_RELATIVE_PATH = '/GeneratedListTemplate.php';
    
    /**
     * 
     * @return string
     */
    public function getRawSourceContentPath() {
        return __DIR__ . self::SOURCE_RELATIVE_PATH;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getOutputContentPath() {
        return __DIR__ . self::OUTPUT_RELATIVE_PATH;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getOutputTemplatePath() {
        return __DIR__ . self::OUTPUT_TEMPLATE_RELATIVE_PATH;
    }
    
}