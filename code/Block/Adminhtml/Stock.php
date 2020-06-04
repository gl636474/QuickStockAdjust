<?php
class Gareth_QuickStockAdjust_Block_Adminhtml_Stock
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();
        
        /**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed within this grid container.
         * Our <blocks> identifier from config.xml. 
         */
        $this->_blockGroup = 'gareth_quickstockadjust_adminhtml';
        
        /**
         * $_controller is a bit of a confusing name for this property. This 
         * value in fact refers to the folder containing our Grid.php and 
         * Edit.php. Here, .../Gareth/QuickStockAdjust/Block/Adminhtml/Stock, 
         * i.e. gareth_quickstockadjust_adminhtml/Stock, so we use 'stock'.
         */
        $this->_controller = 'stock';
        
        /**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('gareth_quickstockadjust/data')
            ->__('Quick Stock Adjust');
    }
  
    /**
     * Cannot add/edit/remove buttons/etc in constructor because this class is
     * not fully set up at that point. Add/edit/remove such stuff here instead.
     * 
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Grid_Container::_prepareLayout()
     */
    protected function _prepareLayout()
    {
    	// no need to override getCreateUrl if removing add button
 		$this->_removeButton('add');
    	return parent::_prepareLayout();
    }
}
