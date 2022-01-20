<?php

namespace Tests\Unit;

use App\Exceptions\GeneratorException;
use App\Generator\TemplateConfig;
use Tests\TestCase;

class TemplateConfigTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testTemplateConstructor()
    {
        $t = $this->getInstance();

        $this->assertTrue( is_string( $t->getType() ) && ! empty( $t->getType() ) );
        $this->assertTrue( is_string( $t->getName() ) && ! empty( $t->getName() ) );
        $this->assertTrue( is_array( $t->getScopes() ) && ! empty( $t->getScopes() ) );

        $this->assertTrue( is_string( $t->fileName ) && ! empty( $t->fileName ) );
        $this->assertTrue( is_string( $t->fileDir ) && ! empty( $t->fileDir ) );
        $this->assertTrue( is_string( $t->filePath ) && ! empty( $t->filePath ) );
        $this->assertTrue( is_string( $t->namespace ) && ! empty( $t->namespace ) );
        $this->assertTrue( is_string( $t->className ) && ! empty( $t->className ) );
        $this->assertTrue( is_string( $t->templatePath ) && ! empty( $t->templatePath ) );

        $this->assertTrue( $t->getTemplate() == 'default' );
    }

    public function testGetField()
    {
        $t = $this->getInstance();
        $field = $t->getField( 'className' );
        $this->assertTrue( is_string( $field ) && ! empty( $field ) );
    }

    public function testGetFieldException()
    {
        $t = $this->getInstance();
        $this->expectException( GeneratorException::class );
        $field = $t->getField( 'non-existing-field' );
    }

    public function testSlugToTitleCase()
    {
        $t = TemplateConfig::slugToTitleCase( 'example' );
        $this->assertEquals( 'Example', $t );

        $t = TemplateConfig::slugToTitleCase( 'example-test' );
        $this->assertEquals( 'ExampleTest', $t );

        $t = TemplateConfig::slugToTitleCase( 'example-test-Test' );
        $this->assertEquals( 'ExampleTestTest', $t );
    }

    protected function getInstance()
    {
        $type = 'aplan';
        $name = 'example';
        $scopes = [ 'examples' ];
        $t = new TemplateConfig( $type, $name, $scopes, null );
        return $t;
    }
}
