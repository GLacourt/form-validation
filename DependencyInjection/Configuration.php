<?php
/**
 * Class DynamicFormService
 *
 * PHP Version 7.0
 *
 * @category Services
 *
 * @package  App\Services
 *
 * @author   Adfab <dev@adfab.fr>
 *
 * @license  All right reserved
 *
 * @link     Null
 */

namespace Adfab\FormValidation\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('form.validation');

        return $treeBuilder;
    }
}