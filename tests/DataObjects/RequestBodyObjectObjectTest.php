<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Exceptions\InvalidModeTypeException;
use PostmanGenerator\Objects\FileObject;
use PostmanGenerator\Objects\FormParameterObject;
use PostmanGenerator\Objects\RequestBodyObject;
use PostmanGenerator\Objects\UrlObject;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers \PostmanGenerator\Objects\RequestBodyObject
 */
class RequestBodyObjectObjectTest extends ObjectTestCase
{
    /**
     * Test mode should throw InvalidModeTypeException when trying to add invalid mode type.
     *
     * @return void
     */
    public function testModeThrowsInvalidType(): void
    {
        $this->expectException(InvalidModeTypeException::class);

        new RequestBodyObject(['mode' => 'invalid-mode']);
    }

    /**
     * Test data object properties.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\InvalidModeTypeException
     */
    public function testProperties(): void
    {
        $body = new RequestBodyObject();

        $url = new UrlObject();
        $formParameter = new FormParameterObject();
        $file = new FileObject();

        $body->setDisabled(false);
        $body->setMode('file');
        $body->setRaw('test-raw');
        $body->setUrl($url);
        $body->setFormParameter($formParameter);
        $body->setFile($file);

        $this->assertProperties($body, [
            'isDisabled' => false,
            'getMode' => 'file',
            'getRaw' => 'test-raw',
            'getUrl' => $url,
            'getFormParameter' => $formParameter,
            'getFile' => $file
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $file = new FileObject();
        $url = new UrlObject();
        $formParameter = new FormParameterObject();

        $body = new RequestBodyObject([
            'disabled' => false,
            'file' => $file,
            'form_parameter' => $formParameter,
            'mode' => 'file',
            'raw' => 'test-raw',
            'url' => $url
        ]);

        self::assertEquals([
            'disabled' => false,
            'file' => $file,
            'formdata' => $formParameter,
            'mode' => 'file',
            'raw' => 'test-raw',
            'urlencoded' => $url
        ], $body->toArray());
    }
}
