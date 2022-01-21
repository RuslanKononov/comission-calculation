<?php

namespace App\Command\Comission;

use App\Domain\Comission\CalculateComission;
use App\Domain\Comission\Factory\CalculateComissionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateComissionCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'comission:calculate';

    private string $storageDir;
    private CalculateComissionFactory $calculateComissionFactory;
    private CalculateComission $calculateComission;

    public function __construct(
        string $storageDir,
        CalculateComissionFactory $calculateComissionFactory,
        CalculateComission $calculateComission
    ) {
        parent::__construct();

        $this->storageDir = $storageDir;
        $this->calculateComissionFactory = $calculateComissionFactory;
        $this->calculateComission = $calculateComission;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Calculate commissions')
            ->addArgument('fileName', InputArgument::REQUIRED, 'Input file to calculate comissions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFile = sprintf('%1$s/%2$s', $this->storageDir, $input->getArgument('fileName'));
        foreach (file($inputFile) as $transaction) {
            $calculateComissionRequest = $this->calculateComissionFactory->fromSourceToDomainRequest($transaction);
            $calculateComissionResponse = $this->calculateComission->calculate($calculateComissionRequest);

            $output->writeLn($this->calculateComissionFactory->fromDomainToSourceResponse($calculateComissionResponse));
        }

        return Command::SUCCESS;
    }
}
