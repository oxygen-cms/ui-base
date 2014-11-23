<?php

    use Oxygen\Core\Form\Field;

?>

<div class="Row">

    <div class="Form-label flex-item">
        {{{ $field->getMeta()->label }}}:
    </div>

    @if($field->getMeta()->type === Field::TYPE_RELATIONSHIP && $field->getValue() !== null)
        <?php
            $blueprint = Blueprint::get($field->getMeta()->options['blueprint']);
        ?>

        <div class="Form-content flex-item">
            <a
              href="{{{ URL::route($blueprint->getRouteName('getInfo'), $field->getValue()->getId()) }}}"
              class="Button Button-color--white">
                <span class="Icon Icon-external-link Icon--pushRight"></span>
                View {{ $blueprint->getDisplayName() }}
            </a>
        </div>
    @elseif($field->isPretty())
        <div class="Form-content flex-item">{{ $field->getPrettyValue() }}</div>
    @else
        <pre class="Form-content flex-item">{{{ $field->getValue() }}}</pre>
    @endif

</div>