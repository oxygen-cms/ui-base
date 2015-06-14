<?php

namespace Oxygen\CoreViews\Pagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Symfony\Component\Translation\TranslatorInterface;

class Presenter implements PresenterContract {

    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $paginator;

    /**
     * The translation component.
     *
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $lang;

    /**
     * Create a new Bootstrap presenter instance.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     */
    public function __construct(LengthAwarePaginator $paginator, TranslatorInterface $lang, Request $request) {
        $this->paginator = $paginator;
        $this->lang = $lang;

        // append the current query string
        if($paginator instanceof AbstractPaginator) {
            $queryString = array_except($request->query(), $paginator->getPageName());
            $this->paginator->appends($queryString);
        }
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
        return '<div class="Pagination-element"><a ' . html_attributes($attributes) . '>'.$text.'</a></div>';
    }

    /**
     * Returns the HTML to display a generic link.
     *
     * @param string $url
     * @param string $page
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
        return '<div class="Pagination-element"><a ' . html_attributes($attributes) . '>'.$page.'</a></div>';
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
    public function getPreviousButton($text = '&laquo;') {
        // If the current page is less than or equal to one, it means we can't go any
        // further back in the pages, so we will render a disabled previous button
        // when that is the case. Otherwise, we will give it an active "status".
        if ($this->paginator->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text, 'prev');
        }

        $url = $this->paginator->url($this->paginator->currentPage() - 1);

        return $this->getPageLinkWrapper($url, $text, 'prev');
    }

    /**
     * Get the next page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getNextButton($text = '&raquo;') {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if(!$this->paginator->hasMorePages()) {
            return $this->getDisabledTextWrapper($text, 'next');
        }

        $url = $this->paginator->url($this->paginator->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text, 'next');
    }

    /**
     * Render the given paginator.
     *
     * @return string
     */
    public function render() {
        if ($this->hasPages()) {
            return sprintf(
                '<div class="Pagination">%s <div class="Pagination-message">%s</div> %s</ul>',
                $this->getPreviousButton($this->lang->get('pagination.previous')),
                $this->lang->get('pagination.message', [
                    'current' => $this->paginator->currentPage(),
                    'total' => $this->paginator->lastPage()
                ]),
                $this->getNextButton($this->lang->get('pagination.next'))
            );
        }
        return '';
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages() {
        return $this->paginator->hasPages();
    }
}