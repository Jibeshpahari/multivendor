<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $slugs;

    public function __construct(array $slugs = [])
    {
        $this->slugs = $slugs;
    }

    public function collection(): Collection
    {
        $query = Category::with('parent', 'children');

        if (!empty($this->slugs)) {
            $query->whereIn('slug', $this->slugs);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Category',
            'Parent',
            'Childrens',
            'Status',
            'Products',
            'Order',
            'Modified At',
            'Created At',
        ];
    }

    public function map($category): array
    {
        return [
            $category->name,
            $category->parent?->name ?? '-',
            $category?->children->count() ?? '-',
            $category->is_active ? 'Active' : 'Inactive',
            '0',
            '0',
            $category->updated_at?->format('Y-m-d H:i:s'),
            $category->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
