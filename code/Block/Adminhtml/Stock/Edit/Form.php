<?php

/**
 * The data for the HTML form and fields.
 * 
 * @author gareth
 */
class Gareth_QuickStockAdjust_Block_Adminhtml_Stock_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	const PRODUCT_FORM_FIELD_NAME = 'product';
	const PRODUCT_FORM_FIELD_SEARCH = 'search';
	
    protected function _prepareForm()
    {
    	/* @var Gareth_QuickStockAdjust_Helper_Data $helper */
    	$helper = Mage::helper('gareth_quickstockadjust/data');
    	
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Product Selection')));

        
        $productSearchData = array(
        		'name'     => self::PRODUCT_FORM_FIELD_SEARCH,
        		'label'    => $helper->__('Find products with this SKU or names containing this text'),
        		'title'    => $helper->__('SKU/name search string'),
        		'required' => false,
        );
        // Get search string
        $searchString = $this->getRequest()->getParam(self::PRODUCT_FORM_FIELD_SEARCH);
        if (!empty($searchString))
        {
        	$productSearchData['value'] = $searchString;
        }
        $fieldset->addField('search', 'text', $productSearchData);
        
        $fieldset->addField('do_search', 'button', array(
        		'name'    => 'do_search',
        		'value'   => Mage::helper('gareth_quickstockadjust')->__('Search'),
        		'onclick' => "editForm.submit()",
        		'class'   => 'form-button',
        ));
        
        $productSelectData = array(
        		'name'     => self::PRODUCT_FORM_FIELD_NAME,
        		'label'    => $helper->__('Product'),
        		'title'    => $helper->__('Product'),
        		'required' => true,
        		'options'  => $helper->getProductOptions($searchString),
        		'style'    => 'min-width:280px; width: 100%; font-size: 16px;',
        );
        // Get last selected value if any
        $previousProduct = $this->getRequest()->getParam(self::PRODUCT_FORM_FIELD_NAME);
        if (is_numeric($previousProduct) && intval($previousProduct) > 0)
        {
        	$productSelectData['value'] = $previousProduct;
        }       
        $fieldset->addField('product', 'select', $productSelectData);

        $fieldset->addField('decrement', 'button', array(
        		'name'    => 'decrement',	
        		'value'   => Mage::helper('gareth_quickstockadjust')->__('Reduce stock by 1'),
        		'onclick' => "editForm.submit()",
        		'class'   => 'form-button',
        		'style'   => 'font-size: 16px;',
        ));
        
        $form->setAction($this->getUrl('*/*/decrement'));
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
