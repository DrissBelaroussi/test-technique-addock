<?php

namespace App\Command;

use App\Entity\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class DiscountCommand extends Command
{
    protected static $defaultName = 'app:discount-command';
    private $em;

    public function __construct(ManagerRegistry $em)
    {
        $this->em = $em->getManager();
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Apply periodic discount prices on products');
    }

    //Script à lancer tous les jours à 00h00, pour mettre les tarifs de réduction à jour
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $today = new \DateTime();
        $products = $this->em->getRepository(Product::class)->findAll();
        foreach ($products as $product) {
            $product->setDiscountPrice(null);
            if ($product->getDiscountPeriods()) {
                foreach ($product->getDiscountPeriods() as $period) {
                    if ($today > $period->getStartDate() && $today < $period->getEndDate()) {
                        $product->setDiscountPrice($product->getPrice() * (100 - $period->getDiscount()) / 100);
                    }
                }
            }
            $this->em->persist($product);
            $output->writeln($product->getId());
        }
        $this->em->flush();
    }
}