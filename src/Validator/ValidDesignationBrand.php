<?php

// src/Validator/ValidDesignationBrand.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidDesignationBrand extends Constraint
{
    public string $message = 'La désignation "{{ designation }}" est invalide. Les valeurs ne correspondent pas aux normes attendues.';
}
