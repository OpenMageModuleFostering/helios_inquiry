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
}
?>
