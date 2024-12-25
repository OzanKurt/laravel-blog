<?php

namespace OzanKurt\Blog\Enums;

enum PostType: int
{
    case TEXT = 1;
    case IMAGE = 2;
    case CAROUSEL = 3;
    case VIDEO = 4;
}
