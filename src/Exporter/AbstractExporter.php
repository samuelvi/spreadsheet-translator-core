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
    public function save($localizedTranslations)
    {
        foreach ($localizedTranslations as $locale => $translations) {
            $destinationFile = $this->buildDestinationFile($locale, $this->getFormat());

            /** @var ExportContent $exportContent */
            $exportContent = new ExportContent($destinationFile, $translations, $locale);
            $content = $this->buildContent($exportContent);

            $this->persist($destinationFile, $content);
        }
    }

    /**
     * @throws \Exception
     */
    protected function persist($destinationFile, $content)
    {
        $bytes = file_put_contents($destinationFile, $content);
        if ($bytes === false) {
            throw new \Exception(sprintf('An error occurred when saving the file %s', $destinationFile));
        }
    }

    protected function getDestinationFileWithoutExtension()
    {
        $destinationFolder = sprintf('%s%s', rtrim($this->configuration->getDestinationFolder(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);
        return sprintf('%s%s%s', $destinationFolder, $this->configuration->getPrefix(), $this->configuration->getDomain());
    }

    protected function buildDestinationFile($locale, $extension)
    {
        $destinationFile = sprintf('%s.%s.%s', $this->getDestinationFileWithoutExtension(), $locale, $extension);
        return $destinationFile;
    }
}