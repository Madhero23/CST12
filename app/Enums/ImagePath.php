<?php
// app/Enums/ImagePath.php

namespace App\Enums;

enum ImagePath: string
{
    // Hero Slides
    case HERO_SLIDE_1 = 'hero0.png';
    case HERO_SLIDE_2 = 'hero1.png';
    case HERO_SLIDE_3 = 'hero2.png';
    case HERO_SLIDE_4 = 'hero3.png';
    
    // Icons
    case ICON_TRUST = 'icon-7.svg';
    case ICON_BROWSE = 'icon8.svg';
    case ICON_CONTACT = 'icon9.svg';
    case ICON_ULTRASOUND = 'icon10.svg';
    case ICON_MONITOR = 'icon12.svg';
    case ICON_SURGICAL = 'icon14.svg';
    case ICON_ARROW_1 = 'icon11.svg';
    case ICON_ARROW_2 = 'icon13.svg';
    case ICON_ARROW_3 = 'icon15.svg';
    case ICON_QUALITY = 'icon0.svg';
    case ICON_SUPPORT = 'icon1.svg';
    case ICON_DELIVERY = 'icon2.svg';
    case ICON_FACILITIES = 'icon3.svg';
    case ICON_PRODUCTS = 'icon4.svg';
    case ICON_EXPERIENCE = 'icon5.svg';
    case ICON_SATISFACTION = 'icon6.svg';
}