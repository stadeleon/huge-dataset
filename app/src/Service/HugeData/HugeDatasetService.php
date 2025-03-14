<?php declare(strict_types=1);

namespace App\Service\HugeData;

use Symfony\Component\Lock\LockFactory;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use App\Repository\BigDataRepository;

class HugeDatasetService
{
    private const CACHE_KEY = 'huge_dataset_result';
    private const CACHE_TTL = 60;
    private const LOCK_TTL = 30;
    private const SLEEP_TIMEOUT = 10;
    private const LOCK_KEY = 'huge_dataset_lock';

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly LockFactory $lockFactory,
        private readonly BigDataRepository $repository
    ) {}

    public function getProcessedDataset(): array
    {
        $lock = $this->lockFactory->createLock(self::LOCK_KEY, ttl: self::LOCK_TTL);

        return $this->cache->get(self::CACHE_KEY, function(ItemInterface $item) use ($lock) {
            $item->expiresAfter(self::CACHE_TTL);

            if ($lock->acquire()) {
                try {
                    return $this->processData();
                } finally {
                    $lock->release();
                }
            }

            return $item->get() ?? [];
        });
    }

    private function processData(): array
    {
        sleep(self::SLEEP_TIMEOUT);

        $items = $this->repository->findLatest();

        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'created_at' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $result;
    }
}
