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
    #[Route('/api/crypto-currency/{symbol}', name: 'crypto_currency_by_symbole', methods: ['GET'])]
    public function getCryptoCurrencyBySymbol($symbol, CryptoCurrencyRepository $repo): JsonResponse
    {
        $currency = $repo->findBySymbol($symbol);
        return new JsonResponse($currency ? $currency->toArray() : null);
    }

    // -----/api/crypto-currency?min=1000-----
    // -----/api/crypto-currency?max=1000-----
    #[Route('/api/crypto-currency', name: 'crypto_currency_by_price', methods: ['GET'])]
    public function getCryptoCurrencyByPrice(CryptoCurrencyRepository $repo): JsonResponse
    {
        $min = $_GET['min'] ?? null;
        $max = $_GET['max'] ?? null;

        //return if both min and max arent provided
        if ($min === null && $max === null) {
            return new JsonResponse(['error' => 'You need to put min or max parameter.'], Response::HTTP_BAD_REQUEST);
        }

        // fetch currencies by min or max
        $currencies = [];
        if ($min !== null) {
            $currencies = $repo->findByMinPrice($min);
        } elseif ($max !== null) {
            $currencies = $repo->findByMaxPrice($max);
        }

        // return if no currencies are found
        if (empty($currencies)) {
            return new JsonResponse(['message' => 'No currencies found'], Response::HTTP_NOT_FOUND);
        }

        $currencyArray = array_map(fn($currency) => $currency->toArray(), $currencies);
        return new JsonResponse($currencyArray);
    }

    // -----/api/find-currency-by-id/{id}-----
    #[Route('/api/find-currency-by-id/{id}', name: 'crypto_currency_by_id', methods: ['GET'])]
    public function getCryptoCurrencyById($id, CryptoCurrencyRepository $repo): JsonResponse
    {
        $currency = $repo->findById($id);
        return new JsonResponse($currency ? $currency->toArray() : null);
    }
}
