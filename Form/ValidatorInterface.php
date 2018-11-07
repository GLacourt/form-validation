<?php
/**
 * Class ValidatorInterface
 *
 * PHP Version 7.0
 *
 * @category Interface
 *
 * @package  Adfab\FormValidation\Form
 *
 * @author   Adfab <dev@adfab.fr>
 *
 * @license  All right reserved
 *
 * @link     Null
 */

namespace Adfab\FormValidation\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Mapping\MetadataInterface;

/**
 * Interface ValidatorInterface
 */
interface ValidatorInterface
{
    /**
     * @param MetadataInterface $metadata
     * @param FormInterface     $form
     */
    public function addConstraintToValidate(MetadataInterface $metadata, FormInterface $form);

    /**
     * @param string $property
     * @param array  $constraints
     */
    public function transpile(string $property, array $constraints);
}