<?php
class Gareth_QuickStockAdjust_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * The number of characters to make the product name. Products with names
	 * shorter than this nuber of chatacters will be appended with &nbsp; s
	 * @var integer PRODUCT_NAME_LENGTH_CHARS
	 */
	const PRODUCT_NAME_LENGTH_CHARS = 60;
	
	/**
	 * Returns an array of all products for listing in the quick stock adjustdropdown.
	 * @return array product_id=>"Product Name (SKU Qty:n)"
	 */
	public function getProductOptions()
	{
		$products = array();
		/* @var Mage_Catalog_Model_Product $productModel */
		$productModel = Mage::getModel('catalog/product');
		/* @var Mage_Catalog_Model_Resource_Product_Collection $productsCollection */
		$productsCollection = $productModel->getCollection();
		$productsCollection->addAttributeToSelect("name");
		$productsCollection->addAttributeToSort('name', 'ASC');
		/* @var Mage_Catalog_Model_Product $product */
		foreach ($productsCollection as $product)
		{
			$id = $product->getId();
			$name = $product->getName();
			
			$sku = $product->getSku();
			
			/* @var Mage_CatalogInventory_Model_Stock_Item $stock_item */
			$stock_item = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
			$qty = intval($stock_item->getQty());
			
			$products[$id]="$sku: $name (Qty: $qty)";
		}
		return $products;
	}
	
}
