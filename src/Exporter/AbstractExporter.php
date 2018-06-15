<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Exporter;

abstract class AbstractExporter
{
    /** @var  ExporterConfigurationManager $configuration */
    protected $configuration;

    protected abstract function buildContent(ExportContentInterface $exportContent);

    protected abstract function getFormat();

    /**
     * @throws \Exception
     */
    public function save($localizedTranslations, $sheetName)
    {
        foreach ($localizedTranslations as $locale => $translations) {

            $fileName = $this->buildFileNameWithoutExtension($sheetName, $locale);
            $baseName = $this->buildFileNameWithExtension($fileName);
            $absolutePath = $this->buildDestinationFile($baseName);

            /** @var ExportContent $exportContent */
            $exportContent = new ExportContent($absolutePath, $translations, $locale);
            $content = $this->buildContent($exportContent);

            $this->doPersist($absolutePath, $content);
        }
    }

    private function buildFileNameWithoutExtension($sheetName, $locale)
    {
        return sprintf('%s_%s.%s', $this->configuration->getDomain(), $sheetName, $locale);
    }

    private function buildFileNameWithExtension($fileName)
    {
        return sprintf('%s.%s', $fileName, $this->getFormat());
    }

    /**
     * @throws \Exception
     */
    private function doPersist($destinationFile, $content)
    {
        $bytes = file_put_contents($destinationFile, $content);
        if ($bytes === false) {
            throw new \Exception(sprintf('An error occurred when saving the file %s', $destinationFile));
        }
    }

    protected function buildDestinationFile($baseName)
    {
        $destinationFile = sprintf('%s%s%s', $this->buildDestinationFolder(), DIRECTORY_SEPARATOR, $baseName);
        return $destinationFile;
    }

    private function buildDestinationFolder()
    {
        return rtrim($this->configuration->getDestinationFolder(), DIRECTORY_SEPARATOR);
    }
}