<?php
/**
 * 2007-2020 Frédéric BENOIST
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *  @author    Frédéric BENOIST
 *  @copyright 2013-2020 Frédéric BENOIST <https://www.fbenoist.com/>
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

include_once _PS_MODULE_DIR_.'fbsample_event/vendor/autoload.php';

class Fbsample_EventDefaultModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        // ...

        $this->setTemplate('module:fbsample_event/views/templates/front/default.tpl');
        parent::initContent();
    }

    public function displayAjax()
    {
        die('displayAjax....');
    }

    public function displayAjaxLoad()
    {
        die('displayAjaxLoad');
    }


}
