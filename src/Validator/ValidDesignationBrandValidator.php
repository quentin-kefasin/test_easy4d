<?php

// src/Validator/ValidDesignationBrandValidator.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidDesignationBrandValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {        
        if (null === $value || '' === $value) {
            return;
        }

        $product = $this->context->getObject();

        if (!$product instanceof \App\Entity\Product || !$product->getDesignation()) {
            return;
        }

        $designation = $product->getDesignation();
        $designation = preg_replace('/\s+/', ' ', $designation);

        // Récupérer les champs de l’entité
        $width = trim($product->getWidth());
        $height = trim($product->getHeight());
        $construction = trim($product->getConstruction());
        $diameter = trim($product->getDiameter());
        $loadIndex = trim($product->getLoadIndex());
        $speedIndex = trim($product->getSpeedIndex());
        $brandName =trim( $product->getBrand() ? $product->getBrand()->getName() : null);

        $pattern = '/^' . preg_quote($width, '/');
        if ((int) $height > 0) {
            $pattern.= '\/' . preg_quote($height, '/');
        } 
        
        $pattern.= '\s+' .
            preg_quote($construction, '/') . '\s+' . preg_quote($diameter, '/') . '\s+' .
            preg_quote($loadIndex, '/') . preg_quote($speedIndex, '/') . '\s+' .
            preg_quote($brandName, '/') . '\s+.*/';

        if (!preg_match($pattern, $designation, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ designation }}', $designation)
                ->addViolation();
            return;
        }
    }
}
