<?php

namespace App\Console\Commands;

use App\Models\Planet;
use App\Models\Resident;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class SyncPlanets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-planets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }
    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle()
    {
        $url = config('services.swapi.base_url') . "/planets";

        while ($url !== null) {
            $response = $this->client->request('GET', $url);
            $data = json_decode($response->getBody(), true);

            foreach ($data['results'] as $planetData) {
                $planet = $this->syncPlanet($planetData);
                $this->syncResidents($planet->id, $planetData['residents']);
            }

            $url = $data['next'];
        }

        $this->info('Sync process completed.');
    }

    private function syncPlanet($planetData)
    {
        return Planet::updateOrCreate(
            ['name' => $planetData['name']],
            [
                'rotation_period' => $planetData['rotation_period'],
                'orbital_period' => $planetData['orbital_period'],
                'diameter' => $planetData['diameter'],
                'climate' => $planetData['climate'],
                'gravity' => $planetData['gravity'],
                'terrain' => $planetData['terrain'],
                'surface_water' => $planetData['surface_water'],
                'population' => $planetData['population'],
            ]
        );
    }

    private function syncResidents($planetId, $residentsUrls)
    {

        foreach ($residentsUrls as $url) {
            $response = $this->client->request('GET', $url);
            $residentData = json_decode($response->getBody(), true);

            // Assuming 'url' is unique for each resident
            Resident::updateOrCreate(
                ['url' => $url],
                [
                    'name' => $residentData['name'],
                    'height' => $residentData['height'],
                    'mass' => $residentData['mass'],
                    'planet_id' => $planetId,
                ]
            );
        }
    }
}
