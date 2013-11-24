<?php

class Gbinside_Catwatermark_Model_Observer
{

    /**
     * @param Varien_Event_Observer $observer
     */
    public function WatermarkCategory($observer)
    {
        /** @var Mage_Catalog_Model_Category $_category */
        $_category = $observer->getDataObject();

        if ($_category->getImage()) {
            $_filename = Mage::getBaseDir('media') . '/catalog/category/' . $_category->getImage();
            $_varienImage = new Varien_Image($_filename);
            $_image = Mage::getSingleton('catalog/product_media_config')->getBaseMediaPath() . '/watermark/' . Mage::getStoreConfig("design/watermark/category_image");
            $_varienImage->setWatermarkWidth($_varienImage->getOriginalWidth());
            $_varienImage->setWatermarkHeigth($_varienImage->getOriginalHeight());
            $_varienImage->setWatermarkImageOpacity(Mage::getStoreConfig("design/watermark/category_imageOpacity"));
            $_varienImage->setWatermarkPosition('0x0');
            $_varienImage->watermark($_image);
            $_finalFilename = 'cache/catimage_' . $_category->getId() . '.jpg'; #collisioni?
            $_varienImage->save(Mage::getBaseDir('media') . '/catalog/category/' . $_finalFilename);
            $_category->setImage( $_finalFilename );
        }
        /**/
    }
}