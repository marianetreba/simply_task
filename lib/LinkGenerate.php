<?php


class LinkGenerate
{
    public static function sortLinks($columns)
    {
        $page = $_GET['page'] ?? 1;
        $currentSortBy = $_GET['sortBy'] ?? '';
        $currentSortDirection = $_GET['sortDirection'] ?? '';

        $links = [];
        foreach ($columns as $column) {
            if ($currentSortBy === $column) {
                $sortDirection = ($currentSortDirection === 'desc') ? 'asc' : 'desc';
            } else {
                $sortDirection = 'asc';
            }

            $params = [
                'sortBy' => $column,
                'sortDirection' => $sortDirection,
                'page' => $page,
            ];

            $links[$column] = '/' . MODULE . '?' . http_build_query($params);
        }

        return $links;
    }

    public static function pageLink($page)
    {
        if ($page > 1) {
            $params['page'] = $page;
        }

        foreach (['sortBy', 'sortDirection'] as $key) {
            if ($_GET[$key]) {
                $params[$key] = $_GET[$key];
            }
        }

        return '/' . MODULE . '?' . http_build_query($params ?? []);
    }

}
