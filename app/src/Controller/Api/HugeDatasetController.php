<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\HugeData\HugeDatasetService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HugeDatasetController extends AbstractController
{
    public function __construct(private readonly HugeDatasetService $hugeDatasetService)
    {
    }

    #[Route('/api/process-huge-dataset', methods: ['GET'])]
    #[OA\Tag(name: 'Huge Dataset')]
    #[OA\Response(
        response: 200,
        description: 'Processed huge dataset',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Item 1'),
                ]
            )
        )
    )]
    public function processHugeDataset(): JsonResponse
    {
        $data = $this->hugeDatasetService->getProcessedDataset();

        return $this->json($data);
    }
}
