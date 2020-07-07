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

class AdminProductEventController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = 'productevent';
        $this->className = 'FBenoist\FbSample_Event\Model\ProductEvent';
        $this->lang = true;
        $this->bootstrap = true;
        parent::__construct();

        $this->fields_list = [
            'id_productevent' => ['title' => '#'],
            'title' => [
                'title' => $this->module->l('Title', 'AdminProductEventController')
            ],
            'date_event_start' => [
                'title' => $this->module->l('Date start', 'AdminProductEventController'),
                'type' => 'datetime'
            ],
            'date_event_end' => [
                'title' => $this->module->l('Date end', 'AdminProductEventController'),
                'type' => 'datetime'
            ]
        ];

        $this->bulk_actions = [
            'delete' => [
                'text' => $this->module->l('Delete selected', 'AdminProductEventController'),
                'confirm' => $this->module->l('Delete selected items?', 'AdminProductEventController')
            ],
            'enableSelection' => [
                'text' => $this->module->l('Enable selection', 'AdminProductEventController')
            ],
            'disableSelection' => [
                'text' => $this->module->l('Disable selection', 'AdminProductEventController')
            ]
        ];
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    public function renderForm()
    {
        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
               'title' => $this->module->l('Edit Content', 'AdminProductEventController')
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->module->l('Title', 'AdminProductEventController'),
                    'name' => 'title',
                    'size' => 120,
                    'lang' => true,
                    'required' => true
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->module->l('Active', 'AdminProductEventController'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->module->l('Yes', 'AdminProductEventController')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->module->l('No', 'AdminProductEventController')
                        )
                    )
                ),
                array(
                    'type' => 'datetime',
                    'label' => $this->module->l('Event start', 'AdminProductEventController'),
                    'name' => 'date_event_start',
                    'size' => 10,
                    'required' => true,
                ),
                array(
                    'type' => 'datetime',
                    'label' => $this->module->l('Event end ', 'AdminProductEventController'),
                    'name' => 'date_event_end',
                    'size' => 10,
                    'required' => true,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->module->l('Content', 'AdminProductEventController'),
                    'name' => 'message',
                    'autoload_rte' => true,
                    'lang' => true,
                    'rows' => 10,
                    'cols' => 100
                )
            ),
            'submit' => array(
                'title' => $this->module->l('Save')
            )
        );
        return parent::renderForm();

    }




    public static function installInBO($menu_entry_title)
    {
        // Use Legacy
        $new_menu = new Tab();
        $new_menu->id_parent = Tab::getIdFromClassName('AdminCatalog');
        $new_menu->class_name = 'AdminProductEvent'; // Class Name (Without "Controller")
        $new_menu->module = 'fbsample_event'; // Module name
        $new_menu->active = true;

        // Set menu name in all active Language.
        $languages = Language::getLanguages(true);
        foreach ($languages as $language) {
            $new_menu->name[(int)$language['id_lang']] = $menu_entry_title;
        }
        return $new_menu->save();
    }

    public static function removeFromBO()
    {
        $remove_id = Tab::getIdFromClassName('AdminProductEvent');
        if ($remove_id) {
            $to_remove = new Tab((int)$remove_id);
            if (validate::isLoadedObject($to_remove)) {
                return $to_remove->delete();
            }
        }
        return true;
    }

    public function displayAjax()
    {
        die('AdminProductEventController::displayAjax....');
    }

    public function displayAjaxLoad()
    {
        die('AdminProductEventController::displayAjaxLoad');
    }
}
