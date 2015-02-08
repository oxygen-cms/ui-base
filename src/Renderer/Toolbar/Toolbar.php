<?php


namespace Oxygen\CoreViews\Renderer\Toolbar;

use Oxygen\Core\Html\Toolbar\Toolbar as ToolbarInstance;
use Oxygen\Core\Html\RendererInterface;

class Toolbar implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param ToolbarInstance $toolbar    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($toolbar, array $arguments) {
        $return = '';

        foreach($toolbar->getItems() as $item) {
            if($item->shouldRender($arguments)) {
                $return .= $item->render($arguments);
            }
        }

        return $return;
    }
}