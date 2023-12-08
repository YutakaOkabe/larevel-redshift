<?php

namespace App\Console\Commands;

use App\Models\User;
use Aws\S3\S3Client;
use Illuminate\Console\Command;

class ExportUsersToS3 extends Command
{
    private S3Client $s3client;
    protected $signature = 'export:users';
    protected $description = 'Create and Export Users to S3 as CSV';

    public function __construct()
    {
        parent::__construct();
        $this->s3client = $this->client();
    }

    public function handle()
    {
        $this->info('export_user_csv_to_s3 start');

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');

        for ($i = 0; $i < 1000000; $i++) {
            $users[] = array_values(User::factory()->make()->toArray());
        }

        $headers = array_keys(User::factory()->make()->getAttributes());

        // csv作成
        $file = fopen(storage_path('app/tmp/users.csv'), 'w');
        fputcsv($file, $headers);
        foreach ($users as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        // S3にアップロード
        try {
            $this->s3client->putObject([
                'Bucket' => 'redshift-data-csv',
                'Key' => 'users.csv',
                'Body' => fopen(storage_path('app/tmp/users.csv'), 'r')
            ]);

            $this->info('finish successfully');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function client(): S3Client
    {
        return new S3Client([
            'region' => 'ap-northeast-1',
            'credentials' => [
                'key' => 'xxx',
                'secret' => 'yyy',
            ],
        ]);
    }
}
