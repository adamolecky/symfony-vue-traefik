<?php

declare(strict_types=1);

namespace App\Helpers;

use Symfony\Component\ErrorHandler\Error\UndefinedMethodError;
use Symfony\Component\HttpFoundation\Request;

use function array_walk;
use function json_decode;
use function method_exists;
use function ucfirst;

class RequestHelper
{
    /**
     * @param Object $entity
     *
     * @return Object
     *
     * @throws UndefinedMethodError
     *
     * Description: takes Request and Entity. Decodes content from request as an associative array. Walks through array
     * using key of array row as source for creating name of setter function. When created name, value from array is set
     * for entity via setter function. Returns filled entity if given request is correct.
     */
    public function fillEntityFromRequest(Request $request, object $entity): object
    {
        $data = json_decode((string) $request->getContent(), true);
        array_walk($data, static function ($val, $key) use ($entity): void {
            $key = ucfirst($key);
            $funcName = (string) ("set{$key}");
            if (! method_exists($entity, $funcName)) {
                return;
            }

            $entity->$funcName($val);
        });

        return $entity;
    }
}
