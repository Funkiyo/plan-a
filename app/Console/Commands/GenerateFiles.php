<?php

namespace App\Console\Commands;

use App\Exceptions\GeneratorException;
use App\Generator\Template;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plana:generate-files {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates files from config/generator and resources/templates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->argument( 'type' );
        $rawConfigs = config( 'generator.' . $type );
        foreach ( $rawConfigs as $c ) {
            $templateConfigClass = $this->getTemplateConfigClassName( $type );
            $templateConfig = new $templateConfigClass( $type, $c[ 'name' ], $c[ 'scope' ], $c[ 'template' ] ?? null );
            $template = new Template( $templateConfig );
            try {
                $template->load()->hydrate()->save();
            } catch ( GeneratorException $e ) {
                $this->error( $e->getMessage() );
            }
        }
    }

    protected function getTemplateConfigClassName( string $type )
    {
        $typeName = ucfirst( Str::singular( $type ) );
        $templateConfigClass = '\\App\\Generator\\' . $typeName . 'TemplateConfig';
        if ( ! class_exists( $templateConfigClass ) ) {
            $templateConfigClass = '\\App\\Generator\\TemplateConfig';
        }
        return $templateConfigClass;
    }
}
