<?php

namespace Rior\Bundle\GruntDistBundle\Extension;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * This extension prepend dist views folder to twig loader when on production environment and
 * remove it when on development.
 *
 * @author Diego Marangoni <diegomarangoni@me.com>
 */
class LoaderExtension extends \Twig_Extension
{
    protected $environment;
    protected $rootDir;
    protected $rootDirName;

    public function __construct($environment, $rootDir)
    {
        $this->environment = $environment;
        $this->rootDir = $rootDir;
        $this->rootDirName = basename($this->rootDir);
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $loader = $environment->getLoader();

        $paths = $loader->getPaths();

        if ('prod' == $this->environment) {
            $prepend = realpath("{$this->rootDir}/../dist/{$this->rootDirName}/Resources/views");

            if (file_exists($prepend)) {
                array_unshift($paths, $prepend);
            }
        }

        if ('dev' == $this->environment || 'test' == $this->environment) {
            $paths = array_filter($paths, array($this, 'notDist'));
        }

        $paths = array_unique($paths);

        $loader->setPaths($paths);
    }

    public function getName()
    {
        return 'rior_grunt_dist';
    }

    private function notDist($path)
    {
        if (false === strpos($path, "dist/{$this->rootDirName}/Resources/views")) {
            return $path;
        }

        return null;
    }
}
