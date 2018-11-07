<?php
/**
 * Class FormValidationExtension
 *
 * PHP Version 7.0
 *
 * @category Extension
 *
 * @package  Adfab\FormValidation\DependencyInjection
 *
 * @author   Adfab <dev@adfab.fr>
 *
 * @license  All right reserved
 *
 * @link     Null
 */
namespace Adfab\FormValidation\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class FormValidationExtension
 */
class FormValidationExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
    }

    /**
     * @inheritdoc
     */
    public function getNamespace()
    {
        return 'http://adfab.fr/schema/dic/form-validation';
    }

    /**
     * @inheritdoc
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }
}