<?php

if (!defined('TYPO3_MODE') && !defined('TYPO3')) {
    die('Access denied.');
}

$driverRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\Driver\DriverRegistry::class);
$driverRegistry->registerDriverClass(
    \AUS\AusDriverAmazonS3\Driver\AmazonS3Driver::class,
    \AUS\AusDriverAmazonS3\Driver\AmazonS3Driver::DRIVER_TYPE,
    'AWS S3',
    'FILE:EXT:' . \AUS\AusDriverAmazonS3\Driver\AmazonS3Driver::EXTENSION_KEY . '/Configuration/FlexForm/AmazonS3DriverFlexForm.xml'
);

// register extractor
\TYPO3\CMS\Core\Resource\Index\ExtractorRegistry::getInstance()->registerExtractionService(\AUS\AusDriverAmazonS3\Index\Extractor::class);

/* @var $signalSlotDispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\SignalSlot\Dispatcher');
$signalSlotDispatcher->connect(\TYPO3\CMS\Core\Resource\Index\FileIndexRepository::class, 'recordUpdated', \AUS\AusDriverAmazonS3\Signal\FileIndexRepository::class, 'recordUpdatedOrCreated');
$signalSlotDispatcher->connect(\TYPO3\CMS\Core\Resource\Index\FileIndexRepository::class, 'recordCreated', \AUS\AusDriverAmazonS3\Signal\FileIndexRepository::class, 'recordUpdatedOrCreated');
