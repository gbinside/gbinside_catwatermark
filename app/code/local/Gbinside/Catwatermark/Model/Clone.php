<?php
class Gbinside_Catwatermark_Model_Clone extends Mage_Adminhtml_Model_System_Config_Clone_Media_Image {
    public function getPrefixes()
    {
        $prefixes = parent::getPrefixes();
        $prefixes[] = array(
            'field' => 'category_',
            'label' => 'Category',
        );
        return $prefixes;

    }

}