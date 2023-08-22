<?php

declare(strict_types=1);

namespace MageMastery\Popup\Api;

use MageMastery\Popup\Api\Data\PopupInterface;

interface PopupRepositoryInterface
{
    /**
     * @param PopupInterface $popup
     * @return void
     */
    public function save(PopupInterface $popup): void;

    /**
     * @param int $popupId
     * @return PopupInterface
     */
    public function getById(int $popupId): PopupInterface;
}
