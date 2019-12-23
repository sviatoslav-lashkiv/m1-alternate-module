<?php
/**
 * Copyright (c) 2019. All rights reserved.
 * @author: Sviatoslav Lashkiv
 * @mail:   ss.lashkiv@gmail.com
 * @github: https://github.com/sviatoslav-lashkiv
 */

class MageCloud_Alternate_Model_Observer
{
    public function alternateLinks($observer)
    {
        $controller = $observer->getAction();
        $layout = $controller->getLayout();
        $block = $layout->createBlock('core/text');

        $stores = Mage::app()->getStores();
        $defaultStoreId = Mage::app()->getWebsite(true)->getDefaultGroup()->getDefaultStoreId();
        $product = Mage::registry('current_product');
        $category = Mage::registry('current_category');

        if($product || $category) {
            $html = '';
            foreach ($stores as $store) {

                if ($product) {
                    $category ? $categoryId = $category->getId() : $categoryId = null;
                    $url = $store->getBaseUrl() . Mage::helper('alternate')->rewrittenProductUrl($product->getId(), $categoryId, $store->getId());
                } elseif ($category) {
                    $url = $store->getBaseUrl() . Mage::helper('alternate')->rewrittenCategoryUrl($category->getId(), $store->getId());
                }
                /**
                 * temporary disabled alternate tags for other pages
                 * because store switcher not working correct
                 */
//                else {
//                    $url = $store->getUrl('', array(
//                        '_current' => true,
//                        '_use_rewrite' => true
//                    ));
//                }

                if ((strpos($url, '?') !== false)) {
                    $url = substr($url, 0, strrpos($url, "?"));
                }

                $storeId = $store->getId();
                $storeCode = substr(Mage::getStoreConfig('general/locale/code', $storeId), 0, 2);

                $html .= '<link rel="alternate" hreflang="' . $storeCode . '"href="' . $url . '" />' . "\n";

                if ($storeId === $defaultStoreId) {
                    $html .= '<link rel="alternate" href="' . $url . '" hreflang="x-default" />' . "\n";
                }
            }

            $block->setText($html);
            $layout->getBlock('head')->append($block);
        }

        return $this;
    }
}
