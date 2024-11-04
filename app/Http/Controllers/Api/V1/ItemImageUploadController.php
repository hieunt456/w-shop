<?php

declare(strict_types=1);

namespace WolfShop\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WolfShop\Http\Requests\Api\V1\ItemImageRequest;
use WolfShop\UseCases\Item\FindItemByName;
use WolfShop\UseCases\Item\UploadItemImage;

class ItemImageUploadController
{
    public function __invoke(
        string $itemName,
        ItemImageRequest $request,
        FindItemByName $findItemByName,
        UploadItemImage $uploadItemImage
    ): JsonResponse
    {
        $item = $findItemByName->handle($itemName);

        if (!$item) {
            throw new ModelNotFoundException("Item with name $itemName not found.");
        }

        $uploadItemImage->handle($item, $request->file('image'));

        return response()->json([
            'message' => 'Image uploaded successfully.',
            'status' => Response::HTTP_OK,
        ]);
    }
}
