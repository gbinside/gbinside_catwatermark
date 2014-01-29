<?php

class Gbinside_Catwatermark_Model_Observer
{

    protected function _parseSize($string)
    {
        $size = explode('x', strtolower($string));
        if (sizeof($size) == 2) {
            return array(
                'width' => ($size[0] > 0) ? $size[0] : null,
                'heigth' => ($size[1] > 0) ? $size[1] : null,
            );
        }
        return false;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function WatermarkCategory($observer)
    {
        /** @var Mage_Catalog_Model_Category $_category */
        $_category = $observer->getDataObject();

        if ($_category->getImage() && Mage::getStoreConfig("design/watermark/category_image")) {
            $_category->setGboriginalImage($_category->getImage());
            $_filename = Mage::getBaseDir('media') . '/catalog/category/' . $_category->getImage();
            if (file_exists($_filename)) {
                $_varienImage = new Varien_Image($_filename);
                $_image = Mage::getSingleton('catalog/product_media_config')->getBaseMediaPath() . '/watermark/' . Mage::getStoreConfig("design/watermark/category_image");
                $size = $this->_parseSize(Mage::getStoreConfig("design/watermark/category_size"));
                if ($size) {
                    $_varienImage->setWatermarkHeigth($size['heigth']);
                    $_varienImage->setWatermarkWidth($size['width']);
                }
                $_varienImage->setWatermarkPosition(Mage::getStoreConfig("design/watermark/category_position"));
                $_varienImage->setWatermarkImageOpacity(Mage::getStoreConfig("design/watermark/category_imageOpacity"));
                $_varienImage->watermark($_image);
                $_finalFilename = 'cache/catimage_' . $_category->getId() . '.jpg'; #collisioni?
                $_varienImage->save(Mage::getBaseDir('media') . '/catalog/category/' . $_finalFilename);
                $_category->setImage( $_finalFilename );
            }
        }
    }

    public function CategorySaveBefore($observer) {
        $_category = $observer->getDataObject();

        if ($_category->getGboriginalImage()) {
            $_category->setImage($_category->getGboriginalImage());
        }
    }
}