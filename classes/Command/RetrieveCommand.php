<?php

namespace MySociety\Slurp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class RetrieveCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('retrieve')
            ->setDescription('Retrieve data from site instances.')
            ->addArgument(
                'id',
                InputArgument::OPTIONAL,
                'Which site instance do you want to retrieve data from?'
            )
            ->addOption(
               'onlyDue',
               null,
               InputOption::VALUE_NONE,
               'Should we only actually get due retrievals?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $query = Capsule::table('site_instances')
            ->orderBy('last_retrieved', 'asc');

        if ($input->getArgument('id')) {
            $query->where('id', (int) $input->getArgument('id'));
        }

        $instances = $query->get();

        $client = new \GuzzleHttp\Client();

        if (count($instances) > 0) {

            foreach ($instances as $instance) {

                if (!$input->getOption('onlyDue')
                    || (
                        $input->getOption('onlyDue')
                        && ( strtotime($instance['last_retrieved']) <= time() - $instance['update_interval'] * 3600 )
                    )
                ) {

                    $output->writeln('<info>Instance ' . $instance['id'] . ' is using "' . $instance['adapter']. '" adapter on endpoint "' . $instance['endpoint'] . '".</info>');

                    // Try get the necessary site adapter?
                    $adapterClassPath = 'MySociety\\Slurp\\Adapter\\' . $instance['adapter'] . 'Adapter';
                    if (class_exists($adapterClassPath)) {
                        $adapter = new $adapterClassPath;

                        try {
                            $adapter->parseBody($instance['id'], $client, $instance['endpoint']);
                            Capsule::table('site_instances')
                                ->where('id', $instance['id'])
                                ->update([
                                    'last_retrieved' => date('Y-m-d H:i:s')
                                ]);
                            $output->writeln('<comment>Success!</comment>');
                        } catch (\Exception $e) {
                            $output->writeln('<error>Something seems to have gone wrong: ' . $e->getMessage() . ' (' . get_class($e) . ')</error>');
                        }

                    } else {
                        $output->writeln('<error>Cannot find adapter ' . $instance['adapter'] . ' for instance ' . $instance['id'] . '!</error>');
                    }

                } else {
                    $output->writeln('<info>Skipping instance ' . $instance['id'] . '.</info>');
                }

            }

        } else {

            $output->writeln('<info>No site instances to retrieve!</info>');

        }

    }
}
