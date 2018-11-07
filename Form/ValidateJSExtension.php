<?php
/**
 * Class FormValidatorExtension
 *
 * PHP Version 7.0
 *
 * @category Form
 *
 * @package  App\Form
 *
 * @author   Adfab <dev@adfab.fr>
 *
 * @license  All right reserved
 *
 * @link     Null
 */

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Validator\ViolationMapper\ViolationMapper;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class FormValidatorExtension
 */
class FormValidatorExtension extends BaseValidatorExtension
{
    /**
     * @param string|null $property
     * @param array       $constraints
     *
     * @return array
     */
    protected function transpile(string $property = null, array $constraints = [])
    {
        $validate = [];

        foreach ($constraints as $constraint) {
            switch (get_class($constraint)) {
                case NotBlank::class:
                    $validate[] = [
                        $property => [
                            'presence'   => [
                                'message' => $constraint->message,
                            ],
                            'allowEmpty' => false,
                        ],
                    ];
                    break;
            }
        }

        return $validate;
    }
}