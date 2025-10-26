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
namespace Atico\SpreadsheetTranslator\Core\Provider;

use Exception;
use Atico\SpreadsheetTranslator\Core\Configuration\AbstractConfigurationManager;

class DefaultProviderManager extends AbstractConfigurationManager
{
    public function getFormat()
    {
        return $this->getNonRequiredOption('format', $this->getDefaultFormat());
    }

    /**
     * @throws Exception
     */
    public function getSourceResource()
    {
        return $this->getRequiredOption('source_resource');
    }

    /**
     * @throws Exception
     */
    public function getTempLocalSourceFile()
    {
        return $this->getRequiredOption('temp_local_source_file');
    }
}
