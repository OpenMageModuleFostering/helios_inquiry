<?php

class Helios_Inquiry_Block_About
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Render fieldset html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = <<<HTML
<div style="background:#EAF0EE;border:1px solid #CCCCCC;margin-bottom:10px;padding:5px;">
    <img src="http://www.heliossolutions.in/wp-content/themes/helios/newimages/logo.png">
	<li id="menu-item-212"><a href="http://www.heliossolutions.in/about-helios/"><span class="wpmega-link-title">About Helios</span></a><div class="wpmega-nonlink uberClearfix"><p>Helios Solutions is an Indian IT sourcing company which sees your relationship with us as equally vital to the success of our outsourcing partnership as our development skills. We focus exclusively on the European market and employ native European Project Managers to bridge the cultural and communication gap and ensure your outsourcing experience to India is the same as if you were working with a European partner. When working with us you will always have a Project Manager from your own country here in India. You can communicate comfortably in your own language and avoid any cultural misunderstandings that might otherwise arise when working across national borders.</p>
	<li id="menu-item-268" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-depth-1 ss-sidebar"><a href="#"><span class="wpmega-link-title">Address</span></a><div class="wpmega-nonlink wpmega-widgetarea ss-colgroup-1 uberClearfix"><ul id="wpmega-ubermenu-widget-area-2"><li id="custom_post_widget-7" class="widget widget_custom_post_widget"><div class="clearfix">
	<div style="float: left; margin-right: 15px; padding-top: 0px;">	
	</div>	
	<div style="float: left; clear: both; padding-top: 5px;"><b>Email:</b> info@heliossolutions.in, hsmagento.support@heliossolutions.in</div>	
	</div>
	</li>
</ul></div></li>
</div>
HTML;
        return $html;
    }
}
