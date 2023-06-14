<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\Validation;

use Tilta\Sdk\Exception\TiltaException;

class InvalidFieldValueCollectionException extends TiltaException
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var InvalidFieldValueException[]
     */
    protected array $errors = [];

    public function addError(string $field, InvalidFieldValueException $fieldException): void
    {
        $this->errors[$field] = $fieldException;

        $this->message = 'Field validation errors: ';
        foreach ($this->errors as $_field => $error) {
            $this->message .= "\n" . $_field . ': ' . $error->getMessage();
        }
    }

    /**
     * @return InvalidFieldValueException[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
