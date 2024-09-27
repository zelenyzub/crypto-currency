<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CryptoCurrencyRepository;

class ApiCryptoCurrencyController extends AbstractController
{
    #[Route('/api/crypto-currency/{symbol}', name:'crypto_currency_by_symbole', methods:['GET'])]
    public function getCryptoCurrencyBySymbol($symbol, CryptoCurrencyRepository $repo): JsonResponse
    {
        $currency = $repo->findBySymbol($symbol);
        return new JsonResponse($currency ? $currency->toArray() : null);
    }
}
