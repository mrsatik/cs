<?php

namespace Some\Space;

use Some\Space\ClassFromCurrentNamespace;
use Another\Space\ClassForParameterType;
use Another\Space\ClassForReturnType;
use Another\Space\UnusedImport;
use Another\Space\AnnotationImportClass;
use \UnusedGlobalClassForPHPCode;
use \UnusedGlobalClassForPHPDoc;
use \UsedGlobalClassForPHPCode;
use \UsedGlobalClassForPHPDoc;
use UnusedWithoutNamespace;
use UsedWithoutNamespaceInPHPDoc;
use Another\Space\AnotherTrait1;
use Another\Space\AnotherTrait2;
use Another\Space\stubs1 as UsedNSInCode;
use Another\Space\stubs1 as UsedNSInPHPDoc;
use Another\Space\stubs1 as UsedNSInUse;
use Another\Space\stubs2 as UnusedNS;
use Doctrine\NS\JoinTable;
use Doctrine\NS\JoinColumn;
use Another\Space\UsedClassForPHPDocAsArray;

abstract class BadClassWithUnusedUses
{
    use AnotherTrait1;
    use UsedNSInUse\SomeClassForUse;

    /**
     * @injectable
     * @var UsedNSInPHPDoc\SomeClassForPHPDoc
     */
    public $propertyWithFeedbackFromNamespace;

    /**
     * @JoinTable(name="abc",
     *      joinColumns={@JoinColumn(name="id_abc", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="id_cba", referencedColumnName="id")}
     *      )
     *
     * @var
     */
    public $propertyWithDoctrineAnnotations;

    abstract protected function foo(ClassForParameterType $b) : ClassForReturnType;

    protected function bar()
    {
        $a = new UsedGlobalClassForPHPCode;
        $b = new \UnusedGlobalClassForPHPCode;
        $c = new UsedNSInCode\SomeClassForCode;
        return new ClassFromCurrentNamespace($a, $b, $c, new \GlobalClassForPHPCode);
    }

    /**
     * @AnnotationImportClass some text
     *
     * @param UsedWithoutNamespaceInPHPDoc|UsedGlobalClassForPHPDoc
     * @param \UnusedGlobalClassForPHPDoc
     * @param UsedClassForPHPDocAsArray[]
     */
    abstract public function baz();
}

trait SomeTrait
{
    use AnotherTrait2;
}
