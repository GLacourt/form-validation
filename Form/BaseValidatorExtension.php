<?php
/**
 * Class BaseValidatorExtension
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

use Adfab\FormValidation\Form\ValidatorInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\MetadataInterface;

/**
 * Class BaseValidatorExtension
 */
class BaseValidatorExtension extends AbstractTypeExtension implements ValidatorInterface
{
    /** @var ValidatorInterface $validator */
    protected $validator;

    /**
     * BaseValidatorExtension constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function getExtendedType()
    {
        return FormType::class;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validate' => [],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($entity = $form->getConfig()->getDataClass()) {
            $metadata = $this->validator->getMetadataFor($entity);

            foreach ($form->all() as $formInterface) {
                $this->addConstraintToValidate($metadata, $formInterface);
            }
        }

        if (isset($options['validate'])) {
            $view->vars['validate'] = $options['validate'];
        }
    }

    /**
     * @param MetadataInterface $metadata
     * @param FormInterface     $form
     *
     * @throws \ReflectionException
     */
    protected function addConstraintToValidate(MetadataInterface $metadata, FormInterface $form)
    {
        $property = $form->getName();
        $type     = $form->getConfig()->getType()->getInnerType();
        $options  = $form->getConfig()->getOptions();

        $type = (new \ReflectionClass($type))->getName();
        if ($metadata->hasPropertyMetadata($property)) {
            foreach ($metadata->getPropertyMetadata($property) as $propertyMetadata) {
                $constraints = $propertyMetadata->getConstraints();

                if (isset($options['validate'])) {
                    $options['validate'] = array_merge($options['validate'], $this->transpile($property, $constraints));
                }
            }
        }

        $form->getParent()->add($property, $type, $options);
    }

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
