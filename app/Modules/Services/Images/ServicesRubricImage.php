<?php

namespace App\Modules\Services\Images;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;

/**
 * Class ServicesRubricImage
 *
 * @package App\Modules\Services\Images
 */
class ServicesRubricImage extends ImageContainer
{

    /**
     * Field name in the form
     *
     * @return string
     */
    public static function getField(): string
    {
        return 'image';
    }

    /**
     * Folder name
     *
     * @return string
     */
    public static function getType(): string
    {
        return 'servicesrubrics-image';
    }

    /**
     * Configurations
     *
     * @return ImagesGroup
     * @throws \App\Exceptions\WrongParametersException
     */
    public function configurations(): ImagesGroup
    {
        $image = new ImagesGroup($this->getType());
        $image
            ->addTo('small')
            ->setWidth(250)
            ->setHeight(250)
            ->setCrop(true);
        $image
            ->addTo('big')
            ->setWidth(1080)
            ->setHeight(500)
            ->setCrop(true);

        return $image;
    }

}
