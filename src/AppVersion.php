<?php

namespace Jdenoc\LaravelAppVersion;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AppVersion extends Command {

    const ENV_PARAM = "APP_VERSION";
    const CONFIG_PARAM = "app.version";
    const ARG_NAME = "version";
    const INFO_STRING_GET_VERSION = "Application version: %s";
    const INFO_STRING_SET_VERSION = "Application version [%s] has been set successfully.";
    const INFO_STRING_NO_VERSION = "NOT YET SET";
    const ERROR_STRING_ENV_FILE_MISSING = "%s file does not exist.\nPlease create one before trying again.";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:version
                            {version? : The applications new version number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get/Set application version';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        if (!$this->environmentFileExists()) {
            $this->error(sprintf(self::ERROR_STRING_ENV_FILE_MISSING, basename($this->getEnvironmentFilePath())));
            return;
        }

        $new_version = $this->argument(self::ARG_NAME);
        if (empty($new_version)) {
            $current_version = config(self::CONFIG_PARAM);  // getting config value from memory
            $current_version = empty($current_version) ? self::INFO_STRING_NO_VERSION : $current_version;
            $this->info(sprintf(self::INFO_STRING_GET_VERSION, $current_version));
            return;
        }

        $this->writeNewEnvironmentFileWith($new_version);
        config([self::CONFIG_PARAM=>$new_version]);  // setting the config value in memory
        $this->info(sprintf(self::INFO_STRING_SET_VERSION, $new_version));
        return;
    }

    /**
     * @return string
     */
    protected function getEnvironmentFilePath() {
        return $this->laravel->environmentFilePath();
    }

    /**
     * Makes sure that the (provided) environment file exists
     *
     * @return bool
     */
    protected function environmentFileExists(): bool {
        return File::exists($this->getEnvironmentFilePath());
    }

    /**
     * Write a new environment file with the given key.
     *     Taken & modified from Illuminate\Foundation\Console\KeyGenerateCommand
     *
     * @param string  $version
     * @return void
     */
    protected function writeNewEnvironmentFileWith(string $version) {
        $env_file_path = $this->getEnvironmentFilePath();
        $file_contents = file_get_contents($env_file_path);
        if (!str_contains($file_contents, self::ENV_PARAM.'=')) {
            $updated_file_contents = $file_contents."\n".self::ENV_PARAM.'='.$version;
        } else {
            $updated_file_contents = preg_replace(
                $this->versionReplacementPattern(),
                self::ENV_PARAM.'='.$version,
                $file_contents
            );
        }
        file_put_contents($env_file_path, $updated_file_contents);
    }

    /**
     * Get a regex pattern that will match env APP_VERSION with any random key.
     *     Taken & modified from Illuminate\Foundation\Console\KeyGenerateCommand
     *
     * @return string
     */
    protected function versionReplacementPattern(): string {
        $escaped = preg_quote('='.config(self::CONFIG_PARAM), '/');
        return "/^".self::ENV_PARAM."{$escaped}/m";
    }

}
