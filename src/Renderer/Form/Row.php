<?php

namespace Oxygen\CoreViews\Renderer\Form;

use Oxygen\Core\Html\RendererInterface;

class Row implements RendererInterface {

    /**
     * Renders the element.
     *
     * @param object $row    Object to render
     * @param array  $arguments Extra arguments to customize the element.
     * @return string
     */
    public function render($row, array $arguments) {
        $return = '';

        $return .= '<div class="Row">';

        foreach($row->getCells() as $cell) {
            $return .= $cell->render([]);
        }

        $return .= '</div>';

        return $return;
    }
}