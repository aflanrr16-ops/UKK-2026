<?php

namespace Sakuci\Database;

use Sakuci\Http\Request;

/**
 * Hasil paginasi beserta helper untuk merender navigasi halaman.
 */
class Paginator implements \IteratorAggregate, \Countable, \JsonSerializable
{
    public function __construct(
        protected array $items,
        protected int $total,
        protected int $perPage,
        protected int $currentPage
    ) {
    }

    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function lastPage(): int
    {
        return max(1, (int) ceil($this->total / max(1, $this->perPage)));
    }

    public function hasPages(): bool
    {
        return $this->lastPage() > 1;
    }

    public function isEmpty(): bool
    {
        return $this->items === [];
    }

    public function firstItem(): int
    {
        return $this->isEmpty() ? 0 : ($this->currentPage - 1) * $this->perPage + 1;
    }

    public function lastItem(): int
    {
        return $this->isEmpty() ? 0 : $this->firstItem() + count($this->items) - 1;
    }

    public function url(int $page): string
    {
        $page  = max(1, min($page, $this->lastPage()));
        $query = Request::current()->query;
        $query['page'] = $page;

        return Request::current()->uri() . '?' . http_build_query($query);
    }

    public function previousPageUrl(): ?string
    {
        return $this->currentPage > 1 ? $this->url($this->currentPage - 1) : null;
    }

    public function nextPageUrl(): ?string
    {
        return $this->currentPage < $this->lastPage() ? $this->url($this->currentPage + 1) : null;
    }

    /** Navigasi halaman siap pakai: {!! $posts->links() !!} */
    public function links(): string
    {
        if (! $this->hasPages()) {
            return '';
        }

        $html = '<nav class="pagination">';

        $html .= $this->previousPageUrl()
            ? '<a href="' . e($this->previousPageUrl()) . '">&laquo; Sebelumnya</a>'
            : '<span class="disabled">&laquo; Sebelumnya</span>';

        for ($page = 1; $page <= $this->lastPage(); $page++) {
            $html .= $page === $this->currentPage
                ? '<span class="active">' . $page . '</span>'
                : '<a href="' . e($this->url($page)) . '">' . $page . '</a>';
        }

        $html .= $this->nextPageUrl()
            ? '<a href="' . e($this->nextPageUrl()) . '">Berikutnya &raquo;</a>'
            : '<span class="disabled">Berikutnya &raquo;</span>';

        return $html . '</nav>';
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return [
            'data'         => array_map(
                fn ($item) => is_object($item) && method_exists($item, 'toArray') ? $item->toArray() : $item,
                $this->items
            ),
            'total'        => $this->total,
            'per_page'     => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page'    => $this->lastPage(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

