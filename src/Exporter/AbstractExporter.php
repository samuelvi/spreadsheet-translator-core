<?php

declare(strict_types=1);

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Atico\SpreadsheetTranslator\Core\Exporter;

use Exception;

abstract class AbstractExporter
{
    /** @var  ExporterConfigurationManager $configuration */
    protected $configuration;

    protected abstract function buildContent(ExportContentInterface $exportContent);

    protected abstract function getFormat();

    /**
     * @throws Exception
     */
    public function save($localizedTranslations, $sheetName): void
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

    private function buildFileNameWithoutExtension($sheetName, $locale): string
    {
        return sprintf('%s%s.%s', $this->configuration->getPrefix(), $sheetName, $locale);
    }

    private function buildFileNameWithExtension(string $fileName): string
    {
        return sprintf('%s.%s', $fileName, $this->getFormat());
    }

    /**
     * @throws Exception
     */
    private function doPersist(string $destinationFile, $content): void
    {
        $bytes = file_put_contents($destinationFile, $content);
        if ($bytes === false) {
            throw new Exception(sprintf('An error occurred when saving the file %s', $destinationFile));
        }
    }

    protected function buildDestinationFile($baseName)
    {
        return sprintf('%s%s%s', $this->buildDestinationFolder(), DIRECTORY_SEPARATOR, $baseName);
    }

    private function buildDestinationFolder(): string
    {
        return rtrim((string) $this->configuration->getDestinationFolder(), DIRECTORY_SEPARATOR);
    }
}
