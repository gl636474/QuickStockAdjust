<?php
class Gareth_QuickStockAdjust_Block_Adminhtml_Stock_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        /**
         * Tell Magento which Collection to use for displaying in the grid.
         * @var Mage_Catalog_Model_Resource_Product_Collection $collection
         */
        $collection = Mage::getModel('catalog/product')->getCollection();
        // By default empty products are returned
        $collection->addAttributeToSelect("name");
        
        // Join stock_item table for qty
        $collection->joinField('qty', 			// alias - resultset column name
        		'cataloginventory/stock_item', 	// module/table Magento syntax
        		'qty',							// column name in above table
        		'product_id=entity_id',			// bind/ON condition
        		'{{table}}.stock_id=1',			// condition - see below
        		'left'							// join type
        		);
        
        /**
         * Condition:
         * An optional where clause to exclude rows from joined table (in this
         * case stock_item). "{{table}}" means use value from above Magento
         * table identifier. Stock_Item has a Stock_Id which is for future
         * 'multi-stock' capabilities. For the moment it is always 1 but we add
         * this condition for future proofing.
         */
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        /**
         * When a grid row is clicked, this is where the user should
         * be redirected to. In this case edit the product using Magento edit
         * product page.
         */
        return $this->getUrl('adminhtml/catalog_product/edit', 
            array('id' => $row->getId())
        );
    }

    protected function _prepareColumns()
    {
    	/* @var Gareth_QuickStockAdjust_Helper_Data $helper */
    	$helper = Mage::helper('gareth_quickstockadjust/data');
    	
        /**
         * Here we define which columns we want to be displayed in the grid.
         */
        $this->addColumn('entity_id', array(
        		'header' => $helper->__('ID'),
            	'type' => 'number',
            	'index' => 'entity_id',
        ));
        
        $this->addColumn('sku', array(
        		'header' => $helper->__('SKU'),
        		'width' => '9ex',
        		'type' => 'text',
        		'index' => 'sku',
        ));
        
        $this->addColumn('name', array(
        		'header' => $helper->__('Name'),
        		'type' => 'text',
        		'index' => 'name',
        ));
        
                $this->addColumn('qty', array(
        		'header' => $helper->__('# Stock'),
            	'type' => 'number',
            	'index' => 'qty',
        ));
        
/**
         * Finally we add an action column with an edit link.
         */
        $this->addColumn('action', array(
        		'header' => $helper->__('Action'),
	            'width' => '20ex',
	            'type' => 'action',
	            'actions' => array(
	                array(
	                    'caption' => $helper->__('Reduce stock by 1'),
	                    'url' => array(
	                        'base' => 'quick_stock_adjust_admin/quickadjust/decrement',
	                    ),
	                    'field' => 'product'
	                ),
	            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'entity_id',
        ));
        
        return parent::_prepareColumns();
    }
}
