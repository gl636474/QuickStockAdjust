<?php

require_once('app/code/local/Gareth/QuickStockAdjust/Block/Adminhtml/Stock/Edit/Form.php');

/**
 * Adminhtml Quick Stock Adjust controller
 * 
 * @author gareth
 */
class Gareth_QuickStockAdjust_Adminhtml_QuickadjustController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		//$this->_title($this->__('System'))->_title($this->__('My Account'));
		
		$this->loadLayout();
		
		/* <catalog> and <quick_stock_adjust> under <menu> in config.xml */
		$this->_setActiveMenu('catalog/quick_stock_adjust');
		
		$formContainerBlock = $this->getLayout()->createBlock('gareth_quickstockadjust_adminhtml/stock_edit');
		$this->_addContent($formContainerBlock);
		
		$this->renderLayout();
	}
	
	public function decrementAction()
	{
		$productFieldName = Gareth_QuickStockAdjust_Block_Adminhtml_Stock_Edit_Form::PRODUCT_FORM_FIELD_NAME;
		$productId = $this->getRequest()->getParam($productFieldName);
		try
		{
			if (is_numeric($productId) && intval($productId) > 0)
			{
				/** @var Mage_Catalog_Model_Product $product */
				$product = Mage::getModel('catalog/product')->load($productId);
				
				/** @var Mage_CatalogInventory_Model_Stock_Item $stock_item */
				$stock_item = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
				
				$stock_count = $stock_item->getQty();
				$stock_count -= 1;
				$stock_item->setQty($stock_count);
				$stock_item->save();
				
				$this->_getSession()->addSuccess(
						$this->__('%s stock count has been reduced to %d.', $product->getName(), $stock_count)
						);
				
				// <routers> from comnfig.xml / controller name / action name
				return $this->_redirect(
						'quick_stock_adjust_admin/quickadjust/index',
						array($productFieldName => $productId)
						);
			}
			else
			{
				$this->_getSession()->addError($this->__("Invalid product Id: $productId"));
			}
		}
		catch (Exception $e) {
			Mage::logException($e);
			$this->_getSession()->addError($e->getMessage());
		}
	}
}