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


if (!defined('_PS_VERSION_')) {
    exit;
}

include_once dirname(__FILE__).'/vendor/autoload.php';

use FBenoist\FbSample_Event\Model\ProductEvent;

class Fbsample_Event extends Module
{
    public function __construct()
    {
        $this->name = 'fbsample_event';
        $this->version = '1.7.0';
        $this->author = 'Frederic BENOIST';
        $this->tab = 'others';
        $this->bootstrap = true;
        $this->controllers = array('default');
        $this->ps_versions_compliancy = array(
            'min' => '1.7.6',
            'max' => _PS_VERSION_
        );
        parent::__construct();
        $this->displayName = $this->l('Sample product event Module ');
        $this->description = $this->l('Add event to product in PrestaShop 1.7.');
    }

    public function install()
    {
        return parent::install()
            //&& ProductEvent::createDbTable()
            && $this->registerHook('displayAdminProductsExtra')
            && AdminProductEventController::installInBO('Manage product event');
    }

    public function uninstall()
    {
        return parent::uninstall()
            //&& ProductEvent::removeDbTable()
            && AdminProductEventController::removeFromBO();
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        $id_product = (int)$params['id_product'];

        $this->context->smarty->assign([
            'allEvent' => ProductEvent::getActiveEventForAdminProduct()
        ]);

        return $this->fetch(
            'module:'.$this->name.'/views/templates/hook/displayAdminProductsExtra.tpl'
        );
    }
}
