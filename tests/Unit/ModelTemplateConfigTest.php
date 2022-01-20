<?php

namespace Tests\Unit;

use App\Generator\ModelTemplateConfig;
use Tests\TestCase;

class ModelTemplateConfigTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExplicitTemplate()
    {
        $t = $this->getInstance();
        $this->assertEquals( 'guarded', $t->getTemplate() );
    }

    public function testTableNameIsSet()
    {
        $t = $this->getInstance();
        $this->assertEquals( 'meeting-rooms', $t->tableName );
    }


    protected function getInstance()
    {
        $type = 'models';
        $name = 'meeting-rooms';
        $scopes = [
            'indirect-emissions-owned',
            'electricity',
        ];
        $template = 'guarded';
        $t = new ModelTemplateConfig( $type, $name, $scopes, $template );
        return $t;
    }
}
