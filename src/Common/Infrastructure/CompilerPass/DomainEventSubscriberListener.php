<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\CompilerPass;

use App\Common\Infrastructure\Events\EventSubscribersLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DomainEventSubscriberListener implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('domain.event.subscriber');

        $definition = $container->findDefinition(EventSubscribersLocator::class);

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
