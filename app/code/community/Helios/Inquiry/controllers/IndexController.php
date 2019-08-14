<?php
/**
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Helios_Inquiry_IndexController extends Mage_Core_Controller_Front_Action
{	
    public function indexAction()
    {
		 $this->loadLayout(array('default'));
		 $this->_initLayoutMessages('core/session');
		 $this->renderLayout();
		 
		 if($_POST['SUBMIT']=='SUBMIT')
		 {
			 $produkteinfo =  $this->getRequest()->getParam("produkteinfo");
			 			 
			 
			 $fname =  $this->getRequest()->getParam("firstname");
			 $lname =  $this->getRequest()->getParam("lastname");
			 $company =  $this->getRequest()->getParam("company");
			 
			 //$subject =  $this->getRequest()->getParam("subject");
			 $road =  $this->getRequest()->getParam("city")."," .$this->getRequest()->getParam("state");
			 
			 $zip =  $this->getRequest()->getParam("zip");
			 $location =  $this->getRequest()->getParam("country");
			 
			 $phone =  $this->getRequest()->getParam("phone");
			 $email =  $this->getRequest()->getParam("email");
			 $bdesc =  addslashes($this->getRequest()->getParam("comments"));
			 $headers = "";
		 
		 	$insertArr = array("produckteinfo"=>$produkteinfo,"firstname"=>$fname,"lastname"=>$lname,"company"=>$company,"road"=>$road,"zip"=>$zip,"location"=>$location,"phone"=>$phone,"email"=>$email,"desc"=>$bdesc,"iscustcreated"=>0,"status"=>1,"createddt"=>date('Y-m-d H:i:s')); 			
			$collection = Mage::getModel("inquiry/inquiry");
			$collection->setData($insertArr); //
			$collection->save();
			
		
	 	$adminContent = '<table border="1">
							<tr>
								<td>
									<table border="0">
										<tr>
											<Td><label>Hello Administrator,</label></Td>
										</tr>
										<tr>
											<Td><p>Mr/Ms. '.$fname.' '.$lname.' have requested a produkt and details are below.</p></td>
										</tr>
										<tr>
												<td>
													<table border="0">
														<tr>
													<td><label>First Name:</label></td>
													<td><label>'.$fname.'</label></td>
												</tr>
												<tr>
													<td><label>Last Name:</label></td>
													<td><label>'.$lname.'</label></td>
												</tr>
												<tr>
													<td><label>Company:</label></td>
													<td><label>'.$company.'</label></td>
												</tr>
												<tr>
													<td><label>Subject:</label></td>
													<td><label>'.$subject.'</label></td>
												</tr>
												<tr>
													<td><label>Road:</label></td>
													<td><label>'.$road.'</label></td>
												</tr>

												<tr>
													<td><label>ZIP/Postal Code:</label></td>
													<td><label>'.$zip.'</label></td>
												</tr>
												<tr>
													<td><label>Location:</label></td>
													<td><label>'.$location.'</label></td>
												</tr>

											
												<tr>
													<td><label>Contact Phone Number:</label></td>
													<td><label>'.$phone.'</label></td>
												</tr>
												<tr>
													<td><label>Email:</label></td>
													<td><label>'.$email.'</label></td>
												</tr>
												
												<tr>
													<td valign="top" width="15%"><label>Description:</label></td>
													<td><label>'.$bdesc.'</label></td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
												<tr>
													<td colspan="2"><label>Thank You.</label></td>
												</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>';
		$adminSubject = "Produkte Inquiry from New Customer";
		$adminName = Mage::getStoreConfig('quotation/emailsetting/sender_email'); //sender name
		$adminEmail = Mage::getStoreConfig('quotation/emailsetting/sender_email');
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$adminEmail;
		///Comment the mail functionality while using in local in below than ver1.4.1
		//beginning og mail functionality.......................
		
	
		mail($adminEmail,$adminSubject,$adminContent,$headers);
	
		$customerContent = '<table border="0">
									<tr>
										<td>
											<table border="0">
												<tr>
													<td>Hello '.$fname.' '.$lname.',</td>
												</tr>
												<tr>
													<td><p>Thank you for contacting '.$adminName.'. A company representative will contact you as soon as possible.</p></td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
												<tr>
													<td colspan="2">Thank You.</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
		$headers = "";
		$adminName = Mage::getStoreConfig('quotation/emailsetting/title_email'); //sender name
		$custSubject = "Thank you for contacting ".$adminName."";
		$headers  .= 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:'.$adminEmail;
		//end mail functionaliy...............
		mail($email,$custSubject,$customerContent,$headers);
		
		Mage::getSingleton('core/session')->addSuccess(Mage::helper('inquiry')->__('Your inquiry was submitted and will be responded to as soon as possible.'));
		$this->_redirect('inquiry/index/thanks');
    	} 
    }
	
	public function delAction()
	{
		 $getUrl=Mage::getSingleton('adminhtml/url')->getSecretKey("adminhtml_mycontroller","delAction");
		
		$delid = $this->getRequest()->getParam('delid');
		if(!empty($delid))
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
		
		$this->_redirectReferer();
	}
	
	
	public function thanksAction()
    {
		 $this->loadLayout(array('default'));
		 $this->renderLayout();
	}
}	
?>
