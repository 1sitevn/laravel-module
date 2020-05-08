<?php


namespace OneSite\Module;


/**
 * Interface FileGeneratorInterface
 * @package OneSite\Module
 */
interface FileGeneratorInterface
{
    /**
     * @param $filePath
     * @param $targetFilePath
     * @param array $searchContent
     * @param array $replaceContent
     * @return mixed
     */
    public function generator($filePath, $targetFilePath, $searchContent = [], $replaceContent = []);
}