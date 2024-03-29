<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, TransactionService};

class HomeController
{


    public function __construct(private TemplateEngine $view, private TransactionService $transactionService)
    {
    }

    public function home()
    {
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = 3;
        $offset = ($page - 1) * $length;
        $searchTerm = $_GET['s'] ?? null;

        [$transactions, $totalCount] = $this->transactionService->getUserTransactions($length, $offset);
        $lastPage = ceil($totalCount / $length);

        $pages = $lastPage ? range(1, $lastPage) : [];
        $pageLinks = array_map(fn ($eachNum) => http_build_query([
            "p" => $eachNum,
            "s" => $searchTerm,
        ]), $pages);
        echo $this->view->render(
            "index.php",
            [
                "transactions" => $transactions,
                "currentPage" => $page,
                "lastPage" => $lastPage,
                "previousPageQuery" => http_build_query([
                    "p" => $page - 1,
                    "s" => $searchTerm,

                ]),
                "nextPageQuery" => http_build_query([
                    "p" => $page + 1,
                    "s" => $searchTerm,

                ]),
                "pageLinks" => $pageLinks,
                "searchTerm" => $searchTerm,
            ]

        );
    }
}
