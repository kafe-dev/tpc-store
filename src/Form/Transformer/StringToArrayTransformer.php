<?php

namespace App\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class StringToArrayTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(mixed $value): mixed
    {
        if ($value === null) {
            return '';
        }

        return is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform(mixed $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        return array_map('trim', explode(',', $value));
    }
}
