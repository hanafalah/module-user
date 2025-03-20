<?php

namespace Zahzah\ModuleUser\Concerns\Maps;

use Stancl\VirtualColumn\VirtualColumn;
use Zahzah\LaravelHasProps\Concerns\PropAttribute;

trait HasCoordinate {
    use VirtualColumn;
    use PropAttribute{
        PropAttribute::getCustomColumns insteadof VirtualColumn;
    }
    
    protected static string $__coordinate_name = 'coordinate';

    /**
     * Initialize the trait.
     *
     * This method bootstraps the initial state of the model, and is
     * called when the model is instantiated.
     *
     * @return void
     */
    public function initializeHasCoordinate(){
        $this->mergeFillable([
            self::$__coordinate_name
        ]);
    }
}