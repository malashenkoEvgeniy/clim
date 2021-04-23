<?php

namespace App\Components\Seo;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Meta
 * Storage for meta data of the current page
 *
 * @package App\Components\Seo
 */
class Meta
{
    
    /**
     * Page name
     *
     * @var string
     */
    protected $defaultName;
    
    /**
     * H1
     *
     * @var string
     */
    protected $h1;
    
    /**
     * Title
     *
     * @var string
     */
    protected $title;
    
    /**
     * Description
     *
     * @var string
     */
    protected $description;
    
    /**
     * Keywords
     *
     * @var string
     */
    protected $keywords;
    
    /**
     * SEO text
     *
     * @var string
     */
    protected $text;
    
    /**
     * Display h1
     *
     * @param  null|string $default
     * @return string
     */
    public function getH1(?string $default = null): ?string
    {
        return $this->h1 ?? $default;
    }
    
    /**
     * Set h1
     *
     * @param  string $h1
     * @return $this
     */
    public function setH1(?string $h1): self
    {
        $this->h1 = trim($h1, ',- ');
        
        return $this;
    }
    
    /**
     * Display title
     *
     * @param  null|string $default
     * @return string
     */
    public function getTitle(?string $default = null): ?string
    {
        return $this->title ?? $default;
    }
    
    /**
     * Set title
     *
     * @param  string $title
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = trim($title, ',- ');
        
        return $this;
    }
    
    /**
     * Display description
     *
     * @param  null|string $default
     * @return string
     */
    public function getDescription(?string $default = null): ?string
    {
        return $this->description ?? $default;
    }
    
    /**
     * Set description
     *
     * @param  string $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = trim($description, ',- ');
        
        return $this;
    }
    
    /**
     * Display keywords
     *
     * @param  null|string $default
     * @return string
     */
    public function getKeywords(?string $default = null): ?string
    {
        return $this->keywords ?? $default;
    }
    
    /**
     * Set keywords
     *
     * @param  string|array $keywords
     * @return $this
     */
    public function setKeywords($keywords): self
    {
        if (is_array($keywords)) {
            $this->keywords = implode(', ', $keywords);
        } else {
            $this->keywords = trim((string)$keywords, ',- ');
        }
        
        return $this;
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
     * Set seo text
     *
     * @param  string $text
     * @return $this
     */
    public function setSeoText(?string $text): self
    {
        $this->text = $text;
        
        return $this;
    }
    
    /**
     * Multiple set meta data
     *
     * @param array $meta
     */
    public function set(array $meta): void
    {
        if (array_get($meta, 'name')) {
            $this->setDefaultName(array_get($meta, 'name'));
        }
        if (array_get($meta, 'h1')) {
            $this->setH1(array_get($meta, 'h1'));
        }
        if (array_get($meta, 'title')) {
            $this->setTitle(array_get($meta, 'title'));
        }
        if (array_get($meta, 'description')) {
            $this->setDescription(array_get($meta, 'description'));
        }
        if (array_get($meta, 'keywords')) {
            $this->setKeywords(array_get($meta, 'keywords'));
        }
        if (array_get($meta, 'text')) {
            $this->setSeoText(
                array_get($meta, 'text') ??
                array_get($meta, 'content') ??
                array_get($meta, 'seo_text')
            );
        }
    }
    
    /**
     * @param Model $model
     */
    public function setFromModel(Model $model): void
    {
        $this->set([
            'name' => $model->name ?? null,
            'h1' => $model->h1 ?? null,
            'title' => $model->title ?? null,
            'description' => $model->description ?? null,
            'keywords' => $model->keywords ?? null,
        ]);
    }
    
    /**
     * @param string|null $defaultName
     * @return $this
     */
    public function setDefaultName(?string $defaultName = null): self
    {
        
        $this->defaultName = trim($defaultName, ',- ');
        
        return $this;
    }
    
    /**
     * @param null|string $default
     * @return string
     */
    public function getDefaultName(?string $default = null): ?string
    {
        return $this->defaultName ?? $default;
    }
    
}
