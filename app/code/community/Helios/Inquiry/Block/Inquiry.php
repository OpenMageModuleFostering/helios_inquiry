<?php
/**
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Helios_Inquiry_Block_Inquiry extends Mage_Core_Block_Template
{

/*Start fo functions for admin section.*/
	public function getAllInquires()
	{
		if($collection = Mage::getModel("inquiry/inquiry")->getCollection())
			$collection->setOrder('createddt',"Asc")->load(); 
		return $collection;
	}
	
	public function getAllDealer($delId)
	{
		$collection = Mage::getModel("inquiry/inquiry")->load($delId)->getData();
		return $collection;
	}
	public function getWishlistItemsInquiry()
	{
		$productId = (int) $this->getRequest()->getParam('product');
		$qty = (int) $this->getRequest()->getParam('qty');
		
		if(isset($productId) && $productId!='' && isset($qty) && $qty!='')
		{
			$_itemsInWishList[0]['product'] = $productId;
			$_itemsInWishList[0]['qty'] = $qty;
		}else{
			$_itemCollection = Mage::helper('wishlist')->getWishlistItemCollection();
			$_itemsInWishList = array();
			$i=0;
			foreach ($_itemCollection as $_item) {
				$_itemsInWishList[$i]['product'] = $_item->getProductId();
				$_itemsInWishList[$i]['qty'] = (int)$_item->getQty();
				$i++;
	    	}
		}
	
		return base64_encode(serialize($_itemsInWishList));
	}
	public function getIsCreated($email)
	{
		$collection = Mage::getModel("customer/customer")->getCollection()->addFieldToFilter("email",$email);
		if($collection->count())
			return 1;
		else
			return 0;
	}
/*End of functions for admin section.*/
}

