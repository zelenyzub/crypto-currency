<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use App\Entity\CryptoCurrency;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:fetch-crypto-currencies',
    description: 'Fetch crypto currency data',
    hidden: false,
    aliases: ['app:fetch-crypto-currencies']
)]
class FetchCryptoCurrenciesCommand extends Command
{
    protected static $defaultName = 'app:fetch-crypto-currencies';
    private EntityManagerInterface $entityManager;
    private Client $httpClient;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->httpClient = new Client(['verify' => false]);
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=50&page=1&sparkline=false';
        
        try{
            $response = $this->httpClient->get($url);
            $data = json_decode($response->getBody(), true);

            foreach($data as $item) {
                $criptoCurrency = new CryptoCurrency();
                $criptoCurrency -> setName($item['name']);
                $criptoCurrency -> setSymbol($item['symbol']);
                $criptoCurrency -> setCurrentPrice($item['current_price']);
                $criptoCurrency -> setTotalVolume($item['total_volume']);
                $criptoCurrency -> setAth($item['ath']);
                $criptoCurrency -> setAthDate(new \DateTime($item['ath_date']));
                $criptoCurrency -> setAtl($item['atl']);
                $criptoCurrency -> setAtlDate(new \DateTime($item['atl_date']));
                $criptoCurrency -> setUpdatedAt(new \DateTimeImmutable());

                $this->entityManager->persist($criptoCurrency);
            }

            $this->entityManager->flush();
            $output->writeln('Crypto currency data fetched successfully');
            return Command::SUCCESS;
        }catch(RequestException $ex) {
            $output->writeln('Error: ' . $ex->getMessage());
            return Command::FAILURE;
        }
    }
}
