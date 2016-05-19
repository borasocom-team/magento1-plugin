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
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Creative Commons License.
 * It is available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to servicedesk@totalinternetgroup.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact servicedesk@totalinternetgroup.nl for more information.
 *
 * @copyright   Copyright (c) 2016 Total Internet Group B.V. (http://www.totalinternetgroup.nl)
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 */
/**
 * Class TIG_Adcurve_Helper_Data
 */
class TIG_TinyPNG_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * The name of the logfile.
     *
     * @var string
     */
    protected $_logFile = 'TIG_TinyPNG.log';

    /**
     * @param $msg
     * @param $type
     */
    public function logMessage($msg, $type = null, $store = null)
    {
        $logginModes = $this->_loggingArray($store);

        /**
         * Always log exceptions. $msg should be an instanceof Exception!
         */
        if ($msg instanceof Exception ) {
            $type = 'exception';
        }

        if (!in_array($type, $logginModes)) {
            return;
        }

        Mage::log($msg, null, $this->_logFile, true);

        return $this;
    }

    /**
     * @param $store
     *
     * @return array
     */
    protected function _loggingArray($store)
    {
        switch (TIG_TinyPNG_Helper_Config::getLoggingMode($store))
        {
            case 'only_exceptions':
                $logginArray = array('exception');
                break;
            case 'fail_and_exceptions':
                $logginArray = array('failure', 'exception');
                break;
            case 'all':
                $logginArray = array('info', 'failure', 'exception');
                break;
            default:
                $logginArray = array('exception');
        }

        return $logginArray;
    }

}