<?php

namespace Tests\Unit;


use App\Exceptions\GeneratorException;
use App\Generator\Template;
use App\Generator\TemplateConfig;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testConstructor()
    {
        $t = $this->getInstance();
        $this->assertNotNull( $t->getTemplateConfig() );
        $this->assertEmpty( $t->getRawTemplate() );
        $this->assertEmpty( $t->getHydratedTemplate() );
    }

    public function testLoading()
    {
        $t = $this->getInstance();
        $t->load();
        $this->assertNotEmpty( $t->getRawTemplate() );
        $this->assertEmpty( $t->getHydratedTemplate() );
    }

    public function testTemplateNotFoundException()
    {
        $type = 'aplan';
        $name = 'example';
        $scopes = [ 'examples' ];
        $template = 'non-existent';
        $tc = new TemplateConfig( $type, $name, $scopes, $template );
        $t = new Template( $tc );
        $this->expectException( GeneratorException::class );
        $t->load();
    }

    public function testHydrating()
    {
        $t = $this->getInstance();
        $t->load()->hydrate();
        $this->assertNotEmpty( $t->getRawTemplate() );
        $this->assertNotEmpty( $t->getHydratedTemplate() );
    }

    public function testHydratingNotLoadedException()
    {
        $t = $this->getInstance();
        $this->expectException( GeneratorException::class );
        $t->hydrate();
    }

    public function testSaving()
    {
        $t = $this->getInstance();
        $t->load()->hydrate()->save();
        $this->assertFileExists( app_path( $t->getTemplateConfig()->filePath ) );
    }

    public function testSavingNotHydratedException()
    {
        $t = $this->getInstance();
        $this->expectException(GeneratorException::class);
        $t->save();
    }

    public function testSavingNotHydratedException2()
    {
        $t = $this->getInstance();
        $this->expectException(GeneratorException::class);
        $t->load()->save();
    }

    protected function getInstance()
    {
        $type = 'aplan';
        $name = 'test';
        $scopes = [ 'examples' ];
        $tc = new TemplateConfig( $type, $name, $scopes, null );
        $t = new Template( $tc );
        return $t;
    }
}
