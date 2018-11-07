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

        $rootNode
            ->children()
                ->scalarNode('lib')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(['jQueryFormValidator', 'Parsley', 'ValidateJS'])
                        ->thenInvalid('Invalid lib')
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('mapping')
                    ->children()
                        ->scalarNode('constraint')->end()
                        ->scalarNode('bridge')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}