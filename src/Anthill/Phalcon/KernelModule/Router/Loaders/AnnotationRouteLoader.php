<?php

namespace Anthill\Phalcon\KernelModule\Router\Loaders;

use Phalcon\Mvc\Router\Annotations;
use Phalcon\Mvc\RouterInterface;

class AnnotationRouteLoader implements LoaderInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    private $suffixName = 'Controller';

    public function __construct(Annotations $router)
    {
        $this->router = $router;
        $this->router->setControllerSuffix($this->suffixName);
    }

    public function load($directory)
    {
        /* @var $dir \SplFileInfo[] */
        $dir = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        foreach ($dir as $file) {

            if (!$file->isFile()) {
                continue;
            }

            $fileName = $file->getPathname();
            if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'php') {
                continue;
            }

            $className = $this->getClassnameWithNamespace($fileName);

            if (!$className) {
                continue;
            }
            $className = substr($className, 0, 0 - strlen($this->suffixName));
            $this->router->addResource($className);
        }
    }

    private function getClassnameWithNamespace($path)
    {
        $phpFile = file_get_contents($path);
        $tokens = token_get_all($phpFile);

        $namespace = array();
        $isNameSpace = false;
        $isClass = false;
        $stringBefore = false;
        foreach ($tokens as $token) {
            if (!is_array($token) && $token === ';') {
                $isNameSpace = false;
                continue;
            }

            if ($token[0] === T_NAMESPACE) {
                $isNameSpace = true;
                continue;
            }

            if ($isNameSpace && $token[0] === T_STRING) {
                $namespace[] = $token[1];
                continue;
            }
            if ($token[0] === T_CLASS) {
                $isClass = true;
                continue;
            }

            if (!$isClass) {
                continue;
            }

            if ($stringBefore && $token[0] === T_WHITESPACE) {
                $isClass = false;
                break;
            }

            if ($token[0] === T_STRING) {
                $namespace[] = $token[1];
            }

            $stringBefore = ($token[0] === T_STRING);
        }

        return implode('\\', $namespace);
    }
}