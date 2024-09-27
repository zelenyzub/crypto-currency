<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CryptoCurrencyRepository;

class ApiCryptoCurrencyController extends AbstractController
{
    // -----/api/crypto-currency/{symbol}-----
    #[Route('/api/crypto-currency/{symbol}', name:'crypto_currency_by_symbole', methods:['GET'])]
    public function getCryptoCurrencyBySymbol($symbol, CryptoCurrencyRepository $repo): JsonResponse {
        $currency = $repo->findBySymbol($symbol);
        return new JsonResponse($currency ? $currency->toArray() : null);
    }

    // -----/api/crypto-currency?min=1000-----
    #[Route('api/crypto-currency', name:'crypto:currency_by_min', methods:['GET'])]
    public function getCryptoCurrencyByMinPrice(CryptoCurrencyRepository $repo): JsonResponse {
        $min = $_GET['min'] ?? null;
        $currencies = $repo->findByMinPrice($min);
        $currencyArray = array_map(fn($currency) => $currency->toArray(), $currencies);
        return new JsonResponse($currencyArray);
    }
}
