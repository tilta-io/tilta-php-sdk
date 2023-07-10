<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LogLevel;
use Tilta\Sdk\Util\Logging;

function enableLogging(): void
{
    if (!isset($_ENV['LOG_FILE'])) {
        fwrite(STDOUT, 'TILTA: Logging of API Requests is disabled.' . "\n");

        return;
    }

    $logFile = $_ENV['LOG_FILE'];

    $logger = new Logger('phpunit-request-logger');
    $handler = new StreamHandler($logFile, LogLevel::DEBUG);
    $logger->pushHandler($handler);

    if ($handler->getUrl() && file_exists($handler->getUrl())) {
        // always delete file on a new run to keep the file clean
        unlink($handler->getUrl());
    }

    Logging::setPsr3Logger($logger);
    Logging::setLogHeaders(true);

    fwrite(STDERR, sprintf('TILTA: Logging of API Requests is enabled. LogFile: %s' . "\n", $handler->getUrl()));
}

enableLogging();
