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
use Atico\SpreadsheetTranslator\Core\Configuration\AbstractConfigurationManager;

class ExporterConfigurationManager extends AbstractConfigurationManager implements ExporterConfigurationInterface
{
    /**
     * @throws Exception
     */
    public function getDestinationFolder()
    {
        return $this->getRequiredOption('destination_folder');
    }

    public function getPrefix()
    {
        return $this->getNonRequiredOption('prefix', '');
    }

    /**
     * @throws Exception
     */
    public function getDomain()
    {
        return $this->getRequiredOption('domain');
    }
}
