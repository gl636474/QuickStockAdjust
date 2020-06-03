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
	 * 
	 * @param string $searchString only return products with this string in sku or name
	 * @var bool $addPleaseSelect whether to add a "Please Select" option at the top (with product_id==-1)
	 * @return array product_id=>"Product Name (SKU Qty:n)"
	 */
	public function getProductOptions($searchString = null, $addPleaseSelect = true)
	{
		$products = array();
		if ($addPleaseSelect)
		{
			$products[-1] = $this->__('Please select product');
		}
		
		/* @var Mage_Catalog_Model_Product $productModel */
		$productModel = Mage::getModel('catalog/product');
		/* @var Mage_Catalog_Model_Resource_Product_Collection $productsCollection */
		$productsCollection = $productModel->getCollection();
		
		// By default empty products are returned
		$productsCollection->addAttributeToSelect("name");
		$productsCollection->addAttributeToSort('name', 'ASC');
		
		if (!empty($searchString))
		{
			// where sku like '%xxx%' OR name like '%xxx%'
			$productsCollection->addAttributeToFilter(
					array(
							array('attribute' => 'sku',  'like' => "%$searchString%"),
							array('attribute' => 'name', 'like' => "%$searchString%"),
					)
					);
		}
		
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
