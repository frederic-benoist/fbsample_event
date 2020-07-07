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

namespace FBenoist\FbSample_Event\Model;

use Db;
use DbQuery;
use ObjectModel;
use Context;

class ProductEvent extends ObjectModel
{
    public $active;
    public $date_event_start;
    public $date_event_end;
    public $date_add;
    public $date_upd;
    public $title;
    public $message;

    public static $definition = array(
        'table' => 'productevent',
        'primary' => 'id_productevent',
        'multilang' => true,
        'fields' => array(
            'date_event_start' => array('type' => self::TYPE_DATE),
            'date_event_end' => array('type' => self::TYPE_DATE),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),
            'active' => array('type' => self::TYPE_BOOL, 'required' => true),
            'title' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName',
                'required' => true,
                'size' => 120
            ),
            'message' => array(
                'type' => self::TYPE_HTML,
                'lang' => true,
                'validate' => 'isString',
                'size' => 3999999999999
            ),
        )
    );

    public static function createDbTable()
    {
        return Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'productevent`(
                    `id_productevent` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `active` TINYINT(1) NOT NULL DEFAULT \'0\',
                    `date_event_start` DATETIME,
                    `date_event_end` DATETIME,
                    `date_add` DATETIME,
                    `date_upd` DATETIME,
                    PRIMARY KEY (`id_productevent`)
                    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8')
            && Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'productevent_lang`(
                    `id_productevent` INT(10) UNSIGNED NOT NULL,
                    `id_lang` INT(10) UNSIGNED NOT NULL,
                    `title` VARCHAR(120) DEFAULT NULL,
                    `message` TEXT,
                    PRIMARY KEY (`id_productevent`,`id_lang`)
                    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');
    }

    public static function removeDbTable()
    {
        return Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'productevent`')
            && Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'productevent_lang`');
    }

    public static function getActiveEventForAdminProduct($id_lang = null)
    {
        $id_lang = is_null($id_lang) ? (int)Context::getContext()->language->id : (int)$id_lang;

        $query = new DbQuery();
        $query->select('p.id_productevent, pl.title');
        $query->from('productevent', 'p');
        $query->innerJoin(
            'productevent_lang',
            'pl',
            'p.id_productevent = pl.id_productevent AND pl.id_lang = '.(int)$id_lang
        );
        $query->where('p.active = 1');
        $query->orderBy('date_event_start DESC');
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
    }
}
