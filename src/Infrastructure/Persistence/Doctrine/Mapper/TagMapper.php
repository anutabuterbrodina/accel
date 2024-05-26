<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Infrastructure\Persistence\Doctrine\ORMEntity\TagORM;

class TagMapper
{
    private const KOSTIL = [
        '1' => 'Здоровье и медицина',
        '2' => 'Пищевая промышленность',
        '3' => 'Информационный технологии IT',
        '4' => 'Домашние животные',
        '5' => 'Сельсхое хозяйство',
        '6' => 'Красота и уход за собой',
        '7' => 'Машиностроение',
        '8' => 'Уход за детьми',
        '9' => 'Строительство',
    ];

    public static function mapToOrm(Tag $tag): TagORM {
        $tagORM = new TagORM();
        $tagORM->setTagId( array_search($tag->toScalar(), self::KOSTIL) );
        $tagORM->setName( $tag->toScalar() );
        return $tagORM;
    }
}