<?php

namespace Jdenoc\LaravelAppVersion\Tests;

use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Artisan;
use Jdenoc\LaravelAppVersion\AppVersion;
use Jdenoc\LaravelAppVersion\AppVersion as AppVersionCommand;
use Jdenoc\LaravelAppVersion\AppVersionServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * Class AppVersionTest
 * Code in this test class has been inspired by this StackOverflow post: https://stackoverflow.com/a/37469635
 *
 * @package Tests\Feature\Console
 */
class AppVersionTest extends TestCase {

    /**
     * @var string
     */
    private $_command = "app:version";

    /**
     * @var string
     */
    private $_test_version;

    public function setUp(): void
    {
        parent::setUp();
        $faker = FakerFactory::create();
        $this->_test_version = $faker->randomDigitNotNull().'.'.$faker->randomDigitNotNull().'.'.$faker->randomDigitNotNull().'-test-'.$faker->word();
    }

    public function getEnvironmentSetUp($app){
        // create .env file
        $env_file_path = $app->environmentFilePath();
        file_put_contents($env_file_path, AppVersionCommand::ENV_PARAM.'=');
        $this->assertFileExists($env_file_path);
    }

    protected function getPackageProviders($app)
    {
        return [AppVersionServiceProvider::class];
    }

    public function testCommandInArtisanList(){
        // GIVEN - nothing

        // WHEN
        Artisan::call('list');

        // THEN
        $result_as_text = trim(Artisan::output());
        $this->assertStringContainsString($this->_command, $result_as_text);
    }

    public function testEnvFileDoesNotExist(){
        // GIVEN - see setUp()
        $env_file_path = $this->app->environmentFilePath();
        unlink($env_file_path);

        // THEN
        Artisan::call($this->_command);

        // WHEN
        $result_as_text = trim(Artisan::output());
        $this->assertEquals(sprintf(AppVersionCommand::ERROR_STRING_ENV_FILE_MISSING, basename($env_file_path)), $result_as_text);
    }

    public function testSettingAppVersionViaArgument(){
        // GIVEN - see setUp()
        $env_file_path = $this->app->environmentFilePath();
        $this->assertFileExists($env_file_path);

        // WHEN
        Artisan::call($this->_command, [AppVersionCommand::ARG_NAME => $this->_test_version]);

        // THEN
        $result_as_text = trim(Artisan::output());
        $this->assertEquals(
            sprintf(AppVersionCommand::INFO_STRING_SET_VERSION, $this->_test_version),
            $result_as_text,
            "command output invalid"
        );
        $this->assertEquals(
            $this->_test_version,
            config(AppVersionCommand::CONFIG_PARAM),
            "config value not updated"
        );
    }

    public function testSettingAppVersionWhenEnvVariableDoesNotExist(){
        // GIVEN - see setUp()
        $env_file_path = $this->app->environmentFilePath();
        file_put_contents($env_file_path, '');
        $this->assertFileExists($env_file_path);
        $this->assertStringNotContainsString(AppVersionCommand::ENV_PARAM, file_get_contents($env_file_path));

        // WHEN
        Artisan::call($this->_command, [AppVersionCommand::ARG_NAME => $this->_test_version]);

        // THEN
        $result_as_text = trim(Artisan::output());
        $this->assertStringContainsString(AppVersionCommand::ENV_PARAM, file_get_contents($env_file_path));
        $this->assertEquals(
            sprintf(AppVersionCommand::INFO_STRING_SET_VERSION, $this->_test_version),
            $result_as_text,
            "command output invalid"
        );
        $this->assertEquals(
            $this->_test_version,
            config(AppVersionCommand::CONFIG_PARAM),
            "config value not updated"
        );
    }

    public function testGetAppVersionWhereVersionNotSet(){
        // GIVEN - see setUp()

        // WHEN
        Artisan::call($this->_command);

        // THEN
        $result_as_text = trim(Artisan::output());
        $this->assertEquals(sprintf(AppVersionCommand::INFO_STRING_GET_VERSION, AppVersionCommand::INFO_STRING_NO_VERSION), $result_as_text);
    }

    public function testGettingAppVersion(){
        // GIVEN - see setUp()

        // WHEN
        config([AppVersionCommand::CONFIG_PARAM => $this->_test_version]);
        Artisan::call($this->_command);

        // THEN
        $result_as_text = trim(Artisan::output());
        $this->assertEquals(sprintf(AppVersionCommand::INFO_STRING_GET_VERSION, $this->_test_version), $result_as_text);
    }

}
