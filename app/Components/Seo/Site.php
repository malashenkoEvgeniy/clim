<?php

namespace App\Components\Seo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Site
 *
 * @package App\Components\Seo
 */
class Site extends Meta
{

    /**
     * @var Meta
     */
    protected $metaByLink;

    /**
     * @var Meta
     */
    protected $template;

    /**
     * @var Collection
     */
    protected $availableTemplates;


    /**
     * @var bool
     */
    protected $pageNumber = false;

    /**
     * @var bool
     */
    protected $canonical = false;

    /**
     * @var bool
     */
    protected $hideDescriptionKeywords = false;
    /**
     * Site constructor.
     */
    public function __construct()
    {
        $this->metaByLink = new Meta();
        $this->template = new Meta();
        $this->availableTemplates = new Collection();
    }

    /**
     * @param string $templateAlias
     * @param Model $template
     * @return $this
     */
    public function addAvailableTemplate(?string $templateAlias, Model $template): self
    {
        $this->availableTemplates->put($templateAlias ?? $template->id, $template);

        return $this;
    }

    /**
     * @param null|string $templateAlias
     * @return Model
     */
    public function getAvailableTemplate(?string $templateAlias): ?Model
    {
        return $templateAlias ? $this->availableTemplates->get($templateAlias) : null;
    }

    /**
     * @param string $templateAlias
     * @param array $variables
     */
    public function setTemplate(string $templateAlias, array $variables = []): void
    {
        $template = $this->getAvailableTemplate($templateAlias);
        if (!$template) {
            return;
        }
        if (!$variables) {
            $this->template->set([
                'h1' => $template->h1,
                'title' => $template->title,
                'description' => $template->description,
                'keywords' => $template->keywords,
            ]);
        } else {
            $from = $to = [];
            foreach ($variables as $key => $value) {
                $from[] = "{{{$key}}}";
                $to[] = $value;

                $fullString = $template->h1 . $template->title . $template->keywords . $template->description;
                preg_match_all("/\{\{{$key}:([0-9]*)\}\}/", $fullString, $matches);
                if (isset($matches[1]) && is_array($matches[1]) && count($matches[1]) > 0) {
                    $value = strip_tags($value);
                    $value = trim($value);
                    foreach ($matches[1] as $match) {
                        if ($match < 2) {
                            continue;
                        }
                        $from[] = "{{{$key}:{$match}}}";
                        $to[] = Str::substr($value, 0, $match - 1);
                    }
                }
            }
            $this->template->set([
                'h1' => str_replace($from, $to, $template->h1 ?? ''),
                'title' => str_replace($from, $to, $template->title ?? ''),
                'description' => str_replace($from, $to, $template->description ?? ''),
                'keywords' => str_replace($from, $to, $template->keywords ?? ''),
            ]);
        }
    }

    /**
     * Set meta tags from seo_links table
     *
     * @param Model|null $model
     */
    public function setMetaByLink(?Model $model): void
    {
        if (!$model || !$model->exists) {
            return;
        }
        $this->metaByLink->setFromModel($model);
    }
    
    /**
     * @param string|null $text
     * @return array|string|null
     */
    private function usePageNumberCheck(?string $text)
    {
        if (!$this->pageNumber || $this->pageNumber < 2) {
            return $text;
        }
        if (!$text) {
            return Str::ucfirst(__('global.seo-page', ['page' => $this->pageNumber]));
        }
        return $text . ', ' . __('global.seo-page', ['page' => $this->pageNumber]);
    }

    /**
     * Display h1
     *
     * @param  null|string $default
     * @return string
     */
    public function getH1(?string $default = null): ?string
    {
        $h1 = $this->metaByLink->getH1() ?? $this->h1 ?? $this->template->getH1() ?? $default ?? $this->defaultName;
        return $this->usePageNumberCheck($h1);
    }

    /**
     * Display title
     *
     * @param  null|string $default
     * @return string
     */
    public function getTitle(?string $default = null): ?string
    {
        $title = $this->metaByLink->getTitle() ?? $this->title ?? $this->template->getTitle() ?? $default ?? $this->defaultName;
        return $this->usePageNumberCheck($title);
    }

    /**
     * Display description
     *
     * @param  null|string $default
     * @return string
     */
    public function getDescription(?string $default = null): ?string
    {
        $description = $this->metaByLink->getDescription() ?? $this->description ?? $this->template->getDescription() ?? $default;
        if ($this->pageNumber && $this->pageNumber > 1) {
            return null;
        }
        return $this->usePageNumberCheck($description);
    }

    /**
     * Display keywords
     *
     * @param  null|string $default
     * @return string
     */
    public function getKeywords(?string $default = null): ?string
    {
        $keywords = $this->metaByLink->getKeywords() ?? $this->keywords ?? $this->template->getKeywords() ?? $default;
        if ($this->pageNumber && $this->pageNumber > 1) {
            return null;
        }
        return $this->usePageNumberCheck($keywords);
    }

    /**
     * Display seo text
     *
     * @param  null|string $default
     * @return string
     */
    public function getSeoText(?string $default = null): ?string
    {
        return $this->text ?? $default;
    }

    /**
     * @return bool
     */
    public function doNotNeedSeoBlock(): bool
    {
        return $this->needSeoBlock() === false;
    }

    /**
     * @return bool
     */
    public function needSeoBlock(): bool
    {
        if($this->hideDescriptionKeywords || ($this->pageNumber && $this->pageNumber > 1)) {
            return false;
        }
        $strippedSeoText = strip_tags($this->getSeoText());
        $trimmedSeoText = trim($strippedSeoText);
        return $trimmedSeoText;
    }


    /**
     * @param $canonical
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }

    /**
     * @return bool
     */
    public function getCanonical()
    {
        return $this->canonical;
    }


    /**
     * @param $page
     * @return bool
     */
    public function setPageNumber($page)
    {

        if ($page > 1) {
            return $this->pageNumber = $page;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getPageNumber()
    {
        if ($this->pageNumber > 1) {
            return $this->pageNumber;
        }
        return false;
    }

    /**
     * @param $hide
     */
    public function setHideDescriptionKeywords($hide)
    {
        $this->hideDescriptionKeywords = $hide;
    }

    /**
     * @return bool
     */
    public function getHideDescriptionKeywords()
    {
        return $this->hideDescriptionKeywords;
    }

}
