<?php
/**
 *                  ___________       __            __
 *                  \__    ___/____ _/  |_ _____   |  |
 *                    |    |  /  _ \\   __\\__  \  |  |
 *                    |    | |  |_| ||  |   / __ \_|  |__
 *                    |____|  \____/ |__|  (____  /|____/
 *                                              \/
 *          ___          __                                   __
 *         |   |  ____ _/  |_   ____ _______   ____    ____ _/  |_
 *         |   | /    \\   __\_/ __ \\_  __ \ /    \ _/ __ \\   __\
 *         |   ||   |  \|  |  \  ___/ |  | \/|   |  \\  ___/ |  |
 *         |___||___|  /|__|   \_____>|__|   |___|  / \_____>|__|
 *                  \/                           \/
 *                  ________
 *                 /  _____/_______   ____   __ __ ______
 *                /   \  ___\_  __ \ /  _ \ |  |  \\____ \
 *                \    \_\  \|  | \/|  |_| ||  |  /|  |_| |
 *                 \______  /|__|    \____/ |____/ |   __/
 *                        \/                       |__|
 *
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact servicedesk@totalinternetgroup.nl for more information.
 *
 * @copyright   Copyright (c) 2016 Total Internet Group B.V. (http://www.totalinternetgroup.nl)
 */
class Tiny_CompressImages_Block_Adminhtml_System_Config_Form_Field_Api extends Varien_Data_Form_Element_Abstract
{
    /**
     * Generate the status for the TinyPNG extension.
     *
     * @return string
     */
    public function getElementHtml()
    {
        $_helper = Mage::helper('tig_tinypng');
        $apiStatusCache = Mage::app()->loadCache('tig_tinypng_api_status');
        $message = $_helper->__('Click the button to check the API status.');

        if ($apiStatusCache !== false) {
            $apiStatusCacheData = json_decode($apiStatusCache, true);

            switch ($apiStatusCacheData['status']) {
                case 'operational':
                    $message = '<span class="tinypng_status_success"><span class="apisuccess"></span>'
                        . Mage::helper('tig_tinypng')->__('API connection successful')
                        . '</span>';
                    break;
                case 'nonoperational':
                    $message = '<span class="tinypng_status_failure">'
                        . Mage::helper('tig_tinypng')->__('Non-operational')
                        . '</span>';
                    break;
            }
        }

        $button  = '<button type="button" id="tinypng_check_status" class="scalable">';
        $button .= '<span><span><span>'.$_helper->__('Check status').'</span></span></span></button>';

        $message = '<span id="tinypng_api_status">' . $message . '</span><br>';
        $message .= $button;

        return $message;
    }

    /**
     * @return string
     */
    public function getScopeLabel()
    {
        $_helper = Mage::helper('tig_tinypng');

        $js = '<script type="text/javascript">
                    var url = "' . Mage::helper("adminhtml")->getUrl('adminhtml/tinypngAdminhtml_status/getApiStatus') . '";

                    $("tinypng_check_status").on("click", function (event, element) {
                        Event.stop(event);

                        new Ajax.Request(url,
                            {
                                method: "post",
                                onSuccess: function (data) {
                                    var result = data.responseText.evalJSON(true);
                                    if (result.status == "success") {
                                        element.hide();
                                        $("tinypng_api_status").innerHTML = result.message;
                                    }
                                }
                            })
                    });
                </script>';

        $label = parent::getScopeLabel() . $js;

        return $label;
    }
}
