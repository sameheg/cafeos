<?php

namespace Modules\Reports\Services;

class MenuEngineeringService
{
    /**
     * Calculate profitability and popularity for menu items.
     *
     * @param array $items
     * @return array
     */
    public function calculate(array $items): array
    {
        $totalSales = array_sum(array_column($items, 'sales'));

        return array_map(function (array $item) use ($totalSales) {
            $profitability = $item['price'] - $item['cost'];
            $popularity = $totalSales > 0 ? $item['sales'] / $totalSales : 0;

            return [
                'name' => $item['name'],
                'profitability' => $profitability,
                'popularity' => $popularity,
            ];
        }, $items);
    }
}
