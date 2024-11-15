<?php

namespace App\Command;

use App\Entity\Brand;
use App\Entity\CategoryTyre;
use App\Entity\Family;
use App\Entity\Product;
use App\Entity\Segment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'insert-data-imports',
    description: 'Add a short description for your command',
)]
class InsertDataImportsCommand extends Command
{
    
    private string $importDir;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        string $projectDir,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->importDir = $projectDir . '/import';
        $this->entityManager = $entityManager;
        $this->validator = $validator;

        parent::__construct();
    }

    // parcours les csv du dossier import et les traitent
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $importDir = $this->importDir;
        $errorDir = $importDir . '/erreur';

        if (!is_dir($importDir)) {
            $io->error("Le dossier 'import' n'existe pas à la racine du projet.");
            return Command::FAILURE;
        }

        // si le dossier erreur n'existe pas le créer
        if (!is_dir(filename: $errorDir)) {
            mkdir($errorDir, 0777, true);
        }

        $files = glob(pattern: $importDir . '/*.csv');
        if (empty($files)) {
            $io->warning('Aucun fichier CSV à traiter.');
            return Command::SUCCESS;
        }

        // on parcours les fichiers du dossier import
        foreach ($files as $file) {
            $errorsCount = 0;
            $rows = $this->parseCsvFile($file);
            $entities = [];
            foreach ($rows as $rowIndex => $row) {
                if ($rowIndex === 0 || $errorsCount > 3) {
                    continue; 
                }
                $entity = $this->setProductEntity($row);
                $errors = $this->validator->validate($entity);
                if (count($errors) > 0) {
                    $io->error("Erreur à la ligne $rowIndex : " . (string) $errors);
                    $errorsCount++;
                } else {
                    $entities[] = $entity;
                }
            }

            // si il y a plus de 3 erreurs on met le fichier dans le dossier erreur sinon on le traite
            if ($errorsCount > 3) {
                $io->warning("Le fichier contient $errorsCount erreurs. Il sera déplacé dans le dossier 'erreur'.");
                rename($file, $errorDir . '/' . basename($file));
            } else {
                foreach ($entities as $entity) {
                    $this->entityManager->persist($entity);
                }
                $this->entityManager->flush();
                $io->success("Le fichier " . basename($file) . " a été importé avec succès.");
                unlink($file);
            }
        }

        return Command::SUCCESS;
    }

    // récupère toutes les lignes d'un fichier CSV
    private function parseCsvFile(string $filePath): array
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }

    // Formate la ligne csv pour correspondre à une entity Product
    private function setProductEntity(array $rowElement): Product
    {
        $row = explode( ';', $rowElement[0]);
        $product = new Product();
        $product->setEasyCode($row[0]);
        $product->setEanCode((int) $row[1]);
        $product->setDesignation($row[2]);
        $product->setCategoryTyre($this->getEntity($row[3], CategoryTyre::class));
        $product->setBrand($this->getEntity($row[4], Brand::class));
        $product->setFamily($this->getEntity($row[5], Family::class));
        $product->setWidth((int) $row[6]);
        $product->setHeight((int) $row[7]);
        $product->setDiameter((int) $row[8]);
        $product->setConstruction($row[9]);
        $product->setLoadIndex($row[10]);
        $product->setSpeedIndex($row[11]);
        $product->setSegment($this->getEntity($row[12], Segment::class));


        return $product;
    }

    private function getEntity($row, $class) {
        $entity = $this->entityManager
            ->getRepository($class)
            ->findOneBy(['name' => $row]);
        if (!$entity) {
            throw new \Exception("'$row' non trouvé dans la base de données.");
        }
        return $entity;
    }
}
