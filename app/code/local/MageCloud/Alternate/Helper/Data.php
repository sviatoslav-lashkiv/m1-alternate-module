<?php
/**
 * Copyright (c) 2019. All rights reserved.
 * @author: Sviatoslav Lashkiv
 * @mail:   ss.lashkiv@gmail.com
 * @github: https://github.com/sviatoslav-lashkiv
 */

class MageCloud_Alternate_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function rewrittenProductUrl($productId, $categoryId, $storeId)
    {
        $coreUrl = Mage::getModel('core/url_rewrite');
        $idPath = sprintf('product/%d', $productId);

        if ($categoryId) {
            $idPath = sprintf('%s/%d', $idPath, $categoryId);
        }

        $coreUrl->setStoreId($storeId);
        $coreUrl->loadByIdPath($idPath);

        return $coreUrl->getRequestPath();
    }

    public function rewrittenCategoryUrl($categoryId, $storeId)
    {
        $coreUrl = Mage::getModel('core/url_rewrite');
        $idPath = sprintf('category/%d', $categoryId);
        $coreUrl->setStoreId($storeId);
        $coreUrl->loadByIdPath($idPath);
        return $coreUrl->getRequestPath();
    }
}
