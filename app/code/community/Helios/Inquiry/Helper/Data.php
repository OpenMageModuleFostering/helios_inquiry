<?php
/**
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Helios_Inquiry_Helper_Data extends Mage_Wishlist_Helper_Data
{
	/**
     * Retrieve logged in customer
     *
     * @return Helios_Inquiry_Helper_Data
    */
	protected function _isloggedCustomer()
    {
        $isloggedin = Mage::getSingleton('customer/session')->isLoggedIn();        
        return $isloggedin;
    }
	protected function _getCustomerDetails()
	{
		$customer = Mage::getSingleton('customer/session');	
		$customerData = Mage::getSingleton('customer/customer')->load($customer->getId())->getData();
		return $customerData;
	}
	protected function _getCustomerAddressDetails()
	{
		$address=Mage::getSingleton('customer/address')->load(1)->getData();
		return $address;
	}
	public function getFirstName()
	{
		if($this->_isloggedCustomer())
		{
			$firstname=$this->_getCustomerDetails();
			return $firstname['firstname'];
		}
		else
			return "";
	}
	public function getLastName()
	{
		if($this->_isloggedCustomer())
		{
			$lastname=$this->_getCustomerDetails();
			return $lastname['lastname'];
		}
		else
			return "";
	}
	public function getCompanyName()
	{
		if($this->_isloggedCustomer())
		{
			$companyName=$this->_getCustomerAddressDetails();
			return $companyName['company'];
		}
		else
			return "";
	}
	public function getEmail()
	{
		if($this->_isloggedCustomer())
		{
			$email=$this->_getCustomerDetails();
			return $email['email'];
		}
		else
			return "";
	}
	public function getCity()
	{
		if($this->_isloggedCustomer())
		{
			$city=$this->_getCustomerAddressDetails();
			return $city['city'];
		}
		else
			return "";
	}
	public function getState()
	{
		if($this->_isloggedCustomer())
		{
			$region=$this->_getCustomerAddressDetails();
			return $region['region'];
		}
		else
			return "";
	}
	public function getCountry()
	{			
		if($this->_isloggedCustomer())
		{
			$address=$this->_getCustomerAddressDetails();
			$countryName = Mage::getModel('directory/country')->load($address['country_id'])->getName();
			$str="";			
			$countries = Mage::getResourceModel('directory/country_collection') ->loadData() ->toOptionArray(false);		
			if (count($countries) > 0):
				$str.='<select id="country" name="country" title="Country">';
				$str.='<option value="">-- Please Select --</option>';
				foreach($countries as $country):
					if($address['country_id']==$country['value']) $select="selected"; else $select="";
					$str.='<option value="'.$country['value'].' "'.$select.'>'.$country['label'].'</option>';			
				endforeach;
			$str.='</select>';			
			endif;
			return $str;
		}
		else
			return "";
	}
	public function getTelephone()
	{
		if($this->_isloggedCustomer())
		{
			$telephone=$this->_getCustomerAddressDetails();
			return $telephone['telephone'];
		}
		else
			return "";
	}
	public function getWproductInquiry($item, array $params = array())
    {
        $productId = null;
        if ($item instanceof Mage_Catalog_Model_Product) {
            $productId = $item->getEntityId();
            $qty = $item->getQty();
        }
        if ($item instanceof Mage_Wishlist_Model_Item) {
            $productId = $item->getProductId();
            $qty = $item->getQty();
        }
		
        if ($productId) {
            $params['product'] = $productId;
            $params['qty'] = (int)$qty;
            
            return $this->_getUrlStore($item)->getUrl('inquiry', $params);
        }

        return false;
    }
}
