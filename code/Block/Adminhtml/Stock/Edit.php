<?php
/**
 * Form container for the quick stock adjustment feature. This is effectively
 * the page. The form container provides the page heading (orange text) and the
 * standard top level buttons (back, reset, save).
 * 
 * @author gareth
 */
class Gareth_QuickStockAdjust_Block_Adminhtml_Stock_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
    	/* Our <blocks> identifier from config.xml */
        $this->_blockGroup = 'gareth_quickstockadjust_adminhtml';
        
        /* Look for QuickadjustController */
        $this->_controller = 'stock';
        
        /**
         * This form could have several modes, e.g. edit, new or delete. New
         * might be all fields shown/enabled but blank. Edit might be editable
         * fields prefilled with current values and some fields non-editable
         * (e.g. ID or SKU). Delete might have only identifying fields. Magento
         * will look for the Form.php in a subdirectory with this name. So
         * 'adjust' corresponds to the Form.php in:
         * code/local/Gareth/QuickStockAdjust/Block/Adminhtml/Stock/Edit.
         * @var string $_mode
         * 
         * NB: Does not work with 'adjust' so have used default of 'edit'.
         */
        $this->_mode = 'edit';

        /**
         * The title in orange, under the menus, with save (etc) buttons on the
         * right hand side.
         * @var string $_headerText
         */
        $this->_headerText = $this->__('Quick Stock Adjustment');
        
    }
    
    /**
     * Cannot edit buttons in constructor because they haven't been created yet!
     * 
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Form_Container::_prepareLayout()
     */
    protected function _prepareLayout()
    {
        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('save');
        $this->_removeButton('back');
        
        return parent::_prepareLayout();
    }
}