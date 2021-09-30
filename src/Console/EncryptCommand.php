<?php

namespace FlexFlux\Encryptor\Console;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EncryptCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encryptor:encrypt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt existing data from models on database. This command encrypts all the encryptable attributes from every model in your project to make sure every record is encrypted.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Encrypting...');
        DB::beginTransaction();
        foreach($this->getModels() as $model)
        {
            $data = app($model)->all();
            foreach ($data as $row) {
                $row->timestamps = false;
                if (method_exists(app($model), 'getEncryptable') && count(app($model)->getEncryptable()) > 0) {
                    foreach (app($model)->getEncryptable() as $encryptable) {
                        $oldData = $row->$encryptable;
                        $row->$encryptable = encrypt($oldData);
                    }
                    $row->save();
                }
            }
        }
        DB::commit();
        $this->comment('Database encrypted.');
    }

    private function getModels()
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf('\%s%s',
                    Container::getInstance()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

                return $class;
            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        return $models->values();
    }

}