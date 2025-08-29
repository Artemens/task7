<?php

use \Bitrix\Main\EventManager;

class emperor_site extends CModule
{
    var $MODULE_ID  = 'emperor.site';

    function __construct()
    {
        $arModuleVersion = array();
        include __DIR__ . '/version.php';

        $this->MODULE_ID = 'emperor.site';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = 'Комплексное свойство';
        $this->MODULE_DESCRIPTION = 'Куууча полей';

        $this->PARTNER_NAME = 'Комплекс комплекс';
        $this->PARTNER_URI = 'https://phpdev.org';

        $this->FILE_PREFIX = 'cprop';
        $this->MODULE_FOLDER = str_replace('.', '_', $this->MODULE_ID);
        $this->FOLDER = 'bitrix';

        $this->INSTALL_PATH_FROM = '/' . $this->FOLDER . '/modules/' . $this->MODULE_ID;
    }

    function isVersionD7()
    {
        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;
        if($this->isVersionD7())
        {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();

            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
        }
        else
        {
            $APPLICATION->ThrowException('Битрикс старый!');
        }
    }

    function DoUninstall()
    {
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->UnInstallFiles();
        $this->UnInstallEvents();
        $this->UnInstallDB();
    }

    function InstallDB()
    {
        return true;
    }

    function UnInstallDB()
    {
        return true;
    }

    function installFiles()
    {
        return true;
    }

    function uninstallFiles()
    {
        return true;
    }

    function getEvents()
    {
        return [
            ['FROM_MODULE' => 'iblock', 'EVENT' => 'OnIBlockPropertyBuildList', 'TO_METHOD' => 'GetUserTypeDescription'],
        ];
    }

    function InstallEvents()
    {
        $classHandler = 'ComplexPropertyEmp';
        $eventManager = EventManager::getInstance();

        $arEvents = $this->getEvents();
        foreach($arEvents as $arEvent){
            $eventManager->registerEventHandler(
                $arEvent['FROM_MODULE'],
                $arEvent['EVENT'],
                $this->MODULE_ID,
                $classHandler,
                $arEvent['TO_METHOD']
            );
        }

        return true;
    }

    function UnInstallEvents()
    {
        $classHandler = 'ComplexPropertyEmp';
        $eventManager = EventManager::getInstance();

        $arEvents = $this->getEvents();
        foreach($arEvents as $arEvent){
            $eventManager->unregisterEventHandler(
                $arEvent['FROM_MODULE'],
                $arEvent['EVENT'],
                $this->MODULE_ID,
                $classHandler,
                $arEvent['TO_METHOD']
            );
        }

        return true;
    }
}