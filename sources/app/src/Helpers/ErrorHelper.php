<?php

declare(strict_types=1);

namespace App\Helpers;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorHelper
{
    /**
     * @return array
     */
    public function createErrorResponse(ConstraintViolationListInterface $errors): array
    {
        $response = [];
        foreach ($errors as $error) {
            $response['errors'][] = [
                $error->getMessage(),
                $error->getParameters(),
            ];
        }

        return $response;
    }
}
