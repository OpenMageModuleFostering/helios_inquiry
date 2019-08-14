<?php
/**
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Helios_Inquiry_Manage_InquiryController extends Mage_Adminhtml_Controller_Action 
{
    public function indexAction()
    { 
		$action = $custId = "";
		$action = $this->getRequest()->getParam('ac');
		$delid = $this->getRequest()->getParam('delid');
		
		if($action == "del" && !empty($delid))
		{
			$collection = Mage::getModel("inquiry/inquiry")->load($delid);
			
			if($collection->delete())
			{
				Mage::getSingleton('core/session')->addSuccess("Inquire deleted successfully.");
			}
			else
			{
				Mage::getSingleton('core/session')->addError("Sorry inquire is not deleted.");
			}
		}
		
    	$this->_title($this->__('Customer Inquiry'));
        $this->loadLayout();
        $this->_setActiveMenu('inquiry');
       	$this->_addContent($this->getLayout()->createBlock('core/template'));
        $this->renderLayout();
    }
	public function viewAction()
    { 
		$delid = $this->getRequest()->getParam('delid');
		
		$this->_title($this->__('Customer Detail'));

        $this->loadLayout();
        $this->_setActiveMenu('inquiry');
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Dashboard'), Mage::helper('adminhtml')->__('Dashboard'));
		$this->_addContent($this->getLayout()->createBlock('core/template'));
        $this->renderLayout();
		
	}
	public function createCustomerAction()
	{	
		$del = $this->getRequest()->getParam('multival');
		$values = explode('~~',$del); 
		$country11 = $values[9];
		$country1 = explode('$$$',$country11);
 function RandomPassword($PwdLength=8, $PwdType='standard')
    {
		// $PwdType can be one of these:
		//    test .. .. .. always returns the same password = "test"
		//    any  .. .. .. returns a random password, which can contain strange characters
		//    alphanum . .. returns a random password containing alphanumerics only
		//    standard . .. same as alphanum, but not including l10O (lower L, one, zero, upper O)
    $Ranges='';
 
    if('test'==$PwdType)         return 'test';
    elseif('standard'==$PwdType) $Ranges='65-78,80-90,97-107,109-122,50-57';
    elseif('alphanum'==$PwdType) $Ranges='65-90,97-122,48-57';
    elseif('any'==$PwdType)      $Ranges='40-59,61-91,93-126';
 
    if($Ranges<>'')
        {
        $Range=explode(',',$Ranges);
        $NumRanges=count($Range);
        mt_srand(time()); //not required after PHP v4.2.0
        $p='';
        for ($i = 1; $i <= $PwdLength; $i++)
            {
            $r=mt_rand(0,$NumRanges-1);
            list($min,$max)=explode('-',$Range[$r]);
            $p.=chr(mt_rand($min,$max));
            }
        return $p;			
        }
    }
	$randompass = RandomPassword(9,'standard');
		
		$customer = Mage::getModel('customer/customer');
		$website_id = 1;
		
		$customer->setWebsiteId($website_id);
		$customer->loadByEmail($values[0]);
		if(!$customer->getId()) 
		{
			$groups = Mage::getResourceModel('customer/group_collection')->getData();
			$groupID = '1';
			$customer->setData('group_id', $groupID );
			$customer->setData('website_id', '1' );
			$customer->setData('is_active', '1');
			$customer->setData('customer_activated', '1');
			$customer->setStatus(1);
			$customer->setEmail($values[0]);
			$customer->setFirstname($values[1]);
			$customer->setLastname($values[2]);
			$customer->setTaxvat($values[10]);
			//$customer->setPassword($randompass);
			$customer->setPassword($values[1].'pass');
			$customer->setConfirmation(null);
			$customer->save();
			if($customer->save())
			{
				//If you use this extension on local then please comment the mail functionality to use it properly.
				///Beginning of Mail functionality.......
				$adminEmail = Mage::getStoreConfig('trans_email/ident_general/email'); 
				$adminName = Mage::getStoreConfig('trans_email/ident_general/name');
				$fromEmail = $adminEmail;
				$fromName = $adminName;
			 
				$toEmail = $values[0]; 
				$toName = $values[1].$values[2];
			 
				$body = '<table border="1">
											<tr>
												<td>
													<table border="0">
														<tr>
															<Td>Hello '.$values[1].' '.$values[2].',</Td>
														</tr>
														<tr>
														<Td><p>Thank You for Register with '.$adminName.'.Your Login Details for access your Account.....</p></Td>
														</tr>
														<tr>
															<Td><p>Login Email :&nbsp; '.$values[0].' </p></Td>
														</tr>
														<tr>
															<Td><p>Login Password :&nbsp; '.$randompass.' </p></Td>
														</tr>
														<tr>
															<Td><p>You can login directly in your account from here with given login details..... &nbsp;<br /><br />'. Mage::getBaseUrl().'customer/account/login/</p></Td>
														</tr>
														<tr><td colspan="2">&nbsp;</td></tr>
														<tr>
															<td colspan="2">Thank You.</td>
														</tr>
													</table>
													</td>
												</tr>
											</table>';
				$subject = " Registration Details of Customer Inquiry "; 
				
				$mail = new Zend_Mail(); 
				  
				$mail->setBodyHtml($body);
			 
				$mail->setFrom($fromEmail, $fromName);
			 
				$mail->addTo($toEmail, $toName);
			 
				$mail->setSubject($subject);
			 
				try {
					$mail->send();
				}
				catch(Exception $ex) {
					Mage::getSingleton('core/session')
						->__('Unable to send email.');
				}
				///End of Mail functionality.......
				Mage::getSingleton('core/session')->addSuccess("Customer Account Created successfully.");
			}
		//Build billing and shipping address for customer, for checkout
		$_custom_address = array (
		'street' => array (
		'0' => $values[4],
		//'1' => $values[11],
		),
		'firstname' => $values[1],
		'lastname' => $values[2],
		'company' => $values[3],
		'city' => $values[5],
		'region_id' => '',
		'region' => $values[6],
		'postcode' => $values[7],
		'country_id' => $country1[0], 
		'telephone' => $values[8],
		);
		
		$customAddress = Mage::getModel('customer/address');
		$customAddress->setData($_custom_address)
		->setCustomerId($customer->getId())
		->setIsDefaultBilling('1')
		->setIsDefaultShipping('1')
		->setSaveInAddressBook('1');
		
		try {
		$customAddress->save();
		}
		catch (Exception $ex) {
		}
			$this->_redirectReferer();
		}
	}
}
?>
