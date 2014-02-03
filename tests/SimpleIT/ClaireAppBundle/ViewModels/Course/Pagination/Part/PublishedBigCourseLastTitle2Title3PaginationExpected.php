<?php

namespace SimpleIT\ClaireAppBundle\ViewModels\Course\Pagination\Part;

use SimpleIT\ClaireAppBundle\ViewModels\Course\Pagination\Pagination;
use SimpleIT\ClaireAppBundle\ViewModels\Course\Toc\PaginationTitleThreeStub1;
use SimpleIT\ClaireAppBundle\ViewModels\Course\Toc\PaginationTitleTwoStub2;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PublishedBigCourseLastTitle2Title3PaginationExpected extends Pagination
{
    const PREVIOUS_TITLE = PaginationTitleThreeStub1::TITLE;

    const PREVIOUS_URL = '/category-slug/cours/course-1-title/title-three-title-1';

    const NEXT_TITLE = PaginationTitleTwoStub2::TITLE;

    const NEXT_URL = '/category-slug/cours/course-1-title/title-two-title-2';

    public $previousTitle = self::PREVIOUS_TITLE;

    public $previousUrl = self::PREVIOUS_URL;

    public $nextTitle = self::NEXT_TITLE;

    public $nextUrl = self::NEXT_URL;
}