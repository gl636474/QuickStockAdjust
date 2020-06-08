<?php

//require_once('app/code/local/Gareth/QuickStockAdjust/Block/Adminhtml/Stock/Edit/Form.php');

/**
 * Adminhtml Quick Stock Adjust controller
 * 
 * @author gareth
 */
class Gareth_QuickStockAdjust_Adminhtml_QuickadjustController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Called to display the page (GET request)
	 */
	public function indexAction()
	{
		//$this->_title($this->__('System'))->_title($this->__('My Account'));
		
		$this->loadLayout();
		
		/* <catalog> and <quick_stock_adjust> under <menu> in config.xml */
		$this->_setActiveMenu('catalog/quick_stock_adjust');
		
		$formContainerBlock = $this->getLayout()->createBlock('gareth_quickstockadjust_adminhtml/stock');
		$this->_addContent($formContainerBlock);
		
		$jsBlock = $this->getLayout()->createBlock('core/text');
		$jsBlock->setText('
function submitGridRow() {
    alert("HI");
}
');
		$this->_addJs($jsBlock);
		
		$this->renderLayout();
	}
	
	/**
	 * Called when user clicks "Reduce Stock by 1" link for a specific product.
	 * 
	 * @return Gareth_QuickStockAdjust_Adminhtml_QuickadjustController
	 */
	public function decrementAction()
	{
		// must match the field in the action column URL in
		// Gareth_QuickStockAdjust_Block_Adminhtml_Stock_Grid
		$productFieldName = 'product';
		$productId = $this->getRequest()->getParam($productFieldName);
		
		try
		{
			if (is_numeric($productId) && intval($productId) > 0)
			{
				/** @var Mage_Catalog_Model_Product $product */
				$product = Mage::getModel('catalog/product')->load($productId);
				// load always returns a model - check it's not empty
				if (!empty($product->getId()))
				{
					/** @var Mage_CatalogInventory_Model_Stock_Item $stock_item */
					$stock_item = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
					
					$stock_count = $stock_item->getQty();
					if ($stock_count > 0)
					{
						$stock_count -= 1;
						$stock_item->setQty($stock_count);
						$stock_item->save();
						
						$this->_getSession()->addSuccess(
								$this->__('"%s" stock count has been reduced to %d', $product->getName(), $stock_count)
								);
					}
					else
					{
						$this->_getSession()->addError(
								$this->__('"%s" stock count already zero', $product->getName())
								);
					}
				}
				else
				{
					$this->_getSession()->addError($this->__('Unknown product Id: %d', $productId));
				}
			}
			else
			{
				$this->_getSession()->addError($this->__('Invalid product Id: %s', $productId));
			}
		}
		catch (Exception $e) {
			Mage::logException($e);
			$this->_getSession()->addError($e->getMessage());
		}
		
		// We always redirect back to the quick stock adjust table
		// <routers> from comnfig.xml / controller name / action name
		return $this->_redirect('quick_stock_adjust_admin/quickadjust/index');
	}
	
	/**
	 * Called when use clicks link to set stock level for specific product.
	 * 
	 * @return Gareth_QuickStockAdjust_Adminhtml_QuickadjustController
	 */
	public function setstocklevelAction()
	{
		var_dump($this->getRequest()->getParams());
		die();
		
		// We always redirect back to the quick stock adjust table
		// <routers> from comnfig.xml / controller name / action name
		return $this->_redirect('quick_stock_adjust_admin/quickadjust/index');
	}
}
