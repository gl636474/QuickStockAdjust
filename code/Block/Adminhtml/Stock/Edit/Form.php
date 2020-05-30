<?php

/**
 * The data for the HTML form and fields.
 * 
 * @author gareth
 */
class Gareth_QuickStockAdjust_Block_Adminhtml_Stock_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	const PRODUCT_FORM_FIELD_ID = 'productId';
	const PRODUCT_FORM_FIELD_NAME = 'product';
	
    protected function _prepareForm()
    {
    	/* @var Gareth_QuickStockAdjust_Helper_Data $helper */
    	$helper = Mage::helper('gareth_quickstockadjust');
    	
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Product Selection')));

        $productSelectData = array(
        		'name'  => self::PRODUCT_FORM_FIELD_NAME,
        		'label' => $helper->__('Product'),
        		'title' => $helper->__('Product'),
        		'required' => true,
        		'options' => $helper->getProductOptions(),
        		'style' => 'min-width:280px; width: 100%;',
        );
        // Get last selected value if any
        $previousProduct = $this->getRequest()->getParam(self::PRODUCT_FORM_FIELD_NAME);
        if (is_numeric($previousProduct) && intval($previousProduct) > 0)
        {
        	$productSelectData['value'] = $previousProduct;
        }       
        $fieldset->addField(PRODUCT_FORM_FIELD_ID, 'select', $productSelectData);

        $fieldset->addField('decrement', 'button', array(
        		'name'    => 'decrement',	
        		'value'   => Mage::helper('gareth_quickstockadjust')->__('Reduce stock by 1'),
        		'onclick' => "editForm.submit()",
        		'class'   => 'form-button'
        ));
        
        
        $form->setAction($this->getUrl('*/*/decrement'));
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
