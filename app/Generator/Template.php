<?php

namespace App\Generator;

use App\Exceptions\GeneratorException;
use Illuminate\Support\Str;

class Template
{
    protected $templateConfig;

    protected $rawTemplate;

    protected $hydratedTemplate;

    public function __construct( TemplateConfig $templateConfig )
    {
        $this->templateConfig = $templateConfig;
    }

    public function getTemplateConfig()
    {
        return $this->templateConfig;
    }

    public function getRawTemplate()
    {
        return $this->rawTemplate;
    }

    public function getHydratedTemplate()
    {
        return $this->hydratedTemplate;
    }

    public function load()
    {
        if ( ! file_exists( $this->templateConfig->templatePath ) ) {
            throw new GeneratorException( sprintf( '%s template %s not found.', ucfirst( $this->templateConfig->getType() ), $this->templateConfig->getTemplate() ) );
        }
        $this->rawTemplate = file_get_contents( $this->templateConfig->templatePath );
        return $this;
    }

    public function hydrate()
    {
        if ( ! isset( $this->rawTemplate ) ) {
            throw new GeneratorException( 'Must load template first.' );
        }

        $matches = Str::of( $this->rawTemplate )->matchAll( '/{([a-zA-Z-_]+)}/' );
        $this->hydratedTemplate = Str::of( $this->rawTemplate );
        foreach ( $matches as $m ) {
            $this->hydratedTemplate = $this->hydratedTemplate->replace( '{' . $m . '}', $this->templateConfig->getField( $m ) );
        }

        return $this;
    }

    public function save()
    {
        if ( ! isset( $this->hydratedTemplate ) ) {
            throw new GeneratorException( 'Must hydrate template first.' );
        }

        if ( ! is_dir( app_path( $this->templateConfig->fileDir ) ) ) {
            mkdir( app_path( $this->templateConfig->fileDir ), null, true );
        }

        file_put_contents( app_path( $this->templateConfig->filePath ), $this->hydratedTemplate );
    }
}
