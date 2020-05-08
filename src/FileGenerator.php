<?php


namespace OneSite\Module;

use Illuminate\Filesystem\Filesystem;

/**
 * Class FileGenerator
 * @package OneSite\Module
 */
class FileGenerator implements FileGeneratorInterface
{

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * FileGenerator constructor.
     */
    public function __construct()
    {
        $this->file = new Filesystem();
    }

    /**
     * @param $filePath
     * @param $targetFilePath
     * @param array $searchContent
     * @param array $replaceContent
     * @return mixed|void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generator($filePath, $targetFilePath, $searchContent = [], $replaceContent = [])
    {
        $content = $this->file->get($filePath);

        $content = str_replace($searchContent, $replaceContent, $content);

        $this->putFileContent($targetFilePath, $content);
    }

    /**
     * @param $filePath
     * @param $content
     */
    public function putFileContent($filePath, $content)
    {
        $dirname = dirname($filePath);

        if (!$this->file->exists($dirname)) {
            $this->file->makeDirectory($dirname, 0755, true);
        }

        $this->file->put($filePath, $content);
    }
}
