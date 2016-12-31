<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Feed\CsvWriter\Tests;

use ReflectionMethod;

trait ProtectedMethodTrait
{
    /**
     * Get an accessible reflection of a protected method.
     *
     * @param string $class
     * @param string $method
     *
     * @return ReflectionMethod
     */
    protected function getProtectedMethod(string $class, string $method): ReflectionMethod
    {
        $reflection = new ReflectionMethod($class, $method);
        $reflection->setAccessible(true);
        return $reflection;
    }
}
