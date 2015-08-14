<?php

namespace Polifonic\Bundle\MailerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * PolifonicMailer bundle extension.
 *
 * @author     Olivier Pichon <op@united-asian.com>
 * @copyright  2015 Olivier Pichon
 */
class PolifonicMailerExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @param mixed[]          $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');
    }
}
