<?php

namespace MySociety\Slurp\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class RetrieveDueCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('retrieve:due')
            ->setDescription('Retrieve data from site instances due a retrieval.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $instances = Capsule::table('site_instances')
            ->orderBy('last_retrieved', 'asc')
            ->get();

        $client = new \GuzzleHttp\Client();

        foreach ($instances as $instance) {

            if (strtotime($instance->last_retrieved) <= time() - $instance->update_interval * 3600) {

                $output->writeln('<info>Instance ' . $instance->id . ' is using "' . $instance->adapter . '" adapter on endpoint "' . $instance->endpoint . '".</info>');

                // Try get the necessary site adapter?
                $adapterClassPath = 'MySociety\\Slurp\\Adapter\\' . $instance->adapter . 'Adapter';
                $adapter = new $adapterClassPath($instance->id, $client, $instance->endpoint);

                try {
                    $adapter->parseBody();
                    Capsule::table('site_instances')
                        ->where('id', $instance->id)
                        ->update([
                            'last_retrieved' => date('Y-m-d H:i:s')
                        ]);
                    $output->writeln('<info>Success!</info>');
                } catch (\Exception $e) {
                    $output->writeln('<error>Something seems to have gone wrong: ' . $e->getMessage() . ' (' . get_class($e) . ')</error>');
                }

            }

        }

    }
}
