<?php

namespace Oxygen\CoreViews\Pagination;

use HTML;
use Illuminate\Pagination\Presenter as BasePresenter;

class Presenter extends BasePresenter {

    /**
     * Returns the HTML to display the active page.
     *
     * @param string $text
     * @return string
     */
    public function getActivePageWrapper($text) {
        return '<div class="Pagination-element"><a href="#" class="Button Button-color--white">'.$text.'</a></div>';
    }

    /**
     * Returns the HTML to display a disabled link.
     *
     * @param string $text
     * @param string $rel
     * @return string
     */
    public function getDisabledTextWrapper($text, $rel = null) {
        $attributes = [
            'href' => '#',
            'class' => 'Button Button-color--white',
            'disabled'
        ];
        $this->addBackAndForward($attributes, $rel);
        return '<div class="Pagination-element"><a ' . HTML::attributes($attributes) . '>'.$text.'</a></div>';
    }

    /**
     * Returns the HTML to display a generic link.
     *
     * @param string $url
     * @param string $text
     * @param string $rel
     * @return string
     */
    public function getPageLinkWrapper($url, $page, $rel = null) {
        $attributes = [
            'href' => $url,
            'class' => 'Button Button-color--white Link--smoothState'
        ];
        if($rel !== null) {
            $attributes['rel'] = $rel;
        }
        $this->addBackAndForward($attributes, $rel);
        return '<div class="Pagination-element"><a ' . HTML::attributes($attributes) . '>'.$page.'</a></div>';
    }

    /**
     * Adds back and forward styles to the button, if applicable.
     *
     * @param array $attributes
     * @param string $rel
     * @return void
     */

    protected function addBackAndForward(array &$attributes, $rel) {
        if($rel === 'prev') {
            $attributes['class'] .= ' Button--back';
        } else if($rel === 'next') {
            $attributes['class'] .= ' Button--forward';
        }
    }

    /**
     * Get the previous page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getPrevious($text = '&laquo;') {
        // If the current page is less than or equal to one, it means we can't go any
        // further back in the pages, so we will render a disabled previous button
        // when that is the case. Otherwise, we will give it an active "status".
        if ($this->currentPage <= 1) {
            return $this->getDisabledTextWrapper($text, 'prev');
        }

        $url = $this->paginator->getUrl($this->currentPage - 1);

        return $this->getPageLinkWrapper($url, $text, 'prev');
    }

    /**
     * Get the next page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getNext($text = '&raquo;') {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if ($this->currentPage >= $this->lastPage) {
            return $this->getDisabledTextWrapper($text, 'next');
        }

        $url = $this->paginator->getUrl($this->currentPage + 1);

        return $this->getPageLinkWrapper($url, $text, 'next');
    }

}